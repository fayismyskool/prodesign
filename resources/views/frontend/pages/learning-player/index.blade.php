@extends('frontend.pages.learning-player.master')

@section('meta_title', $course->title . ' || ' . $setting->app_name)

@section('contents')

{{-- ───────────── MATERIAL MODAL ───────────── --}}
<div class="modal fade" id="materialModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header"
                 style="background:linear-gradient(135deg,#6d4bc3,#7d5ce0);border:none;">

                <h6 class="modal-title text-white fw-bold">
                    <i class="fas fa-box-open me-2"></i>
                    {{ __('Materials Required') }}
                </h6>

                <!-- <button type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Close"
                        style="opacity:1;font-size:1.4rem;background:none;border:none;">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>

            <div class="modal-body p-4">
                <p id="materialModalText"
                   style="font-size:15px;line-height:1.8;color:#333;white-space:pre-wrap;margin:0;"></p>
            </div>
        </div>
    </div>
</div>

<style>

    /* ───────────────── HERO ───────────────── */

    .phonics-hero{
        background:linear-gradient(135deg,#7d5ce0,#6d4bc3);
        padding:20px;
        color:#fff;
    }

    /* .phonics-hero h1{
        font-size:42px;
        font-weight:700;
        margin-bottom:18px;
    } */

    .phonics-hero p{
        font-size:16px;
        line-height:1.8;
        color:#fff;
        opacity:.92;
        max-width:900px;
    }


    /* ───────────────── CHAPTER WRAPPER ───────────────── */

    .chapter-tabs-wrapper{
        background:#fff;
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 4px 20px rgba(0,0,0,.07);
    }


    /* ───────────────── TAB NAVIGATION ───────────────── */

    .chapter-tab-nav-wrapper{
        position:relative;
        display:flex;
        align-items:center;

        background:#faf8ff;
        border-bottom:2px solid #f0ecfb;
    }

    .chapter-tab-nav{
        flex:1;
        display:flex;
        flex-wrap:nowrap;

        overflow-x:auto;
        overflow-y:hidden;

        white-space:nowrap;
        scroll-behavior:smooth;

        padding:0 4px;

        scrollbar-width:none;
        -ms-overflow-style:none;
    }

    .chapter-tab-nav::-webkit-scrollbar{
        display:none;
    }

    .chapter-tab-btn{
        flex:0 0 auto;

        position:relative;
        padding:16px 22px;

        border:none;
        border-bottom:3px solid transparent;

        background:none;
        color:#666;

        font-size:14px;
        font-weight:600;

        cursor:pointer;
        transition:all .2s ease;

        display:flex;
        align-items:center;
        gap:8px;
    }

    .chapter-tab-btn:hover{
        color:#6d4bc3;
    }

    .chapter-tab-btn.active{
        color:#6d4bc3;
        border-bottom-color:#6d4bc3;
        background:#fff;
    }

    .tab-num{
        width:24px;
        height:24px;

        border-radius:50%;

        display:flex;
        align-items:center;
        justify-content:center;

        background:#ede7f6;
        color:#6d4bc3;

        font-size:11px;
        font-weight:700;

        flex-shrink:0;
    }

    .chapter-tab-btn.active .tab-num{
        background:#6d4bc3;
        color:#fff;
    }


    /* ───────────────── SCROLL BUTTONS ───────────────── */

    .tab-scroll-btn{
        width:40px;
        height:40px;

        border:none;
        border-radius:50%;

        background:#fff;
        color:#6d4bc3;

        display:flex;
        align-items:center;
        justify-content:center;

        box-shadow:0 2px 10px rgba(0,0,0,.08);

        cursor:pointer;
        transition:all .2s ease;

        flex-shrink:0;
        z-index:2;

        margin:0 6px;
    }

    .tab-scroll-btn:hover{
        background:#6d4bc3;
        color:#fff;
    }


    /* ───────────────── TAB PANES ───────────────── */

    .chapter-tab-pane{
        display:none;
        padding:32px;
        animation:fadeInPane .25s ease;
        background: #f4f4f4;
    }

    .chapter-tab-pane.active{
        display:block;
    }

    @keyframes fadeInPane{
        from{
            opacity:0;
            transform:translateY(6px);
        }
        to{
            opacity:1;
            transform:translateY(0);
        }
    }


    /* ───────────────── ACTIVITY CARD ───────────────── */

    .activity-card{
        border:none;
        border-radius:16px;
        overflow:hidden;

        height:100%;

        transition:all .3s ease;
        box-shadow:0 4px 16px rgba(0,0,0,.06);
    }

    .activity-card:hover{
        transform:translateY(-5px);
        box-shadow:0 12px 30px rgba(0,0,0,.12);
    }

    .activity-card .card-body{
        padding:26px;
    }

    .activity-label{
        font-size:11px;
        letter-spacing:2px;
        text-transform:uppercase;
        color:#999;
        font-weight:700;
    }

    .activity-card h3{
        font-size:20px;
        font-weight:700;
        margin:12px 0 10px;
        color:#1a1a2e;
    }

    .activity-desc{
        font-size:14px;
        line-height:1.75;
        color:#555;
    }


    /* ───────────────── META TAGS ───────────────── */

    .meta-tag{
        display:inline-flex;
        align-items:center;
        gap:5px;

        background:#f5f5f5;

        padding:6px 12px;
        border-radius:30px;

        font-size:12px;
        font-weight:600;
        color:#444;
    }

    .activity-meta{
        border-top:1px solid #eee;
        padding-top:14px;
        margin-top:16px;
    }

    .meta-tag-material{
        cursor:pointer;
        border:1px solid #e0d8f5;
        transition:all .2s ease;
    }

    .meta-tag-material:hover{
        background:#ede7f6 !important;
        color:#6d4bc3 !important;
    }


    /* ───────────────── FILES ───────────────── */

    .activity-files{
        margin-top:14px;
        border-top:1px solid #eee;
        padding-top:12px;
    }

    .file-link{
        display:flex;
        align-items:center;
        gap:8px;

        padding:8px 10px;
        border-radius:8px;

        background:#f8f8f8;
        border:1px solid #eee;

        margin-bottom:6px;

        text-decoration:none;
        color:#333;

        font-size:13px;
        font-weight:500;

        transition:all .2s ease;
    }

    .file-link:hover{
        background:#f0ecfb;
        color:#6d4bc3;
    }


    /* ───────────────── ACCENTS ───────────────── */

    .accent-0{ border-top:5px solid #6d4bc3; }
    .accent-1{ border-top:5px solid #f0b74d; }
    .accent-2{ border-top:5px solid #ff6b6b; }
    .accent-3{ border-top:5px solid #4db6ac; }
    .accent-4{ border-top:5px solid #8bc34a; }
    .accent-5{ border-top:5px solid #ff9800; }


    /* ───────────────── LESSON ROWS ───────────────── */

    .lesson-row{
        display:flex;
        align-items:center;
        gap:14px;

        padding:13px 16px;

        border-radius:12px;
        border:1px solid #eee;

        background:#fafafa;

        margin-bottom:8px;

        transition:all .2s ease;
    }

    .lesson-row:hover{
        background:#f0ecfb;
    }

    .lesson-icon{
        width:38px;
        height:38px;

        border-radius:10px;

        display:flex;
        align-items:center;
        justify-content:center;

        flex-shrink:0;
    }

    .icon-video{
        background:#ede7f6;
        color:#6d4bc3;
    }

    .icon-doc{
        background:#e3f2fd;
        color:#1976d2;
    }

    .icon-quiz{
        background:#fff3e0;
        color:#f57c00;
    }

    .icon-other{
        background:#f1f8e9;
        color:#558b2f;
    }

    .lesson-title{
        flex:1;
        margin:0;

        font-size:14px;
        font-weight:600;
        color:#333;
    }

    .lesson-type-badge{
        padding:3px 10px;
        border-radius:20px;

        background:#ede7f6;
        color:#6d4bc3;

        font-size:11px;
        font-weight:700;
        letter-spacing:1px;
        text-transform:uppercase;
    }


    /* ───────────────── MOBILE ───────────────── */

    @media (max-width:768px){

        .phonics-hero{
            padding:35px 25px;
        }

        .phonics-hero h1{
            font-size:30px;
        }

        .chapter-tab-pane{
            padding:20px 16px;
            background: #f4f4f4;
        }

        .tab-scroll-btn{
            width:34px;
            height:34px;
            margin:0 4px;
        }
    }

</style>

<section class="wsus__course_video py-4">
    <div class="container">

        {{-- BACK --}}
        <div class="row mb-4">
            <div class="col-12">

                <a href="{{ route('student.dashboard') }}"
                   class="link mb-4">
                    <i class="fas fa-angle-left me-2"></i>
                    {{ __('Go back to dashboard') }}
                </a>

                @if($course->chapters->isNotEmpty())

                    <div class="chapter-tabs-wrapper">

                        {{-- ───────── TAB NAVIGATION ───────── --}}
                        <div class="chapter-tab-nav-wrapper">

                            <button type="button"
                                    class="tab-scroll-btn"
                                    id="tabScrollLeft">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div class="chapter-tab-nav"
                                 id="chapterTabNav"
                                 role="tablist">

                                @foreach($course->chapters as $chapterIndex => $chapter)

                                    <button
                                        class="chapter-tab-btn {{ $chapterIndex === 0 ? 'active' : '' }}"
                                        role="tab"
                                        aria-selected="{{ $chapterIndex === 0 ? 'true' : 'false' }}"
                                        aria-controls="chapter-pane-{{ $chapter->id }}"
                                        data-pane="chapter-pane-{{ $chapter->id }}"
                                    >
                                        <span class="tab-num">
                                            {{ $chapterIndex + 1 }}
                                        </span>

                                        {{ $chapter->title }}
                                    </button>

                                @endforeach

                            </div>

                            <button type="button"
                                    class="tab-scroll-btn"
                                    id="tabScrollRight">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                        </div>


                        {{-- ───────── TAB PANES ───────── --}}
                        @foreach($course->chapters as $chapterIndex => $chapter)

                            @php
                                $activityItems = $chapter->chapterItems->where('type', 'activity');
                                $otherItems    = $chapter->chapterItems->where('type', '!=', 'activity');
                            @endphp

                            <div id="chapter-pane-{{ $chapter->id }}"
                                 class="chapter-tab-pane {{ $chapterIndex === 0 ? 'active' : '' }}"
                                 role="tabpanel">

                                {{-- HERO --}}
                                <div class="phonics-hero mb-4">

                                    <h1 class="text-white">{{ $chapter->title }}</h1>

                                    @if($chapter->description)
                                        <p>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($chapter->description), 300) }}
                                        </p>
                                    @endif
                                </div>


                                {{-- ACTIVITIES --}}
                                @if($activityItems->count())

                                    <div class="row g-4 mb-4">

                                        @foreach($activityItems as $itemIndex => $item)

                                            @php
                                                $lesson = $item->lesson;
                                            @endphp

                                            <div class="col-lg-4 col-md-6">

                                                <div class="card activity-card accent-{{ $itemIndex % 6 }}">

                                                    <div class="card-body">

                                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                                                            <div class="activity-label">
                                                                {{ __('Activity') }} {{ $itemIndex + 1 }}
                                                            </div>

                                                            @if($lesson && ($lesson->age_min || $lesson->age_max || $lesson->activity_duration))

                                                                <div class="d-flex align-items-center gap-3 flex-wrap">

                                                                    @if($lesson->age_min || $lesson->age_max)

                                                                        <span class="meta-tag">
                                                                            <i class="fas fa-child me-1"></i>

                                                                            {{ __('Age') }}

                                                                            @if($lesson->age_min && $lesson->age_max)
                                                                                {{ $lesson->age_min }}–{{ $lesson->age_max }}
                                                                            @elseif($lesson->age_min)
                                                                                {{ $lesson->age_min }}+
                                                                            @else
                                                                                {{ __('Up to') }} {{ $lesson->age_max }}
                                                                            @endif

                                                                            {{ __('yrs') }}
                                                                        </span>

                                                                    @endif

                                                                    @if($lesson->activity_duration)

                                                                        <span class="meta-tag">
                                                                            <i class="fas fa-clock me-1"></i>
                                                                            {{ $lesson->activity_duration }}
                                                                        </span>

                                                                    @endif

                                                                </div>

                                                            @endif
                                                        </div>

                                                        <h3>
                                                            {{ $lesson?->title ?? __('Untitled Activity') }}
                                                        </h3>

                                                        @if($lesson?->description)
                                                            <p class="activity-desc">
                                                                {{ $lesson->description }}
                                                            </p>
                                                        @endif


                                                        {{-- MATERIAL --}}
                                                        @if($lesson && $lesson->material_required)

                                                            <div class="activity-meta">

                                                                <span class="meta-tag meta-tag-material"
                                                                      data-toggle="modal"
                                                                      data-target="#materialModal"
                                                                      data-material="{{ $lesson->material_required }}">

                                                                    <i class="fas fa-box-open"></i>

                                                                    {{ __('Materials Required') }}

                                                                    <i class="fas fa-info-circle ms-1"
                                                                       style="opacity:.5;font-size:10px;"></i>

                                                                </span>

                                                            </div>

                                                        @endif


                                                        {{-- FILES --}}
                                                        @if($lesson && $lesson->activityFiles->isNotEmpty())

                                                            <div class="activity-files">

                                                                @foreach($lesson->activityFiles as $file)

                                                                    @php

                                                                        $ext = strtolower($file->file_type ?? pathinfo($file->file_path, PATHINFO_EXTENSION));

                                                                        $fileIcon = match($ext) {
                                                                            'pdf' => 'fas fa-file-pdf text-danger',
                                                                            'doc', 'docx' => 'fas fa-file-word text-primary',
                                                                            'txt' => 'fas fa-file-alt text-secondary',
                                                                            'zip' => 'fas fa-file-archive text-warning',
                                                                            'png', 'jpg', 'jpeg', 'gif', 'webp' => 'fas fa-file-image text-success',
                                                                            default => 'fas fa-file text-muted',
                                                                        };

                                                                        $fileUrl = str_starts_with($file->file_path, 'http')
                                                                            ? $file->file_path
                                                                            : asset($file->file_path);

                                                                    @endphp

                                                                    <a href="{{ $fileUrl }}"
                                                                       target="_blank"
                                                                       class="file-link">

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


                                {{-- OTHER ITEMS --}}
                                @if($otherItems->count())

                                    <div class="mb-2">

                                        @foreach($otherItems as $item)

                                            @php

                                                $iconClass = match($item->type) {
                                                    'lesson' => 'icon-video',
                                                    'document' => 'icon-doc',
                                                    'quiz' => 'icon-quiz',
                                                    default => 'icon-other',
                                                };

                                                $iconFa = match($item->type) {
                                                    'lesson' => 'fas fa-play',
                                                    'document' => 'fas fa-file-alt',
                                                    'quiz' => 'fas fa-question-circle',
                                                    default => 'fas fa-circle',
                                                };

                                                $label = match($item->type) {
                                                    'lesson' => __('Lesson'),
                                                    'document' => __('Document'),
                                                    'quiz' => __('Quiz'),
                                                    default => ucfirst($item->type),
                                                };

                                                $title = $item->lesson?->title
                                                        ?? $item->quiz?->title
                                                        ?? __('Untitled');

                                            @endphp

                                            <div class="lesson-row">

                                                <div class="lesson-icon {{ $iconClass }}">
                                                    <i class="{{ $iconFa }}"></i>
                                                </div>

                                                <p class="lesson-title">
                                                    {{ $title }}
                                                </p>

                                                <span class="lesson-type-badge">
                                                    {{ $label }}
                                                </span>

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-5">
                        <p class="text-muted">
                            {{ __('No chapters available for this course.') }}
                        </p>
                    </div>

                @endif

            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script>
(function () {

    /* ───────── TAB SWITCHING ───────── */

    const tabs  = document.querySelectorAll('.chapter-tab-btn');
    const panes = document.querySelectorAll('.chapter-tab-pane');

    tabs.forEach(function (btn) {

        btn.addEventListener('click', function () {

            tabs.forEach(function (t) {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });

            panes.forEach(function (p) {
                p.classList.remove('active');
            });

            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');

            const target = document.getElementById(btn.dataset.pane);

            if(target){
                target.classList.add('active');
            }
        });

    });


    /* ───────── TAB SCROLL ───────── */

    const chapterTabNav = document.getElementById('chapterTabNav');

    const tabScrollLeft  = document.getElementById('tabScrollLeft');
    const tabScrollRight = document.getElementById('tabScrollRight');

    if(chapterTabNav){

        tabScrollLeft.addEventListener('click', function () {

            chapterTabNav.scrollBy({
                left: -250,
                behavior: 'smooth'
            });

        });

        tabScrollRight.addEventListener('click', function () {

            chapterTabNav.scrollBy({
                left: 250,
                behavior: 'smooth'
            });

        });

    }

})();


/* ───────── MATERIAL MODAL ───────── */

$(document).on('click', '.meta-tag-material', function () {

    var text = $(this).data('material') || '';

    $('#materialModalText').text(text);

    $('#materialModal').modal('show');

});
</script>

@endpush