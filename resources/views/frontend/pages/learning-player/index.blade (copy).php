@extends('frontend.pages.learning-player.master')

@section('meta_title', $course->title . ' || ' . $setting->app_name)

@section('contents')

<style>
    /* ── Hero ── */
    .phonics-hero {
        background: linear-gradient(135deg, #6d4bc3, #7d5ce0);
        border-radius: 20px;
        padding: 50px 60px;
        color: #fff;
    }
    .phonics-hero h1 { font-size: 36px; font-weight: 700; margin: 0 0 10px; }
    .phonics-hero p  { font-size: 16px; line-height: 1.7; color: #fff; opacity: .9; margin: 0; }

    /* ── Grade tabs ── */
    .grade-tabs-wrapper {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07);
        overflow: hidden;
    }
    .grade-tab-nav {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        scrollbar-width: none;
        border-bottom: 2px solid #f0ecfb;
        background: #faf8ff;
        padding: 0 8px;
    }
    .grade-tab-nav::-webkit-scrollbar { display: none; }
    .grade-tab-btn {
        padding: 16px 24px;
        font-size: 14px;
        font-weight: 700;
        color: #666;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color .2s, border-color .2s;
        flex-shrink: 0;
    }
    .grade-tab-btn:hover { color: #6d4bc3; }
    .grade-tab-btn.active { color: #6d4bc3; border-bottom-color: #6d4bc3; background: #fff; }
    .grade-tab-btn .grade-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 26px; height: 26px; border-radius: 50%;
        background: #ede7f6; color: #6d4bc3;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
        transition: background .2s, color .2s;
    }
    .grade-tab-btn.active .grade-num { background: #6d4bc3; color: #fff; }

    /* ── Grade pane ── */
    .grade-tab-pane { display: none; padding: 32px; animation: fadePane .25s ease; }
    .grade-tab-pane.active { display: block; }
    @keyframes fadePane { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }

    /* ── Chapter section inside grade ── */
    .chapter-section { margin-bottom: 36px; }
    .chapter-section-title {
        font-size: 18px; font-weight: 700; color: #1a1a2e;
        padding-bottom: 10px; margin-bottom: 20px;
        border-bottom: 2px solid #f0ecfb;
        display: flex; align-items: center; gap: 10px;
    }
    .chapter-section-title .ch-badge {
        background: #6d4bc3; color: #fff;
        font-size: 11px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; padding: 3px 10px; border-radius: 20px;
        flex-shrink: 0;
    }
    .chapter-desc { font-size: 14px; color: #666; margin-bottom: 16px; }

    /* ── Activity card ── */
    .activity-card {
        border: none; border-radius: 16px; overflow: hidden;
        transition: transform .3s, box-shadow .3s; height: 100%;
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
    }
    .activity-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,.12); }
    .activity-card .card-body { padding: 24px; }
    .activity-label { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #999; font-weight: 700; margin-bottom: 10px; }
    .activity-card h3 { font-size: 19px; font-weight: 700; margin-bottom: 10px; color: #1a1a2e; }
    .activity-card .activity-desc { font-size: 14px; line-height: 1.75; color: #555; margin-bottom: 0; }
    .activity-meta { border-top: 1px solid #eee; padding-top: 12px; margin-top: 14px; }
    .activity-meta .meta-tag {
        background: #f5f5f5; padding: 5px 12px; border-radius: 30px;
        font-size: 12px; font-weight: 600; display: inline-block;
        margin-right: 6px; margin-bottom: 6px; color: #444;
    }
    .activity-meta .meta-tag i { margin-right: 4px; opacity: .65; }

    /* ── Activity files list ── */
    .activity-files { margin-top: 14px; border-top: 1px solid #eee; padding-top: 12px; }
    .activity-files .file-link {
        display: flex; align-items: center; gap: 8px;
        padding: 7px 10px; border-radius: 8px;
        background: #f8f8f8; border: 1px solid #eee;
        margin-bottom: 6px; text-decoration: none;
        color: #333; font-size: 13px; font-weight: 500;
        transition: background .2s;
    }
    .activity-files .file-link:hover { background: #f0ecfb; color: #6d4bc3; }
    .activity-files .file-link i { font-size: 15px; flex-shrink: 0; }

    /* ── Accent colours ── */
    .accent-0 { border-top: 5px solid #6d4bc3; }
    .accent-1 { border-top: 5px solid #f0b74d; }
    .accent-2 { border-top: 5px solid #ff6b6b; }
    .accent-3 { border-top: 5px solid #4db6ac; }
    .accent-4 { border-top: 5px solid #8bc34a; }
    .accent-5 { border-top: 5px solid #ff9800; }

    /* ── Lesson row ── */
    .lesson-row {
        display: flex; align-items: center; gap: 14px;
        padding: 13px 16px; border-radius: 12px;
        background: #fafafa; border: 1px solid #eee;
        margin-bottom: 8px; transition: background .2s;
    }
    .lesson-row:hover { background: #f0ecfb; }
    .lesson-icon {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; flex-shrink: 0;
    }
    .lesson-icon.icon-video  { background: #ede7f6; color: #6d4bc3; }
    .lesson-icon.icon-doc    { background: #e3f2fd; color: #1976d2; }
    .lesson-icon.icon-quiz   { background: #fff3e0; color: #f57c00; }
    .lesson-icon.icon-other  { background: #f1f8e9; color: #558b2f; }
    .lesson-title  { font-size: 14px; font-weight: 600; color: #333; margin: 0; flex: 1; }
    .lesson-type-badge {
        font-size: 11px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; padding: 3px 10px; border-radius: 20px;
        background: #ede7f6; color: #6d4bc3; flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .phonics-hero { padding: 30px 20px; }
        .phonics-hero h1 { font-size: 26px; }
        .grade-tab-pane { padding: 20px 16px; }
    }
</style>

<section class="wsus__course_video py-4">
    <div class="container">

        {{-- Back button --}}
        <div class="mb-4">
            <a href="{{ route('student.enrolled-courses') }}" class="btn btn-outline-primary">
                <i class="fas fa-angle-left me-2"></i>{{ __('Go back to enrolled courses') }}
            </a>
        </div>

        {{-- Course hero --}}
        <div class="mb-4">
            <div class="phonics-hero">
                <small style="letter-spacing:2px;text-transform:uppercase;font-size:12px;font-weight:600;opacity:.8;">
                    {{ __('Course') }}
                </small>
                <h1>{{ $course->title }}</h1>
                @if($course->description)
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 250) }}</p>
                @endif
            </div>
        </div>

        {{-- Grades as tabs --}}
        @if($grades->isNotEmpty())
            <div class="grade-tabs-wrapper">

                {{-- Grade tab buttons --}}
                <div class="grade-tab-nav" role="tablist">
                    @foreach($grades->values() as $gi => $grade)
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
                @foreach($grades->values() as $gi => $grade)
                    <div
                        id="grade-pane-{{ $grade->id }}"
                        class="grade-tab-pane {{ $gi === 0 ? 'active' : '' }}"
                        role="tabpanel"
                    >
                        @if($grade->description)
                            <p class="text-muted mb-4" style="font-size:15px;">{{ $grade->description }}</p>
                        @endif

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
                                    <div class="row g-4 mb-4">
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
                                                                    <span class="meta-tag"><i class="fas fa-box-open"></i>{{ \Illuminate\Support\Str::limit($lesson->material_required, 40) }}</span>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        {{-- Activity files --}}
                                                        @if($lesson && $lesson->activityFiles->isNotEmpty())
                                                            <div class="activity-files">
                                                                @foreach($lesson->activityFiles as $file)
                                                                    @php
                                                                        $ext = strtolower($file->file_type ?? pathinfo($file->file_path, PATHINFO_EXTENSION));
                                                                        $fileIcon = match($ext) {
                                                                            'pdf'  => 'fas fa-file-pdf text-danger',
                                                                            'doc','docx' => 'fas fa-file-word text-primary',
                                                                            'txt'  => 'fas fa-file-alt text-secondary',
                                                                            'zip'  => 'fas fa-file-archive text-warning',
                                                                            'png','jpg','jpeg','gif','webp' => 'fas fa-file-image text-success',
                                                                            default => 'fas fa-file text-muted',
                                                                        };
                                                                        // Build correct URL — file_path may be relative or absolute
                                                                        $fileUrl = str_starts_with($file->file_path, 'http')
                                                                            ? $file->file_path
                                                                            : asset($file->file_path);
                                                                    @endphp
                                                                    <a href="{{ $fileUrl }}" target="_blank" class="file-link">
                                                                        <i class="{{ $fileIcon }}"></i>
                                                                        {{ $file->file_name ?? basename($file->file_path) }}
                                                                    </a>
                                                                @endforeach
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
            {{-- Fallback: no grades — show chapters directly --}}
            @if($course->chapters->isNotEmpty())
                <div class="grade-tabs-wrapper">
                    <div class="grade-tab-nav" role="tablist">
                        @foreach($course->chapters as $ci => $chapter)
                            <button class="grade-tab-btn {{ $ci === 0 ? 'active' : '' }}"
                                role="tab" data-pane="chapter-pane-{{ $chapter->id }}">
                                <span class="grade-num">{{ $ci + 1 }}</span>
                                {{ $chapter->title }}
                            </button>
                        @endforeach
                    </div>

                    @foreach($course->chapters as $ci => $chapter)
                        @php
                            $activityItems = $chapter->chapterItems->where('type', 'activity');
                            $otherItems    = $chapter->chapterItems->where('type', '!=', 'activity');
                        @endphp
                        <div id="chapter-pane-{{ $chapter->id }}"
                            class="grade-tab-pane {{ $ci === 0 ? 'active' : '' }}" role="tabpanel">

                            @if($chapter->description)
                                <p class="chapter-desc">{{ $chapter->description }}</p>
                            @endif

                            @if($activityItems->count())
                                <div class="row g-4 mb-4">
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
                                                                <span class="meta-tag"><i class="fas fa-child"></i>{{ __('Age') }}
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
                                                                <span class="meta-tag"><i class="fas fa-box-open"></i>{{ \Illuminate\Support\Str::limit($lesson->material_required, 40) }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @if($lesson && $lesson->activityFiles->isNotEmpty())
                                                        <div class="activity-files">
                                                            @foreach($lesson->activityFiles as $file)
                                                                @php
                                                                    $ext = strtolower($file->file_type ?? pathinfo($file->file_path, PATHINFO_EXTENSION));
                                                                    $fileIcon = match($ext) {
                                                                        'pdf' => 'fas fa-file-pdf text-danger',
                                                                        'doc','docx' => 'fas fa-file-word text-primary',
                                                                        'txt' => 'fas fa-file-alt text-secondary',
                                                                        'zip' => 'fas fa-file-archive text-warning',
                                                                        'png','jpg','jpeg','gif','webp' => 'fas fa-file-image text-success',
                                                                        default => 'fas fa-file text-muted',
                                                                    };
                                                                    $fileUrl = str_starts_with($file->file_path, 'http') ? $file->file_path : asset($file->file_path);
                                                                @endphp
                                                                <a href="{{ $fileUrl }}" target="_blank" class="file-link">
                                                                    <i class="{{ $fileIcon }}"></i>
                                                                    {{ $file->file_name ?? basename($file->file_path) }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

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
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted">{{ __('No content available for this course yet.') }}</p>
                </div>
            @endif
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    var preloader_path = "{{ asset(Cache::get('setting')->preloader) }}";
</script>
<script src="{{ asset('frontend/js/default/learning-player.js') }}?v={{$setting?->version}}"></script>
<script src="{{ asset('frontend/js/default/quiz-page.js') }}?v={{$setting?->version}}"></script>
<script src="{{ asset('frontend/js/default/qna.js') }}?v={{$setting?->version}}"></script>
<script src="{{ asset('frontend/js/pdf.min.js') }}"></script>
<script src="{{ asset('frontend/js/jszip.min.js') }}"></script>
<script src="{{ asset('frontend/js/docx-preview.min.js') }}"></script>
<script src="{{ asset('frontend/js/custom-tinymce.js') }}"></script>

<script>
(function () {
    document.querySelectorAll('.grade-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var nav = btn.closest('.grade-tab-nav');
            nav.querySelectorAll('.grade-tab-btn').forEach(function (b) {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.closest('.grade-tabs-wrapper').querySelectorAll('.grade-tab-pane').forEach(function (p) {
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
@endpush
