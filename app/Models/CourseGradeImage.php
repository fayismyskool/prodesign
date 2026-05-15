<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseGradeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_id',
        'image_path',
        'image_name',
        'order',
    ];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(CourseGrade::class, 'grade_id', 'id');
    }
}
