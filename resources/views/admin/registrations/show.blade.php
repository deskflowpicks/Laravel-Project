
@extends('layouts.app')

@section('title', 'Registration Details | Komdigital')

@section('content')



@php
    // Remove spaces, brackets, hyphens and other non-digit characters.
    $whatsappNumber = preg_replace('/\D+/', '', $registration->phone);

    // Convert Ghanaian local numbers to international format.
    if (str_starts_with($whatsappNumber, '0')) {
        $whatsappNumber = '233' . substr($whatsappNumber, 1);
    } elseif (!str_starts_with($whatsappNumber, '233')) {
        $whatsappNumber = '233' . $whatsappNumber;
    }

    // Get the course name.
    $courseName = $registration->cohort?->course?->title
        ?? $registration->course;

    // Prepare the WhatsApp message.
    $whatsappMessage = "Hello {$registration->full_name}, this is Komdigital. We are contacting you regarding your registration for {$courseName}. Thank you.";

    // Build the WhatsApp URL.
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber
        . '?text=' . urlencode($whatsappMessage);
@endphp

<section class="dashboard-section">
    <div class="container">

        <div class="dashboard-header">
            <div>
                <h1>Registration Details</h1>
                <p>Review the student's course application.</p>
            </div>

            <a href="{{ route('admin.registrations.index') }}"
               class="btn btn-primary">
                Back to Registrations
            </a>
        </div>

        <div class="dashboard-filter-card registration-details">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <h2>Student Information</h2>

            <div class="detail-item">
                <strong>Full Name:</strong>
                <span>{{ $registration->full_name }}</span>
            </div>

            <div class="detail-item">
                <strong>Email Address:</strong>
                <span>{{ $registration->email }}</span>
            </div>

            <div class="detail-item">
                <strong>Phone Number:</strong>
                <span>{{ $registration->phone }}</span>
            </div>
            
            @if ($whatsappNumber)
                <div class="whatsapp-contact">
                    <a href="{{ $whatsappUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-whatsapp">

                        Contact Student on WhatsApp

                    </a>
                </div>
            @endif


            <hr>

            <h2>Course Information</h2>

            <div class="detail-item">
                <strong>Course:</strong>
                <span>
                    {{ $registration->cohort?->course?->title ?? $registration->course }}
                </span>
            </div>

            <div class="detail-item">
                <strong>Cohort:</strong>
                <span>
                    {{ $registration->cohort?->cohort_name ?? 'Not assigned' }}
                </span>
            </div>

            <hr>

            <h2>Application Information</h2>

            <div class="detail-item">
                <strong>Registration Date:</strong>
                <span>{{ $registration->created_at->format('d M Y, h:i A') }}</span>
            </div>

            <div class="detail-item">
                <strong>Application Status:</strong>
                <span class="status-badge status-{{ strtolower($registration->status) }}">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>

            <div class="detail-item">
                <strong>Additional Message:</strong>
                <span>{{ $registration->message ?: 'No message provided.' }}</span>
            </div>

            @if ($registration->status === 'pending')

                <div class="registration-actions">

                    <form method="POST"
                        action="{{ route('admin.registrations.approve', $registration->id) }}"
                        onsubmit="return confirm('Are you sure you want to approve this application?')">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn btn-success">
                            Approve Application
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('admin.registrations.reject', $registration->id) }}"
                        onsubmit="return confirm('Are you sure you want to reject this application?')">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn btn-danger">
                            Reject Application
                        </button>
                    </form>

                </div>

            @endif

            

        </div>

    </div>
</section>

@endsection
