<?php

namespace Modules\CourseApi\app\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\ActivityFile;
use App\Models\CourseGrade;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\CourseChapter;
use App\Models\CourseChapterItem;
use App\Models\CourseChapterLesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Session\Session;
use App\Http\Requests\Frontend\QuizLessonCreateRequest;
use Modules\CourseApi\app\Http\Requests\ChapterLessonRequest;

class CourseContentController extends Controller
{
    function gradeStore(Request $request, string $courseId): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'max:255'],
            'description' => ['nullable', 'max:1000'],
        ], [
            'title.required' => __('Title is required'),
            'title.max'      => __('Title is too long'),
        ]);

        CourseGrade::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'course_id'     => $courseId,
            'instructor_id' => Course::find($courseId)->instructor_id,
            'status'        => 'active',
            'order'         => CourseGrade::where('course_id', $courseId)->max('order') + 1,
        ]);

        return redirect()->back()->with(['messege' => __('Grade created successfully'), 'alert-type' => 'success']);
    }

    function gradeEdit(string $gradeId)
    {
        $grade = CourseGrade::findOrFail($gradeId);
        return view('course::course.partials.edit-grade-modal', compact('grade'))->render();
    }

    function gradeUpdate(Request $request, string $gradeId)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $request->validate([
            'title'       => ['required', 'max:255'],
            'description' => ['nullable', 'max:1000'],
        ]);
        $grade = CourseGrade::findOrFail($gradeId);
        $grade->title       = $request->title;
        $grade->description = $request->description;
        $grade->save();
        return redirect()->back()->with(['messege' => __('Grade updated successfully'), 'alert-type' => 'success']);
    }

    function gradeDestroy(string $gradeId)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $grade = CourseGrade::findOrFail($gradeId);
        // Detach chapters from this grade (set grade_id to null)
        CourseChapter::where('grade_id', $gradeId)->update(['grade_id' => null]);
        $grade->delete();
        return response()->json(['status' => 'success', 'message' => __('Grade deleted successfully')]);
    }

    function chapterStore(Request $request, string $courseId): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'max:255'],
            'description' => ['nullable', 'max:1000'],
        ], [
            'title.required' => __('Title is required'),
            'title.max'      => __('Title is too long'),
        ]);

        $chapter = new CourseChapter();
        $chapter->title       = $request->title;
        $chapter->description = $request->description;
        $chapter->grade_id    = $request->grade_id ?: null;
        $chapter->course_id   = $courseId;
        $chapter->instructor_id = Course::find($courseId)->instructor_id;
        $chapter->status = 'active';
        $chapter->order  = CourseChapter::where('course_id', $courseId)->max('order') + 1;
        $chapter->save();

        return redirect()->back()->with(['messege' => __('Chapter created successfully'), 'alert-type' => 'success']);
    }

    function chapterEdit(string $chapterId)
    {
        $chapter = CourseChapter::find($chapterId);
        return view('course::course.partials.edit-section-modal', compact('chapter'))->render();
    }

    function chapterUpdate(Request $request, string $chapterId)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $chapter = CourseChapter::findOrFail($chapterId);
        $chapter->title       = $request->title;
        $chapter->description = $request->description;
        $chapter->save();
        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }

    function chapterDestroy(string $chapterId)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $chapter = CourseChapter::findOrFail($chapterId);
        $chapterItems = CourseChapterItem::where('chapter_id', $chapterId)->get();
        $lessonFiles = CourseChapterLesson::whereIn('chapter_item_id', $chapterItems->pluck('id'))->get();
        $quizIds = Quiz::whereIn('chapter_item_id', $chapterItems->pluck('id'))->pluck('id');
        $questionIds = QuizQuestion::whereIn('quiz_id', $quizIds)->pluck('id');

        // delete quizzes, questions, answers and lesson files
        QuizQuestion::whereIn('id', $questionIds)->delete();
        Quiz::whereIn('id', $quizIds)->delete();
        CourseChapterLesson::whereIn('id', $lessonFiles->pluck('id'))->delete();
        foreach ($lessonFiles as $lesson) {
            if (\File::exists(asset($lesson->file_path))) \File::delete(asset($lesson->file_path));
        }

        // delete chapter items and chapter
        CourseChapterItem::whereIn('id', $chapterItems->pluck('id'))->delete();
        $chapter->delete();

        return response()->json(['status' => 'success', 'message' => __('Question deleted successfully')]);
    }

    function chapterSorting(string $courseId)
    {
        $chapters = CourseChapter::where('course_id', $courseId)->orderBy('order', 'ASC')->get();
        return view('course::course.partials.chapter-sorting-index', compact('chapters', 'courseId'))->render();
    }

    function chapterSortingStore(Request $request, string $courseId)
    {
        $newOrder = $request->chapter_ids;

        foreach ($newOrder as $key => $value) {
            $chapter = CourseChapter::where('course_id', $courseId)->find($value);
            $chapter->order = $key + 1;
            $chapter->save();
        }

        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }

    function lessonCreate(Request $request)
    {
        $courseId = $request->courseId;
        $chapterId = $request->chapterId;
        $chapters = CourseChapter::where('course_id', $courseId)->get();
        $type = $request->type;
        if ($request->type == 'lesson') {
            return view('course::course.partials.lesson-create-modal', [
                'courseId' => $courseId,
                'chapterId' => $chapterId,
                'chapters' => $chapters,
                'type' => $type
            ])->render();
        }elseif ($request->type == 'document') {
            return view('course::course.partials.document-create-modal', [
                'courseId' => $courseId,
                'chapterId' => $chapterId,
                'chapters' => $chapters,
                'type' => $type
            ])->render();
        } elseif ($request->type == 'activity') {
            return view('course::course.partials.activity-create-modal', [
                'courseId' => $courseId,
                'chapterId' => $chapterId,
                'chapters' => $chapters,
                'type' => $type
            ])->render();
        } elseif ($request->type == 'quiz') {
            return view('course::course.partials.quiz-create-modal', [
                'courseId' => $courseId,
                'chapterId' => $chapterId,
                'chapters' => $chapters,
                'type' => $type
            ])->render();
        }
    }

    function lessonStore(ChapterLessonRequest $request)
    {
        $chapterItem = CourseChapterItem::create([
            'instructor_id' => Course::find(session()->get('course_create'))->instructor_id,    
            'chapter_id' => $request->chapter_id,
            'type' => $request->type,
            'order' => CourseChapterItem::whereChapterId($request->chapter_id)->count() + 1,
        ]);

        if ($request->type == 'lesson') {
            CourseChapterLesson::create([
                'title' => $request->title,
                'description' => $request->description,
                'instructor_id' =>  $chapterItem->instructor_id,
                'course_id' => $request->course_id,
                'chapter_id' => $request->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path' => $request->source == 'upload' ? $request->upload_path : $request->link_path,
                'storage' => $request->source,
                'file_type' => $request->file_type,
                'volume' => $request->volume,
                'duration' => $request->duration,
                'is_free' => $request->is_free,
            ]);
        }elseif ($request->type == 'document') {
            CourseChapterLesson::create([
                'title' => $request->title,
                'description' => $request->description,
                'instructor_id' =>  $chapterItem->instructor_id,
                'course_id' => $request->course_id,
                'chapter_id' => $request->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path' => $request->upload_path,
                'file_type' => $request->file_type,
            ]);
        } elseif ($request->type == 'activity') {
            $lesson = CourseChapterLesson::create([
                'title'             => $request->title,
                'description'       => $request->description,
                'material_required' => $request->material_required,
                'age_min'           => $request->age_min,
                'age_max'           => $request->age_max,
                'activity_duration' => $request->activity_duration,
                'instructor_id'     => $chapterItem->instructor_id,
                'course_id'         => $request->course_id,
                'chapter_id'        => $request->chapter_id,
                'chapter_item_id'   => $chapterItem->id,
                'storage'           => 'upload',
            ]);

            // Handle file manager paths
            foreach ((array) $request->activity_files_paths as $url) {
                if (empty($url)) continue;
                ActivityFile::create([
                    'lesson_id' => $lesson->id,
                    'file_path' => $url,
                    'file_name' => basename(parse_url($url, PHP_URL_PATH)),
                    'file_type' => pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION),
                ]);
            }
        } elseif ($request->type == 'quiz') {
            Quiz::create([
                'chapter_item_id' => $chapterItem->id,
                'instructor_id' => $chapterItem->instructor_id,
                'chapter_id' => $request->chapter,
                'course_id' => $request->course_id,
                'title' => $request->title,
                'time' => $request->time_limit,
                'attempt' => $request->attempts,
                'pass_mark' => $request->pass_mark,
                'total_mark' => $request->total_mark,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson created successfully')]);
    }

    function lessonEdit(Request $request)
    {
        $courseId = $request->courseId;
        $chapterItemId = $request->chapterItemId;
        $chapterItem = CourseChapterItem::with(['lesson', 'lesson.activityFiles', 'quiz'])->find($chapterItemId);
        $chapters = CourseChapter::where('course_id', $courseId)->get();
        if ($request->type == 'lesson') {
            return view('course::course.partials.lesson-edit-modal', [
                'chapters' => $chapters,
                'courseId' => $courseId,
                'chapterItem' => $chapterItem
            ])->render();
        }elseif ($request->type == 'document') {
            return view('course::course.partials.document-edit-modal', [
                'chapters' => $chapters,
                'courseId' => $courseId,
                'chapterItem' => $chapterItem
            ])->render();
        } elseif ($request->type == 'activity') {
            $activityFiles = $chapterItem->lesson
                ? $chapterItem->lesson->activityFiles()->get()
                : collect();
            return view('course::course.partials.activity-edit-modal', [
                'chapters'      => $chapters,
                'courseId'      => $courseId,
                'chapterItem'   => $chapterItem,
                'activityFiles' => $activityFiles,
            ])->render();
        } else {
            return view('course::course.partials.quiz-edit-modal', [
                'chapters' => $chapters,
                'courseId' => $courseId,
                'chapterItem' => $chapterItem
            ])->render();
        }
    }

    function lessonUpdate(ChapterLessonRequest $request)
    {
        checkAdminHasPermissionAndThrowException('course.management');

        $chapterItem = CourseChapterItem::findOrFail($request->chapter_item_id);

        $chapterItem->update([
            'chapter_id' => $request->chapter
        ]);

        if ($request->type == 'lesson') {
            $courseChapterLesson = CourseChapterLesson::where('chapter_item_id', $chapterItem->id)->first();

            $old_file_path = $courseChapterLesson->file_path;
            if (in_array($courseChapterLesson->storage, ['wasabi', 'aws']) && $old_file_path != $request->link_path) {
                $disk = Storage::disk($courseChapterLesson->storage);
                $disk->exists($old_file_path) && $disk->delete($old_file_path);
            }

            $courseChapterLesson->update([
                'title' => $request->title,
                'description' => $request->description,
                'course_id' => $chapterItem->course_id,
                'chapter_id' => $chapterItem->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path' => $request->source == 'upload' ? $request->upload_path : $request->link_path,
                'storage' => $request->source,
                'file_type' => $request->file_type,
                'volume' => $request->volume,
                'duration' => $request->duration,
            ]);
        }elseif($request->type == 'document') {
            $courseChapterLesson = CourseChapterLesson::where('chapter_item_id', $chapterItem->id)->first();
            $courseChapterLesson->update([
                'title' => $request->title,
                'description' => $request->description,
                'course_id' => $chapterItem->course_id,
                'chapter_id' => $chapterItem->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path' => $request->upload_path,
                'file_type' => $request->file_type,
            ]);
        } elseif ($request->type == 'activity') {
            $courseChapterLesson = CourseChapterLesson::where('chapter_item_id', $chapterItem->id)->first();
            $courseChapterLesson->update([
                'title'             => $request->title,
                'description'       => $request->description,
                'material_required' => $request->material_required,
                'age_min'           => $request->age_min,
                'age_max'           => $request->age_max,
                'activity_duration' => $request->activity_duration,
                'course_id'         => $chapterItem->course_id,
                'chapter_id'        => $chapterItem->chapter_id,
                'chapter_item_id'   => $chapterItem->id,
            ]);

            // Handle new file manager paths
            foreach ((array) $request->activity_files_paths as $url) {
                if (empty($url)) continue;
                ActivityFile::create([
                    'lesson_id' => $courseChapterLesson->id,
                    'file_path' => $url,
                    'file_name' => basename(parse_url($url, PHP_URL_PATH)),
                    'file_type' => pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION),
                ]);
            }
        } else {
            $quiz = Quiz::where('chapter_item_id', $chapterItem->id)->first();
            $quiz->update([
                'chapter_item_id' => $chapterItem->id,
                'title' => $request->title,
                'time' => $request->time_limit,
                'attempt' => $request->attempts,
                'pass_mark' => $request->pass_mark,
                'total_mark' => $request->total_mark,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson updated successfully')]);
    }

    function sortLessons(Request $request, string $chapterId)
    {
        $newOrder = $request->orderIds;
        foreach ($newOrder as $key => $itemId) {
            $chapterItem = CourseChapterItem::where(['chapter_id' => $chapterId, 'id' => $itemId])->first();
            $chapterItem->order = $key + 1;
            $chapterItem->save();
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson sorted successfully')]);
    }

    function chapterLessonDestroy(string $chapterItemId)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $chapterItem = CourseChapterItem::findOrFail($chapterItemId);

        if ($chapterItem->type == 'quiz') {
            $quiz = $chapterItem->quiz;
            $question = $quiz->questions;
            foreach ($question as $key => $question) {
                $question->answers()->delete();
                $question->delete();
            }
            $quiz->delete();
            $chapterItem->delete();
        } else {
            if (in_array($chapterItem->lesson->storage, ['wasabi', 'aws'])) {
                $disk = Storage::disk($chapterItem->lesson->storage);
                $filePath = $chapterItem->lesson->file_path;
                $disk->exists($filePath) && $disk->delete($filePath);
            }
            // delete chapter item lesson if file exists
            if (\File::exists(asset($chapterItem->lesson->file_path))) \File::delete(asset($chapterItem->lesson->file_path));
            // delete lesson row
            $chapterItem->lesson()->delete();
            $chapterItem->delete();
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson deleted successfully')]);
    }

    function createQuizQuestion(string $quizId)
    {
        return view('course::course.partials.quiz-question-create-modal', ['quizId' => $quizId])->render();
    }

    function storeQuizQuestion(Request $request, string $quizId)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'answers.*' => ['required', 'max:255'],
            'grade' => ['required', 'numeric', 'min:0']
        ], [
            'title.required' => __('Question title is required'),
            'title.max' => __('Question title should not be more than 255 characters'),
            'answers.*.required' => __('At least one answer is required'),
            'answers.*.max' => __('Answer should not be more than 255 characters'),
            'grade.required' => __('Grade is required'),
            'grade.numeric' => __('Grade should be a number'),
            'grade.min' => __('Grade should be greater than or equal to 0'),
        ]);

        $question = QuizQuestion::create([
            'quiz_id' => $quizId,
            'title' => $request->title,
            'grade' => $request->grade
        ]);

        foreach ($request->answers as $key => $answer) {
            $question->answers()->create([
                'title' => $answer,
                'correct' => isset($request->correct[$key]) ? 1 : 0,
                'question_id' => $question->id
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Question created successfully')]);
    }

    function editQuizQuestion(string $questionId)
    {
        $question = QuizQuestion::findOrFail($questionId);
        return view('course::course.partials.quiz-question-edit-modal', ['question' => $question])->render();
    }

    function updateQuizQuestion(Request $request, string $questionId)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'answers.*' => ['required', 'max:255'],
            'grade' => ['required', 'numeric', 'min:0']
        ], [
            'title.required' => __('Question title is required'),
            'title.max' => __('Question title should not be more than 255 characters'),
            'answers.*.required' => __('At least one answer is required'),
            'answers.*.max' => __('Answer should not be more than 255 characters'),
            'grade.required' => __('Grade is required'),
            'grade.numeric' => __('Grade should be a number'),
            'grade.min' => __('Grade should be greater than or equal to 0'),
        ]);

        $question = QuizQuestion::findOrFail($questionId);
        $question->update([
            'title' => $request->title,
            'grade' => $request->grade
        ]);
        // update or delete answers
        $question->answers()->delete();
        foreach ($request->answers as $key => $answer) {
            $question->answers()->create([
                'title' => $answer,
                'correct' => isset($request->correct[$key]) ? 1 : 0,
                'question_id' => $question->id
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Question updated successfully')]);
    }

    function destroyQuizQuestion(string $questionId)
    {
        $question = QuizQuestion::findOrFail($questionId);
        $question->answers()->delete();
        $question->delete();
        return response()->json(['status' => 'success', 'message' => __('Question deleted successfully')]);
    }

    function activityFileDestroy(string $fileId)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $file = ActivityFile::findOrFail($fileId);
        // file_path is a file manager URL — no local file to delete
        $file->delete();

        return response()->json(['status' => 'success', 'message' => __('File deleted successfully')]);
    }
}
