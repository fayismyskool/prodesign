<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SchoolMember;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Str;

class SchoolStudentController extends Controller
{
    public function index(): View
    {
        $students = SchoolMember::with('user')
            ->where('school_id', userAuth()->id)
            ->students()
            ->orderByDesc('id')
            ->paginate(15);

        return view('frontend.school-dashboard.students.index', compact('students'));
    }

    public function create(): View
    {
        $grades = ['Nursery', 'LKG', 'UKG', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'];
        $sections = ['A', 'B', 'C', 'D', 'E', 'F'];
        $boards = ['CBSE', 'ICSE', 'State Board', 'IB (International Baccalaureate)', 'Cambridge (IGCSE)', 'Other'];
        
        $currentYear = (int) date('Y');
        $academicYears = [
            ($currentYear - 2) . '-' . ($currentYear - 1),
            ($currentYear - 1) . '-' . $currentYear,
            $currentYear . '-' . ($currentYear + 1),
            ($currentYear + 1) . '-' . ($currentYear + 2),
            ($currentYear + 2) . '-' . ($currentYear + 3),
        ];

        return view('frontend.school-dashboard.students.create', compact('grades', 'sections', 'boards', 'academicYears'));
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_import_template.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = ['Name', 'Email', 'Roll_Number', 'Grade', 'Section', 'Academic_Year', 'Board', 'Password'];
        $sample  = ['John Smith', 'student@example.com', 'STD-101', 'Grade 6', 'A', '2026-2027', 'CBSE', '123456'];

        $callback = function () use ($columns, $sample) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, $sample);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show(SchoolMember $member): View
    {
        if ($member->school_id !== userAuth()->id || $member->role_in_school !== 'student') {
            abort(403);
        }

        $member->load('user');

        // Get all courses assigned to this student by this school
        $assignments = \App\Models\SchoolCourseAssignment::with('course')
            ->where('school_id', userAuth()->id)
            ->where('user_id', $member->user_id)
            ->get();

        foreach ($assignments as $assignment) {
            $course = $assignment->course;
            if ($course) {
                $totalLectures = \App\Models\CourseChapterItem::whereHas('chapter', function ($q) use ($course) {
                    $q->where('course_id', $course->id);
                })->count();

                $watchedCount = \App\Models\CourseProgress::where('user_id', $member->user_id)
                    ->where('course_id', $course->id)
                    ->where('watched', 1)
                    ->count();

                $assignment->total_lectures = $totalLectures;
                $assignment->watched_lectures = $watchedCount;
                $assignment->progress_percent = $totalLectures > 0 ? round(($watchedCount / $totalLectures) * 100) : 0;
            }
        }

        // Get quiz results for this student
        $quizResults = \App\Models\QuizResult::with(['quiz.chapterItem.chapter.course'])
            ->where('user_id', $member->user_id)
            ->orderByDesc('id')
            ->take(20)
            ->get();

        return view('frontend.school-dashboard.students.show', compact('member', 'assignments', 'quizResults'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'password'      => 'nullable|string|min:4',
            'id_number'     => 'nullable|string|max:100',
            'grade'         => 'nullable|string|max:50',
            'section'       => 'nullable|string|max:20',
            'academic_year' => 'nullable|string|max:20',
            'board'         => 'nullable|string|max:50',
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::where('email', $request->email)->first();
            $password = $request->password ?: '123456';

            if (!$user) {
                $user = User::create([
                    'name'               => $request->name,
                    'email'              => $request->email,
                    'role'               => 'student',
                    'password'           => Hash::make($password),
                    'status'             => 'active',
                    'is_banned'          => 'no',
                    'email_verified_at'  => now(),
                    'verification_token' => null,
                ]);
            }

            $exists = SchoolMember::where('school_id', userAuth()->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($exists) {
                $notification = ['messege' => __('This user is already a member of your school.'), 'alert-type' => 'error'];
                return redirect()->back()->with($notification);
            }

            SchoolMember::create([
                'school_id'      => userAuth()->id,
                'user_id'        => $user->id,
                'role_in_school' => 'student',
                'id_number'      => $request->id_number,
                'grade'          => $request->grade,
                'section'        => $request->section,
                'academic_year'  => $request->academic_year,
                'board'          => $request->board,
                'status'         => 'active',
            ]);

            $notification = ['messege' => __('Student added successfully. Password: ') . $password, 'alert-type' => 'success'];
            return redirect()->route('school.students.index')->with($notification);
        });
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|file|max:5120',
        ], [
            'csv_file.required' => __('Please select a CSV file to upload.'),
        ]);

        $file = $request->file('csv_file');
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['csv', 'txt'])) {
            $notification = ['messege' => __('Please upload a valid .csv file.'), 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);

        // Detect delimiter (comma or semicolon)
        $firstLine = strtok($content, "\r\n");
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $notification = ['messege' => __('Unable to read the uploaded CSV file.'), 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        // Read header row
        $header = fgetcsv($handle, 0, $delimiter);

        $added = 0;
        $skipped = 0;

        DB::transaction(function () use ($handle, $delimiter, &$added, &$skipped) {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                if (empty(array_filter($row))) {
                    continue; // Skip empty rows
                }

                $name     = preg_replace('/^\xEF\xBB\xBF/', '', trim($row[0] ?? ''));
                $email    = trim($row[1] ?? '');
                $idNum    = trim($row[2] ?? '');

                if (count($row) >= 8) {
                    $grade        = trim($row[3] ?? '') ?: null;
                    $section      = trim($row[4] ?? '') ?: null;
                    $academicYear = trim($row[5] ?? '') ?: null;
                    $board        = trim($row[6] ?? '') ?: null;
                    $password     = trim($row[7] ?? '') ?: '123456';
                } else {
                    $grade        = null;
                    $section      = null;
                    $academicYear = null;
                    $board        = null;
                    $password     = trim($row[3] ?? '') ?: '123456';
                }

                if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $skipped++;
                    continue;
                }

                $user = User::where('email', $email)->first();
                if (!$user) {
                    $user = User::create([
                        'name'               => $name,
                        'email'              => $email,
                        'role'               => 'student',
                        'password'           => Hash::make($password),
                        'status'             => 'active',
                        'is_banned'          => 'no',
                        'email_verified_at'  => now(),
                        'verification_token' => null,
                    ]);
                }

                $exists = SchoolMember::where('school_id', userAuth()->id)
                    ->where('user_id', $user->id)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                SchoolMember::create([
                    'school_id'      => userAuth()->id,
                    'user_id'        => $user->id,
                    'role_in_school' => 'student',
                    'id_number'      => $idNum ?: null,
                    'grade'          => $grade,
                    'section'        => $section,
                    'academic_year'  => $academicYear,
                    'board'          => $board,
                    'status'         => 'active',
                ]);
                $added++;
            }
        });

        fclose($handle);

        $notification = ['messege' => __("Import complete: :added added, :skipped skipped.", ['added' => $added, 'skipped' => $skipped]), 'alert-type' => 'success'];
        return redirect()->route('school.students.index')->with($notification);
    }

    public function toggleStatus(SchoolMember $member): RedirectResponse
    {
        if ($member->school_id !== userAuth()->id || $member->role_in_school !== 'student') {
            abort(403);
        }

        $member->update(['status' => $member->status === 'active' ? 'inactive' : 'active']);

        $notification = ['messege' => __('Student status updated.'), 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    public function destroy(SchoolMember $member): RedirectResponse
    {
        if ($member->school_id !== userAuth()->id || $member->role_in_school !== 'student') {
            abort(403);
        }

        $member->delete();

        $notification = ['messege' => __('Student removed from school.'), 'alert-type' => 'success'];
        return redirect()->route('school.students.index')->with($notification);
    }
}
