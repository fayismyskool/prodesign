<?php

namespace Modules\CourseApi\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\CourseApi\Database\factories\CourseFilterTranslationFactory;

class CourseFilterTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['course_filter_id', 'lang_code', 'title'];

    function courseFilter() : BelongsTo
    {
        return $this->belongsTo(CourseFilter::class, 'course_filter_id');
    }
}
