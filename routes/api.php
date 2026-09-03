<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/collab-courses', function (\Illuminate\Http\Request $request) {
    $type = $request->get('type');
    
    $query = \App\Models\Course::active()
        ->with(['category.translation', 'instructor:id,name']);

    if ($type !== null && $type !== '') {
        $hasExactType = \App\Models\Course::where('type', $type)->exists();
        if ($hasExactType) {
            $query->where('type', $type);
        } else {
            if ((string)$type === '8') {
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

            return [
                'id' => $course->id,
                'course_id' => $course->id,
                'type' => $assignedType,
                'course_type' => $assignedType,
                'title' => $course->title,
                'slug' => $course->slug,
                'description' => strip_tags($course->description ?? ''),
                'short_description' => $course->short_description ?? '',
                'price' => (float) $course->price,
                'formatted_price' => '₹ ' . number_format($course->price, 0),
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
    ]);
});

Route::get('/nav-menu', function () {
    $nav_menu = \Illuminate\Support\Facades\Cache::rememberForever('nav_menu', function () {
        return menuGetBySlug('nav-menu');
    });

    return response()->json([
        'status' => 'success',
        'data' => $nav_menu
    ]);
});
