<?php

use App\Http\Controllers\Frontend\InstructorCourseController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use Modules\CourseApi\app\Http\Controllers\CourseCategoryController;
use Modules\CourseApi\app\Http\Controllers\CourseContentController;
use Modules\CourseApi\app\Http\Controllers\CourseController;
use Modules\CourseApi\app\Http\Controllers\CourseDeleteRequestController;
use Modules\CourseApi\app\Http\Controllers\CourseGradeController;
use Modules\CourseApi\app\Http\Controllers\CourseLanguageController;
use Modules\CourseApi\app\Http\Controllers\CourseLevelController;
use Modules\CourseApi\app\Http\Controllers\CourseReviewController;
use Modules\CourseApi\app\Http\Controllers\CourseSubCategoryController;
use Modules\CourseApi\app\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth:admin', 'translation'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    /** Course Routes */
    Route::get('coursesapi', [CourseController::class, 'index'])->name('coursesapi.index');
    Route::get('coursesapi/create', [CourseController::class, 'create'])->name('coursesapi.create');
    Route::get('coursesapi/create/{id}/step/{step?}', [CourseController::class, 'edit'])->name('coursesapi.edit');
    Route::get('coursesapi/{id}/edit', [CourseController::class, 'editView'])->name('coursesapi.edit-view');
    Route::get('coursesapi/get-instructors', [CourseController::class, 'getInstructors'])->name('coursesapi.get-instructors');
    Route::post('coursesapi/create', [CourseController::class, 'store'])->name('coursesapi.store');
    Route::post('coursesapi/update', [CourseController::class, 'update'])->name('coursesapi.update');
    Route::delete('coursesapi/delete/{id}', [CourseController::class, 'destroy'])->name('coursesapi.destroy');
    Route::post('coursesapi/status-update/{id}', [CourseController::class, 'statusUpdate'])->name('coursesapi.status-update');

    /** Course category routes */
    Route::put('courseapi-category/status-update/{id}', [CourseCategoryController::class, 'statusUpdate'])->name('courseapi-category.status-update');
    Route::resource('courseapi-category', CourseCategoryController::class)->names('courseapi-category');

    /** Course sub category routes */
    Route::get('courseapi-sub-category/{parent_id}', [CourseSubCategoryController::class, 'index'])->name('courseapi-sub-category.index');
    Route::get('courseapi-sub-category/{parent_id}/create', [CourseSubCategoryController::class, 'create'])->name('courseapi-sub-category.create');
    Route::post('courseapi-sub-category/{parent_id}/store', [CourseSubCategoryController::class, 'store'])->name('courseapi-sub-category.store');
    Route::get('courseapi-sub-category/{parent_id}/{sub_category_id}/edit', [CourseSubCategoryController::class, 'edit'])->name('courseapi-sub-category.edit');
    Route::put('courseapi-sub-category/{parent_id}/{sub_category_id}/update', [CourseSubCategoryController::class, 'update'])->name('courseapi-sub-category.update');
    Route::delete('courseapi-sub-category/{parent_id}/{sub_category_id}', [CourseSubCategoryController::class, 'destroy'])->name('courseapi-sub-category.destroy');
    Route::put('courseapi-sub-category/status-update/{id}', [CourseSubCategoryController::class, 'statusUpdate'])->name('courseapi-sub-category.status-update');

    /** Course Language Routes */
    Route::put('courseapi-language/status-update/{id}', [CourseLanguageController::class, 'statusUpdate'])->name('courseapi-language.status-update');
    Route::resource('courseapi-language', CourseLanguageController::class)->names('courseapi-language');

    /** Course Level Routes */
    Route::put('courseapi-level/status-update/{id}', [CourseLevelController::class, 'statusUpdate'])->name('courseapi-level.status-update');
    Route::resource('courseapi-level', CourseLevelController::class)->names('courseapi-level');

    /** Course Grade Routes */
    Route::put('courseapi-grade/status-update/{id}', [CourseGradeController::class, 'statusUpdate'])->name('courseapi-grade.status-update');
    Route::delete('courseapi-grade-image/{id}/destroy', [CourseGradeController::class, 'imageDestroy'])->name('courseapi-grade.image.destroy');
    Route::resource('courseapi-grade', CourseGradeController::class)->names('courseapi-grade');

    /** Course content routes */
    Route::post('courseapi-chapter/{course_id?}/store', [CourseContentController::class, 'chapterStore'])->name('courseapi-chapter.store');
    Route::get('courseapi-chapter/sorting/{course_id}', [CourseContentController::class, 'chapterSorting'])->name('courseapi-chapter.sorting.index');
    Route::get('courseapi-chapter/edit/{chapter_id}', [CourseContentController::class, 'chapterEdit'])->name('courseapi-chapter.edit');
    Route::put('courseapi-chapter/update/{chapter_id}', [CourseContentController::class, 'chapterUpdate'])->name('courseapi-chapter.update');
    Route::delete('courseapi-chapter/delete/{chapter_id}', [CourseContentController::class, 'chapterDestroy'])->name('courseapi-chapter.destroy');

    Route::post('courseapi-chapter-grade/{course_id}/store', [CourseContentController::class, 'gradeStore'])->name('courseapi-chapter-grade.store');
    Route::get('courseapi-chapter-grade/edit/{grade_id}', [CourseContentController::class, 'gradeEdit'])->name('courseapi-chapter-grade.edit');
    Route::put('courseapi-chapter-grade/update/{grade_id}', [CourseContentController::class, 'gradeUpdate'])->name('courseapi-chapter-grade.update');
    Route::delete('courseapi-chapter-grade/delete/{grade_id}', [CourseContentController::class, 'gradeDestroy'])->name('courseapi-chapter-grade.destroy');

    Route::post('courseapi-chapter/sorting/{course_id}', [CourseContentController::class, 'chapterSortingStore'])->name('courseapi-chapter.sorting.store');
    Route::get('courseapi-chapter/lesson/create', [CourseContentController::class, 'lessonCreate'])->name('courseapi-chapter.lesson.create');
    Route::post('courseapi-chapter/lesson/create', [CourseContentController::class, 'lessonStore'])->name('courseapi-chapter.lesson.store');
    Route::get('courseapi-chapter/lesson/edit', [CourseContentController::class, 'lessonEdit'])->name('courseapi-chapter.lesson.edit');
    Route::post('courseapi-chapter/lesson/update', [CourseContentController::class, 'lessonUpdate'])->name('courseapi-chapter.lesson.update');
    Route::delete('courseapi-chapter/lesson/{chapter_item_id}/destroy', [CourseContentController::class, 'chapterLessonDestroy'])->name('courseapi-chapter.lesson.destroy');
    Route::post('courseapi-chapter/lesson/sorting/{chapter_id}', [CourseContentController::class, 'sortLessons'])->name('courseapi-chapter.lesson.sorting');
    Route::delete('courseapi-chapter/activity-file/{file_id}/destroy', [CourseContentController::class, 'activityFileDestroy'])->name('courseapi-chapter.activity-file.destroy');

    Route::get('courseapi-chapter/quiz-question/create/{quiz_id}', [CourseContentController::class, 'createQuizQuestion'])->name('courseapi-chapter.quiz-question.create');
    Route::post('courseapi-chapter/quiz-question/create/{quiz_id}', [CourseContentController::class, 'storeQuizQuestion'])->name('courseapi-chapter.quiz-question.store');
    Route::get('courseapi-chapter/quiz-question/edit/{question_id}', [CourseContentController::class, 'editQuizQuestion'])->name('courseapi-chapter.quiz-question.edit');
    Route::put('courseapi-chapter/quiz-question/update/{question_id}', [CourseContentController::class, 'updateQuizQuestion'])->name('courseapi-chapter.quiz-question.update');
    Route::delete('courseapi-chapter/quiz-question/delete/{question_id}', [CourseContentController::class, 'destroyQuizQuestion'])->name('courseapi-chapter.quiz-question.destroy');

    /** Review & delete request */
    Route::resource('courseapi-review', CourseReviewController::class)->names('courseapi-review');
    Route::resource('courseapi-delete-request', CourseDeleteRequestController::class)->names('courseapi-delete-request');
});
