<?php

use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'about')->name('about');

Route::view('/services', 'services')->name('services');

Route::get('/courses', [PublicCourseController::class, 'index'])
    ->name('courses');

Route::get('/courses/{slug}', [PublicCourseController::class, 'show'])
    ->name('courses.show');

Route::get('/register', [CourseRegistrationController::class, 'create'])
    ->name('register');

Route::post('/register', [CourseRegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('register.store');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/contact-messages', [ContactMessageController::class, 'index'])
            ->name('contact-messages.index');

        Route::get('/contact-messages/{id}', [ContactMessageController::class, 'show'])
            ->name('contact-messages.show');

        Route::patch('/contact-messages/{id}/status', [ContactMessageController::class, 'updateStatus'])
            ->name('contact-messages.update-status');

        Route::get('/registrations', [RegistrationController::class, 'index'])
            ->name('registrations.index');
        
        Route::get('/registrations/{id}', [RegistrationController::class, 'show'])
            ->name('registrations.show');

        Route::patch('/registrations/{id}/approve', [RegistrationController::class, 'approve'])
            ->name('registrations.approve');

        Route::patch('/registrations/{id}/reject', [RegistrationController::class, 'reject'])
            ->name('registrations.reject');

        Route::get('/courses', [CourseController::class, 'index'])
            ->name('courses.index');

        Route::get('/courses/create', [CourseController::class, 'create'])
            ->name('courses.create');

        Route::post('/courses', [CourseController::class, 'store'])
            ->name('courses.store');

        Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])
            ->name('courses.edit');

        Route::patch('/courses/{id}', [CourseController::class, 'update'])
            ->name('courses.update');

        Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
            ->name('courses.destroy');

        // Category Management
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::get('/categories/create', [CategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        // Edit a category
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        // Update a category
        Route::patch('/categories/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');

        // Delete a category
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');
    });