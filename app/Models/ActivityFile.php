<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'file_path',
        'file_name',
        'file_type',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(CourseChapterLesson::class, 'lesson_id', 'id');
    }
}
