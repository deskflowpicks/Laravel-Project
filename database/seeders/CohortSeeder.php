<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Cohort;

class CohortSeeder extends Seeder
{
    public function run(): void
    {
        $digitalMarketing = Course::where(
            'slug',
            'digital-marketing-masterclass'
        )->firstOrFail();

        $socialMedia = Course::where(
            'slug',
            'social-media-page-management'
        )->firstOrFail();

        Cohort::firstOrCreate(
            [
                'course_id' => $digitalMarketing->id,
                'cohort_name' => 'January 2027 Cohort',
            ],
            [
                'registration_open_date' => '2026-11-01',
                'registration_close_date' => '2027-01-10',
                'start_date' => '2027-01-15',
                'end_date' => '2027-02-26',
                'capacity' => 30,
                'status' => 'open',
            ]
        );

        Cohort::firstOrCreate(
            [
                'course_id' => $socialMedia->id,
                'cohort_name' => 'January 2027 Cohort',
            ],
            [
                'registration_open_date' => '2026-11-01',
                'registration_close_date' => '2027-01-10',
                'start_date' => '2027-01-15',
                'end_date' => '2027-02-26',
                'capacity' => 30,
                'status' => 'open',
            ]
        );
    }
}