
@extends('layouts.app')

@section('title', 'Home | Komdigital')

@section('description', 'Build your digital skills, grow your business and achieve more with Komdigital.')

@section('content')

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">

            <div class="hero-wrapper">

                <div class="hero-content">

                    <span class="hero-label">
                        BUILD. MARKET. GROW.
                    </span>

                    <h1>
                        Transform Your Ideas Into
                        <span>Digital Growth.</span>
                    </h1>

                    <p>
                        We empower individuals and businesses with
                        practical digital skills, innovative technology
                        and creative solutions that help them succeed
                        in a digital world.
                    </p>

                    <div class="hero-buttons">

                        <a href="{{ route('courses') }}" class="btn">
                            Explore Our Courses
                        </a>

                        <a href="{{ route('home') }}#services"
                        class="btn btn-outline">
                            Discover What We Do
                        </a>

                    </div>

                </div>

                <div class="hero-image">

                    <img
                        src="{{ asset('images/komdigital-hero.jpg') }}"
                        alt="Komdigital digital business and technology solutions"
                    >

                </div>

            </div>

        </div>
    </section>

    <!-- WHO WE ARE SECTION -->
    <section class="section who-we-are" id="about">

        <div class="container">

            <div class="who-we-are-wrapper">

                <div class="who-we-are-content">

                    <span class="section-label">
                        WHO WE ARE
                    </span>

                    <h2>
                        Empowering People.
                        <span>Enabling Businesses.</span>
                    </h2>

                    <p>
                        Komdigital is a digital skills and technology
                        solutions brand committed to helping individuals
                        develop relevant digital skills and businesses
                        establish a stronger presence in the digital world.
                    </p>

                    <p>
                        Through practical training, creative thinking
                        and technology-driven solutions, we help turn
                        ideas into opportunities and challenges into
                        growth.
                    </p>

                    <a href="{{ route('home') }}#services" class="btn">
                        Discover What We Do
                    </a>

                </div>

                <div class="who-we-are-highlight">

                    <h3>Our Mission</h3>

                    <p>
                        To empower individuals and businesses with
                        the knowledge, skills and digital solutions
                        they need to grow and succeed.
                    </p>

                    <div class="mission-divider"></div>

                    <h3>Our Approach</h3>

                    <p>
                        We believe in practical learning, innovative
                        thinking and solutions that create real value.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- SERVICES SECTION -->
    <section class="section services-section" id="services">

        <div class="container">

            <div class="section-heading">

                <span class="section-label">
                    WHAT WE DO
                </span>

                <h2>
                    Digital Solutions That Move You Forward
                </h2>

                <p>
                    We combine technology, creativity and digital
                    expertise to help individuals and businesses
                    achieve more.
                </p>

            </div>

            <div class="services-grid">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>

                    <h3>Website Development</h3>

                    <p>
                        We create professional, responsive and
                        user-friendly websites that help businesses
                        establish a strong online presence.
                    </p>

                    <a href="{{ route('contact') }}">
                        Discuss Your Project →
                    </a>

                </div>


                <div class="service-card">

                    <div class="service-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <h3>Digital Marketing</h3>

                    <p>
                        We help businesses improve their online
                        visibility, reach their target audiences
                        and grow through effective digital strategies.
                    </p>

                    <a href="{{ route('contact') }}">
                        Discuss Your Project →
                    </a>

                </div>


                <div class="service-card">

                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <h3>Cybersecurity Solutions</h3>

                    <p>
                        We provide technology guidance and security
                        solutions to help businesses protect their
                        digital environments.
                    </p>

                    <a href="{{ route('contact') }}">
                        Discuss Your Project →
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- TRAINING COURSES SECTION -->
    <section class="section courses-preview-section" id="training">

        <div class="container">

            <div class="section-heading">

                <span class="section-label">
                    LEARN WITH KOMDIGITAL
                </span>

                <h2>
                    Develop Skills That Create Opportunities
                </h2>

                <p>
                    Gain practical digital skills through training
                    programmes designed to help you grow professionally
                    and succeed in today's digital world.
                </p>

            </div>

            @if ($courses->isNotEmpty())

                <div class="courses-preview-grid">

                    @foreach ($courses as $course)

                        <div class="preview-course-card">

                            <div class="preview-course-image">

                                @if ($course->image)
                                    <img
                                        src="{{ asset('storage/' . $course->image) }}"
                                        alt="{{ $course->title }}"
                                    >
                                @else
                                    <div class="preview-course-placeholder">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                @endif

                            </div>

                            <div class="preview-course-info">

                                <span class="course-category">
                                    {{ $course->category->name ?? 'General' }}
                                </span>

                                <h3>{{ $course->title }}</h3>

                                <p>
                                    {{ $course->short_description }}
                                </p>

                                <div class="preview-course-meta">

                                    @if ($course->duration)
                                        <span>
                                            <i class="far fa-clock"></i>
                                            {{ $course->duration }}
                                        </span>
                                    @endif

                                    @if ($course->fee !== null)
                                        <span>
                                            GHS {{ number_format($course->fee, 2) }}
                                        </span>
                                    @endif

                                </div>

                                <a
                                    href="{{ route('courses.show', $course->slug) }}"
                                    class="preview-course-link"
                                >
                                    Explore Course →
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="no-courses-message">
                    <p>Our training programmes will be available soon.</p>
                </div>

            @endif

            <div class="courses-preview-action">

                <a href="{{ route('courses') }}" class="btn">
                    View All Courses
                </a>

            </div>

        </div>

    </section>

    <!-- WHY CHOOSE KOMDIGITAL SECTION -->
    <section class="section why-choose-section">

        <div class="container">

            <div class="section-heading">

                <span class="section-label">
                    WHY KOMDIGITAL
                </span>

                <h2>
                    Your Partner in Digital Growth
                </h2>

                <p>
                    We combine practical knowledge, technology
                    and creative thinking to help you move forward.
                </p>

            </div>

            <div class="why-choose-grid">

                <div class="why-choose-card">

                    <div class="why-choose-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>

                    <h3>Practical Learning</h3>

                    <p>
                        Develop useful digital skills through
                        practical, relevant and career-focused training.
                    </p>

                </div>


                <div class="why-choose-card">

                    <div class="why-choose-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>

                    <h3>Business-Focused Solutions</h3>

                    <p>
                        Get digital solutions designed to address
                        real business needs and opportunities.
                    </p>

                </div>


                <div class="why-choose-card">

                    <div class="why-choose-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <h3>Growth-Oriented Approach</h3>

                    <p>
                        We focus on strategies and skills that
                        support continuous improvement and growth.
                    </p>

                </div>


                <div class="why-choose-card">

                    <div class="why-choose-icon">
                        <i class="fas fa-headset"></i>
                    </div>

                    <h3>Dedicated Support</h3>

                    <p>
                        Receive guidance and support as you develop
                        your skills or work towards your business goals.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- HOW WE WORK SECTION -->
    <section class="section how-we-work-section">

        <div class="container">

            <div class="section-heading">

                <span class="section-label">
                    OUR PROCESS
                </span>

                <h2>
                    A Simple Approach to Achieving More
                </h2>

                <p>
                    Whether you're developing new skills or seeking
                    digital solutions for your business, we make
                    the process clear and straightforward.
                </p>

            </div>

            <div class="process-grid">

                <div class="process-card">

                    <span class="process-number">01</span>

                    <div class="process-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <h3>Discover</h3>

                    <p>
                        We take time to understand your goals,
                        needs and challenges.
                    </p>

                </div>


                <div class="process-card">

                    <span class="process-number">02</span>

                    <div class="process-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>

                    <h3>Plan</h3>

                    <p>
                        We identify the right strategy and
                        approach to achieve your objectives.
                    </p>

                </div>


                <div class="process-card">

                    <span class="process-number">03</span>

                    <div class="process-icon">
                        <i class="fas fa-rocket"></i>
                    </div>

                    <h3>Deliver</h3>

                    <p>
                        We provide practical training or
                        digital solutions tailored to your needs.
                    </p>

                </div>


                <div class="process-card">

                    <span class="process-number">04</span>

                    <div class="process-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <h3>Support & Grow</h3>

                    <p>
                        We provide guidance and support to help
                        you continue making progress.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- CONTACT / CALL TO ACTION SECTION -->
    <section class="section contact-cta-section" id="contact">
        <div class="container">
            <div class="contact-cta-content">
                <span class="section-label">LET'S WORK TOGETHER</span>

                <h2>Ready to Build, Market and Grow?</h2>

                <p>
                    Whether you want to develop valuable digital skills
                    or need technology solutions for your business,
                    Komdigital is ready to help you take the next step.
                </p>

                <div class="contact-cta-buttons">
                    <a href="{{ route('contact') }}" class="btn">
                        Get in Touch
                    </a>

                    <a href="{{ route('courses') }}" class="btn btn-outline">
                        Explore Our Courses
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
