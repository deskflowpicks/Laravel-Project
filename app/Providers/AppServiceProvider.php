<?php

namespace App\Providers;

use App\Models\CourseRegistration;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'admin.dashboard'], function ($view) {

            // Count all pending student registrations.
            $pendingRegistrationsCount = CourseRegistration::where(
                'status',
                'pending'
            )->count();

            // Count all unread contact messages.
            $unreadContactMessagesCount = ContactMessage::where(
                'status',
                'unread'
            )->count();

            // Share both counts with the main layout.
            $view->with([
                'pendingRegistrationsCount' => $pendingRegistrationsCount,
                'unreadContactMessagesCount' => $unreadContactMessagesCount,
            ]);

        });
    }
}
