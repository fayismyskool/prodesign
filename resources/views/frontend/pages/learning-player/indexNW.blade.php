@extends('frontend.pages.learning-player.master')

@section('meta_title', $course->title . ' || ' . $setting->app_name)

@section('contents')

<style>
    .phonics-hero{
        background: linear-gradient(135deg,#6d4bc3,#7d5ce0);
        border-radius: 20px;
        padding: 60px;
        color: #fff;
    }

    .phonics-hero small{
        letter-spacing: 2px;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 600;
    }

    .phonics-hero h1{
        font-size: 48px;
        font-weight: 700;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .phonics-hero p{
        font-size: 17px;
        line-height: 1.8;
        max-width: 900px;
        color:#ffffff;
    }

    .activity-card{
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: 0.3s ease;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }

    .activity-card:hover{
        transform: translateY(-5px);
    }

    .activity-card .card-body{
        padding: 30px;
    }

    .activity-label{
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #777;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .activity-card h3{
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .activity-card p{
        font-size: 15px;
        line-height: 1.8;
        color: #555;
    }

    .activity-meta{
        border-top: 1px solid #eee;
        padding-top: 18px;
        margin-top: 20px;
    }

    .activity-meta span{
        background: #f5f5f5;
        padding: 8px 15px;
        border-radius: 30px;
        font-size: 13px;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .border-purple{
        border-top: 6px solid #6d4bc3;
    }

    .border-warning{
        border-top: 6px solid #f0b74d;
    }

    .border-danger{
        border-top: 6px solid #ff6b6b;
    }

    .border-success{
        border-top: 6px solid #4db6ac;
    }

    .border-info{
        border-top: 6px solid #8bc34a;
    }

    .border-orange{
        border-top: 6px solid #ff9800;
    }

    @media(max-width:768px){

        .phonics-hero{
            padding: 35px 25px;
        }

        .phonics-hero h1{
            font-size: 34px;
        }

        .phonics-hero p{
            font-size: 15px;
            color:#ffffff;
        }
    }
</style>

<section class="wsus__course_video py-4">

    <div class="container">

        <!-- Back Button -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="wsus__course_header">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('Go back to dashboard') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Hero -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="phonics-hero">

                    <h1>Phonics & Language</h1>

                    <p>
                        These 15 activities build the most critical foundation in early education —
                        a child’s relationship with language. From learning individual sounds to
                        constructing full sentences, every activity transforms abstract language
                        concepts into concrete, joyful experiences.
                    </p>

                </div>
            </div>
        </div>

        <!-- Activity Cards -->
        <div class="row g-4">

            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card border-purple">

                    <div class="card-body">

                        <div class="activity-label">
                            Activity 1
                        </div>

                        <h3>Snake Sound Parade</h3>

                        <p>
                            Children slither like snakes while repeating the /s/ sound.
                            Each time they reach a picture card, they call out the sound
                            and the word.
                        </p>

                        <div class="activity-meta">

                            <span>Age 3–5</span>

                            <span>10 min</span>

                            <span>No materials</span>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card border-warning">

                    <div class="card-body">

                        <div class="activity-label">
                            Activity 2
                        </div>

                        <h3>Alphabet Treasure Hunt</h3>

                        <p>
                            Hide objects around the room. Children search and identify
                            words beginning with the target sound.
                        </p>

                        <div class="activity-meta">

                            <span>Age 3–6</span>

                            <span>15 min</span>

                            <span>Household objects</span>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card border-danger">

                    <div class="card-body">

                        <div class="activity-label">
                            Activity 3
                        </div>

                        <h3>Sound Basket Sorting</h3>

                        <p>
                            Children sort objects into baskets based on the beginning
                            sound. Great for group participation.
                        </p>

                        <div class="activity-meta">

                            <span>Age 3–6</span>

                            <span>15 min</span>

                            <span>Baskets + objects</span>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card border-success">

                    <div class="card-body">

                        <div class="activity-label">
                            Activity 4
                        </div>

                        <h3>Rhyme Finish Game</h3>

                        <p>
                            Teacher starts a rhyme and children creatively complete
                            the sentence with matching sounds.
                        </p>

                        <div class="activity-meta">

                            <span>Age 4–6</span>

                            <span>10 min</span>

                            <span>Verbal activity</span>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card border-info">

                    <div class="card-body">

                        <div class="activity-label">
                            Activity 5
                        </div>

                        <h3>Sand Tray Letter Tracing</h3>

                        <p>
                            Children trace letters in sand while repeating sounds
                            aloud for sensory-based learning.
                        </p>

                        <div class="activity-meta">

                            <span>Age 3–5</span>

                            <span>10 min</span>

                            <span>Tray + sand</span>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card border-orange">

                    <div class="card-body">

                        <div class="activity-label">
                            Activity 6
                        </div>

                        <h3>Blending Robot</h3>

                        <p>
                            Teacher speaks separated sounds like a robot while children
                            blend them into complete words.
                        </p>

                        <div class="activity-meta">

                            <span>Age 4–6</span>

                            <span>15 min</span>

                            <span>CVC focus</span>

                        </div>

                    </div>

                </div>
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

@endpush