
@extends('layouts.app')

@section('title', 'Contact Message Details | Komdigital')

@section('content')

<section class="dashboard-section">
    <div class="container">

        <div class="dashboard-header">
            <div>
                <h1>Contact Message Details</h1>
                <p>View the complete enquiry submitted through your website.</p>
            </div>

            <a href="{{ route('admin.contact-messages.index') }}"
               class="btn btn-secondary">
                Back to Messages
            </a>
        </div>

        <div class="dashboard-filter-card">

            <h2>Visitor Information</h2>

            <div class="message-details-grid">

                <div>
                    <strong>Name</strong>
                    <p>{{ $message->name }}</p>
                </div>

                <div>
                    <strong>Email Address</strong>
                    <p>{{ $message->email }}</p>
                </div>

                <div>
                    <strong>Phone Number</strong>
                    <p>{{ $message->phone ?: 'Not provided' }}</p>
                </div>

                <div>
                    <strong>Subject</strong>
                    <p>{{ $message->subject }}</p>
                </div>

                <div>
                    <strong>Date Received</strong>
                    <p>{{ $message->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <div>
                    <strong>Status</strong>
                    <p>
                        <span class="status-badge status-{{ strtolower($message->status) }}">
                            {{ ucfirst($message->status) }}
                        </span>
                    </p>
                </div>

            </div>

            <hr>

            <h2>Enquiry Message</h2>

            <div class="contact-message-content">
                {{ $message->message }}
            </div>

            <div class="message-action-buttons">

                <a href="mailto:{{ $message->email }}"
                   class="btn btn-primary">
                    Reply by Email
                </a>

                @if($message->phone)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $message->phone) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn btn-secondary">
                        Contact on WhatsApp
                    </a>
                @endif

            </div>

        </div>

    </div>
</section>

@endsection
