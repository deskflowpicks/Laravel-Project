@extends('layouts.app')

@section('title', 'Social Media Page Management | Komdigital')

@section('content')

<section class="page-banner">
    <div class="container">
        <h1>Social Media Page Management</h1>
        <p>Learn to manage and grow social media business pages.</p>
    </div>
</section>

<section class="section">
    <div class="container course-details">

        <h2>About This Course</h2>

        <p>
            This course introduces you to the skills required
            to manage social media accounts professionally,
            create engaging content and build online communities.
        </p>

        <h2>What You Will Learn</h2>

        <ul>
            <li>Social media management fundamentals</li>
            <li>Creating and optimising business pages</li>
            <li>Content planning and scheduling</li>
            <li>Designing engaging social media content</li>
            <li>Audience engagement and community management</li>
            <li>Social media analytics and reporting</li>
        </ul>

        <h2>Course Information</h2>

        <p>Duration: To be announced</p>
        <p>Course fee: Contact Komdigital</p>
        <p>Training format: To be announced</p>

        <div class="course-actions" style="margin-top: 25px;">

            <a href="{{ route('register', ['course' => 'Social Media Page Management']) }}"
               class="btn">
                Register Online
            </a>

            <a href="https://wa.me/{{ config('komdigital.whatsapp_number') }}?text={{ urlencode('Hello Komdigital, I would like to enrol in Social Media Page Management.') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="btn btn-whatsapp">
                Enquire on WhatsApp
            </a>

        </div>

    </div>
</section>

@endsection