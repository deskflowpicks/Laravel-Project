
@extends('layouts.app')

@section('title', 'Our Courses | Komdigital')

@section('description', 'Explore practical digital marketing and social media management courses at Komdigital.')

@section('content')

<section class="page-banner">
    <div class="container">
        <h1>Our Courses</h1>
        <p>Develop practical digital skills and grow your opportunities.</p>
    </div>

    <br>
    <form action="{{ route('courses') }}" method="GET" class="course-search-form">

        <div class="course-search-input">
            <input
                type="search"
                name="search"
                placeholder="Search courses by title, category or keyword..."
                value="{{ $search ?? '' }}"
            >

            <button type="submit" class="btn">
                Search
            </button>
        </div>

        @if (!empty($search))
            <a href="{{ route('courses') }}" class="course-clear-search">
                Clear Search
            </a>
        @endif

    </form>
</section>

<section class="section">
    <div class="container">

        <div class="section-heading">
            <h2>Explore Our Training Programmes</h2>
            <p>
                Learn practical skills through training designed
                to help you succeed in the digital world.
            </p>
        </div>

        
        


        <div class="courses-grid">

            @forelse ($courses as $course)

                <div class="course-card">

                    @if ($course->image)
                        <img
                            src="{{ asset('storage/' . $course->image) }}"
                            alt="{{ $course->title }}"
                            class="course-image"
                        >
                    @else
                        <div class="course-image course-image-placeholder">
                            <span>Komdigital</span>
                        </div>
                    @endif

                    <div class="course-info">

                        <span class="course-category">
                            {{ $course->category->name ?? 'General' }}
                        </span>

                        <h3>{{ $course->title }}</h3>

                        <p class="course-description">
                            {{ $course->short_description ?? 'Course details will be announced soon.' }}
                        </p>

                        <div class="course-meta">

                            <span>
                                Duration:
                                {{ $course->duration ?? 'To be announced' }}
                            </span>

                            <span>
                                Fees:
                                {{ $course->fee !== null
                                    ? 'GHS ' . number_format((float) $course->fee, 2)
                                    : 'Contact us' }}
                            </span>

                        </div>

                        <div class="course-actions">

                            <a href="{{ route('courses.show', $course->slug) }}"
                               class="btn btn-sm">
                                View Details
                            </a>

                            <a href="{{ route('register', ['course' => $course->slug]) }}"
                                class="btn btn-sm btn-outline-color">
                                    Register Online
                            </a>

                            <a href="https://wa.me/{{ config('komdigital.whatsapp_number') }}?text={{ urlencode('Hello Komdigital, I am interested in ' . $course->title . '. Please provide more information.') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-sm btn-whatsapp">
                                WhatsApp
                            </a>

                        </div>

                    </div>
                </div>

            @empty

                <div class="empty-courses">

                    @if (!empty($search))

                        <h3>No Matching Courses Found</h3>

                        <p>
                            We couldn't find any courses matching
                            "{{ $search }}".
                            Try another keyword or browse all our courses.
                        </p>

                        <a href="{{ route('courses') }}" class="btn">
                            View All Courses
                        </a>

                    @else

                        <h3>No Courses Available Yet</h3>

                        <p>
                            We are preparing our training programmes.
                            Please check back soon.
                        </p>

                    @endif

                </div>

            @endforelse

        </div>

        @if ($courses->hasPages())
            <div class="course-pagination">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
