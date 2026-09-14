@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex justify-content-between">
            <h4 class="title">{{ __('Enrolled Courses') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="courseTabContent">
                            @forelse ($enrolls as $enroll)
                                <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel"
                                    aria-labelledby="all-tab" tabindex="0">
                                    <div class="dashboard-courses-active dashboard_courses">
                                        <div class="courses__item courses__item-two shine__animate-item">
                                            <div class="row align-items-center">
                                                <div class="col-xl-5">
                                                    <div class="courses__item-thumb courses__item-thumb-two">
                                                        <a href="{{ route('student.enrolled-courses-grades', $enroll->course->slug) }}"
                                                            class="shine__animate-link">
                                                            <img src="{{ asset($enroll->course->thumbnail) }}"
                                                                alt="img">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-7">
                                                    <div class="courses__item-content courses__item-content-two">
                                                        <ul class="courses__item-meta list-wrap">
                                                            <li class="courses__item-tag">
                                                                <a
                                                                    href="javascript:;">{{ $enroll->course->category->translation->name }}</a>
                                                            </li>
                                                        </ul>

                                                        <h5 class="title">
                                                            <a href="{{ route('student.enrolled-courses-grades', $enroll->course->slug) }}">{{ $enroll->course->title }}</a>
                                                        </h5>
                                                        <div class="courses__item-content-bottom">
                                                            <div class="author-two">
                                                                <a href="javascript:;"><img
                                                                        src="{{ asset($enroll->course->instructor->image) }}"
                                                                        alt="img">{{ $enroll->course->instructor->name }}</a>
                                                            </div>
                                                            <div class="avg-rating">
                                                                <i class="fas fa-star"></i>
                                                                {{ number_format($enroll->course->reviews()->avg('rating') ?? 0, 1) }}
                                                            </div>
                                                        </div>
                                                        @php
                                                            $courseLectureCount = App\Models\CourseChapterItem::whereHas(
                                                                'chapter',
                                                                function ($q) use ($enroll) {
                                                                    $q->where('course_id', $enroll->course->id);
                                                                },
                                                            )->count();

                                                            $courseLectureCompletedByUser = App\Models\CourseProgress::where(
                                                                'user_id',
                                                                userAuth()->id,
                                                            )
                                                                ->where('course_id', $enroll->course->id)
                                                                ->where('watched', 1)
                                                                ->count();
                                                            $courseCompletedPercent =
                                                                $courseLectureCount > 0
                                                                    ? ($courseLectureCompletedByUser /
                                                                            $courseLectureCount) *
                                                                        100
                                                                    : 0;
                                                        @endphp
                                                        <div class="progress-item progress-item-two">
                                                            <h6 class="title">
                                                                {{ __('COMPLETE') }}<span>{{ number_format($courseCompletedPercent, 1) }}%</span>
                                                            </h6>
                                                            <div class="progress" role="progressbar"
                                                                aria-label="Example with label" aria-valuenow="25"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar"
                                                                    style="width: {{ number_format($courseCompletedPercent, 1) }}%">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="courses__item-bottom-two">
                                                        <ul class="list-wrap">
                                                            <li><i class="flaticon-book"></i>{{ $courseLectureCount }}
                                                            </li>
                                                            <li><i
                                                                    class="flaticon-clock"></i>{{ minutesToHours($enroll->course->duration) }}
                                                            </li>
                                                            <li><i
                                                                    class="flaticon-mortarboard"></i>{{ $enroll->course->enrollments()->count() }}
                                                            </li>
                                                            @if ($courseCompletedPercent == 100)
                                                                <li class="ms-auto">
                                                                    <a class="basic-button"
                                                                        href="{{ route('student.download-certificate', $enroll->course->id) }}"><i
                                                                            class="certificate fas fa-download"></i>
                                                                        {{ __('Certificate') }}</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <div class="text-center py-5 bg-white rounded-4 border p-4">
                                <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 48px;"></i>
                                <h5 class="fw-bold mb-1">{{ __('No Enrolled Courses Found') }}</h5>
                                <p class="text-muted small mb-3">{{ __('You have not enrolled in any courses yet. Browse our course catalog to start learning!') }}</p>
                                <a href="{{ route('courses') }}" class="btn btn-primary btn-sm px-4">
                                    <i class="fas fa-search me-1"></i> {{ __('Explore Courses') }}
                                </a>
                            </div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
                        @if($enrolls->hasPages())
                            <div class="mt-4">
                                {{ $enrolls->links() }}
                            </div>
                        @endif

                        {{-- ───────────── RECOMMENDED COURSES FOR CROSS-SELLING ───────────── --}}
                        @if(isset($relatedCourses) && $relatedCourses->isNotEmpty())
                            <div class="mt-5 pt-4 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                    <div>
                                        <span class="badge bg-primary-subtle text-primary px-3 py-1 mb-1 fw-bold" style="font-size: 11px; text-transform: uppercase;">
                                            <i class="fas fa-sparkles me-1"></i> {{ __('Discover More') }}
                                        </span>
                                        <h4 class="title mb-0 fw-bold" style="font-size: 22px;">{{ __('Recommended Courses for You') }}</h4>
                                        <p class="text-muted small mb-0">{{ __('Expand your skills with these recommended courses and grade pathways.') }}</p>
                                    </div>
                                    <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-primary px-3">
                                        {{ __('Browse All Courses') }} <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>

                                <div class="row g-4">
                                    @foreach($relatedCourses as $relCourse)
                                        <div class="col-xl-4 col-lg-6 col-md-6">
                                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden cross-sell-card" style="transition: all 0.3s ease; border: 1px solid #edf2f7 !important; background: #fff;">
                                                <div class="position-relative overflow-hidden" style="height: 175px; background: #f1f5f9;">
                                                    <a href="{{ route('course.show', $relCourse->slug) }}">
                                                        <img src="{{ asset($relCourse->thumbnail) }}" alt="{{ $relCourse->title }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
                                                    </a>
                                                    @if($relCourse->category?->translation?->name)
                                                        <span class="position-absolute top-0 start-0 m-3 badge bg-white text-dark shadow-sm px-2 py-1" style="font-size: 11px; font-weight: 700;">
                                                            {{ $relCourse->category->translation->name }}
                                                        </span>
                                                    @endif
                                                    <div class="position-absolute bottom-0 end-0 m-2">
                                                        @if($relCourse->price > 0)
                                                            @if($relCourse->discount)
                                                                <span class="badge bg-danger shadow-sm px-2 py-1 fw-bold">{{ currency($relCourse->discount) }}</span>
                                                            @else
                                                                <span class="badge bg-primary shadow-sm px-2 py-1 fw-bold">{{ currency($relCourse->price) }}</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-success shadow-sm px-2 py-1 fw-bold">{{ __('Free') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 12px;">
                                                            <div class="text-warning">
                                                                <i class="fas fa-star"></i>
                                                                <span class="text-dark fw-bold ms-1">{{ number_format($relCourse->reviews?->avg('rating') ?? 5, 1) }}</span>
                                                            </div>
                                                            <div class="text-muted">
                                                                <i class="fas fa-users me-1"></i> {{ $relCourse->enrollments_count ?? $relCourse->enrollments()->count() }} {{ __('students') }}
                                                            </div>
                                                        </div>

                                                        <h6 class="fw-bold mb-2" style="font-size: 15px; line-height: 1.4; height: 42px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                            <a href="{{ route('course.show', $relCourse->slug) }}" class="text-dark text-decoration-none">
                                                                {{ $relCourse->title }}
                                                            </a>
                                                        </h6>
                                                    </div>

                                                    <div class="pt-3 mt-2 border-top d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center gap-2" style="font-size: 12px;">
                                                            <div style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">
                                                                {{ strtoupper(substr($relCourse->instructor?->name ?? 'P', 0, 1)) }}
                                                            </div>
                                                            <span class="text-muted text-truncate" style="max-width: 110px;">{{ $relCourse->instructor?->name ?? __('Instructor') }}</span>
                                                        </div>

                                                        <a href="{{ route('course.show', $relCourse->slug) }}" class="btn btn-sm btn-primary px-3 py-1 rounded-pill" style="font-size: 12px; font-weight: 600;">
                                                            {{ __('Explore') }} <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
