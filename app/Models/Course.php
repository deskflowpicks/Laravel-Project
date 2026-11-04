<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'description',
        'short_description',
        'image',
        'fee',
        'duration',
        'status',
    ];

    public function cohorts(): HasMany
    {
        return $this->hasMany(Cohort::class);
    }

    /**
     * Get the category this course belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}