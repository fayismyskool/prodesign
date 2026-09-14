@extends('frontend.pages.learning-player.master')

@section('meta_title', $course->title . ' || ' . $setting->app_name)

@section('contents')

{{-- ───────────── MULTIMEDIA PLAYER MODAL ───────────── --}}
<div class="modal fade" id="mediaPlayerModal" tabindex="-1" aria-labelledby="mediaPlayerModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 60px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border: none; padding: 20px 28px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div>
                        <span class="badge bg-white text-dark mb-1" id="modalTopicBadge" style="font-size: 11px; font-weight: 700; text-transform: uppercase;">{{ __('Topic') }}</span>
                        <h5 class="modal-title text-white fw-bold mb-0" id="mediaPlayerModalLabel">{{ __('Activity Learning Hub') }}</h5>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                {{-- Modal Navigation Tabs --}}
                <ul class="nav nav-pills nav-fill bg-light p-2 border-bottom" id="mediaPlayerTab" role="tablist" style="gap: 8px;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold py-2" id="modal-video-tab" data-bs-toggle="tab" data-bs-target="#modal-video-pane" type="button" role="tab">
                            <i class="fas fa-video me-1 text-danger"></i> {{ __('Video Demo') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold py-2" id="modal-audio-tab" data-bs-toggle="tab" data-bs-target="#modal-audio-pane" type="button" role="tab">
                            <i class="fas fa-headphones me-1 text-primary"></i> {{ __('Audio Guide') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold py-2" id="modal-pdf-tab" data-bs-toggle="tab" data-bs-target="#modal-pdf-pane" type="button" role="tab">
                            <i class="fas fa-file-pdf me-1 text-danger"></i> {{ __('Activity Worksheet (PDF)') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold py-2" id="modal-procedure-tab" data-bs-toggle="tab" data-bs-target="#modal-procedure-pane" type="button" role="tab">
                            <i class="fas fa-tasks me-1 text-success"></i> {{ __('Procedure & Materials') }}
                        </button>
                    </li>
                </ul>

                <div class="tab-content p-4" id="mediaPlayerTabContent">
                    {{-- Tab 1: Video Player --}}
                    <div class="tab-pane fade show active" id="modal-video-pane" role="tabpanel">
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden bg-dark shadow-sm" style="max-height: 500px;">
                            <iframe id="modalVideoIframe" src="" title="Video Demonstration" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle me-1 text-primary"></i> {{ __('Interactive video demonstration and pedagogical walkthrough.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Tab 2: Audio Player --}}
                    <div class="tab-pane fade" id="modal-audio-pane" role="tabpanel">
                        <div class="card border-0 bg-light p-4 rounded-4 text-center">
                            <div class="mb-3">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #6366f1); color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 10px 25px rgba(99, 102, 241, 0.35);">
                                    <i class="fas fa-podcast"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold mb-1" id="modalAudioTitle">{{ __('Activity Audio Narration') }}</h5>
                            <p class="text-muted small mb-4">{{ __('Listen to step-by-step spoken instructions, key concepts, and safety guidelines.') }}</p>
                            
                            <div class="d-flex justify-content-center mb-3">
                                <audio id="modalAudioElement" controls style="width: 100%; max-width: 600px; height: 48px; border-radius: 30px;">
                                    <source id="modalAudioSource" src="" type="audio/wav">
                                    {{ __('Your browser does not support audio playback.') }}
                                </audio>
                            </div>
                        </div>
                    </div>

                    {{-- Tab 3: PDF Worksheet Viewer --}}
                    <div class="tab-pane fade" id="modal-pdf-pane" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-secondary">
                                <i class="fas fa-file-alt text-danger me-1"></i> {{ __('Modular Activity Worksheet') }}
                            </h6>
                            <a href="#" id="modalPdfDownloadBtn" target="_blank" class="btn btn-sm btn-primary px-3">
                                <i class="fas fa-download me-1"></i> {{ __('Download PDF Worksheet') }}
                            </a>
                        </div>
                        <div class="border rounded-4 overflow-hidden" style="height: 520px; background: #525659;">
                            <iframe id="modalPdfIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                        </div>
                    </div>

                    {{-- Tab 4: Step-by-Step Procedure & Materials --}}
                    <div class="tab-pane fade" id="modal-procedure-pane" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-5">
                                <div class="card h-100 border-0 bg-light rounded-4 p-3">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-box-open me-2"></i> {{ __('Materials Required') }}
                                    </h6>
                                    <p id="modalMaterialText" style="font-size: 14px; line-height: 1.8; color: #333; white-space: pre-wrap; margin: 0;"></p>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card h-100 border-0 bg-light rounded-4 p-3">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="fas fa-clipboard-list me-2"></i> {{ __('Activity Procedure & Objectives') }}
                                    </h6>
                                    <p id="modalProcedureText" style="font-size: 14px; line-height: 1.8; color: #333; margin: 0;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light border-0 px-4 py-3">
                <button type="button" class="btn btn-secondary btn-sm px-4 rounded-3" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- ───────────── MATERIAL QUICK MODAL ───────────── --}}
<div class="modal fade" id="materialModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;overflow:hidden; border:none; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background:linear-gradient(135deg,#6d4bc3,#7d5ce0);border:none; color: white;">
                <h6 class="modal-title text-white fw-bold">
                    <i class="fas fa-box-open me-2"></i>
                    {{ __('Materials Required') }}
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p id="materialModalText" style="font-size:15px;line-height:1.8;color:#333;white-space:pre-wrap;margin:0;"></p>
            </div>
        </div>
    </div>
</div>

<style>
    /* ───────────────── HERO HEADER ───────────────── */
    .curriculum-hero {
        background: linear-gradient(135deg, #4338ca, #6d28d9 60%, #7c3aed);
        padding: 35px 30px;
        border-radius: 16px;
        color: #ffffff !important;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.25);
    }
    .curriculum-hero::after {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .curriculum-hero h1,
    .curriculum-hero h2,
    .curriculum-hero h3 {
        color: #ffffff !important;
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 12px;
    }
    .curriculum-hero p,
    .curriculum-hero .curriculum-hero-desc {
        color: #ffffff !important;
        font-size: 15.5px;
        line-height: 1.75;
        opacity: 0.96;
        max-width: 950px;
        margin-bottom: 0;
    }

    /* ───────────────── CHAPTER TABS ───────────────── */
    .chapter-tabs-wrapper {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
    }
    .chapter-tab-nav-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    .chapter-tab-nav {
        flex: 1;
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        scroll-behavior: smooth;
        padding: 0 8px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .chapter-tab-nav::-webkit-scrollbar {
        display: none;
    }
    .chapter-tab-btn {
        flex: 0 0 auto;
        padding: 16px 22px;
        border: none;
        border-bottom: 3px solid transparent;
        background: none;
        color: #64748b;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chapter-tab-btn:hover {
        color: #4f46e5;
        background: rgba(79, 70, 229, 0.04);
    }
    .chapter-tab-btn.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
        background: #fff;
    }
    .tab-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ede9fe;
        color: #6d28d9;
        font-size: 12px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .chapter-tab-btn.active .tab-num {
        background: #4f46e5;
        color: #fff;
    }

    .tab-scroll-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        background: #fff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        cursor: pointer;
        transition: all .2s ease;
        flex-shrink: 0;
        z-index: 2;
        margin: 0 8px;
    }
    .tab-scroll-btn:hover {
        background: #4f46e5;
        color: #fff;
    }

    /* ───────────────── PART FILTER BAR ───────────────── */
    .part-filter-wrapper {
        background: linear-gradient(135deg, #1e1b4b, #312e81);
        padding: 16px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .part-filter-pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .part-filter-pill {
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.08);
        color: #e0e7ff;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .part-filter-pill:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateY(-1px);
    }
    .part-filter-pill.active {
        background: #4f46e5;
        border-color: #818cf8;
        color: #fff;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
    }
    .part-tag-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 6px;
        background: rgba(79, 70, 229, 0.15);
        color: #4f46e5;
    }
    .chapter-tab-btn.active .part-tag-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }

    /* ───────────────── TAB PANES & FILTERS ───────────────── */
    .chapter-tab-pane {
        display: none;
        padding: 30px;
        background: #f8fafc;
        animation: fadeInPane .25s ease;
    }
    .chapter-tab-pane.active {
        display: block;
    }
    @keyframes fadeInPane {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Media Filter Bar */
    .media-filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin-bottom: 24px;
        padding: 12px 18px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    .filter-btn {
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .filter-btn:hover, .filter-btn.active {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }

    /* Topic Group Header */
    .topic-group-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 25px;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e2e8f0;
    }
    .topic-group-title {
        font-size: 17px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .topic-group-badge {
        background: #ede9fe;
        color: #6d28d9;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
    }

    /* ───────────────── ACTIVITY CARD ───────────────── */
    .activity-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all .3s ease;
        box-shadow: 0 4px 14px rgba(0,0,0,.05);
        border: 1px solid #edf2f7;
    }
    .activity-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.1);
        border-color: #cbd5e1;
    }
    .activity-card .card-body {
        padding: 22px;
    }
    .activity-label {
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 800;
    }
    .activity-card h3 {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 10px;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .activity-desc {
        font-size: 13.5px;
        line-height: 1.6;
        color: #475569;
        margin-bottom: 14px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta tags */
    .meta-tag {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .meta-tag-material {
        cursor: pointer;
        background: #fef3c7;
        color: #92400e;
        transition: all .2s ease;
    }
    .meta-tag-material:hover {
        background: #fde68a;
    }

    /* Multimedia Action Pills */
    .media-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-media-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 10px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        transition: all .2s ease;
        text-decoration: none !important;
        text-align: center;
    }
    .btn-media-video {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-media-video:hover {
        background: #fecaca;
        color: #b91c1c;
    }
    .btn-media-audio {
        background: #e0f2fe;
        color: #0284c7;
    }
    .btn-media-audio:hover {
        background: #bae6fd;
        color: #0369a1;
    }
    .btn-media-pdf {
        background: #f3e8ff;
        color: #7e22ce;
    }
    .btn-media-pdf:hover {
        background: #e9d5ff;
        color: #6b21a8;
    }
    .btn-media-hub {
        background: #dcfce7;
        color: #15803d;
    }
    .btn-media-hub:hover {
        background: #bbf7d0;
        color: #166534;
    }

    /* Accent borders */
    .accent-0 { border-top: 4px solid #4f46e5; }
    .accent-1 { border-top: 4px solid #06b6d4; }
    .accent-2 { border-top: 4px solid #10b981; }
    .accent-3 { border-top: 4px solid #f59e0b; }
    .accent-4 { border-top: 4px solid #ec4899; }
    .accent-5 { border-top: 4px solid #8b5cf6; }

    @media (max-width: 768px) {
        .curriculum-hero { padding: 22px 18px; }
        .curriculum-hero h1 { font-size: 22px; }
        .chapter-tab-pane { padding: 18px 14px; }
        .media-actions-grid { grid-template-columns: 1fr; }
    }
</style>

<section class="wsus__course_video py-4">
    <div class="container">
        {{-- Top Navigation / Back --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ auth()->user()?->role === 'instructor' ? route('instructor.dashboard') : (auth()->user()?->role === 'school' ? route('school.dashboard') : route('student.dashboard')) }}" class="btn btn-sm btn-outline-secondary px-3 py-1">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Dashboard') }}
            </a>
            <div class="text-muted small">
                <i class="fas fa-graduation-cap text-primary me-1"></i> {{ $course->title }}
            </div>
        </div>

        @if($course->chapters->isNotEmpty())
            <div class="chapter-tabs-wrapper">
                {{-- ───────── PART FILTER BAR (PART 1, PART 2, PART 3) ───────── --}}
                <div class="part-filter-wrapper">
                    <div class="d-flex align-items-center gap-2 text-white">
                        <i class="fas fa-layer-group text-warning fs-5"></i>
                        <div>
                            <div class="fw-bold text-white" style="font-size: 14px; line-height: 1.2;">{{ __('Curriculum Terms') }}</div>
                            <small class="text-white-50" style="font-size: 11px;">{{ __('Filter modules by curriculum parts') }}</small>
                        </div>
                    </div>
                    <div class="part-filter-pill-group">
                        <button type="button" class="part-filter-pill active" data-part="all">
                            <i class="fas fa-th-large"></i> {{ __('All Curriculum') }} ({{ $course->chapters->count() }})
                        </button>
                        <button type="button" class="part-filter-pill" data-part="1">
                            <i class="fas fa-bookmark text-info"></i> {{ __('Part 1 (Term I)') }}
                        </button>
                        <button type="button" class="part-filter-pill" data-part="2">
                            <i class="fas fa-bookmark text-warning"></i> {{ __('Part 2 (Term II)') }}
                        </button>
                        <button type="button" class="part-filter-pill" data-part="3">
                            <i class="fas fa-bookmark text-success"></i> {{ __('Part 3 (Term III)') }}
                        </button>
                    </div>
                </div>

                {{-- ───────── TAB NAVIGATION (PROJECT CHAPTERS) ───────── --}}
                <div class="chapter-tab-nav-wrapper">
                    <button type="button" class="tab-scroll-btn" id="tabScrollLeft">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="chapter-tab-nav" id="chapterTabNav" role="tablist">
                        @foreach($course->chapters as $chapterIndex => $chapter)
                            @php
                                $partNumber = (int) ceil(($chapterIndex + 1) / 2);
                            @endphp
                            <button
                                class="chapter-tab-btn {{ $chapterIndex === 0 ? 'active' : '' }}"
                                role="tab"
                                aria-selected="{{ $chapterIndex === 0 ? 'true' : 'false' }}"
                                aria-controls="chapter-pane-{{ $chapter->id }}"
                                data-pane="chapter-pane-{{ $chapter->id }}"
                                data-part="{{ $partNumber }}"
                            >
                                <span class="tab-num">{{ $chapterIndex + 1 }}</span>
                                <span class="part-tag-badge">P{{ $partNumber }}</span>
                                {{ $chapter->title }}
                            </button>
                        @endforeach
                    </div>

                    <button type="button" class="tab-scroll-btn" id="tabScrollRight">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                {{-- ───────── TAB PANES (CURRICULUM CONTENT) ───────── --}}
                @foreach($course->chapters as $chapterIndex => $chapter)
                    @php
                        $partNumber = (int) ceil(($chapterIndex + 1) / 2);
                        $activityItems = $chapter->chapterItems->where('type', 'activity');
                        $otherItems    = $chapter->chapterItems->where('type', '!=', 'activity');
                        
                        // Group activities by topic category
                        $groupedActivities = $activityItems->groupBy(function($item) {
                            return $item->lesson?->topic_category ?? 'General Project Activities';
                        });
                    @endphp

                    <div id="chapter-pane-{{ $chapter->id }}"
                         class="chapter-tab-pane {{ $chapterIndex === 0 ? 'active' : '' }}"
                         data-part="{{ $partNumber }}"
                         role="tabpanel">

                        {{-- Project Hero Banner --}}
                        <div class="curriculum-hero mb-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-warning text-dark px-3 py-1 fw-bold" style="font-size: 11px; text-transform: uppercase;">
                                            <i class="fas fa-layer-group me-1"></i> PART {{ $partNumber }}
                                        </span>
                                        <span class="badge bg-white text-dark px-3 py-1 fw-bold" style="font-size: 11px; text-transform: uppercase;">
                                            {{ __('Module') }} {{ $chapterIndex + 1 }}
                                        </span>
                                    </div>
                                    <h1 class="text-white">{{ $chapter->title }}</h1>
                                </div>
                                @php
                                    $firstLesson = $activityItems->first()?->lesson;
                                    $projectPdfFile = $firstLesson?->activityFiles?->firstWhere('file_name', 'like', '%Project Module%')?->file_path;
                                @endphp
                                @if($projectPdfFile)
                                    <a href="{{ asset($projectPdfFile) }}" target="_blank" class="btn btn-light btn-sm fw-bold px-3 py-2 shadow-sm">
                                        <i class="fas fa-book-reader text-danger me-1"></i> {{ __('Complete Project PDF') }}
                                    </a>
                                @endif
                            </div>

                            @if($chapter->description)
                                <p class="curriculum-hero-desc" style="color: #ffffff !important; opacity: 0.95;">{{ strip_tags($chapter->description) }}</p>
                            @endif
                        </div>

                        {{-- Media Filter Bar --}}
                        <div class="media-filter-bar">
                            <span class="text-muted small fw-bold me-2"><i class="fas fa-filter text-primary"></i> {{ __('Filter by Media:') }}</span>
                            <button type="button" class="filter-btn active" data-filter="all">
                                <i class="fas fa-th-large"></i> {{ __('All Resources') }} ({{ $activityItems->count() }})
                            </button>
                            <button type="button" class="filter-btn" data-filter="video">
                                <i class="fas fa-video text-danger"></i> {{ __('Video Lessons') }}
                            </button>
                            <button type="button" class="filter-btn" data-filter="audio">
                                <i class="fas fa-headphones text-primary"></i> {{ __('Audio Guides') }}
                            </button>
                            <button type="button" class="filter-btn" data-filter="pdf">
                                <i class="fas fa-file-pdf text-danger"></i> {{ __('Worksheets (PDF)') }}
                            </button>
                            <button type="button" class="filter-btn" data-filter="activity">
                                <i class="fas fa-tools text-success"></i> {{ __('Hands-on Activities') }}
                            </button>
                        </div>

                        {{-- Topic-wise Activities Section --}}
                        @if($groupedActivities->count())
                            @foreach($groupedActivities as $topicName => $itemsInTopic)
                                <div class="topic-group-section mb-4">
                                    <div class="topic-group-header">
                                        <h4 class="topic-group-title">
                                            <i class="fas fa-layer-group text-primary"></i>
                                            {{ $topicName }}
                                        </h4>
                                        <span class="topic-group-badge">
                                            {{ $itemsInTopic->count() }} {{ __('Activities & Resources') }}
                                        </span>
                                    </div>

                                    <div class="row g-3">
                                        @foreach($itemsInTopic as $itemIndex => $item)
                                            @php
                                                $lesson = $item->lesson;
                                                $actPdf = $lesson?->file_path ? asset($lesson->file_path) : '#';
                                                $actAudio = $lesson?->audio_path ? asset($lesson->audio_path) : '';
                                                $actVideo = $lesson?->video_url ?? 'https://www.youtube.com/embed/gW9b2K2iP0Y';
                                                $accentIndex = ($itemIndex + $chapterIndex) % 6;
                                            @endphp

                                            <div class="col-lg-4 col-md-6 activity-item-card" 
                                                 data-has-video="{{ $lesson?->video_url ? 'yes' : 'no' }}"
                                                 data-has-audio="{{ $lesson?->audio_path ? 'yes' : 'no' }}"
                                                 data-has-pdf="{{ $lesson?->file_path ? 'yes' : 'no' }}"
                                                 data-has-activity="yes">

                                                <div class="activity-card accent-{{ $accentIndex }}">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                                            <span class="activity-label">
                                                                <i class="fas fa-hashtag text-primary"></i> {{ __('Activity') }} {{ $loop->iteration }}
                                                            </span>

                                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                @if($lesson?->activity_duration)
                                                                    <span class="meta-tag">
                                                                        <i class="fas fa-clock text-warning me-1"></i> {{ $lesson->activity_duration }}
                                                                    </span>
                                                                @endif
                                                                <span class="meta-tag">
                                                                    <i class="fas fa-child text-info me-1"></i> 11–12 yrs
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <h3>{{ $lesson?->title ?? __('Activity') }}</h3>

                                                        @if($lesson?->description)
                                                            <p class="activity-desc">{{ $lesson->description }}</p>
                                                        @endif

                                                        {{-- Materials Tag --}}
                                                        @if($lesson?->material_required)
                                                            <div class="mb-3">
                                                                <span class="meta-tag meta-tag-material"
                                                                      data-bs-toggle="modal"
                                                                      data-bs-target="#materialModal"
                                                                      data-material="{{ $lesson->material_required }}">
                                                                    <i class="fas fa-box-open me-1"></i> {{ __('Materials Checklist') }}
                                                                    <i class="fas fa-info-circle ms-1" style="opacity:.6; font-size:10px;"></i>
                                                                </span>
                                                            </div>
                                                        @endif

                                                        {{-- Multimedia Action Bar --}}
                                                        <div class="media-actions-grid">
                                                            {{-- Video Demo --}}
                                                            <button type="button" class="btn-media-action btn-media-video open-media-modal-btn"
                                                                    data-tab="video"
                                                                    data-title="{{ $lesson?->title }}"
                                                                    data-topic="{{ $topicName }}"
                                                                    data-video="{{ $actVideo }}"
                                                                    data-audio="{{ $actAudio }}"
                                                                    data-pdf="{{ $actPdf }}"
                                                                    data-material="{{ $lesson?->material_required }}"
                                                                    data-procedure="{{ $lesson?->description }}">
                                                                <i class="fas fa-play-circle"></i> {{ __('Video Demo') }}
                                                            </button>

                                                            {{-- Audio Guide --}}
                                                            <button type="button" class="btn-media-action btn-media-audio open-media-modal-btn"
                                                                    data-tab="audio"
                                                                    data-title="{{ $lesson?->title }}"
                                                                    data-topic="{{ $topicName }}"
                                                                    data-video="{{ $actVideo }}"
                                                                    data-audio="{{ $actAudio }}"
                                                                    data-pdf="{{ $actPdf }}"
                                                                    data-material="{{ $lesson?->material_required }}"
                                                                    data-procedure="{{ $lesson?->description }}">
                                                                <i class="fas fa-podcast"></i> {{ __('Audio Guide') }}
                                                            </button>

                                                            {{-- Split PDF Worksheet --}}
                                                            <button type="button" class="btn-media-action btn-media-pdf open-media-modal-btn"
                                                                    data-tab="pdf"
                                                                    data-title="{{ $lesson?->title }}"
                                                                    data-topic="{{ $topicName }}"
                                                                    data-video="{{ $actVideo }}"
                                                                    data-audio="{{ $actAudio }}"
                                                                    data-pdf="{{ $actPdf }}"
                                                                    data-material="{{ $lesson?->material_required }}"
                                                                    data-procedure="{{ $lesson?->description }}">
                                                                <i class="fas fa-file-pdf"></i> {{ __('Worksheet') }}
                                                            </button>

                                                            {{-- Complete Hub --}}
                                                            <button type="button" class="btn-media-action btn-media-hub open-media-modal-btn"
                                                                    data-tab="procedure"
                                                                    data-title="{{ $lesson?->title }}"
                                                                    data-topic="{{ $topicName }}"
                                                                    data-video="{{ $actVideo }}"
                                                                    data-audio="{{ $actAudio }}"
                                                                    data-pdf="{{ $actPdf }}"
                                                                    data-material="{{ $lesson?->material_required }}"
                                                                    data-procedure="{{ $lesson?->description }}">
                                                                <i class="fas fa-tasks"></i> {{ __('Procedure') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted">{{ __('No activities available for this project yet.') }}</p>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-muted">{{ __('No chapters available for this course.') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    /* ───────── TAB SWITCHING ───────── */
    $(document).on('click', '.chapter-tab-btn', function () {
        $('.chapter-tab-btn').removeClass('active').attr('aria-selected', 'false');
        $('.chapter-tab-pane').removeClass('active');

        $(this).addClass('active').attr('aria-selected', 'true');
        const targetId = $(this).data('pane');
        const target = $('#' + targetId);
        if (target.length) {
            target.addClass('active');
        }
    });

    /* ───────── PART FILTER BUTTONS ───────── */
    $(document).on('click', '.part-filter-pill', function () {
        $('.part-filter-pill').removeClass('active');
        $(this).addClass('active');

        const part = $(this).data('part');
        const chapterBtns = $('.chapter-tab-btn');

        if (part === 'all') {
            chapterBtns.show();
        } else {
            chapterBtns.each(function () {
                if ($(this).data('part') == part) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // If active tab is now hidden, switch active to first visible tab in this part
            const activeBtn = $('.chapter-tab-btn.active');
            if (activeBtn.is(':hidden') || activeBtn.data('part') != part) {
                const firstVisible = $('.chapter-tab-btn[data-part="' + part + '"]:first');
                if (firstVisible.length) {
                    firstVisible.trigger('click');
                }
            }
        }
    });

    /* ───────── TAB SCROLL ───────── */
    const chapterTabNav = document.getElementById('chapterTabNav');
    const tabScrollLeft  = document.getElementById('tabScrollLeft');
    const tabScrollRight = document.getElementById('tabScrollRight');

    if(chapterTabNav && tabScrollLeft && tabScrollRight){
        tabScrollLeft.addEventListener('click', function () {
            chapterTabNav.scrollBy({ left: -250, behavior: 'smooth' });
        });
        tabScrollRight.addEventListener('click', function () {
            chapterTabNav.scrollBy({ left: 250, behavior: 'smooth' });
        });
    }

    /* ───────── MEDIA FILTER BUTTONS ───────── */
    $(document).on('click', '.filter-btn', function () {
        const pane = $(this).closest('.chapter-tab-pane');
        pane.find('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const filter = $(this).data('filter');
        const cards = pane.find('.activity-item-card');

        if (filter === 'all') {
            cards.fadeIn(200);
        } else if (filter === 'video') {
            cards.each(function () {
                $(this).toggle($(this).data('has-video') === 'yes');
            });
        } else if (filter === 'audio') {
            cards.each(function () {
                $(this).toggle($(this).data('has-audio') === 'yes');
            });
        } else if (filter === 'pdf') {
            cards.each(function () {
                $(this).toggle($(this).data('has-pdf') === 'yes');
            });
        } else if (filter === 'activity') {
            cards.each(function () {
                $(this).toggle($(this).data('has-activity') === 'yes');
            });
        }
    });

    /* ───────── MULTIMEDIA HUB MODAL HANDLER ───────── */
    $(document).on('click', '.open-media-modal-btn', function () {
        const title = $(this).data('title') || 'Activity Details';
        const topic = $(this).data('topic') || 'Topic';
        const video = $(this).data('video') || '';
        const audio = $(this).data('audio') || '';
        const pdf = $(this).data('pdf') || '';
        const material = $(this).data('material') || 'Standard classroom materials.';
        const procedure = $(this).data('procedure') || 'Follow teacher instructions.';
        const initialTab = $(this).data('tab') || 'video';

        $('#mediaPlayerModalLabel').text(title);
        $('#modalTopicBadge').text(topic);
        $('#modalAudioTitle').text(title);
        $('#modalMaterialText').text(material);
        $('#modalProcedureText').text(procedure);

        // Set Video
        $('#modalVideoIframe').attr('src', video);

        // Set Audio
        if (audio) {
            $('#modalAudioSource').attr('src', audio);
            const audioElem = document.getElementById('modalAudioElement');
            if (audioElem) {
                audioElem.load();
            }
        }

        // Set PDF
        if (pdf) {
            $('#modalPdfIframe').attr('src', pdf);
            $('#modalPdfDownloadBtn').attr('href', pdf);
        }

        // Activate requested tab
        if (initialTab === 'video') {
            var tabTrigger = new bootstrap.Tab(document.getElementById('modal-video-tab'));
            tabTrigger.show();
        } else if (initialTab === 'audio') {
            var tabTrigger = new bootstrap.Tab(document.getElementById('modal-audio-tab'));
            tabTrigger.show();
        } else if (initialTab === 'pdf') {
            var tabTrigger = new bootstrap.Tab(document.getElementById('modal-pdf-tab'));
            tabTrigger.show();
        } else if (initialTab === 'procedure') {
            var tabTrigger = new bootstrap.Tab(document.getElementById('modal-procedure-tab'));
            tabTrigger.show();
        }

        $('#mediaPlayerModal').modal('show');
    });

    // Stop video/audio on modal close
    $('#mediaPlayerModal').on('hidden.bs.modal', function () {
        $('#modalVideoIframe').attr('src', '');
        const audioElem = document.getElementById('modalAudioElement');
        if (audioElem) {
            audioElem.pause();
        }
    });

    /* ───────── QUICK MATERIAL MODAL ───────── */
    $(document).on('click', '.meta-tag-material', function () {
        var text = $(this).data('material') || '';
        $('#materialModalText').text(text);
        $('#materialModal').modal('show');
    });
});
</script>
@endpush