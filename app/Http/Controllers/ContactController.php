<?php

namespace App\Http\Controllers;

use App\Mail\ContactEnquiryReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Save the enquiry first.
        $contactMessage = ContactMessage::create($validated);

        // Attempt to send the notification email.
        try {
            Mail::to(config('mail.contact_recipient'))
                ->send(new ContactEnquiryReceived($contactMessage));

            return redirect()
                ->route('contact')
                ->with('success', 'Thank you for contacting Komdigital. Your message has been received.');
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('contact')
                ->with('success', 'Your enquiry has been saved successfully. We will process it shortly.')
                ->with('email_warning', 'Email notification could not be sent at this time.');
        }
    }
}