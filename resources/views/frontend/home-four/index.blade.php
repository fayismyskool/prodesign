@extends('frontend.home-four.layouts.master')

@section('meta_title', 'Home — ' . config('app.name', 'Skillvation'))
@section('meta_description', 'Welcome to Skillvation — Empowering schools, teachers, and students with future-ready skills.')

@section('contents')
<!-- Clean Home Canvas — Ready for New Homepage Design -->
<div class="min-h-[70vh] flex flex-col items-center justify-center bg-gradient-to-b from-blue-50/50 via-white to-slate-50 py-20 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto text-center space-y-8">
    
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100/80 text-primary text-xs font-bold uppercase tracking-wider shadow-sm">
      <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
      Skillvation Platform
    </div>

    <h1 class="text-4xl sm:text-6xl font-black text-brand-darknavy tracking-tight leading-tight">
      Transforming Education Through <span class="text-primary underline decoration-primary/30">Future Skills</span>
    </h1>

    <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed font-normal">
      Explore our specialized educational programs designed for schools, teachers, and learners.
    </p>

    <!-- Quick Navigation Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-6 text-left">
      
      <!-- Card 1: Skill 2 Skool -->
      <a href="{{ route('skill2school') }}" class="group bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-primary/40 transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
          <i class="fa-solid fa-school text-xl"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-900 group-hover:text-primary transition-colors">Skill 2 Skool</h3>
        <p class="text-xs text-slate-500 mt-2 leading-relaxed">Comprehensive school-wide curriculum and interactive skill tracks.</p>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-primary mt-4 group-hover:translate-x-1 transition-transform">
          Explore <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </span>
      </a>

      <!-- Card 2: Upskill 4 Teacher -->
      <a href="{{ route('upskill4teacher') }}" class="group bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-primary/40 transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-orange-50 text-brand-orange flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
          <i class="fa-solid fa-chalkboard-user text-xl"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-900 group-hover:text-brand-orange transition-colors">Upskill 4 Teacher</h3>
        <p class="text-xs text-slate-500 mt-2 leading-relaxed">Professional educator development, certifications, and AI tools.</p>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-orange mt-4 group-hover:translate-x-1 transition-transform">
          Explore <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </span>
      </a>

      <!-- Card 3: TTT -->
      <a href="{{ route('ttt') }}" class="group bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-primary/40 transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
          <i class="fa-solid fa-graduation-cap text-xl"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-900 group-hover:text-purple-600 transition-colors">Train the Trainer</h3>
        <p class="text-xs text-slate-500 mt-2 leading-relaxed">Master educator bootcamps and hands-on pedagogical training.</p>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-600 mt-4 group-hover:translate-x-1 transition-transform">
          Explore <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </span>
      </a>

      <!-- Card 4: STEM Labs -->
      <a href="{{ route('labs') }}" class="group bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-brand-orange/40 transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
          <i class="fa-solid fa-robot text-xl"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-900 group-hover:text-amber-600 transition-colors">STEMbot Labs</h3>
        <p class="text-xs text-slate-500 mt-2 leading-relaxed">Turn classrooms into innovation hubs with robotics &amp; AI kits.</p>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 mt-4 group-hover:translate-x-1 transition-transform">
          Explore <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </span>
      </a>

    </div>

  </div>
</div>
@endsection
