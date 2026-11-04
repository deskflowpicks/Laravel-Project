<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Cohort;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Validate the selected filters.
        $validated = $request->validate([
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'cohort_id' => ['nullable', 'integer', 'exists:cohorts,id'],
        ]);

        // Overall statistics.
        $totalCourses = Course::count();

        $totalCohorts = Cohort::count();

        $totalRegistrations = CourseRegistration::count();

        $pendingRegistrations = CourseRegistration::where(
            'status',
            'pending'
        )->count();

        $approvedRegistrations = CourseRegistration::where(
            'status',
            'approved'
        )->count();

        $rejectedRegistrations = CourseRegistration::where(
            'status',
            'rejected'
        )->count();

        // Build the filtered registration query.
        $filteredQuery = CourseRegistration::query();

        if (!empty($validated['course_id'])) {
            $filteredQuery->whereHas('cohort', function ($query) use ($validated) {
                $query->where('course_id', $validated['course_id']);
            });
        }

        if (!empty($validated['cohort_id'])) {
            $filteredQuery->where(
                'cohort_id',
                $validated['cohort_id']
            );
        }

        // Filtered statistics.
        $filteredTotal = (clone $filteredQuery)->count();

        $filteredPending = (clone $filteredQuery)
            ->where('status', 'pending')
            ->count();

        $filteredApproved = (clone $filteredQuery)
            ->where('status', 'approved')
            ->count();

        $filteredRejected = (clone $filteredQuery)
            ->where('status', 'rejected')
            ->count();

        // Data for the filter dropdowns.
        $courses = Course::orderBy('title')->get();

        $cohorts = Cohort::with('course')
            ->orderBy('start_date')
            ->get();

        return view('admin.dashboard', compact(
            'totalCourses',
            'totalCohorts',
            'totalRegistrations',
            'pendingRegistrations',
            'approvedRegistrations',
            'rejectedRegistrations',
            'filteredTotal',
            'filteredPending',
            'filteredApproved',
            'filteredRejected',
            'courses',
            'cohorts'
        ));
    }
}
