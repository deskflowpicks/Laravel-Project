<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Cohort;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        // Validate the filters.
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'cohort_id' => ['nullable', 'integer', 'exists:cohorts,id'],
            'status' => [
                'nullable',
                'in:pending,approved,rejected,cancelled'
            ],
        ]);

        // Start the registration query.
        $query = CourseRegistration::with([
            'cohort.course'
        ]);

        // Search by student name or email.
        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by course.
        if (!empty($validated['course_id'])) {
            $query->whereHas('cohort', function ($subQuery) use ($validated) {
                $subQuery->where('course_id', $validated['course_id']);
            });
        }

        // Filter by cohort.
        if (!empty($validated['cohort_id'])) {
            $query->where('cohort_id', $validated['cohort_id']);
        }

        // Filter by status.
        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        // Get registrations with pagination.
        $registrations = $query->latest()
            ->paginate(15)
            ->withQueryString();

        // Get dropdown data.
        $courses = Course::orderBy('title')->get();

        $cohorts = Cohort::with('course')
            ->orderBy('start_date')
            ->get();

        return view('admin.registrations.index', compact(
            'registrations',
            'courses',
            'cohorts'
        ));
    }

    public function show(int $id): View
    {
        $registration = CourseRegistration::with([
            'cohort.course'
        ])->findOrFail($id);

        return view('admin.registrations.show', compact(
            'registration'
        ));
    }


    public function approve(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $registration = CourseRegistration::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($registration->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending registrations can be approved.',
                ]);
            }

            $registration->update([
                'status' => 'approved',
            ]);
        });

        return redirect()
            ->route('admin.registrations.show', $id)
            ->with('success', 'Student registration approved successfully.');
    }

    public function reject(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $registration = CourseRegistration::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($registration->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending registrations can be rejected.',
                ]);
            }

            $registration->update([
                'status' => 'rejected',
            ]);
        });

        return redirect()
            ->route('admin.registrations.show', $id)
            ->with('success', 'Student registration rejected successfully.');
    }

}
