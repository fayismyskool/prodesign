@extends('frontend.pages.learning-player.master')

@section('meta_title', $course->title . ' || ' . $setting->app_name)

@section('contents')

<style>
    /* ── Hero ── */
    .phonics-hero {
        background: linear-gradient(135deg, #6d4bc3, #7d5ce0);
        border-radius: 20px;
        padding: 60px;
        color: #fff;
    }
    .phonics-hero small {
        letter-spacing: 2px;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 600;
        opacity: .85;
    }
    .phonics-hero h1 {
        font-size: 42px;
        font-weight: 700;
        margin-top: 15px;
        margin-bottom: 20px;
    }
    .phonics-hero p {
        font-size: 17px;
        line-height: 1.8;
        max-width: 900px;
        color: #fff;
        opacity: .9;
    }

    /* ── Chapter tabs ── */
    .chapter-tabs-wrapper {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07);
        overflow: hidden;
    }
    .chapter-tab-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
        border-bottom: 2px solid #f0ecfb;
        background: #faf8ff;
        padding: 0 8px;
    }
    .chapter-tab-btn {
        position: relative;
        padding: 16px 22px;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        cursor: pointer;
        transition: color .2s, border-color .2s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .chapter-tab-btn:hover {
        color: #6d4bc3;
    }
    .chapter-tab-btn.active {
        color: #6d4bc3;
        border-bottom-color: #6d4bc3;
        background: #fff;
    }
    .chapter-tab-btn .tab-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #ede7f6;
        color: #6d4bc3;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
        transition: background .2s, color .2s;
    }
    .chapter-tab-btn.active .tab-num {
        background: #6d4bc3;
        color: #fff;
    }

    /* ── Tab pane ── */
    .chapter-tab-pane {
        display: none;
        padding: 32px;
        animation: fadeInPane .25s ease;
    }
    .chapter-tab-pane.active {
        display: block;
    }
    @keyframes fadeInPane {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Pane heading ── */
    .pane-chapter-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0ecfb;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pane-chapter-title .pane-badge {
        background: #6d4bc3;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 30px;
        flex-shrink: 0;
    }

    /* ── Activity card ── */
    .activity-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: transform .3s ease, box-shadow .3s ease;
        height: 100%;
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
    }
    .activity-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,.12);
    }
    .activity-card .card-body {
        padding: 26px;
    }
    .activity-label {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #999;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .activity-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #1a1a2e;
    }
    .activity-card .activity-desc {
        font-size: 14px;
        line-height: 1.75;
        color: #555;
        margin-bottom: 0;
    }
    .activity-meta {
        border-top: 1px solid #eee;
        padding-top: 14px;
        margin-top: 16px;
    }
    .activity-meta .meta-tag {
        background: #f5f5f5;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 6px;
        color: #444;
    }
    .activity-meta .meta-tag i {
        margin-right: 4px;
        opacity: .65;
    }

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

    /* ── Accent border colours ── */
    .accent-0 { border-top: 5px solid #6d4bc3; }
    .accent-1 { border-top: 5px solid #f0b74d; }
    .accent-2 { border-top: 5px solid #ff6b6b; }
    .accent-3 { border-top: 5px solid #4db6ac; }
    .accent-4 { border-top: 5px solid #8bc34a; }
    .accent-5 { border-top: 5px solid #ff9800; }

    /* ── Lesson / document / quiz row ── */
    .lesson-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 16px;
        border-radius: 12px;
        background: #fafafa;
        border: 1px solid #eee;
        margin-bottom: 8px;
        transition: background .2s;
    }
    .lesson-row:hover { background: #f0ecfb; }
    .lesson-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .lesson-icon.icon-video  { background: #ede7f6; color: #6d4bc3; }
    .lesson-icon.icon-doc    { background: #e3f2fd; color: #1976d2; }
    .lesson-icon.icon-quiz   { background: #fff3e0; color: #f57c00; }
    .lesson-icon.icon-other  { background: #f1f8e9; color: #558b2f; }
    .lesson-title {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin: 0;
        flex: 1;
    }
    .lesson-type-badge {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 20px;
        background: #ede7f6;
        color: #6d4bc3;
        flex-shrink: 0;
    }

    /* ── Scrollable tab nav on mobile ── */
    @media (max-width: 768px) {
        .phonics-hero { padding: 35px 25px; }
        .phonics-hero h1 { font-size: 30px; }
        .chapter-tab-nav {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .chapter-tab-nav::-webkit-scrollbar { display: none; }
        .chapter-tab-btn { white-space: nowrap; }
        .chapter-tab-pane { padding: 20px 16px; }
    }
</style>

<section class="wsus__course_video py-4">
    <div class="container">

        {{-- ── Back button ── --}}
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-angle-left me-2"></i>{{ __('Go back to dashboard') }}
                </a>

                {{-- ── Chapter tabs ── --}}
                @if($course->chapters->isNotEmpty())
                <div class="row">
                    <div class="col-12">
                        <div class="chapter-tabs-wrapper">

                            {{-- Tab buttons --}}
                            <div class="chapter-tab-nav" role="tablist">
                                @foreach($course->chapters as $chapterIndex => $chapter)
                                    <button
                                        class="chapter-tab-btn {{ $chapterIndex === 0 ? 'active' : '' }}"
                                        role="tab"
                                        aria-selected="{{ $chapterIndex === 0 ? 'true' : 'false' }}"
                                        aria-controls="chapter-pane-{{ $chapter->id }}"
                                        data-pane="chapter-pane-{{ $chapter->id }}"
                                    >
                                        <span class="tab-num">{{ $chapterIndex + 1 }}</span>
                                        {{ $chapter->title }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- Tab panes --}}
                            @foreach($course->chapters as $chapterIndex => $chapter)
                                @php
                                    $activityItems = $chapter->chapterItems->where('type', 'activity');
                                    $otherItems    = $chapter->chapterItems->where('type', '!=', 'activity');
                                @endphp

                                <div
                                    id="chapter-pane-{{ $chapter->id }}"
                                    class="chapter-tab-pane {{ $chapterIndex === 0 ? 'active' : '' }}"
                                    role="tabpanel"
                                >
                                    {{-- Pane title --}}

                                    {{-- ── Hero ── --}}
                                    <div class="pane-chapter-title">
                                        <div class="col-12">
                                            <div class="phonics-hero">
                                                <!-- <small>{{ __('Course') }}</small> -->
                                                <h1>{{ $chapter->title }}</h1>
                                                @if($chapter->description)
                                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($chapter->description), 300) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Activity cards --}}
                                    @if($activityItems->count())
                                    
                                        <div class="row g-4 mb-4">
                                            @foreach($activityItems as $itemIndex => $item)
                                                
                                                @php $lesson = $item->lesson; @endphp
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="card activity-card accent-{{ $itemIndex % 6 }}">
                                                        <div class="card-body">
                                                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
                                                            <div class="activity-label">
                                                                {{ __('Activity') }} {{ $itemIndex + 1 }}
                                                            </div>
                                                                @if($lesson && ($lesson->age_min || $lesson->age_max || $lesson->activity_duration))
                                                                    <div class="activity-label">
                                                                        @if($lesson->age_min || $lesson->age_max)
                                                                            <span class="meta-tag">
                                                                                <i class="fas fa-child"></i>
                                                                                {{ __('Age') }}
                                                                                @if($lesson->age_min && $lesson->age_max)
                                                                                    {{ $lesson->age_min }}–{{ $lesson->age_max }}
                                                                                @elseif($lesson->age_min)
                                                                                    {{ $lesson->age_min }}+
                                                                                @else
                                                                                    {{ __('Up to') }} {{ $lesson->age_max }}
                                                                                @endif
                                                                            </span>
                                                                        @endif
                                                                        @if($lesson->activity_duration)
                                                                            <span class="meta-tag"><i class="fas fa-clock"></i>{{ $lesson->activity_duration }}</span>
                                                                        @endif
                                                                    </div>
                                                                @endif

                                                            </div>
                                                            

                                                            <h3>{{ $lesson?->title ?? __('Untitled Activity') }}</h3>

                                                            @if($lesson?->description)
                                                                <p class="activity-desc">{{ $lesson->description }}</p>
                                                            @endif

                                                            @if($lesson && ($lesson->material_required))
                                                                <div class="activity-meta">
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
                                                    $iconClass = match($item->type) {
                                                        'lesson'   => 'icon-video',
                                                        'document' => 'icon-doc',
                                                        'quiz'     => 'icon-quiz',
                                                        default    => 'icon-other',
                                                    };
                                                    $iconFa = match($item->type) {
                                                        'lesson'   => 'fas fa-play',
                                                        'document' => 'fas fa-file-alt',
                                                        'quiz'     => 'fas fa-question-circle',
                                                        default    => 'fas fa-circle',
                                                    };
                                                    $label = match($item->type) {
                                                        'lesson'   => __('Lesson'),
                                                        'document' => __('Document'),
                                                        'quiz'     => __('Quiz'),
                                                        default    => ucfirst($item->type),
                                                    };
                                                    $title = $item->lesson?->title ?? $item->quiz?->title ?? __('Untitled');
                                                @endphp
                                                <div class="lesson-row">
                                                    <div class="lesson-icon {{ $iconClass }}">
                                                        <i class="{{ $iconFa }}"></i>
                                                    </div>
                                                    <p class="lesson-title">{{ $title }}</p>
                                                    <span class="lesson-type-badge">{{ $label }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Empty chapter --}}
                                    @if($chapter->chapterItems->isEmpty())
                                        <p class="text-muted">{{ __('No items in this chapter yet.') }}</p>
                                    @endif

                                </div>{{-- /pane --}}
                            @endforeach

                        </div>{{-- /chapter-tabs-wrapper --}}
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">{{ __('No chapters available for this course.') }}</p>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>

        

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
    const tabs    = document.querySelectorAll('.chapter-tab-btn');
    const panes   = document.querySelectorAll('.chapter-tab-pane');

    tabs.forEach(function (btn) {
        btn.addEventListener('click', function () {
            // Deactivate all
            tabs.forEach(function (t) {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            panes.forEach(function (p) { p.classList.remove('active'); });

            // Activate clicked
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            const target = document.getElementById(btn.dataset.pane);
            if (target) target.classList.add('active');
        });
    });
})();
</script>
@endpush
