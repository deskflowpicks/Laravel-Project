
@extends('layouts.app')

@section('title', 'Contact Messages | Komdigital')

@section('content')

<section class="dashboard-section">
    <div class="container">

        <div class="dashboard-header">
            <div>
                <h1>Contact Messages</h1>
                <p>View and manage enquiries submitted through your website.</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>
        </div>

        <div class="dashboard-filter-card">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h2>All Contact Enquiries</h2>

            <form action="{{ route('admin.contact-messages.index') }}"
                method="GET"
                class="message-filter-form">

                <div class="form-group">
                    <label for="search">Search Messages</label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, email or subject..."
                    >
                </div>

                <div class="form-group">
                    <label for="status">Filter by Status</label>

                    <select id="status" name="status">
                        <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>
                            All Messages
                        </option>

                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>
                            Unread
                        </option>

                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>
                            Read
                        </option>
                    </select>
                </div>

                <div class="message-filter-actions">
                    <button type="submit" class="btn btn-primary">
                        Apply Filters
                    </button>

                    <a href="{{ route('admin.contact-messages.index') }}"
                    class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>

            <p>
                Showing {{ $messages->count() }} of
                {{ $messages->total() }} message(s).
            </p>

            <div class="table-responsive">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date Received</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($messages as $message)

                            <tr>
                                <td>{{ $messages->firstItem() + $loop->index }}</td>

                                <td>{{ $message->name }}</td>

                                <td>{{ $message->email }}</td>

                                <td>{{ $message->subject }}</td>

                                <td>
                                    <span class="status-badge status-{{ strtolower($message->status) }}">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $message->created_at->format('d M Y, h:i A') }}
                                </td>

                                <td>
                                    <div class="message-table-actions">

                                        <a href="{{ route('admin.contact-messages.show', $message->id) }}"
                                        class="btn btn-primary">
                                            View Details
                                        </a>

                                        <form action="{{ route('admin.contact-messages.update-status', $message->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-secondary">
                                                {{ $message->status === 'unread' ? 'Mark as Read' : 'Mark as Unread' }}
                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="empty-table">
                                    No contact messages found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $messages->links() }}
            </div>

        </div>

    </div>
</section>

@endsection
