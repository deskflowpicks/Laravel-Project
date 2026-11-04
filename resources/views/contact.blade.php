
@extends('layouts.app')

@section('title', 'Contact Us | Komdigital')

@section('content')

<!-- CONTACT HERO -->
<section class="contact-hero">
    <div class="container">
        <span class="section-label">GET IN TOUCH</span>
        <h1>Let's Start a Conversation</h1>
        <p>
            Have a project in mind, need help with our services,
            or want to learn more about our courses?
            We'd love to hear from you.
        </p>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="section contact-page-section">
    <div class="container">

        <div class="contact-page-grid">

            <!-- CONTACT INFORMATION -->
            <div class="contact-info">
                <span class="section-label">CONTACT KOMDIGITAL</span>

                <h2>We're Here to Help You Move Forward.</h2>

                <p>
                    Whether you're an individual looking to develop
                    digital skills or a business seeking technology
                    solutions, get in touch with our team.
                </p>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h3>Email Enquiries</h3>
                        <p>Send us your questions and enquiries.</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3>Course Enquiries</h3>
                        <p>Ask us about our training programmes.</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div>
                        <h3>Business Solutions</h3>
                        <p>Let's discuss how we can support your business.</p>
                    </div>
                </div>
            </div>

            <!-- CONTACT FORM -->
            <div class="contact-form-wrapper">

                <h2>Send Us a Message</h2>
                <p>Complete the form below and we'll get back to you.</p>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            required
                        >
                        @error('name')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
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
                        @error('email')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number <span>(Optional)</span></label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter your phone number"
                        >
                        @error('phone')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select an enquiry subject</option>
                            <option value="General Enquiry" {{ old('subject') == 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                            <option value="Course Enquiry" {{ old('subject') == 'Course Enquiry' ? 'selected' : '' }}>Course Enquiry</option>
                            <option value="Website Development" {{ old('subject') == 'Website Development' ? 'selected' : '' }}>Website Development</option>
                            <option value="Digital Marketing" {{ old('subject') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                            <option value="Cybersecurity Solutions" {{ old('subject') == 'Cybersecurity Solutions' ? 'selected' : '' }}>Cybersecurity Solutions</option>
                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('subject')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            placeholder="How can we help you?"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn contact-submit-btn">
                        Send Message
                        <i class="fas fa-paper-plane"></i>
                    </button>

                </form>
            </div>

        </div>
    </div>
</section>

@endsection
