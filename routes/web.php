<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\AboutPageController;
use App\Http\Controllers\Frontend\BecomeInstructorController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseContentController;
use App\Http\Controllers\Frontend\CoursePageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\InstructorAnnouncementController;
use App\Http\Controllers\Frontend\InstructorCourseController;
use App\Http\Controllers\Frontend\InstructorDashboardController;
use App\Http\Controllers\Frontend\InstructorLessonQnaController;
use App\Http\Controllers\Frontend\InstructorLiveCredentialController;
use App\Http\Controllers\Frontend\InstructorPayoutController;
use App\Http\Controllers\Frontend\InstructorProfileSettingController;
use App\Http\Controllers\Frontend\LearningController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\QnaController;
use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\StudentOrderController;
use App\Http\Controllers\Frontend\StudentProfileSettingController;
use App\Http\Controllers\Frontend\StudentReviewController;
use App\Http\Controllers\Frontend\TinymceImageUploadController;
use App\Http\Controllers\Global\CloudStorageController;
use App\Http\Controllers\Frontend\SchoolCourseController;
use App\Http\Controllers\Frontend\SchoolDashboardController;
use App\Http\Controllers\Frontend\SchoolOrderController;
use App\Http\Controllers\Frontend\SchoolProfileSettingController;
use App\Http\Controllers\Frontend\SchoolStudentController;
use App\Http\Controllers\Frontend\SchoolTeacherController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'maintenance.mode'], function () {

    /**
     * ============================================================================
     * Global Routes
     * ============================================================================
     */

    Route::get('set-language', [DashboardController::class, 'setLanguage'])->name('set-language');
    Route::get('set-currency', [HomePageController::class, 'setCurrency'])->name('set-currency');

    Route::get('/', function () {
        return view('frontend.home-four.index');
    })->name('home');

    Route::get('/skill2school', function () {
        return view('frontend.home-four.pages.skill2school');
    })->name('skill2school');

    Route::get('/labs', function () {
        return view('frontend.home-four.pages.labs');
    })->name('labs');

    Route::get('/labs/ai-robotics', function () {
        return view('frontend.home-four.pages.lab-ai-robotics');
    })->name('labs.ai-robotics');

    Route::get('/labs/stem', function () {
        return view('frontend.home-four.pages.lab-stem');
    })->name('labs.stem');

    Route::get('/labs/ecec', function () {
        return view('frontend.home-four.pages.lab-ecec');
    })->name('labs.ecec');

    Route::get('/labs/composite-skill', function () {
        return view('frontend.home-four.pages.lab-composite-skill');
    })->name('labs.composite-skill');

    Route::get('/ttt', function () {
        return view('frontend.home-four.pages.ttt');
    })->name('ttt');

    Route::get('/course-detail/{id}', function ($id) {
        $course = \App\Models\Course::with(['category.translation', 'instructor', 'chapters.chapterItems', 'reviews.user'])->find($id);
        if (!$course) {
            $course = \App\Models\Course::with(['category.translation', 'instructor', 'chapters.chapterItems', 'reviews.user'])->where('slug', $id)->first();
        }
        return view('frontend.home-four.pages.course-detail', compact('course', 'id'));
    })->name('courses.detail');

    Route::get('/upskill4teacher', function () {
        return view('frontend.home-four.pages.upskill-teacher');
    })->name('upskill4teacher');

    Route::get('/api/collab-courses', function (\Illuminate\Http\Request $request) {
        $type = $request->get('type');
        
        $query = \App\Models\Course::active()
            ->with(['category.translation', 'instructor:id,name']);

        if ($type !== null && $type !== '') {
            $hasExactType = \App\Models\Course::where('type', $type)->exists();
            if ($hasExactType) {
                $query->where('type', $type);
            } else {
                if ((string)$type === '8') {
                    // Type 8: TTT - Train the Trainer / Educator courses
                    $query->where(function($q) {
                        $q->whereIn('category_id', [47, 53, 54, 56, 57])
                          ->orWhere('title', 'like', '%TRAINER%')
                          ->orWhere('title', 'like', '%TEACHER%')
                          ->orWhere('title', 'like', '%NLP%')
                          ->orWhere('title', 'like', '%ECE%')
                          ->orWhere('title', 'like', '%MTT%')
                          ->orWhere('title', 'like', '%NTT%')
                          ->orWhere('title', 'like', '%Grade%');
                    });
                } elseif ((string)$type === '10') {
                    // Type 10: Upskill 4 Teacher / Skill Enhancement courses
                    $query->where(function($q) {
                        $q->whereIn('category_id', [44, 46, 49, 50, 51, 52, 58, 59])
                          ->orWhere('title', 'like', '%SKILL%')
                          ->orWhere('title', 'like', '%DEVELOPMENT%')
                          ->orWhere('title', 'like', '%LITERACY%')
                          ->orWhere('title', 'like', '%WONDERKIDS%')
                          ->orWhere('title', 'like', '%YEP%')
                          ->orWhere('title', 'like', '%LDP%');
                    });
                }
            }
        }

        $courses = $query->orderBy('id', 'desc')
            ->get()
            ->map(function ($course) use ($type) {
                $thumb = $course->thumbnail ? asset($course->thumbnail) : asset('designs/img/TTT-1.png');
                $catName = $course->category?->translation?->name ?? 'Skill Courses';
                $assignedType = is_numeric($course->type) ? (int)$course->type : ($type ? (int)$type : 8);
                $effectivePrice = $course->discount > 0 ? (float)$course->discount : (float)$course->price;
                $originalPrice = (float)$course->price;
                $hasDiscount = $course->discount > 0 && $course->discount < $course->price;

                return [
                    'id' => $course->id,
                    'course_id' => $course->id,
                    'type' => $assignedType,
                    'course_type' => $assignedType,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'description' => strip_tags($course->description ?? ''),
                    'short_description' => $course->short_description ?? '',
                    'price' => $effectivePrice,
                    'formatted_price' => $effectivePrice > 0 ? '₹ ' . number_format($effectivePrice, 0) : 'Free',
                    'original_price' => $originalPrice,
                    'formatted_original_price' => '₹ ' . number_format($originalPrice, 0),
                    'discount' => (float) $course->discount,
                    'has_discount' => $hasDiscount,
                    'cover_image' => $thumb,
                    'image' => $thumb,
                    'thumbnail' => $thumb,
                    'category' => $catName,
                    'category_name' => $catName,
                    'instructor_name' => $course->instructor?->name ?? 'Skillvation',
                    'rating' => 5,
                    'reviews_count' => 12,
                ];
            });

        return response()->json([
            'status' => 'success',
            'type' => $type,
            'data' => $courses,
            'courses' => [
                'data' => $courses
            ]
        ])->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, OPTIONS');
    })->name('api.collab-courses');

    Route::get('/api/nav-menu', function () {
        $nav_menu = \Illuminate\Support\Facades\Cache::rememberForever('nav_menu', function () {
            return menuGetBySlug('nav-menu');
        });

        return response()->json([
            'status' => 'success',
            'data' => $nav_menu
        ])->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, OPTIONS');
    })->name('api.nav-menu');

    Route::get('/app', [HomePageController::class, 'index'])->name('home.app');

    Route::get('countries', [HomePageController::class, 'countries'])->name('countries');
    Route::get('states/{country_id}', [HomePageController::class, 'states'])->name('states');
    Route::get('cities/{state_id}', [HomePageController::class, 'cities'])->name('cities');

    /** become a instructor */
    Route::get('become-instructor', [BecomeInstructorController::class, 'index'])->name('become-instructor')->middleware('auth');
    Route::post('become-instructor', [BecomeInstructorController::class, 'store'])->name('become-instructor.create')->middleware('auth');

    Route::get('courses', [CoursePageController::class, 'index'])->name('courses');
    Route::get('fetch-courses', [CoursePageController::class, 'fetchCourses'])->name('fetch-courses');
    Route::get('course/{slug}', [CoursePageController::class, 'show'])->name('course.show');

    /** cart routes */
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::post('add-to-cart-by-api-id/{api_course_id}', [CartController::class, 'addToCartByApiId'])->name('add-to-cart-by-api-id');
    Route::get('remove-cart-item/{rowId}', [CartController::class, 'removeCartItem'])->name('remove-cart-item');
    Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::get('remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');

    /** Blog Routes */
    Route::get('blog', [BlogController::class, 'index'])->name('blogs');
    Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::post('blog/submit-comment', [BlogController::class, 'submitComment'])->name('blog.submit-comment');
    Route::get('all-instructors', [HomePageController::class, 'allInstructors'])->name('all-instructors');
    Route::get('instructor-details/{id}/{slug?}', [HomePageController::class, 'instructorDetails'])->name('instructor-details');
    Route::post('quick-connect/{id}', [HomePageController::class, 'quickConnect'])->name('quick-connect');

    /** About page routes */
    Route::get('about-us', [AboutPageController::class, 'index'])->name('about-us');
    /** Contact page routes */
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('contact/send-mail', [ContactController::class, 'sendMail'])->name('contact.send-mail');

    /** Custom pages */
    Route::get('page/{slug}', [HomePageController::class, 'customPage'])->name('custom-page');

    /** other routes */
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth:admin'], 'as' => 'admin.'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    Route::group(['prefix' => 'frontend-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::get('change-theme/{name}', [HomePageController::class, 'changeTheme'])->name('change-theme');

    /**
     * ============================================================================
     * Student Dashboard Routes
     * ============================================================================
     */

    Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'student', 'as' => 'student.'], function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        // Profile setting routes
        Route::get('setting', [StudentProfileSettingController::class, 'index'])->name('setting.index');
        Route::put('setting/profile', [StudentProfileSettingController::class, 'updateProfile'])->name('setting.profile.update');
        Route::put('setting/bio', [StudentProfileSettingController::class, 'updateBio'])->name('setting.bio.update');
        Route::put('setting/password', [StudentProfileSettingController::class, 'updatePassword'])->name('setting.password.update');
        Route::get('setting/experience-modal', [StudentProfileSettingController::class, 'showExperienceModal'])->name('setting.experience-modal');
        Route::get('setting/edit-experience-modal/{id}', [StudentProfileSettingController::class, 'editExperienceModal'])->name('setting.edit-experience-modal');

        Route::post('setting/experience', [StudentProfileSettingController::class, 'storeExperience'])->name('setting.experience.store');
        Route::put('setting/experience/{id}', [StudentProfileSettingController::class, 'updateExperience'])->name('setting.experience.update');
        Route::delete('setting/experience/{id}', [StudentProfileSettingController::class, 'destroyExperience'])->name('setting.experience.destroy');

        Route::get('setting/add-education-modal', [StudentProfileSettingController::class, 'addEducationModal'])->name('setting.add-education-modal');
        Route::post('setting/education', [StudentProfileSettingController::class, 'storeEducation'])->name('setting.education.store');
        Route::get('setting/edit-education-modal/{id}', [StudentProfileSettingController::class, 'editEducationModal'])->name('setting.edit-education-modal');
        Route::put('setting/education/{id}', [StudentProfileSettingController::class, 'updateEducation'])->name('setting.education.update');
        Route::delete('setting/education/{id}', [StudentProfileSettingController::class, 'destroyEducation'])->name('setting.education.destroy');

        Route::put('setting/address', [StudentProfileSettingController::class, 'updateAddress'])->name('setting.address.update');
        Route::put('setting/socials', [StudentProfileSettingController::class, 'updateSocials'])->name('setting.socials.update');

        /** Order Routes */
        Route::get('orders', [StudentOrderController::class, 'index'])->name('orders.index');
        Route::get('order-details/{id}', [StudentOrderController::class, 'show'])->name('order.show');
        Route::get('order/invoice/{id}', [StudentOrderController::class, 'printInvoice'])->name('order.print-invoice');

        Route::get('reviews', [StudentReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{id}', [StudentReviewController::class, 'show'])->name('reviews.show');
        Route::delete('reviews/{id}', [StudentReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('enrolled-courses', [StudentDashboardController::class, 'enrolledCourses'])->name('enrolled-courses');
        Route::get('enrolled-courses-grades/{slug}', [StudentDashboardController::class, 'enrolledCoursesGrades'])->name('enrolled-courses-grades');
        Route::get('quiz-attempts', [StudentDashboardController::class, 'quizAttempts'])->name('quiz-attempts');

        /** learning routes */
        Route::get('learning/{slug}', [LearningController::class, 'index'])->name('learning.index');
        Route::get('learning/grade/{slug}', [LearningController::class, 'grade'])->name('learning.grade');
        Route::post('learning/get-file-info', [LearningController::class, 'getFileInfo'])->name('get-file-info');
        Route::post('learning/make-lesson-complete', [LearningController::class, 'makeLessonComplete'])->name('make-lesson-complete');
        Route::get('learning/resource-download/{id}', [LearningController::class, 'downloadResource'])->name('download-resource');

        Route::get('learning/quiz/{id}', [LearningController::class, 'quizIndex'])->name('quiz.index');
        Route::post('learning/quiz/{id}', [LearningController::class, 'quizStore'])->name('quiz.store');
        Route::get('learning/quiz-result/{id}/{result_id}', [LearningController::class, 'quizResult'])->name('quiz.result');
        Route::get('learning/{slug}/{lesson_id}', [LearningController::class, 'liveSession'])->name('learning.live');

        /** qna routes */
        Route::post('create-question', [QnaController::class, 'create'])->name('qna.create');
        Route::get('fetch-lesson-questions', [QnaController::class, 'fetchLessonQuestions'])->name('fetch-lesson-questions');
        Route::post('create-reply', [QnaController::class, 'createReply'])->name('create-reply');
        Route::get('fetch-replies', [QnaController::class, 'fetchReply'])->name('fetch-replies');

        Route::delete('delete-question/{id}', [QnaController::class, 'destroyQuestion'])->name('destroy-question');
        Route::delete('delete-reply/{id}', [QnaController::class, 'destroyReply'])->name('destroy-reply');

        /** course review Routes */
        Route::post('add-review', [LearningController::class, 'addReview'])->name('add-review');
        Route::get('fetch-reviews/{course_id}', [LearningController::class, 'fetchReviews'])->name('fetch-reviews');

        /** download certificate route */
        Route::get('download-certificate/{id}', [StudentDashboardController::class, 'downloadCertificate'])->name('download-certificate');
    });

    /**
     * ============================================================================
     * School Dashboard Routes
     * ============================================================================
     */

    Route::group(['middleware' => ['auth', 'verified', 'role:school'], 'prefix' => 'school', 'as' => 'school.'], function () {
        Route::get('dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');

        /** Teachers */
        Route::get('teachers', [SchoolTeacherController::class, 'index'])->name('teachers.index');
        Route::get('teachers/create', [SchoolTeacherController::class, 'create'])->name('teachers.create');
        Route::get('teachers/download-template', [SchoolTeacherController::class, 'downloadTemplate'])->name('teachers.download-template');
        Route::get('teachers/{member}', [SchoolTeacherController::class, 'show'])->name('teachers.show');
        Route::post('teachers', [SchoolTeacherController::class, 'store'])->name('teachers.store');
        Route::post('teachers/import', [SchoolTeacherController::class, 'import'])->name('teachers.import');
        Route::patch('teachers/{member}/toggle-status', [SchoolTeacherController::class, 'toggleStatus'])->name('teachers.toggle-status');
        Route::delete('teachers/{member}', [SchoolTeacherController::class, 'destroy'])->name('teachers.destroy');

        /** Students */
        Route::get('students', [SchoolStudentController::class, 'index'])->name('students.index');
        Route::get('students/create', [SchoolStudentController::class, 'create'])->name('students.create');
        Route::get('students/download-template', [SchoolStudentController::class, 'downloadTemplate'])->name('students.download-template');
        Route::get('students/{member}', [SchoolStudentController::class, 'show'])->name('students.show');
        Route::post('students', [SchoolStudentController::class, 'store'])->name('students.store');
        Route::post('students/import', [SchoolStudentController::class, 'import'])->name('students.import');
        Route::patch('students/{member}/toggle-status', [SchoolStudentController::class, 'toggleStatus'])->name('students.toggle-status');
        Route::delete('students/{member}', [SchoolStudentController::class, 'destroy'])->name('students.destroy');

        /** Courses & Assignments */
        Route::get('courses', [SchoolCourseController::class, 'index'])->name('courses.index');
        Route::get('courses/{courseId}/assign', [SchoolCourseController::class, 'assign'])->name('courses.assign');
        Route::post('courses/{courseId}/assign', [SchoolCourseController::class, 'storeAssignment'])->name('courses.store-assignment');
        Route::get('courses/{courseId}/assignments', [SchoolCourseController::class, 'assignments'])->name('courses.assignments');
        Route::patch('courses/assignment/{assignmentId}/revoke', [SchoolCourseController::class, 'revokeAssignment'])->name('courses.revoke-assignment');

        /** Order History */
        Route::get('orders', [SchoolOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [SchoolOrderController::class, 'show'])->name('orders.show');
        Route::get('orders/invoice/{id}', [SchoolOrderController::class, 'printInvoice'])->name('orders.print-invoice');

        /** Profile Settings */
        Route::get('profile', [SchoolProfileSettingController::class, 'index'])->name('profile.index');
        Route::put('profile', [SchoolProfileSettingController::class, 'updateProfile'])->name('profile.update');
        Route::put('profile/password', [SchoolProfileSettingController::class, 'updatePassword'])->name('profile.update-password');
    });

    /**
     * ============================================================================
     * Instructor Dashboard Routes
     * ============================================================================
     */

    Route::group(['middleware' => ['auth', 'verified', 'approved.instructor', 'role:instructor'], 'prefix' => 'instructor', 'as' => 'instructor.'], function () {
        Route::get('dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
        // Profile setting routes
        Route::get('zoom-setting', [InstructorLiveCredentialController::class, 'index'])->name('zoom-setting.index');
        Route::put('zoom-setting', [InstructorLiveCredentialController::class, 'update'])->name('zoom-setting.update');
        Route::get('jitsi-setting', [InstructorLiveCredentialController::class, 'jitsi_index'])->name('jitsi-setting.index');
        Route::put('jitsi-setting', [InstructorLiveCredentialController::class, 'jitsi_update'])->name('jitsi-setting.update');
        Route::get('setting', [InstructorProfileSettingController::class, 'index'])->name('setting.index');
        Route::put('setting/profile', [InstructorProfileSettingController::class, 'updateProfile'])->name('setting.profile.update');
        Route::put('setting/bio', [InstructorProfileSettingController::class, 'updateBio'])->name('setting.bio.update');
        Route::put('setting/password', [InstructorProfileSettingController::class, 'updatePassword'])->name('setting.password.update');
        Route::get('setting/experience-modal', [InstructorProfileSettingController::class, 'showExperienceModal'])->name('setting.experience-modal');
        Route::get('setting/edit-experience-modal/{id}', [InstructorProfileSettingController::class, 'editExperienceModal'])->name('setting.edit-experience-modal');

        Route::post('setting/experience', [InstructorProfileSettingController::class, 'storeExperience'])->name('setting.experience.store');
        Route::put('setting/experience/{id}', [InstructorProfileSettingController::class, 'updateExperience'])->name('setting.experience.update');
        Route::delete('setting/experience/{id}', [InstructorProfileSettingController::class, 'destroyExperience'])->name('setting.experience.destroy');

        Route::get('setting/add-education-modal', [InstructorProfileSettingController::class, 'addEducationModal'])->name('setting.add-education-modal');
        Route::post('setting/education', [InstructorProfileSettingController::class, 'storeEducation'])->name('setting.education.store');
        Route::get('setting/edit-education-modal/{id}', [InstructorProfileSettingController::class, 'editEducationModal'])->name('setting.edit-education-modal');
        Route::put('setting/education/{id}', [InstructorProfileSettingController::class, 'updateEducation'])->name('setting.education.update');
        Route::delete('setting/education/{id}', [InstructorProfileSettingController::class, 'destroyEducation'])->name('setting.education.destroy');

        Route::put('setting/payout', [InstructorProfileSettingController::class, 'updatePayout'])->name('setting.payout.update');

        Route::put('setting/address', [InstructorProfileSettingController::class, 'updateAddress'])->name('setting.address.update');
        Route::put('setting/socials', [InstructorProfileSettingController::class, 'updateSocials'])->name('setting.socials.update');

        /** Course Routes */
        Route::get('courses', [InstructorCourseController::class, 'index'])->name('courses.index');
        Route::get('courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
        Route::get('courses/create/{id}/step/{step?}', [InstructorCourseController::class, 'edit'])->name('courses.edit');
        Route::get('courses/{id}/edit', [InstructorCourseController::class, 'editView'])->name('courses.edit-view');

        Route::get('courses/get-filters/{category_id}', [InstructorCourseController::class, 'getFiltersByCategory'])->name('courses.get-filters');
        Route::get('courses/get-instructors', [InstructorCourseController::class, 'getInstructors'])->name('courses.get-instructors');

        Route::post('courses/create', [InstructorCourseController::class, 'store'])->name('courses.store');
        Route::post('courses/update', [InstructorCourseController::class, 'update'])->name('courses.update');

        /** Course content routes */
        Route::post('course-chapter/{course_id?}/store', [CourseContentController::class, 'chapterStore'])->name('course-chapter.store');
        Route::get('course-chapter/sorting/{course_id}', [CourseContentController::class, 'chapterSorting'])->name('course-chapter.sorting.index');
        Route::get('course-chapter/edit/{chapter_id}', [CourseContentController::class, 'chapterEdit'])->name('course-chapter.edit');
        Route::put('course-chapter/update/{chapter_id}', [CourseContentController::class, 'chapterUpdate'])->name('course-chapter.update');
        Route::delete('course-chapter/delete/{chapter_id}', [CourseContentController::class, 'chapterDestroy'])->name('course-chapter.destroy');

        Route::post('course-chapter/sorting/{course_id}', [CourseContentController::class, 'chapterSortingStore'])->name('course-chapter.sorting.store');
        Route::get('course-chapter/lesson/create', [CourseContentController::class, 'lessonCreate'])->name('course-chapter.lesson.create');
        Route::post('course-chapter/lesson/create', [CourseContentController::class, 'lessonStore'])->name('course-chapter.lesson.store');
        Route::get('course-chapter/lesson/edit', [CourseContentController::class, 'lessonEdit'])->name('course-chapter.lesson.edit');

        Route::post('course-chapter/lesson/update', [CourseContentController::class, 'lessonUpdate'])->name('course-chapter.lesson.update');
        Route::delete('course-chapter/lesson/{chapter_item_id}/destroy', [CourseContentController::class, 'chapterLessonDestroy'])->name('course-chapter.lesson.destroy');
        Route::post('course-chapter/lesson/sorting/{chapter_id}', [CourseContentController::class, 'sortLessons'])->name('course-chapter.lesson.sorting');

        Route::get('course-chapter/quiz-question/create/{quiz_id}', [CourseContentController::class, 'createQuizQuestion'])->name('course-chapter.quiz-question.create');
        Route::post('course-chapter/quiz-question/create/{quiz_id}', [CourseContentController::class, 'storeQuizQuestion'])->name('course-chapter.quiz-question.store');
        Route::get('course-chapter/quiz-question/edit/{question_id}', [CourseContentController::class, 'editQuizQuestion'])->name('course-chapter quiz-question.edit');
        Route::put('course-chapter/quiz-question/update/{question_id}', [CourseContentController::class, 'updateQuizQuestion'])->name('course-chapter.quiz-question.update');
        Route::delete('course-chapter/quiz-question/delete/{question_id}', [CourseContentController::class, 'destroyQuizQuestion'])->name('course-chapter.quiz-question.destroy');
        Route::get('course-delete-request/{course_id}', [InstructorCourseController::class, 'showDeleteRequest'])->name('course.delete-request.show');
        Route::post('course-delete-request', [InstructorCourseController::class, 'sendDeleteRequest'])->name('course.send-delete-request');

        /** payout routes */
        Route::get('payout', [InstructorPayoutController::class, 'index'])->name('payout.index');
        Route::get('payout/create', [InstructorPayoutController::class, 'create'])->name('payout.create');
        Route::post('payout/create', [InstructorPayoutController::class, 'store'])->name('payout.store');
        Route::delete('payout/delete/{id}', [InstructorPayoutController::class, 'destroy'])->name('payout.destroy');

        /** announcement routes */
        Route::resource('announcements', InstructorAnnouncementController::class);

        /** my sales routes */
        Route::get('my-sells', [InstructorDashboardController::class, 'mySells'])->name('my-sells.index');
        /** lessons qna routes */
        Route::get('lesson-question', [InstructorLessonQnaController::class, 'index'])->name('lesson-questions.index');
        Route::post('lesson-question/{id}', [InstructorLessonQnaController::class, 'createReply'])->name('lesson-question.reply');
        Route::delete('lesson-question/destroy/{id}', [InstructorLessonQnaController::class, 'destroyQuestion'])->name('lesson-question.destroy');
        Route::delete('lesson-question/reply/destroy/{id}', [InstructorLessonQnaController::class, 'destroyReply'])->name('lesson-reply.destroy');
        Route::put('lesson-question/seen-update/{id}', [InstructorLessonQnaController::class, 'markAsReadUnread'])->name('lesson-question.seen-update');

        Route::post('cloud/store', [CloudStorageController::class, 'store'])->name('cloud.store');
    });

    Route::group(['middleware' => ['auth', 'verified']], function () {
        /** checkout routes */
        Route::get('checkout', [CheckOutController::class, 'index'])->name('checkout.index');

        /**payment related route start */
        Route::get('payment', [PaymentController::class, 'payment'])->name('payment');
        Route::post('pay-via-stripe', [PaymentController::class, 'pay_via_stripe'])->name('pay-via-stripe');
        Route::get('pay-via-paypal', [PaymentController::class, 'pay_via_paypal'])->name('pay-via-paypal');
        Route::post('pay-via-bank', [PaymentController::class, 'pay_via_bank'])->name('pay-via-bank');
        Route::post('pay-via-razorpay', [PaymentController::class, 'pay_via_razorpay'])->name('pay-via-razorpay');
        Route::get('pay-via-mollie', [PaymentController::class, 'pay_via_mollie'])->name('pay-via-mollie');
        Route::get('pay-via-instamojo', [PaymentController::class, 'pay_via_instamojo'])->name('pay-via-instamojo');
        Route::post('pay-via-flutterwave', [PaymentController::class, 'pay_via_flutterwave'])->name('pay-via-flutterwave');
        Route::post('pay-via-paystack', [PaymentController::class, 'pay_via_paystack'])->name('pay-via-paystack');
        Route::post('pay-via-bank', [PaymentController::class, 'pay_via_bank'])->name('pay-via-bank');
        Route::post('pay-via-free-gateway', [PaymentController::class, 'pay_via_free_gateway'])->name('pay-via-free-gateway');
        Route::get('/payment-addon-success', [PaymentController::class, 'payment_addon_success'])->name('payment-addon-success');
        Route::get('/payment-addon-faild', [PaymentController::class, 'payment_addon_faild'])->name('payment-addon-faild');
        Route::get('order-completed', [PaymentController::class, 'order_success'])->name('order-success');
        Route::get('order-fail', [PaymentController::class, 'order_fail'])->name('order-fail');

        Route::post('tinymce-upload-image', [TinymceImageUploadController::class, 'upload']);
        Route::delete('tinymce-delete-image', [TinymceImageUploadController::class, 'destroy']);
    });
});

//maintenance mode route
Route::get('/maintenance-mode', function () {
    $setting = Illuminate\Support\Facades\Cache::get('setting', null);
    if (!$setting?->maintenance_mode) {
        return redirect()->route('home');
    }

    return view('global.maintenance');
})->name('maintenance.mode');

require __DIR__ . '/auth.php';

require __DIR__ . '/admin.php';

