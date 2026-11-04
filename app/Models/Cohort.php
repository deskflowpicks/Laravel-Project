<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cohort extends Model
{
    protected $fillable = [
        'course_id',
        'cohort_name',
        'registration_open_date',
        'registration_close_date',
        'start_date',
        'end_date',
        'capacity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'registration_open_date' => 'date',
            'registration_close_date' => 'date',
            'start_date' => 'date',
            'end_date' => 'date',
            'capacity' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }
}