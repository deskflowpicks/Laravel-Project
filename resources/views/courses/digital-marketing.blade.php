@extends('layouts.app')

@section('title', 'Digital Marketing Masterclass | Komdigital')

@section('content')

<section class="page-banner">
    <div class="container">
        <h1>Digital Marketing Masterclass</h1>
        <p>Build practical skills to market businesses online.</p>
    </div>
</section>

<section class="section">
    <div class="container course-details">

        <h2>About This Course</h2>

        <p>
            The Digital Marketing Masterclass introduces you to
            the essential strategies and tools used to promote
            products, services and brands online.
        </p>

        <h2>What You Will Learn</h2>

        <ul>
            <li>Introduction to digital marketing</li>
            <li>Understanding target audiences</li>
            <li>Social media marketing</li>
            <li>Content marketing fundamentals</li>
            <li>Search engine optimisation fundamentals</li>
            <li>Measuring digital marketing performance</li>
        </ul>

        <h2>Course Information</h2>

        <p>Duration: To be announced</p>
        <p>Course fee: Contact Komdigital</p>
        <p>Training format: To be announced</p>

        <div class="course-actions" style="margin-top: 25px;">

            <a href="{{ route('register', ['course' => 'Digital Marketing Masterclass']) }}"
               class="btn">
                Register Online
            </a>

            <a href="https://wa.me/{{ config('komdigital.whatsapp_number') }}?text={{ urlencode('Hello Komdigital, I would like to enrol in the Digital Marketing Masterclass.') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="btn btn-whatsapp">
                Enquire on WhatsApp
            </a>

        </div>

    </div>
</section>

@endsection