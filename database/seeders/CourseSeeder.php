<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::firstOrCreate(
            ['slug' => 'digital-marketing-masterclass'],
            [
                'title' => 'Digital Marketing Masterclass',
                'description' => 'Learn digital marketing strategies and practical techniques to grow businesses online.',
                'fee' => null,
                'duration' => null,
                'status' => 'active',
            ]
        );

        Course::firstOrCreate(
            ['slug' => 'social-media-page-management'],
            [
                'title' => 'Social Media Page Management',
                'description' => 'Learn how to manage social media pages, create content and grow online communities.',
                'fee' => null,
                'duration' => null,
                'status' => 'active',
            ]
        );
    }
}