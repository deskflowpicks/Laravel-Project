
@extends('layouts.app')

@section('title', 'Admin Dashboard | Komdigital')

@section('content')

<section class="dashboard-section">

    <div class="container">

        {{-- Dashboard heading --}}
        <div class="dashboard-header">
            <div>
                <h1>Komdigital Admin Dashboard</h1>
                <p>Welcome, {{ auth()->user()->name }}.</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-primary">
                    Logout
                </button>
            </form>
        </div>

        {{-- Overall statistics --}}
        <div class="dashboard-heading">
            <h2>Overall Statistics</h2>
            <p>A summary of Komdigital's courses and student registrations.</p>
        </div>

        <div class="dashboard-grid">

            {{-- Total Courses --}}
            <a href="{{ route('admin.courses.index') }}" class="dashboard-card dashboard-card-link">
                <h3>Total Courses</h3>
                <p class="dashboard-number">{{ $totalCourses }}</p>
                <span>Manage Courses →</span>
            </a>

            {{-- Total Cohorts --}}
            <div class="dashboard-card">
                <h3>Total Cohorts</h3>
                <p class="dashboard-number">{{ $totalCohorts }}</p>
                <span>Course Cohorts</span>
            </div>

            {{-- Total Registrations --}}
            <a href="{{ route('admin.registrations.index') }}" class="dashboard-card dashboard-card-link">
                <h3>Total Registrations</h3>
                <p class="dashboard-number">{{ $totalRegistrations }}</p>
                <span>View Registrations →</span>
            </a>

            {{-- Pending Applications --}}
            <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" class="dashboard-card dashboard-card-link">
                <h3>Pending Applications</h3>
                <p class="dashboard-number">{{ $pendingRegistrations }}</p>
                <span>View Pending →</span>
            </a>

            {{-- Approved Students --}}
            <a href="{{ route('admin.registrations.index', ['status' => 'approved']) }}" class="dashboard-card dashboard-card-link">
                <h3>Approved Students</h3>
                <p class="dashboard-number">{{ $approvedRegistrations }}</p>
                <span>View Approved →</span>
            </a>

            {{-- Rejected Applications --}}
            <a href="{{ route('admin.registrations.index', ['status' => 'rejected']) }}" class="dashboard-card dashboard-card-link">
                <h3>Rejected Applications</h3>
                <p class="dashboard-number">{{ $rejectedRegistrations }}</p>
                <span>View Rejected →</span>
            </a>

            {{-- Unread Contact Messages --}}
            <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}" class="dashboard-card dashboard-card-link">
                <h3>Unread Messages</h3>
                <p class="dashboard-number">{{ $unreadContactMessagesCount }}</p>
                <span>View Messages →</span>
            </a>

        </div>

        {{-- Registration filters --}}
        <div class="dashboard-heading">
            <h2>Registration Statistics</h2>
            <p>Filter student registrations by course and cohort.</p>
        </div>

        <div class="dashboard-filter-card">

            <form method="GET" action="{{ route('admin.dashboard') }}">

                <div class="dashboard-filter-grid">

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
                                    data-course-id="{{ $cohort->course_id }}"
                                    {{ request('cohort_id') == $cohort->id ? 'selected' : '' }}
                                >
                                    {{ $cohort->course->title }}
                                    — {{ $cohort->cohort_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="dashboard-filter-actions">

                    <button type="submit" class="btn btn-primary">
                        Apply Filters
                    </button>

                    <a href="{{ route('admin.dashboard') }}"
                       class="btn btn-secondary">
                        Clear Filters
                    </a>

                </div>

            </form>

        </div>

        {{-- Filtered registration statistics --}}
        <div class="dashboard-heading">
            <h2>Filtered Results</h2>
        </div>

        <div class="dashboard-grid">

            {{-- Filtered Total Registrations --}}
            <a href="{{ route('admin.registrations.index', request()->only('course_id', 'cohort_id')) }}"
            class="dashboard-card dashboard-card-link">
                <h3>Total Registrations</h3>
                <p class="dashboard-number">{{ $filteredTotal }}</p>
                <span>View Results →</span>
            </a>

            {{-- Filtered Pending --}}
            <a href="{{ route('admin.registrations.index', array_merge(request()->only('course_id', 'cohort_id'), ['status' => 'pending'])) }}"
            class="dashboard-card dashboard-card-link">
                <h3>Pending</h3>
                <p class="dashboard-number">{{ $filteredPending }}</p>
                <span>View Pending →</span>
            </a>

            {{-- Filtered Approved --}}
            <a href="{{ route('admin.registrations.index', array_merge(request()->only('course_id', 'cohort_id'), ['status' => 'approved'])) }}"
            class="dashboard-card dashboard-card-link">
                <h3>Approved</h3>
                <p class="dashboard-number">{{ $filteredApproved }}</p>
                <span>View Approved →</span>
            </a>

            {{-- Filtered Rejected --}}
            <a href="{{ route('admin.registrations.index', array_merge(request()->only('course_id', 'cohort_id'), ['status' => 'rejected'])) }}"
            class="dashboard-card dashboard-card-link">
                <h3>Rejected</h3>
                <p class="dashboard-number">{{ $filteredRejected }}</p>
                <span>View Rejected →</span>
            </a>

        </div>

    </div>

</section>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const courseSelect = document.getElementById('course_id');
        const cohortSelect = document.getElementById('cohort_id');

        const cohortOptions = Array.from(cohortSelect.options).slice(1);

        function updateCohorts() {

            const selectedCourseId = courseSelect.value;

            cohortOptions.forEach(function (option) {

                const belongsToSelectedCourse =
                    !selectedCourseId ||
                    option.dataset.courseId === selectedCourseId;

                option.hidden = !belongsToSelectedCourse;
                option.disabled = !belongsToSelectedCourse;

            });

            // Clear the selected cohort if it doesn't belong
            // to the currently selected course.
            const selectedOption = cohortSelect.selectedOptions[0];

            if (selectedOption && selectedOption.disabled) {
                cohortSelect.value = '';
            }
        }

        // Update cohorts when the page loads.
        updateCohorts();

        // Update cohorts whenever the course changes.
        courseSelect.addEventListener('change', updateCohorts);

    });
</script>
@endsection
