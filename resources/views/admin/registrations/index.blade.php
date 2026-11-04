
@extends('layouts.app')

@section('title', 'Student Registrations | Komdigital')

@section('content')

<section class="dashboard-section">
    <div class="container">

        <div class="dashboard-header">
            <div>
                <h1>Student Registrations</h1>
                <p>View and manage student course applications.</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>
        </div>

        {{-- Search and Filters --}}
        <div class="dashboard-filter-card">

            <h2>Search and Filter Registrations</h2>

            <form method="GET" action="{{ route('admin.registrations.index') }}">

                <div class="registration-filter-grid">

                    <div class="form-group">
                        <label for="search">Search Student</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Enter student name or email"
                        >
                    </div>

                    <div class="form-group">
                        <label for="course_id">Select Course</label>

                        <select name="course_id" id="course_id">
                            <option value="">All Courses</option>

                            @foreach($courses as $course)
                                <option
                                    value="{{ $course->id }}"
                                    {{ request('course_id') == $course->id ? 'selected' : '' }}
                                >
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cohort_id">Select Cohort</label>

                        <select name="cohort_id" id="cohort_id">
                            <option value="">All Cohorts</option>

                            @foreach($cohorts as $cohort)
                                <option
                                    value="{{ $cohort->id }}"
                                    data-course="{{ $cohort->course_id }}"
                                    {{ request('cohort_id') == $cohort->id ? 'selected' : '' }}
                                >
                                    {{ $cohort->course->title }}
                                    — {{ $cohort->cohort_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Registration Status</label>

                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                </div>

                <div class="dashboard-filter-actions">
                    <button type="submit" class="btn btn-primary">
                        Apply Filters
                    </button>

                    <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                        Clear Filters
                    </a>
                </div>

            </form>
        </div>

        {{-- Registration Table --}}
        <div class="dashboard-filter-card" style="margin-top: 30px;">

            <h2>All Registrations</h2>

            <p>
                Showing {{ $registrations->count() }} of
                {{ $registrations->total() }} registration(s).
            </p>

            <div class="table-responsive">

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Cohort</th>
                            <th>Status</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($registrations as $registration)

                            <tr>
                                <td>{{ $registrations->firstItem() + $loop->index }}</td>

                                <td>{{ $registration->full_name }}</td>

                                <td>{{ $registration->email }}</td>

                                <td>{{ $registration->phone }}</td>

                                <td>
                                    {{ $registration->cohort?->course?->title ?? $registration->course }}
                                </td>

                                <td>
                                    {{ $registration->cohort?->cohort_name ?? 'Not assigned' }}
                                </td>

                                <td>
                                    <span class="status-badge status-{{ strtolower($registration->status) }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $registration->created_at->format('d M Y') }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.registrations.show', $registration->id) }}"
                                    class="btn btn-primary">
                                        View Details
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="empty-table">
                                    No student registrations found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $registrations->links() }}
            </div>

        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const courseSelect = document.getElementById('course_id');
    const cohortSelect = document.getElementById('cohort_id');

    function filterCohorts() {

        const selectedCourse = courseSelect.value;
        const selectedCohort = cohortSelect.value;

        Array.from(cohortSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const matchesCourse =
                !selectedCourse ||
                option.dataset.course === selectedCourse;

            option.hidden = !matchesCourse;
        });

        const selectedOption = cohortSelect.selectedOptions[0];

        if (
            selectedOption &&
            selectedOption.value &&
            selectedOption.hidden
        ) {
            cohortSelect.value = '';
        }
    }

    courseSelect.addEventListener('change', filterCohorts);

    filterCohorts();

});
</script>

@endsection
