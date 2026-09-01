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

class SchoolTeacherController extends Controller
{
    public function index(): View
    {
        $teachers = SchoolMember::with('user')
            ->where('school_id', userAuth()->id)
            ->teachers()
            ->orderByDesc('id')
            ->paginate(15);

        return view('frontend.school-dashboard.teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        return view('frontend.school-dashboard.teachers.create');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="teachers_import_template.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = ['Name', 'Email', 'ID_Number', 'Password'];
        $sample  = ['Jane Doe', 'teacher@example.com', 'TCH-001', '123456'];

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
        if ($member->school_id !== userAuth()->id || $member->role_in_school !== 'teacher') {
            abort(403);
        }

        $member->load('user');

        // Get all courses assigned to this teacher by this school
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

        return view('frontend.school-dashboard.teachers.show', compact('member', 'assignments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'password'  => 'nullable|string|min:4',
            'id_number' => 'nullable|string|max:100',
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::where('email', $request->email)->first();
            $password = $request->password ?: '123456';

            if (!$user) {
                $user = User::create([
                    'name'               => $request->name,
                    'email'              => $request->email,
                    'role'               => 'instructor',
                    'password'           => Hash::make($password),
                    'status'             => 'active',
                    'is_banned'          => 'no',
                    'email_verified_at'  => now(),
                    'verification_token' => null,
                ]);
            }

            // Check if already a member of this school
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
                'role_in_school' => 'teacher',
                'id_number'      => $request->id_number,
                'status'         => 'active',
            ]);

            $notification = ['messege' => __('Teacher added successfully. Password: ') . $password, 'alert-type' => 'success'];
            return redirect()->route('school.teachers.index')->with($notification);
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
                $password = trim($row[3] ?? '') ?: '123456';

                if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $skipped++;
                    continue;
                }

                $user = User::where('email', $email)->first();
                if (!$user) {
                    $user = User::create([
                        'name'               => $name,
                        'email'              => $email,
                        'role'               => 'instructor',
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
                    'role_in_school' => 'teacher',
                    'id_number'      => $idNum ?: null,
                    'status'         => 'active',
                ]);
                $added++;
            }
        });

        fclose($handle);

        $notification = ['messege' => __("Import complete: :added added, :skipped skipped.", ['added' => $added, 'skipped' => $skipped]), 'alert-type' => 'success'];
        return redirect()->route('school.teachers.index')->with($notification);
    }

    public function toggleStatus(SchoolMember $member): RedirectResponse
    {
        if ($member->school_id !== userAuth()->id || $member->role_in_school !== 'teacher') {
            abort(403);
        }

        $member->update(['status' => $member->status === 'active' ? 'inactive' : 'active']);

        $notification = ['messege' => __('Teacher status updated.'), 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    public function destroy(SchoolMember $member): RedirectResponse
    {
        if ($member->school_id !== userAuth()->id || $member->role_in_school !== 'teacher') {
            abort(403);
        }

        $member->delete();

        $notification = ['messege' => __('Teacher removed from school.'), 'alert-type' => 'success'];
        return redirect()->route('school.teachers.index')->with($notification);
    }
}
