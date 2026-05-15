<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'instructor_id',
        'order',
        'status',
    ];

    public function chapters(): HasMany
    {
        return $this->hasMany(CourseChapter::class, 'grade_id', 'id')->orderBy('order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CourseGradeImage::class, 'grade_id', 'id')->orderBy('order');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
