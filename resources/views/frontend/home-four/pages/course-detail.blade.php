@extends('frontend.home-four.layouts.master')

@php
  $courseTitle = $course ? $course->title : 'Course Details';
  $courseCategory = $course?->category?->translation?->name ?? 'Skill Course';
  $courseImage = $course && $course->thumbnail ? asset($course->thumbnail) : asset('designs/img/TTT-1.png');
  $price = $course ? (float) $course->price : 0;
  $discount = $course ? (float) $course->discount : 0;
  $hasDiscount = $discount > 0 && $discount < $price;
  $finalPrice = $hasDiscount ? ($price - $discount) : $price;
@endphp

@section('meta_title', $courseTitle . ' — ' . config('app.name', 'Skillvation'))
@section('meta_description', $course ? strip_tags($course->short_description ?? Str::limit($course->description, 150)) : 'Course detail page')

@push('styles')
<style>
  .accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .accordion-content.expanded {
    max-height: 1000px;
  }
</style>
@endpush

@section('contents')
<div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14 space-y-10">

  <!-- Breadcrumb & Top Title -->
  <div class="space-y-2">
    <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 font-medium">
      <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
      <span>/</span>
      <a href="{{ route('courses') }}" class="hover:text-primary transition-colors">Courses</a>
      <span>/</span>
      <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md">{{ $courseTitle }}</span>
    </div>
    
    <div class="flex flex-wrap items-center gap-3 pt-1">
      <span class="px-3 py-1 bg-blue-50 text-primary text-xs font-bold rounded-full border border-blue-100 uppercase tracking-wider">
        {{ $courseCategory }}
      </span>
      @if ($course && $course->certificate)
        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100 flex items-center gap-1">
          <i class="fa-solid fa-award text-xs"></i> Certificate Included
        </span>
      @endif
      @if ($course && $course->course_code)
        <span class="text-xs text-slate-400 font-mono">Code: {{ $course->course_code }}</span>
      @endif
    </div>
  </div>

  <!-- Hero Image Grid -->
  <div class="grid grid-cols-1 md:grid-cols-12 gap-5 h-auto md:h-[380px]">
    <!-- Main Featured Image -->
    <div class="md:col-span-8 h-[260px] md:h-full rounded-2xl overflow-hidden relative border border-slate-200/80 shadow-sm bg-slate-100 group">
      <img src="{{ $courseImage }}" alt="{{ $courseTitle }}" id="course-main-image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ asset('designs/img/TTT-1.png') }}';" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
      <div class="absolute bottom-4 left-4 right-4 text-white">
        <h1 class="text-2xl sm:text-3xl font-extrabold drop-shadow-md leading-tight text-white" id="hero-course-title">
          {{ $courseTitle }}
        </h1>
      </div>
    </div>
    
    <!-- Side Images Stack -->
    <div class="md:col-span-4 flex flex-col gap-5 h-full">
      <div class="h-1/2 rounded-2xl overflow-hidden relative border border-slate-200/80 shadow-sm bg-slate-100 group">
        <img src="{{ $courseImage }}" alt="{{ $courseTitle }}" id="course-side-image-1" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ asset('designs/img/TTT-1.png') }}';" />
      </div>
      <div class="h-1/2 rounded-2xl overflow-hidden relative border border-slate-200/80 shadow-sm bg-slate-100 group">
        <img src="{{ $courseImage }}" alt="{{ $courseTitle }}" id="course-side-image-2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ asset('designs/img/TTT-1.png') }}';" />
      </div>
    </div>
  </div>

  <!-- Main Content Layout (2 Columns) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
    
    <!-- Left Main Column (8 cols) -->
    <div class="lg:col-span-8 space-y-10">
      
      <!-- Course Title & Overview -->
      <div class="space-y-4">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-snug" id="course-title">
          {{ $courseTitle }}
        </h2>
        
        <div class="flex flex-wrap items-center gap-6 text-sm text-slate-600 pb-4 border-b border-slate-100">
          <div class="flex items-center gap-1.5 text-amber-500">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <span class="text-slate-800 font-bold ml-1">5.0</span>
            <span class="text-slate-400 text-xs">({{ $course && $course->reviews ? $course->reviews->count() + 12 : 12 }} reviews)</span>
          </div>

          @if ($course && $course->instructor)
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-chalkboard-user text-primary text-xs"></i>
              <span>By <strong class="text-slate-800">{{ $course->instructor->name }}</strong></span>
            </div>
          @endif

          @if ($course && $course->duration)
            <div class="flex items-center gap-2">
              <i class="fa-regular fa-clock text-primary text-xs"></i>
              <span>{{ $course->duration }} Hours</span>
            </div>
          @endif
        </div>
      </div>

      <!-- Description Section -->
      <div class="space-y-4">
        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
          <i class="fa-solid fa-align-left text-primary text-base"></i>
          <span>Course Description</span>
        </h3>
        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm sm:text-base space-y-3" id="course-description">
          @if ($course && $course->description)
            {!! $course->description !!}
          @else
            <p>
              This comprehensive course provides structured, hands-on learning designed to build core competencies, practical skills, and future-ready knowledge. Through engaging activities, guided projects, and real-world scenarios, learners achieve tangible outcomes aligned with modern educational standards.
            </p>
          @endif
        </div>
      </div>

      <!-- Learning Outcomes / Summary Box -->
      @if ($course && ($course->short_description || $course->seo_description))
        <div class="space-y-4">
          <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-bullseye text-primary text-base"></i>
            <span>Key Learning Outcomes</span>
          </h3>
          <div class="p-6 bg-blue-50/60 rounded-2xl border border-blue-100/80">
            <p class="text-slate-700 leading-relaxed text-sm sm:text-base" id="course-short-description">
              {{ $course->short_description ?: $course->seo_description }}
            </p>
          </div>
        </div>
      @endif

      <!-- Course Curriculum / Chapters -->
      @if ($course && $course->chapters && $course->chapters->count() > 0)
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
              <i class="fa-solid fa-book-open text-primary text-base"></i>
              <span>Course Curriculum</span>
            </h3>
            <span class="text-xs text-slate-500 font-medium">
              {{ $course->chapters->count() }} {{ Str::plural('Module', $course->chapters->count()) }}
            </span>
          </div>

          <div class="space-y-3" id="chapters-accordion">
            @foreach ($course->chapters as $index => $chapter)
              @php
                $itemCount = $chapter->chapterItems ? $chapter->chapterItems->count() : 0;
              @endphp
              <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                <button type="button" class="w-full p-4 sm:p-5 text-left flex items-center justify-between gap-4 bg-slate-50/50 hover:bg-slate-50 transition-colors" onclick="toggleChapterAccordion(this)">
                  <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center flex-shrink-0">
                      {{ $index + 1 }}
                    </span>
                    <span class="font-bold text-sm sm:text-base text-slate-900">
                      {{ $chapter->title }}
                    </span>
                  </div>
                  <div class="flex items-center gap-3 text-slate-400">
                    @if ($itemCount > 0)
                      <span class="text-xs text-slate-500 bg-white px-2.5 py-1 rounded-full border border-slate-200">
                        {{ $itemCount }} {{ Str::plural('lesson', $itemCount) }}
                      </span>
                    @endif
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                  </div>
                </button>
                <div class="accordion-content {{ $index === 0 ? 'expanded' : '' }} px-5 pb-5 pt-3 border-t border-slate-100 bg-white space-y-2 text-sm text-slate-600">
                  @if ($chapter->description)
                    <p class="text-xs sm:text-sm text-slate-500 pb-2">{{ $chapter->description }}</p>
                  @endif
                  @if ($chapter->chapterItems && $chapter->chapterItems->count() > 0)
                    <ul class="space-y-2">
                      @foreach ($chapter->chapterItems as $item)
                        <li class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs sm:text-sm">
                          <div class="flex items-center gap-2.5">
                            @if ($item->type === 'quiz')
                              <i class="fa-solid fa-clipboard-question text-amber-500"></i>
                            @elseif ($item->type === 'document')
                              <i class="fa-solid fa-file-pdf text-rose-500"></i>
                            @elseif ($item->type === 'activity')
                              <i class="fa-solid fa-puzzle-piece text-emerald-500"></i>
                            @else
                              <i class="fa-solid fa-circle-play text-primary"></i>
                            @endif
                            <span class="font-medium text-slate-800 capitalize">{{ $item->type }} lesson</span>
                          </div>
                          <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ $item->type }}</span>
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Instructor Section -->
      @if ($course && $course->instructor)
        <div class="space-y-4 pt-4 border-t border-slate-200">
          <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-id-badge text-primary text-base"></i>
            <span>About the Instructor</span>
          </h3>
          <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row gap-5 items-start sm:items-center">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-primary/30 flex-shrink-0 shadow-sm">
              @if ($course->instructor->image)
                <img src="{{ asset($course->instructor->image) }}" alt="{{ $course->instructor->name }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($course->instructor->name) }}&background=1976d2&color=fff';" />
              @else
                <div class="w-full h-full bg-primary text-white font-bold flex items-center justify-center text-xl">
                  {{ substr($course->instructor->name, 0, 1) }}
                </div>
              @endif
            </div>
            <div class="space-y-1.5 flex-grow">
              <h4 class="text-lg font-bold text-slate-900">{{ $course->instructor->name }}</h4>
              <p class="text-xs text-primary font-semibold uppercase tracking-wider">{{ $course->instructor->job_title ?: 'Certified Educator & Trainer' }}</p>
              <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pt-1">
                {{ $course->instructor->short_bio ?: ($course->instructor->bio ?: 'Experienced educator committed to transforming modern classrooms through interactive, experiential learning.') }}
              </p>
            </div>
          </div>
        </div>
      @endif

      <!-- Reviews & Feedback Section -->
      <div class="space-y-6 pt-4 border-t border-slate-200">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-comments text-primary text-base"></i>
            <span>Ratings &amp; Student Reviews</span>
          </h3>
          <span class="text-xs font-bold text-amber-500 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
            ★ 5.0 Rating
          </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Review 1 -->
          <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center gap-3">
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" alt="Lavanya S" class="w-10 h-10 rounded-full object-cover border border-slate-200" />
              <div>
                <h5 class="text-sm font-bold text-slate-900">Lavanya S.</h5>
                <div class="flex text-amber-400 text-xs">★★★★★</div>
              </div>
            </div>
            <p class="text-xs text-slate-600 leading-relaxed">
              "Skillvation has made professional development so much easier for me. The course is practical, engaging, and easy to follow. I learned several new classroom strategies that keep my students actively involved."
            </p>
          </div>

          <!-- Review 2 -->
          <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center gap-3">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" alt="Arthi K" class="w-10 h-10 rounded-full object-cover border border-slate-200" />
              <div>
                <h5 class="text-sm font-bold text-slate-900">Arthi K.</h5>
                <div class="flex text-amber-400 text-xs">★★★★★</div>
              </div>
            </div>
            <p class="text-xs text-slate-600 leading-relaxed">
              "Joining Skillvation has been one of the best decisions for my teaching career. The modules are well-structured, the resources are top-notch, and I can immediately apply ideas in my classroom."
            </p>
          </div>
        </div>
      </div>

    </div>

    <!-- Right Sidebar Column (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
      <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl space-y-6 sticky top-24">
        
        <!-- Pricing Block -->
        <div class="space-y-1 pb-4 border-b border-slate-100">
          <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Course Fee</p>
          <div class="flex items-baseline gap-3">
            <span class="text-3xl sm:text-4xl font-black text-slate-900" id="sidebar-price">
              @if ($finalPrice > 0)
                ₹ {{ number_format($finalPrice, 0) }}
              @else
                Free
              @endif
            </span>
            @if ($hasDiscount)
              <span class="text-lg text-slate-400 line-through">₹ {{ number_format($price, 0) }}</span>
              <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">Save ₹{{ number_format($discount, 0) }}</span>
            @endif
          </div>
        </div>

        <!-- Action CTAs -->
        <div class="space-y-3">
          @if ($course)
            <form action="{{ route('add-to-cart', $course->id) }}" method="POST">
              @csrf
              <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-2xl bg-primary hover:bg-primary-dark text-white font-bold text-sm shadow-md hover:shadow-lg transition-all active:scale-95">
                <i class="fa-solid fa-cart-shopping text-xs"></i>
                <span>Enroll in Course</span>
              </button>
            </form>
          @else
            <a href="{{ route('courses') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-2xl bg-primary hover:bg-primary-dark text-white font-bold text-sm shadow-md transition-all">
              <span>Enroll in Course</span>
            </a>
          @endif

          <a href="{{ route('contact.index') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-bold text-sm transition-all shadow-sm">
            <i class="fa-regular fa-envelope text-xs"></i>
            <span>Enquire / Request Info</span>
          </a>
        </div>

        <!-- Course Meta Checklist -->
        <div class="pt-4 border-t border-slate-100 space-y-3.5 text-xs sm:text-sm text-slate-600">
          <p class="font-bold text-slate-900 text-xs uppercase tracking-wider">This Course Includes:</p>
          
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2">
              <i class="fa-regular fa-clock text-primary"></i> Duration
            </span>
            <span class="font-bold text-slate-800">{{ $course && $course->duration ? $course->duration . ' Hours' : 'Self-Paced' }}</span>
          </div>

          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-award text-primary"></i> Certificate
            </span>
            <span class="font-bold text-emerald-600">Yes (Upon Completion)</span>
          </div>

          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-layer-group text-primary"></i> Category
            </span>
            <span class="font-bold text-slate-800">{{ $courseCategory }}</span>
          </div>

          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-globe text-primary"></i> Mode
            </span>
            <span class="font-bold text-slate-800">{{ $course && $course->is_online ? 'Online' : 'Blended / Online' }}</span>
          </div>

          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-infinity text-primary"></i> Access
            </span>
            <span class="font-bold text-slate-800">Lifetime Access</span>
          </div>
        </div>

      </div>
    </div>

  </div>

</div>

@push('scripts')
<script>
function toggleChapterAccordion(btn) {
  const content = btn.nextElementSibling;
  const icon = btn.querySelector('.fa-chevron-down');
  if (content) {
    content.classList.toggle('expanded');
    if (icon) {
      icon.classList.toggle('rotate-180');
    }
  }
}
</script>
@endpush
@endsection
