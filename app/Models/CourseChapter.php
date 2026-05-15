<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CourseChapter extends Model {
    use HasFactory;

    protected $fillable = ['order', 'id', 'title', 'description', 'grade_id', 'course_id', 'instructor_id', 'status'];

    public function chapterItems(): HasMany {
        return $this->hasMany(CourseChapterItem::class, 'chapter_id', 'id')->orderBy('order');
    }

    public function grade(): BelongsTo {
        return $this->belongsTo(CourseGrade::class, 'grade_id', 'id');
    }
    /**
     * Boot method to handle model events.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($courseChapter) {
            $courseChapter->chapterItems()->each(function ($chapterItem) {
                $chapterItem->delete();
            });
        });
    }
}
