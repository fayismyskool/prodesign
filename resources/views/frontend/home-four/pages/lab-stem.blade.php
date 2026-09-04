@extends('frontend.home-four.layouts.master')

@section('meta_title', 'STEM Lab — Electronics, IoT & Project-Based Learning for Schools')
@section('meta_description', 'STEMbot\'s STEM Lab equips students with electronics, IoT prototyping, and hands-on project-based learning. Curriculum-aligned for Grades 1–12.')

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
          <span class="text-brand-orange">STEM Lab</span>
        </div>

        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
          <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
          Science, Technology, Engineering & Maths
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-[52px] font-extrabold text-brand-navy leading-[1.12] tracking-tight">
          STEM <span class="text-brand-orange">Lab</span>
        </h1>

        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
          A hands-on innovation space where students explore electronics, build IoT prototypes, and solve real-world engineering challenges through structured project-based learning.
        </p>

        <div class="flex flex-wrap gap-3">
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-microchip text-emerald-500"></i> Electronics
          </div>
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-wifi text-blue-500"></i> IoT Projects
          </div>
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-flask text-purple-500"></i> Science Experiments
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
          <div class="absolute -inset-2 bg-gradient-to-tr from-emerald-200/40 to-brand-navy/10 rounded-3xl transform rotate-1 blur-sm"></div>
          <div class="relative bg-white p-3 rounded-3xl border-2 border-emerald-300/50 shadow-2xl overflow-hidden">
            <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100">
              <img src="https://images.unsplash.com/photo-1516339901601-2e1b62dc0c45?auto=format&fit=crop&w=1000&q=85"
                   alt="Students working in a STEM electronics lab"
                   class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-14 lg:mt-20">
      <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-navy mb-1">400+</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Schools with STEM Labs</div>
      </div>
      <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-orange mb-1">50+</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Hands-on Project Modules</div>
      </div>
      <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-navy mb-1">NEP 2020</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Curriculum Aligned</div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================================
     WHAT IS THE STEM LAB
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-[#e4faed] border-y border-emerald-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

      <div class="lg:col-span-5 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-emerald-700 text-xs font-bold uppercase tracking-wider border border-emerald-200 shadow-sm">
          About This Lab
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy leading-tight">
          What Is the STEM Lab?
        </h2>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          The STEM Lab is an integrated learning environment where Science, Technology, Engineering, and Mathematics come alive through real experiments and project challenges. Students don't just study STEM — they practise it.
        </p>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          From wiring circuits on breadboards to building smart IoT devices and conducting science experiments, students engage with every concept through doing — developing a deep, lasting understanding.
        </p>
        <div class="flex flex-col gap-3 pt-2">
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-emerald-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-emerald-600 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Integrated Science, Technology, Engineering & Maths curriculum</span>
          </div>
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-emerald-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-emerald-600 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Electronics kits, breadboards & IoT sensor modules</span>
          </div>
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-emerald-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-emerald-600 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Structured project-based learning mapped to grade outcomes</span>
          </div>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-2xl overflow-hidden border-2 border-emerald-200 shadow-lg aspect-[4/3] bg-slate-100 group">
          <img src="https://images.unsplash.com/photo-1532094349884-543559383dd4?auto=format&fit=crop&w=700&q=80"
               alt="Students building electronics circuits"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        </div>
        <div class="rounded-2xl overflow-hidden border-2 border-emerald-200 shadow-lg aspect-[4/3] bg-slate-100 group">
          <img src="https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&w=700&q=80"
               alt="Student conducting science experiment"
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
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
        What's Included
      </div>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy">Everything in the STEM Lab Kit</h2>
      <p class="text-base text-slate-600">A complete hardware, software, and curriculum solution — installed and ready to use.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <div class="bg-[#e4faed] rounded-2xl p-6 border border-emerald-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-bolt"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Electronics & Circuit Kits</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Breadboards, resistors, LEDs, capacitors, transistors, and complete component sets for building circuits from scratch.</p>
      </div>

      <div class="bg-[#e4faed] rounded-2xl p-6 border border-emerald-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-wifi"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">IoT Prototyping Modules</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Smart sensors, ESP8266/ESP32 boards, and connectivity modules to design and deploy Internet of Things prototypes.</p>
      </div>

      <div class="bg-[#e4faed] rounded-2xl p-6 border border-emerald-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-flask"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Science Experiment Kits</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Physics, chemistry, and biology experiment sets that make textbook concepts visible, tangible, and memorable.</p>
      </div>

      <div class="bg-[#e4faed] rounded-2xl p-6 border border-emerald-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-calculator"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Applied Mathematics Tools</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Geometry sets, measurement instruments, data loggers, and visualisation tools that bring maths to life through application.</p>
      </div>

      <div class="bg-[#e4faed] rounded-2xl p-6 border border-emerald-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-book-open"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Lesson Plans & Workbooks</h3>
        <p class="text-sm text-slate-600 leading-relaxed">NEP 2020 and CBSE/ICSE-aligned lesson guides with step-by-step teacher notes, student activity sheets, and rubrics.</p>
      </div>

      <div class="bg-[#e4faed] rounded-2xl p-6 border border-emerald-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-people-group"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Teacher Training & Support</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Certified teacher onboarding programme, continuous mentoring, and a dedicated support team throughout the academic year.</p>
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
      <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Skills Students Build</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Scientific Inquiry</h3>
        <p class="text-xs text-emerald-100 leading-relaxed">Forming hypotheses, designing experiments, collecting data, and drawing evidence-based conclusions.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-gears"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Engineering Design</h3>
        <p class="text-xs text-emerald-100 leading-relaxed">Applying the iterative design process — plan, build, test, and refine — to solve real engineering problems.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-chart-line"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Data Analysis</h3>
        <p class="text-xs text-emerald-100 leading-relaxed">Collecting, interpreting, and presenting data through graphs, measurements, and digital visualisation tools.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-puzzle-piece"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Problem Solving</h3>
        <p class="text-xs text-emerald-100 leading-relaxed">Tackling open-ended, multi-disciplinary challenges that require creative, cross-subject thinking.</p>
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
      <a href="{{ route('labs.ai-robotics') }}" class="group flex flex-col gap-3 p-4 rounded-2xl border border-slate-200 hover:border-brand-orange hover:shadow-lg transition-all duration-200 bg-white">
        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-slate-100">
          <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=500&q=80" alt="AI & Robotics Lab" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
        <div>
          <p class="font-bold text-brand-navy group-hover:text-brand-orange transition-colors text-sm">AI & Robotics Lab</p>
          <p class="text-xs text-slate-500 mt-0.5">Hands-on robotics, coding & AI experiments</p>
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
      <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy">Book a Free STEM Lab Demo</h2>
      <p class="text-sm sm:text-base text-slate-700">Let our specialists show you exactly how the STEM Lab transforms science and technology learning.</p>
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
