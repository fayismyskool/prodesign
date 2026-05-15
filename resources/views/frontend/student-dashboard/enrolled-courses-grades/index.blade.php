@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')

<div class="dashboard__content-wrap">

    {{-- Header --}}
    <div class="dashboard__content-title d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h4 class="title mb-0">{{ $course->title }}</h4>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="tab-content" id="courseTabContent">
            @if($grades->isNotEmpty())

                <div class="tab-pane fade show active"
                    id="all-tab-pane"
                    role="tabpanel"
                    aria-labelledby="all-tab"
                    tabindex="0">
                    @foreach($grades as $gi => $grade)
                        <!-- Course Item -->
                        <div class="dashboard-courses-active dashboard_courses mb-4">

                            <div class="courses__item courses__item-two shine__animate-item">

                                <div class="row align-items-center">

                                    <!-- Thumbnail -->
                                    <div class="col-xl-5">

                                        <div class="courses__item-thumb courses__item-thumb-two">

                                            <a href="#" class="shine__animate-link">
                                                @if($grade->images->isNotEmpty())
                                                <img src="{{ $grade->images->first()->image_path }}"
                                                    alt="{{ $grade->title }}">
                                                @endif

                                            </a>

                                        </div>

                                    </div>

                                    <!-- Content -->
                                    <div class="col-xl-7">

                                        <div class="courses__item-content courses__item-content-two">
                                            <!-- Title -->
                                            <h5 class="title">
                                                <a href="{{ route('student.learning.index', $course->slug) }}">
                                                    {{ $grade->title }}
                                                </a>
                                            </h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- End Course Item -->
                    @endforeach

                </div>

            </div>
            @endif
        </div>
    </div>

    <!-- @if($grades->isNotEmpty())

        <div class="grade-tabs-wrapper">

            {{-- Grade tab buttons --}}
            <div class="grade-tab-nav" role="tablist">
                @foreach($grades as $gi => $grade)
                    <button
                        class="grade-tab-btn {{ $gi === 0 ? 'active' : '' }}"
                        role="tab"
                        aria-selected="{{ $gi === 0 ? 'true' : 'false' }}"
                        data-pane="grade-pane-{{ $grade->id }}"
                    >
                        <span class="grade-num">{{ $gi + 1 }}</span>
                        {{ $grade->title }}
                    </button>
                @endforeach
            </div>

            {{-- Grade panes --}}
            @foreach($grades as $gi => $grade)
                <div
                    id="grade-pane-{{ $grade->id }}"
                    class="grade-tab-pane {{ $gi === 0 ? 'active' : '' }}"
                    role="tabpanel"
                >
                    {{-- Grade hero --}}
                    <div class="grade-hero">
                        @if($grade->images->isNotEmpty())
                            <img src="{{ $grade->images->first()->image_path }}"
                                class="grade-hero-img" alt="{{ $grade->title }}">
                        @endif
                        <div>
                            <h2>{{ $grade->title }}</h2>
                            @if($grade->description)
                                <p>{{ $grade->description }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Chapters --}}
                    @forelse($grade->chapters as $ci => $chapter)
                        <div class="chapter-section">

                            <div class="chapter-section-title">
                                <span class="ch-badge">{{ __('Chapter') }} {{ $ci + 1 }}</span>
                                {{ $chapter->title }}
                            </div>

                            @if($chapter->description)
                                <p class="chapter-desc">{{ $chapter->description }}</p>
                            @endif

                            @php
                                $activityItems = $chapter->chapterItems->where('type', 'activity');
                                $otherItems    = $chapter->chapterItems->where('type', '!=', 'activity');
                            @endphp

                            {{-- Activity cards --}}
                            @if($activityItems->count())
                                <div class="row g-3 mb-4">
                                    @foreach($activityItems as $ai => $item)
                                        @php $lesson = $item->lesson; @endphp
                                        <div class="col-lg-4 col-md-6">
                                            <div class="card activity-card accent-{{ $ai % 6 }}">
                                                <div class="card-body">
                                                    <div class="activity-label">{{ __('Activity') }} {{ $ai + 1 }}</div>
                                                    <h3>{{ $lesson?->title ?? __('Untitled Activity') }}</h3>
                                                    @if($lesson?->description)
                                                        <p class="activity-desc">{{ $lesson->description }}</p>
                                                    @endif
                                                    @if($lesson && ($lesson->age_min || $lesson->age_max || $lesson->activity_duration || $lesson->material_required))
                                                        <div class="activity-meta">
                                                            @if($lesson->age_min || $lesson->age_max)
                                                                <span class="meta-tag">
                                                                    <i class="fas fa-child"></i>{{ __('Age') }}
                                                                    @if($lesson->age_min && $lesson->age_max) {{ $lesson->age_min }}–{{ $lesson->age_max }}
                                                                    @elseif($lesson->age_min) {{ $lesson->age_min }}+
                                                                    @else {{ __('Up to') }} {{ $lesson->age_max }}
                                                                    @endif
                                                                </span>
                                                            @endif
                                                            @if($lesson->activity_duration)
                                                                <span class="meta-tag"><i class="fas fa-clock"></i>{{ $lesson->activity_duration }}</span>
                                                            @endif
                                                            @if($lesson->material_required)
                                                                <span class="meta-tag"><i class="fas fa-box-open"></i>{{ \Illuminate\Support\Str::limit($lesson->material_required, 35) }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Lesson / document / quiz rows --}}
                            @if($otherItems->count())
                                <div class="mb-2">
                                    @foreach($otherItems as $item)
                                        @php
                                            $iconClass = match($item->type) { 'lesson' => 'icon-video', 'document' => 'icon-doc', 'quiz' => 'icon-quiz', default => 'icon-other' };
                                            $iconFa    = match($item->type) { 'lesson' => 'fas fa-play', 'document' => 'fas fa-file-alt', 'quiz' => 'fas fa-question-circle', default => 'fas fa-circle' };
                                            $label     = match($item->type) { 'lesson' => __('Lesson'), 'document' => __('Document'), 'quiz' => __('Quiz'), default => ucfirst($item->type) };
                                            $title     = $item->lesson?->title ?? $item->quiz?->title ?? __('Untitled');
                                        @endphp
                                        <div class="lesson-row">
                                            <div class="lesson-icon {{ $iconClass }}"><i class="{{ $iconFa }}"></i></div>
                                            <p class="lesson-title">{{ $title }}</p>
                                            <span class="lesson-type-badge">{{ $label }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($chapter->chapterItems->isEmpty())
                                <p class="text-muted small">{{ __('No items in this chapter yet.') }}</p>
                            @endif

                        </div>
                    @empty
                        <p class="text-muted">{{ __('No chapters in this grade.') }}</p>
                    @endforelse

                </div>
            @endforeach

        </div>

    @else
        <div class="text-center py-5">
            <i class="fas fa-layer-group fa-3x text-muted mb-3 d-block"></i>
            <p class="text-muted">{{ __('No grades available for this course yet.') }}</p>
        </div>
    @endif -->

</div>

<script>
(function () {
    document.querySelectorAll('.grade-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var wrapper = btn.closest('.grade-tabs-wrapper');
            wrapper.querySelectorAll('.grade-tab-btn').forEach(function (b) {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            wrapper.querySelectorAll('.grade-tab-pane').forEach(function (p) {
                p.classList.remove('active');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            var target = document.getElementById(btn.dataset.pane);
            if (target) target.classList.add('active');
        });
    });
})();
</script>

@endsection
