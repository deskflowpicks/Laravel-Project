
@extends('layouts.app')

@section('title', $course->title . ' | Komdigital')

@section('description', $course->description ?? 'Explore this training programme at Komdigital.')

@section('content')

<section class="page-banner course-detail-banner">
    <div class="container">

        <a href="{{ route('courses') }}" class="course-back-link">
            &larr; Back to All Courses
        </a>

        <h1>{{ $course->title }}</h1>

        <p>
            Build practical digital skills and grow your opportunities.
        </p>

    </div>
</section>

<section class="section">
    <div class="container course-details">

        @if ($course->image)
            <img
                src="{{ asset('storage/' . $course->image) }}"
                alt="{{ $course->title }}"
                class="course-detail-image"
            >
        @endif

        <h2>About This Course</h2>

        <div class="course-full-description">
            @if ($course->description)
                {!! $course->description !!}
            @else
                <p>Course details will be announced soon.</p>
            @endif
        </div>

       <h2 class="course-info-heading">Course Information</h2>

        <div class="course-info-grid">

            <div class="course-info-card">
                <span class="course-info-label">Duration</span>
                <strong>{{ $course->duration ?? 'To be announced' }}</strong>
            </div>

            <div class="course-info-card">
                <span class="course-info-label">Course Fee</span>
                <strong>
                    {{ $course->fee !== null
                        ? 'GHS ' . number_format((float) $course->fee, 2)
                        : 'Contact Komdigital' }}
                </strong>
            </div>

            <div class="course-info-card">
                <span class="course-info-label">Training Format</span>
                <strong>To be announced</strong>
            </div>

        </div>

        <div class="course-actions course-detail-actions">

            <a href="{{ route('register', ['course' => $course->title]) }}"
            class="btn course-register-btn">
                Register for This Course
            </a>

            <a href="https://wa.me/{{ config('komdigital.whatsapp_number') }}?text={{ urlencode('Hello Komdigital, I would like to enrol in ' . $course->title . '. Please provide more information.') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="btn btn-whatsapp course-whatsapp-btn">
                Enquire on WhatsApp
            </a>

        </div>

        

    </div>
</section>

@endsection
