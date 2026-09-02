<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SchoolCourseAssignment;
use App\Models\SchoolMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Order\app\Models\Enrollment;
use Modules\Order\app\Models\Order;

class SchoolCourseController extends Controller
{
    /**
     * Show purchased courses & their assignment status.
     */
    public function index(): View
    {
        $school = userAuth();

        // Get all courses the school has purchased via completed orders
        $purchasedCourseIds = Enrollment::where('user_id', $school->id)->pluck('course_id')->unique();

        $courses = Course::whereIn('id', $purchasedCourseIds)->withTrashed()->paginate(15);

        // Load assignment counts per course
        $assignmentCounts = SchoolCourseAssignment::where('school_id', $school->id)
            ->active()
            ->selectRaw('course_id, count(*) as total')
            ->groupBy('course_id')
            ->pluck('total', 'course_id');

        return view('frontend.school-dashboard.courses.index', compact('courses', 'assignmentCounts'));
    }

    /**
     * Show assignment form for a course.
     */
    public function assign(int $courseId): View
    {
        $school = userAuth();
        $course = Course::withTrashed()->findOrFail($courseId);

        // Verify the school has purchased this course
        $enrolled = Enrollment::where('user_id', $school->id)
            ->where('course_id', $courseId)
            ->exists();

        if (!$enrolled) {
            abort(403, 'You have not purchased this course.');
        }

        // Get all school members
        $members = SchoolMember::with('user')
            ->where('school_id', $school->id)
            ->active()
            ->get();

        // Get existing active assignments for this course
        $existingAssignments = SchoolCourseAssignment::where('school_id', $school->id)
            ->where('course_id', $courseId)
            ->active()
            ->pluck('user_id')
            ->toArray();

        $capacity = $course->capacity > 0 ? (int) $course->capacity : null;
        $assignedCount = count($existingAssignments);
        $remainingSlots = $capacity !== null ? max(0, $capacity - $assignedCount) : null;

        return view('frontend.school-dashboard.courses.assign', compact(
            'course', 'members', 'existingAssignments', 'capacity', 'assignedCount', 'remainingSlots'
        ));
    }

    /**
     * Process course assignment to selected members with capacity validation.
     */
    public function storeAssignment(Request $request, int $courseId): RedirectResponse
    {
        $request->validate([
            'member_ids'   => 'required|array|min:1',
            'member_ids.*' => 'exists:school_members,id',
        ]);

        $school = userAuth();
        $course = Course::withTrashed()->findOrFail($courseId);

        // Verify purchase
        $enrolled = Enrollment::where('user_id', $school->id)
            ->where('course_id', $courseId)
            ->exists();

        if (!$enrolled) {
            abort(403, 'You have not purchased this course.');
        }

        $capacity = $course->capacity > 0 ? (int) $course->capacity : null;

        // Current active assignments count
        $currentAssignedCount = SchoolCourseAssignment::where('school_id', $school->id)
            ->where('course_id', $courseId)
            ->active()
            ->count();

        // Get user IDs already assigned
        $alreadyAssignedUserIds = SchoolCourseAssignment::where('school_id', $school->id)
            ->where('course_id', $courseId)
            ->active()
            ->pluck('user_id')
            ->toArray();

        // Selected members
        $membersToAssign = SchoolMember::whereIn('id', $request->member_ids)
            ->where('school_id', $school->id)
            ->get();

        // Filter for new assignments only
        $newMembers = $membersToAssign->reject(function ($m) use ($alreadyAssignedUserIds) {
            return in_array($m->user_id, $alreadyAssignedUserIds);
        });

        $newCount = $newMembers->count();

        if ($newCount === 0) {
            $notification = ['messege' => __('All selected members are already assigned to this course.'), 'alert-type' => 'info'];
            return redirect()->back()->with($notification);
        }

        // Validate capacity limit if set
        if ($capacity !== null) {
            $remainingSlots = max(0, $capacity - $currentAssignedCount);
            if ($newCount > $remainingSlots) {
                $notification = [
                    'messege' => __("Cannot assign :count members. This course has a capacity limit of :limit seats (:assigned assigned, only :remaining available).", [
                        'count'     => $newCount,
                        'limit'     => $capacity,
                        'assigned'  => $currentAssignedCount,
                        'remaining' => $remainingSlots,
                    ]),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($notification);
            }
        }

        DB::transaction(function () use ($newMembers, $school, $courseId) {
            foreach ($newMembers as $member) {
                SchoolCourseAssignment::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'course_id' => $courseId,
                        'user_id'   => $member->user_id,
                    ],
                    [
                        'role_in_school' => $member->role_in_school,
                        'status'         => 'active',
                        'assigned_at'    => now(),
                    ]
                );

                Enrollment::firstOrCreate(
                    [
                        'user_id'   => $member->user_id,
                        'course_id' => $courseId,
                    ],
                    [
                        'has_access' => 1,
                    ]
                );
            }
        });

        $notification = ['messege' => __(':count member(s) assigned successfully.', ['count' => $newCount]), 'alert-type' => 'success'];
        return redirect()->route('school.courses.index')->with($notification);
    }

    /**
     * Revoke a course assignment.
     */
    public function revokeAssignment(int $assignmentId): RedirectResponse
    {
        $assignment = SchoolCourseAssignment::findOrFail($assignmentId);

        if ($assignment->school_id !== userAuth()->id) {
            abort(403);
        }

        $assignment->update(['status' => 'revoked']);

        // Also remove the enrollment
        Enrollment::where('user_id', $assignment->user_id)
            ->where('course_id', $assignment->course_id)
            ->delete();

        $notification = ['messege' => __('Assignment revoked.'), 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    /**
     * Show all assignments for a course with member progress.
     */
    public function assignments(int $courseId): View
    {
        $school = userAuth();
        $course = Course::withTrashed()->findOrFail($courseId);

        $assignments = SchoolCourseAssignment::with('user')
            ->where('school_id', $school->id)
            ->where('course_id', $courseId)
            ->orderByDesc('id')
            ->paginate(20);

        $totalLectures = \App\Models\CourseChapterItem::whereHas('chapter', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->count();

        foreach ($assignments as $assignment) {
            $watchedCount = \App\Models\CourseProgress::where('user_id', $assignment->user_id)
                ->where('course_id', $course->id)
                ->where('watched', 1)
                ->count();

            $assignment->total_lectures = $totalLectures;
            $assignment->watched_lectures = $watchedCount;
            $assignment->progress_percent = $totalLectures > 0 ? round(($watchedCount / $totalLectures) * 100) : 0;
        }

        return view('frontend.school-dashboard.courses.assignments', compact('course', 'assignments'));
    }
}
