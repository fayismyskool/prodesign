<?php

namespace Modules\Course\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseGrade;
use App\Models\CourseGradeImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseGradeController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseGrade::with(['images']);
        $query->when($request->keyword, fn ($q) =>
            $q->where('title', 'like', '%' . $request->keyword . '%')
        );
        $query->when(
            $request->status !== null && $request->status !== '',
            fn ($q) => $q->where('status', $request->status)
        );
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $courseGrades = $request->get('par-page') == 'all'
            ? $query->orderBy('id', $orderBy)->get()
            : $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? 15)->withQueryString();

        return view('course::course-grade.index', compact('courseGrades'));
    }

    public function create()
    {
        return view('course::course-grade.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'             => ['required', 'max:255'],
            'description'       => ['nullable', 'max:1000'],
            'status'            => ['required', 'in:active,inactive'],
            'grade_image_paths' => ['nullable', 'array'],
            'grade_image_paths.*' => ['nullable', 'string'],
        ]);

        $grade = CourseGrade::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'course_id'     => null,
            'instructor_id' => auth()->id(),
            'status'        => $request->status,
            'order'         => CourseGrade::max('order') + 1,
        ]);

        $this->saveImagePaths($grade, $request->grade_image_paths ?? []);

        return redirect()->route('admin.course-grade.index')
            ->with(['messege' => __('Grade created successfully'), 'alert-type' => 'success']);
    }

    public function edit($id)
    {
        $courseGrade = CourseGrade::with('images')->findOrFail($id);
        return view('course::course-grade.edit', compact('courseGrade'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title'               => ['required', 'max:255'],
            'description'         => ['nullable', 'max:1000'],
            'status'              => ['required', 'in:active,inactive'],
            'grade_image_paths'   => ['nullable', 'array'],
            'grade_image_paths.*' => ['nullable', 'string'],
        ]);

        $courseGrade = CourseGrade::findOrFail($id);
        $courseGrade->update([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        $this->saveImagePaths($courseGrade, $request->grade_image_paths ?? []);

        return redirect()->route('admin.course-grade.index')
            ->with(['messege' => __('Grade updated successfully'), 'alert-type' => 'success']);
    }

    public function destroy($id)
    {
        $courseGrade = CourseGrade::with('images')->findOrFail($id);
        // images are stored as file manager URLs — no local files to delete
        $courseGrade->chapters()->update(['grade_id' => null]);
        $courseGrade->delete(); // cascade deletes images via FK

        return response()->json(['status' => 'success', 'message' => __('Grade deleted successfully')]);
    }

    public function imageDestroy($id)
    {
        $image = CourseGradeImage::findOrFail($id);
        // image_path is a full URL from the file manager — no local file to delete
        $image->delete();

        return response()->json(['status' => 'success', 'message' => __('Image deleted successfully')]);
    }

    public function statusUpdate(Request $request, $id)
    {
        $courseGrade = CourseGrade::findOrFail($id);
        $courseGrade->status = $courseGrade->status === 'active' ? 'inactive' : 'active';
        $courseGrade->save();

        return response()->json(['success' => true, 'message' => __('Status updated successfully')]);
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function saveImagePaths(CourseGrade $grade, array $paths): void
    {
        if (empty($paths)) return;

        $order = $grade->images()->max('order') ?? 0;
        foreach ($paths as $url) {
            if (empty($url)) continue;
            CourseGradeImage::create([
                'grade_id'   => $grade->id,
                'image_path' => $url,                          // store full URL from file manager
                'image_name' => basename(parse_url($url, PHP_URL_PATH)),
                'order'      => ++$order,
            ]);
        }
    }
}
