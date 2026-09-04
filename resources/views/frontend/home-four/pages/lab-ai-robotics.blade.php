@extends('frontend.home-four.layouts.master')

@section('meta_title', 'AI & Robotics Lab — Hands-on Coding, AI & Robotics for Schools')
@section('meta_description', 'Empower students with hands-on robotics, coding and AI experiments through STEMbot\'s AI & Robotics Lab. Future-ready skills for every classroom.')

@section('contents')

<!-- =====================================================================
     HERO SECTION
     ===================================================================== -->
<section class="relative pt-12 pb-16 lg:pt-20 lg:pb-24 overflow-hidden bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

      <!-- Left Content -->
      <div class="lg:col-span-6 space-y-6">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-400 font-semibold">
          <a href="{{ route('labs') }}" class="hover:text-brand-orange transition-colors">All Labs</a>
          <i class="fa-solid fa-chevron-right text-[10px]"></i>
          <span class="text-brand-orange">AI & Robotics Lab</span>
        </div>

        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">
          <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
          Future-ready AI Education
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-[52px] font-extrabold text-brand-navy leading-[1.12] tracking-tight">
          AI & Robotics <span class="text-brand-orange">Lab</span>
        </h1>

        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
          Where students step beyond textbooks and into the future — building robots, writing code, and exploring artificial intelligence through hands-on experimentation.
        </p>

        <div class="flex flex-wrap gap-3">
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-robot text-blue-500"></i> Robotics Kits
          </div>
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-brain text-purple-500"></i> AI Modules
          </div>
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-code text-green-500"></i> Coding
          </div>
        </div>

        <div class="flex flex-wrap items-center gap-4 pt-2">
          <a href="#demo" class="inline-flex items-center justify-center px-7 py-3.5 rounded-xl bg-brand-navy hover:bg-brand-darknavy text-white text-sm font-bold transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5 group">
            <span>Book a Demo</span>
            <i class="fa-solid fa-arrow-right ml-2.5 text-xs transition-transform group-hover:translate-x-1"></i>
          </a>
          <a href="{{ route('labs') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-navy transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i> View All Labs
          </a>
        </div>
      </div>

      <!-- Right Image -->
      <div class="lg:col-span-6">
        <div class="relative">
          <div class="absolute -inset-2 bg-gradient-to-tr from-blue-200/40 to-brand-navy/10 rounded-3xl transform rotate-1 blur-sm"></div>
          <div class="relative bg-white p-3 rounded-3xl border-2 border-blue-300/50 shadow-2xl overflow-hidden">
            <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100">
              <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1000&q=85"
                   alt="Students building and programming robots in AI & Robotics Lab"
                   class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-14 lg:mt-20">
      <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-navy mb-1">500+</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Schools with AI Labs</div>
      </div>
      <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-orange mb-1">12+</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">AI & Robotics Modules</div>
      </div>
      <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-navy mb-1">Grade 1–12</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Age-Appropriate Curriculum</div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================================
     WHAT IS THE AI & ROBOTICS LAB
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-[#ebf3ff] border-y border-blue-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

      <div class="lg:col-span-5 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-blue-700 text-xs font-bold uppercase tracking-wider border border-blue-200 shadow-sm">
          About This Lab
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy leading-tight">
          What Is the AI & Robotics Lab?
        </h2>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          The AI & Robotics Lab is a dedicated space where students progress from assembling their first robot to training machine learning models — all in the same classroom. Built for Grades 1–12, the lab grows with the learner.
        </p>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          Students begin with block-based programming and modular robotics, advancing to Python, computer vision, and neural network basics as they move through grades — building genuine AI fluency along the way.
        </p>
        <div class="flex flex-col gap-3 pt-2">
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-blue-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-blue-600 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Age-appropriate modular robotics kits for every grade level</span>
          </div>
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-blue-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-blue-600 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Block-code to Python progression pathway</span>
          </div>
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-blue-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-blue-600 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Computer vision, sensors & intelligent machine experiments</span>
          </div>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-2xl overflow-hidden border-2 border-blue-200 shadow-lg aspect-[4/3] bg-slate-100 group">
          <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=700&q=80"
               alt="Students programming a robot"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        </div>
        <div class="rounded-2xl overflow-hidden border-2 border-blue-200 shadow-lg aspect-[4/3] bg-slate-100 group">
          <img src="https://images.unsplash.com/photo-1677442135703-1787eea5ce01?auto=format&fit=crop&w=700&q=80"
               alt="AI machine learning experiment"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =====================================================================
     WHAT'S INCLUDED
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">
        What's Included
      </div>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy">Everything in the Lab Kit</h2>
      <p class="text-base text-slate-600">A complete hardware and curriculum package — ready to deploy from day one.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <div class="bg-[#ebf3ff] rounded-2xl p-6 border border-blue-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-robot"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Modular Robotics Kits</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Snap-and-build robotics kits with motors, sensors, and structural parts designed for hands-on assembly and programming.</p>
      </div>

      <div class="bg-[#ebf3ff] rounded-2xl p-6 border border-blue-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-brain"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">AI & ML Modules</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Foundational AI experiments covering computer vision, voice recognition, object detection, and basic neural network logic.</p>
      </div>

      <div class="bg-[#ebf3ff] rounded-2xl p-6 border border-blue-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-code"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Coding Progression Path</h3>
        <p class="text-sm text-slate-600 leading-relaxed">From Scratch block-code to Python — structured learning paths that match student grade levels and learning pace.</p>
      </div>

      <div class="bg-[#ebf3ff] rounded-2xl p-6 border border-blue-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-microchip"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Sensors & Microcontrollers</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Ultrasonic, IR, colour, and motion sensors paired with Arduino and Raspberry Pi for real-world automation projects.</p>
      </div>

      <div class="bg-[#ebf3ff] rounded-2xl p-6 border border-blue-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-book-open"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Lesson Plans & Curriculum</h3>
        <p class="text-sm text-slate-600 leading-relaxed">NEP 2020-aligned lesson guides, student workbooks, project briefs, and teacher slide decks for every session.</p>
      </div>

      <div class="bg-[#ebf3ff] rounded-2xl p-6 border border-blue-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-trophy"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Competitions & Showcases</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Access to regional and national robotics tournaments, innovation fairs, and inter-school AI hackathons.</p>
      </div>

    </div>
  </div>
</section>

<!-- =====================================================================
     LEARNING OUTCOMES
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-brand-navy">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 text-white text-xs font-bold uppercase tracking-wider">
        Learning Outcomes
      </div>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-white">What Students Walk Away With</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-lightbulb"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Computational Thinking</h3>
        <p class="text-xs text-blue-100 leading-relaxed">Breaking down complex problems into logical, solvable steps using programming fundamentals.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-gears"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Engineering Mindset</h3>
        <p class="text-xs text-blue-100 leading-relaxed">Design, build, test, and iterate — applying the engineering cycle to every project challenge.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-users"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Collaboration Skills</h3>
        <p class="text-xs text-blue-100 leading-relaxed">Team-based projects that build communication, delegation, and cooperative problem-solving abilities.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-robot"></i>
        </div>
        <h3 class="text-sm font-bold text-white">AI Literacy</h3>
        <p class="text-xs text-blue-100 leading-relaxed">Understanding how AI systems work, from data training to ethical considerations in modern technology.</p>
      </div>
    </div>

  </div>
</section>

<!-- =====================================================================
     OTHER LABS CTA
     ===================================================================== -->
<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-navy mb-3">Explore Our Other Labs</h2>
      <p class="text-slate-500 text-sm">Each lab is designed to complement and expand your school's innovation ecosystem.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
      <a href="{{ route('labs.stem') }}" class="group flex flex-col gap-3 p-4 rounded-2xl border border-slate-200 hover:border-brand-orange hover:shadow-lg transition-all duration-200 bg-white">
        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-slate-100">
          <img src="https://images.unsplash.com/photo-1516339901601-2e1b62dc0c45?auto=format&fit=crop&w=500&q=80" alt="STEM Lab" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
        <div>
          <p class="font-bold text-brand-navy group-hover:text-brand-orange transition-colors text-sm">STEM Lab</p>
          <p class="text-xs text-slate-500 mt-0.5">Electronics, IoT & project-based learning</p>
        </div>
      </a>
      <a href="{{ route('labs.ecec') }}" class="group flex flex-col gap-3 p-4 rounded-2xl border border-slate-200 hover:border-brand-orange hover:shadow-lg transition-all duration-200 bg-white">
        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-slate-100">
          <img src="https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=500&q=80" alt="ECEC Lab" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
        <div>
          <p class="font-bold text-brand-navy group-hover:text-brand-orange transition-colors text-sm">ECEC Lab</p>
          <p class="text-xs text-slate-500 mt-0.5">Early childhood exploration & creativity</p>
        </div>
      </a>
      <a href="{{ route('labs.composite-skill') }}" class="group flex flex-col gap-3 p-4 rounded-2xl border border-slate-200 hover:border-brand-orange hover:shadow-lg transition-all duration-200 bg-white">
        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-slate-100">
          <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=500&q=80" alt="Composite Skill Lab" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
        <div>
          <p class="font-bold text-brand-navy group-hover:text-brand-orange transition-colors text-sm">Composite Skill Lab</p>
          <p class="text-xs text-slate-500 mt-0.5">3D design, making & future-ready skills</p>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- =====================================================================
     BOOK DEMO FORM
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-[#fedecf] border-y border-brand-orange/20" id="demo">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-brand-orange text-xs font-bold uppercase tracking-wider shadow-sm">
        See it in action
      </div>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy">Book a Free AI & Robotics Lab Demo</h2>
      <p class="text-sm sm:text-base text-slate-700">Let our specialists show you exactly how the AI & Robotics Lab transforms a classroom.</p>
    </div>
    <div class="max-w-3xl mx-auto bg-white/95 rounded-3xl p-6 sm:p-10 shadow-xl border border-white/80">
      <form class="space-y-5" onsubmit="event.preventDefault(); alert('Thank you! Our STEM specialists will reach out to schedule your demo.');">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">School Name *</label>
          <input type="text" required placeholder="e.g. National Public School" class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all" />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Contact Person *</label>
            <input type="text" required placeholder="Your full name" class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all" />
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Address *</label>
            <input type="email" required placeholder="principal@school.edu.in" class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all" />
          </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Phone Number *</label>
            <input type="tel" required placeholder="+91 98765 43210" class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all" />
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">City *</label>
            <input type="text" required placeholder="e.g. Bengaluru, Mumbai" class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all" />
          </div>
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Message</label>
          <textarea rows="3" placeholder="Tell us about your student count, grade levels, or specific interests..." class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all"></textarea>
        </div>
        <div class="pt-2">
          <button type="submit" class="w-full sm:w-auto px-10 py-3.5 rounded-xl bg-brand-navy hover:bg-brand-darknavy text-white text-sm font-bold shadow-md hover:shadow-xl transition-all duration-200">
            Submit Demo Request
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

@endsection
