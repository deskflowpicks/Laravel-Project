<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $courses = Course::with('category')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('courses'));
    }
}