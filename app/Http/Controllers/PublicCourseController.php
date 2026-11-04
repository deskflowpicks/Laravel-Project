<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class PublicCourseController extends Controller
{
    /**
     * Display all published courses.
     */
   
    public function index(): View
    {
        $search = request('search');

        $courses = Course::with('category')
            ->where('status', 'published')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('courses.index', compact('courses', 'search'));
    }


    /**
     * Display an individual published course.
     */
    public function show(string $slug): View
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('courses.show', compact('course'));
    }
}
