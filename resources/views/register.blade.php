
@extends('layouts.app')

@section('title', 'Course Registration | Komdigital')

@section('content')


<section class="page-banner">
    <div class="container">
        <a href="{{ route('courses') }}" class="course-back-link">
            &larr; Back to All Courses
        </a>

        @if ($selectedCourse)
            <h1>Register for {{ $selectedCourse->title }}</h1>
            <p>
                Complete your registration for this training programme
                and take the next step in your digital learning journey.
            </p>
        @else
            <h1>Course Registration</h1>
            <p>Take the next step in your digital learning journey.</p>
        @endif

    </div>
</section>


<section class="section section-light">
    <div class="container">

        <div class="registration-wrapper">
            
            <div class="section-heading">
                <h2>Register for a Course</h2>
                <p>
                    Complete the form below. Our team will review
                    your registration and contact you.
                </p>
            </div>

            @if(session('success'))
                <div class="alert-success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error" role="alert">
                    <strong>Please correct the following:</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($selectedCourse)
                    <div class="selected-course-card">

                        <span class="selected-course-label">
                            COURSE SELECTED
                        </span>

                        <h3>{{ $selectedCourse->title }}</h3>

                        <p>
                            You are registering for this training programme.
                            Please select your preferred available cohort below.
                        </p>

                    </div>
                @endif

            <form action="{{ route('register.store') }}" method="POST">

                @csrf

                @if ($selectedCourse)
                    <input
                        type="hidden"
                        name="course"
                        value="{{ $selectedCourse->slug }}"
                    >
                @endif

                <div class="form-group">
                    <label for="full_name">Full Name</label>

                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email address"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Enter your phone number"
                        required
                    >
                </div>


                <!-- Cohort Selection -->
                <div class="form-group">

                    <label for="cohort_id">
                        {{ $selectedCourse ? 'Select Cohort' : 'Select Course and Cohort' }}
                    </label>

                    <select id="cohort_id" name="cohort_id" required>

                        <option value="">
                            {{ $selectedCourse ? 'Choose a cohort' : 'Choose a course and cohort' }}
                        </option>

                        @foreach($cohorts as $cohort)

                            <option
                                value="{{ $cohort->id }}"
                                {{ old('cohort_id') == $cohort->id ? 'selected' : '' }}
                            >
                                @if (!$selectedCourse)
                                    {{ $cohort->course->title }} —
                                @endif

                                {{ $cohort->cohort_name }}
                                (Starts {{ $cohort->start_date->format('d M Y') }})
                            </option>

                        @endforeach

                    </select>

                    @if($cohorts->isEmpty())

                        @if($selectedCourse)
                            <p class="error-text">
                                * There are currently no cohorts accepting registrations
                                for <b>"{{ $selectedCourse->title }}"</b>.
                                Please check back later.
                            </p>
                        @else
                            <p class="error-text">
                               * No cohorts are currently accepting registrations.
                                Please check back later.
                            </p>
                        @endif

                    @endif

                </div>

                <div class="form-group">
                    <label for="message">
                        Additional Information (Optional)
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="4"
                        placeholder="Tell us anything else we should know"
                    >{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn">
                    Submit Registration
                </button>

            </form>

            <p style="margin-top: 20px; font-size: 14px; color: #526078;">
                Your registration is subject to review.
                Komdigital will contact you before confirming your place.
            </p>

        </div>

    </div>
</section>

@endsection
