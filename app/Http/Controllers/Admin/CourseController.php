<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class CourseController extends Controller
{
    /**
     * Display all courses.
     */
    public function index(): View
    {
        $courses = Course::with(['category'])
            ->withCount('cohorts')
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Display the create course form.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the submitted course details.
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:160'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,published'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $validated['description'] = Purify::clean(
            $validated['description'] ?? ''
        );

        // Generate a unique URL-friendly slug.
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (Course::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        // Upload the course image if one was selected.
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('courses', 'public');
        }

        // Save the course in the database.
        Course::create($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the edit course form.
     */
    public function edit(int $id): View
    {
        $course = Course::findOrFail($id);

        $categories = Category::orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update an existing course.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);

        // Validate the submitted course details.
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:160'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,published'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $validated['description'] = Purify::clean(
            $validated['description'] ?? ''
        );

        // Generate a unique slug, excluding the current course.
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Course::where('slug', $slug)
                ->where('id', '!=', $course->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        // Keep track of the existing image.
        $oldImage = $course->image;

        // Remove the image field from validated data initially.
        unset($validated['image']);

        // Upload a replacement image if one was selected.
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('courses', 'public');
        }

        // Update the course in the database.
        $course->update($validated);

        // Delete the old image after the update succeeds.
        if (
            isset($validated['image']) &&
            $oldImage
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Delete a course if it has no cohorts or registrations.
     */
    public function destroy(int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);

        // Check whether the course has any cohorts.
        $hasCohorts = $course->cohorts()->exists();

        // Check whether registrations are linked to this course.
        $hasRegistrations = CourseRegistration::where('course', $course->title)
            ->orWhereHas('cohort', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->exists();

        // Protect courses that have cohorts or registrations.
        if ($hasCohorts || $hasRegistrations) {
            return redirect()
                ->route('admin.courses.index')
                ->with(
                    'error',
                    'This course cannot be deleted because it has cohorts or student registrations. You can change its status to Draft instead.'
                );
        }

        // Remember the image path before deleting the course.
        $image = $course->image;

        // Delete the course from the database.
        $course->delete();

        // Delete its image from public storage.
        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
