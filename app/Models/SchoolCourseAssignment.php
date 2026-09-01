<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolCourseAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'course_id',
        'user_id',
        'role_in_school',
        'order_id',
        'assigned_at',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /**
     * The school that made this assignment.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    /**
     * The course that was assigned.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * The user (teacher/student) to whom the course was assigned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The order through which the school purchased this course.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(\Modules\Order\app\Models\Order::class, 'order_id');
    }

    /**
     * Scope to filter only active assignments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter revoked assignments.
     */
    public function scopeRevoked($query)
    {
        return $query->where('status', 'revoked');
    }
}
