<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display all contact enquiries.
     */
    public function index(): View
    {
        $query = ContactMessage::query();

        // Search by name, email or subject
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Filter by message status
        if (request()->filled('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        $messages = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display an individual contact enquiry.
     */
    public function show($id): View
    {
        $message = ContactMessage::findOrFail($id);

        if ($message->status === 'unread') {
            $message->update([
                'status' => 'read',
            ]);
        }

        return view('admin.contact-messages.show', compact('message'));
    }

    /**
     * Update the read status of a contact message.
     */
    public function updateStatus($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->update([
            'status' => $message->status === 'unread'
                ? 'read'
                : 'unread',
        ]);

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Contact message status updated successfully.');
    }
}