<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'role_in_school',
        'id_number',
        'status',
    ];

    /**
     * The school (User with role=school) that owns this membership.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    /**
     * The user (teacher or student) who is a member of the school.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope to filter only teachers.
     */
    public function scopeTeachers($query)
    {
        return $query->where('role_in_school', 'teacher');
    }

    /**
     * Scope to filter only students.
     */
    public function scopeStudents($query)
    {
        return $query->where('role_in_school', 'student');
    }

    /**
     * Scope to filter only active members.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
