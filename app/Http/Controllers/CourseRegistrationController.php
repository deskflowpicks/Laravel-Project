<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Cohort;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CourseRegistrationController extends Controller
{
   
    public function create()
    {
        $courseSlug = request('course');

        $selectedCourse = null;

        if ($courseSlug) {
            $selectedCourse = Course::where('slug', $courseSlug)
                ->where('status', 'published')
                ->firstOrFail();
        }

        $cohorts = Cohort::with('course')
            ->where('status', 'open')
            ->whereDate('registration_open_date', '<=', now()->toDateString())
            ->whereDate('registration_close_date', '>=', now()->toDateString())
            ->when($selectedCourse, function ($query) use ($selectedCourse) {
                $query->where('course_id', $selectedCourse->id);
            })
            ->orderBy('start_date')
            ->get();

        return view('register', compact('cohorts', 'selectedCourse'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'course' => ['nullable', 'string', 'exists:courses,slug'],
            'cohort_id' => ['required', 'integer', 'exists:cohorts,id'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['email'] = strtolower(trim($validated['email']));

        DB::transaction(function () use ($validated) {

            $cohort = Cohort::with('course')
                ->whereKey($validated['cohort_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Ensure the selected cohort belongs to the selected course.
            if (
                !empty($validated['course']) &&
                (
                    !$cohort->course ||
                    $cohort->course->slug !== $validated['course']
                )
            ) {
                throw ValidationException::withMessages([
                    'cohort_id' => 'The selected cohort does not belong to the course you selected. Please choose a valid cohort.',
                ]);
            }

            $today = now()->toDateString();

            if (
                $cohort->status !== 'open' ||
                !$cohort->registration_open_date ||
                !$cohort->registration_close_date ||
                $today < $cohort->registration_open_date->toDateString() ||
                $today > $cohort->registration_close_date->toDateString()
            ) {
                throw ValidationException::withMessages([
                    'cohort_id' => 'Registration for this cohort is currently closed.',
                ]);
            }

            $duplicate = CourseRegistration::where(
                'cohort_id',
                $cohort->id
            )
                ->whereRaw('LOWER(email) = ?', [
                    strtolower($validated['email'])
                ])
                ->exists();

            if ($duplicate) {
                throw ValidationException::withMessages([
                    'cohort_id' => 'You have already registered for this cohort. Please choose another cohort if you wish to enrol again.',
                ]);
            }

            $reservedPlaces = CourseRegistration::where(
                'cohort_id',
                $cohort->id
            )
                ->whereIn('status', ['pending', 'approved'])
                ->count();

            if ($reservedPlaces >= $cohort->capacity) {
                throw ValidationException::withMessages([
                    'cohort_id' => 'Sorry, this cohort is full. Please select another available cohort.',
                ]);
            }

            CourseRegistration::create([
                'cohort_id' => $cohort->id,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'course' => $cohort->course->title,
                'message' => $validated['message'] ?? null,
                'status' => 'pending',
            ]);
        }, 5);

        return redirect()
            ->route('register')
            ->with(
                'success',
                'Your registration has been received. Komdigital will review your application and contact you.'
            );
    }
}