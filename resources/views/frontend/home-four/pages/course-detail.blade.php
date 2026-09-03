@extends('frontend.home-four.layouts.master')

@section('meta_title', 'Course Details — ' . config('app.name', 'Skillvation'))

@push('styles')
<style>
  .accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
  }
  .accordion-content.expanded {
    max-height: 500px;
  }
</style>
@endpush

@section('contents')
<div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
  <!-- Hero Image Grid -->
  <div class="grid grid-cols-1 md:grid-cols-12 gap-6 h-auto md:h-[400px]">
    <div class="md:col-span-8 h-[300px] md:h-full rounded-2xl overflow-hidden relative border border-slate-200">
      <div class="bg-cover bg-center w-full h-full" id="course-main-image" style="background-image: url('{{ asset('designs/img/TTT-1.png') }}')"></div>
    </div>
    <div class="md:col-span-4 flex flex-col gap-6 h-full">
      <div class="h-1/2 rounded-2xl overflow-hidden relative border border-slate-200">
        <div class="bg-cover bg-center w-full h-full" id="course-side-image-1" style="background-image: url('{{ asset('designs/img/TTT-1.png') }}')"></div>
      </div>
      <div class="h-1/2 rounded-2xl overflow-hidden relative border border-slate-200">
        <div class="bg-cover bg-center w-full h-full" id="course-side-image-2" style="background-image: url('{{ asset('designs/img/TTT-1.png') }}')"></div>
      </div>
    </div>
  </div>

  <!-- Course Content & Sidebar -->
  <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 pt-4">
    <!-- Main Left Column -->
    <div class="md:col-span-8 space-y-8">
      <div>
        <h1 id="course-title" class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6">Course Overview</h1>
        <div class="space-y-4">
          <h2 class="text-2xl font-bold text-slate-900">Description</h2>
          <p id="course-description" class="text-base text-slate-600 leading-relaxed">
            Detailed course outline and learning outcomes will appear here.
          </p>
        </div>
      </div>

      <div class="space-y-4">
        <h2 class="text-2xl font-bold text-slate-900">Learning Outcome</h2>
        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200">
          <p id="course-short-description" class="text-slate-600 leading-relaxed"></p>
        </div>
      </div>
    </div>

    <!-- Right Sidebar / Purchase Card -->
    <div class="md:col-span-4 space-y-6">
      <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl space-y-6 sticky top-24">
        <div class="flex items-baseline justify-between">
          <span class="text-3xl font-black text-slate-900" id="course-price">₹0</span>
          <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Available</span>
        </div>
        
        <div class="space-y-3">
          <a href="{{ route('courses') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl bg-primary hover:bg-primary-dark text-white font-bold text-sm shadow-md transition-all">
            <span>Enroll in Course</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
          <a href="{{ route('contact.index') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-bold text-sm transition-all">
            <span>Enquire Now</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
