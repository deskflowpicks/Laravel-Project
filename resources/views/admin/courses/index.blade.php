
@extends('layouts.app')

@section('title', 'Manage Courses | Komdigital')

@section('content')

<section class="admin-section">

    <div class="admin-container">

        <div class="admin-page-header">
            <div>
                <h1>Manage Courses</h1>
                <p>View and manage all Komdigital courses.</p>
            </div>

            <a href="{{ route('admin.courses.create') }}"
            class="btn btn-primary">
                Add New Course
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Course Title</th>
                        <th>Category</th>
                        <th>Fee (GHS)</th>
                        <th>Duration</th>
                        <th>Cohorts</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($courses as $course)

                        <tr>
                            <td>{{ $courses->firstItem() + $loop->index }}</td>

                           <td>
                                @if ($course->image)
                                    <img
                                        src="{{ asset('storage/' . $course->image) }}"
                                        alt="{{ $course->title }}"
                                        class="admin-course-thumbnail"
                                    >
                                @else
                                    <span class="no-course-image">No image</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $course->title }}</strong>
                            </td>

                            <td>
                                {{ $course->category->name ?? 'Uncategorised' }}
                            </td>

                            <td>
                                {{ $course->fee !== null
                                    ? number_format((float) $course->fee, 2)
                                    : 'Not set' }}
                            </td>

                            <td>{{ $course->duration ?? 'Not set' }}</td>

                            <td>{{ $course->cohorts_count }}</td>

                            <td>
                                <span class="status-badge status-{{ $course->status }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="course-actions">

                                    <a href="{{ route('admin.courses.edit', $course->id) }}"
                                    class="btn btn-primary btn-sm">
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.courses.destroy', $course->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                No courses found.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="admin-pagination">
            {{ $courses->links() }}
        </div>

    </div>

</section>

@endsection
