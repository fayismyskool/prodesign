@extends('frontend.home-four.layouts.master')

@section('meta_title', 'ECEC Lab — Early Childhood Exploration & Creativity for Schools')
@section('meta_description', 'STEMbot\'s ECEC Lab nurtures early childhood curiosity through play-based exploration, sensory activities, and creative learning experiences for young learners.')

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
          <span class="text-brand-orange">ECEC Lab</span>
        </div>

        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-50 text-pink-700 text-xs font-bold uppercase tracking-wider">
          <span class="w-2 h-2 rounded-full bg-pink-400 animate-pulse"></span>
          Early Childhood Education & Care
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-[52px] font-extrabold text-brand-navy leading-[1.12] tracking-tight">
          ECEC <span class="text-brand-orange">Lab</span>
        </h1>

        <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
          A nurturing, playful space designed for young learners — where curiosity is celebrated, creativity is encouraged, and early STEM concepts are discovered through sensory exploration and guided play.
        </p>

        <div class="flex flex-wrap gap-3">
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-paint-brush text-pink-500"></i> Creative Play
          </div>
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-hand-sparkles text-amber-500"></i> Sensory Learning
          </div>
          <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 text-xs font-bold text-slate-700">
            <i class="fa-solid fa-child-reaching text-purple-500"></i> Ages 3–8
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
          <div class="absolute -inset-2 bg-gradient-to-tr from-pink-200/40 to-amber-100/30 rounded-3xl transform rotate-1 blur-sm"></div>
          <div class="relative bg-white p-3 rounded-3xl border-2 border-pink-300/50 shadow-2xl overflow-hidden">
            <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100">
              <img src="https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=1000&q=85"
                   alt="Young children exploring and creating in the ECEC Lab"
                   class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-14 lg:mt-20">
      <div class="bg-pink-50 border border-pink-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-navy mb-1">Ages 3–8</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Designed for Early Learners</div>
      </div>
      <div class="bg-pink-50 border border-pink-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-orange mb-1">30+</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Play-Based Learning Activities</div>
      </div>
      <div class="bg-pink-50 border border-pink-100 rounded-2xl p-6 text-center shadow-sm">
        <div class="text-3xl lg:text-4xl font-black text-brand-navy mb-1">100%</div>
        <div class="text-xs lg:text-sm font-semibold text-slate-600">Safe & Age-Appropriate Materials</div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================================
     WHAT IS THE ECEC LAB
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-[#fff0f6] border-y border-pink-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

      <div class="lg:col-span-5 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-pink-700 text-xs font-bold uppercase tracking-wider border border-pink-200 shadow-sm">
          About This Lab
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy leading-tight">
          What Is the ECEC Lab?
        </h2>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          The Early Childhood Education & Care Lab is a thoughtfully designed space that honours how young children learn best — through play, exploration, and creative expression. It bridges the gap between nurturing care and early academic readiness.
        </p>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
          Every activity is intentionally crafted for ages 3–8, blending sensory experiences, collaborative play, storytelling, art, and introductory STEM concepts into joyful, child-led discovery sessions.
        </p>
        <div class="flex flex-col gap-3 pt-2">
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-pink-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-pink-500 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Play-based learning rooted in child development research</span>
          </div>
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-pink-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-pink-500 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Sensory materials, art tools & guided discovery activities</span>
          </div>
          <div class="flex items-start gap-3 bg-white rounded-xl p-3.5 border border-pink-100 shadow-sm">
            <i class="fa-solid fa-check-circle text-pink-500 mt-0.5"></i>
            <span class="text-sm font-semibold text-slate-700">Safe, colourful, and stimulating lab environment design</span>
          </div>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-2xl overflow-hidden border-2 border-pink-200 shadow-lg aspect-[4/3] bg-slate-100 group">
          <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&w=700&q=80"
               alt="Young child engaged in creative play activity"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        </div>
        <div class="rounded-2xl overflow-hidden border-2 border-pink-200 shadow-lg aspect-[4/3] bg-slate-100 group">
          <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=700&q=80"
               alt="Children working together on a creative project"
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
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-pink-50 text-pink-700 text-xs font-bold uppercase tracking-wider">
        What's Included
      </div>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy">Inside the ECEC Lab</h2>
      <p class="text-base text-slate-600">Every item selected for safety, developmental appropriateness, and maximum engagement.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <div class="bg-[#fff0f6] rounded-2xl p-6 border border-pink-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-hand-sparkles"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Sensory Play Stations</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Sand, water, texture, and nature-based sensory stations that stimulate tactile exploration and early cognitive development.</p>
      </div>

      <div class="bg-[#fff0f6] rounded-2xl p-6 border border-pink-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-paint-brush"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Creative Arts & Craft</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Non-toxic paints, clay, collage materials, and guided art projects that develop fine motor skills and self-expression.</p>
      </div>

      <div class="bg-[#fff0f6] rounded-2xl p-6 border border-pink-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-cubes"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Building & Construction Kits</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Large-block building sets, magnetic tiles, and construction toys that introduce spatial reasoning and early engineering thinking.</p>
      </div>

      <div class="bg-[#fff0f6] rounded-2xl p-6 border border-pink-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-seedling"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Nature & Science Discovery</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Mini garden kits, magnifying glasses, and simple science activities that introduce observation, classification, and natural curiosity.</p>
      </div>

      <div class="bg-[#fff0f6] rounded-2xl p-6 border border-pink-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-book-open"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Storytelling & Literacy Corner</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Illustrated storybooks, puppets, and role-play props that foster language development, listening skills, and imaginative thinking.</p>
      </div>

      <div class="bg-[#fff0f6] rounded-2xl p-6 border border-pink-100 space-y-3 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl">
          <i class="fa-solid fa-chalkboard-user"></i>
        </div>
        <h3 class="text-base font-bold text-brand-navy">Educator's Activity Guides</h3>
        <p class="text-sm text-slate-600 leading-relaxed">Comprehensive session plans, child development milestone trackers, and observation frameworks for early childhood educators.</p>
      </div>

    </div>
  </div>
</section>

<!-- =====================================================================
     DEVELOPMENTAL OUTCOMES
     ===================================================================== -->
<section class="py-16 lg:py-24 bg-brand-navy">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 text-white text-xs font-bold uppercase tracking-wider">
        Developmental Outcomes
      </div>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-white">What Young Learners Develop</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-heart"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Emotional Intelligence</h3>
        <p class="text-xs text-pink-100 leading-relaxed">Self-regulation, empathy, and confidence through collaborative play and guided social interaction.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-hand"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Fine Motor Skills</h3>
        <p class="text-xs text-pink-100 leading-relaxed">Precise hand-eye coordination through drawing, building, cutting, and hands-on craft activities.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-comments"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Language & Communication</h3>
        <p class="text-xs text-pink-100 leading-relaxed">Vocabulary growth, storytelling ability, and conversational confidence through rich language-based activities.</p>
      </div>
      <div class="bg-white/10 border border-white/10 rounded-2xl p-6 text-center space-y-3">
        <div class="w-12 h-12 mx-auto rounded-xl bg-white/20 text-white flex items-center justify-center text-xl">
          <i class="fa-solid fa-star"></i>
        </div>
        <h3 class="text-sm font-bold text-white">Natural Curiosity</h3>
        <p class="text-xs text-pink-100 leading-relaxed">A lifelong love of learning sparked by safe, joyful exploration that rewards questions and discovery.</p>
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
      <a href="{{ route('labs.stem') }}" class="group flex flex-col gap-3 p-4 rounded-2xl border border-slate-200 hover:border-brand-orange hover:shadow-lg transition-all duration-200 bg-white">
        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-slate-100">
          <img src="https://images.unsplash.com/photo-1516339901601-2e1b62dc0c45?auto=format&fit=crop&w=500&q=80" alt="STEM Lab" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
        <div>
          <p class="font-bold text-brand-navy group-hover:text-brand-orange transition-colors text-sm">STEM Lab</p>
          <p class="text-xs text-slate-500 mt-0.5">Electronics, IoT & project-based learning</p>
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
      <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy">Book a Free ECEC Lab Demo</h2>
      <p class="text-sm sm:text-base text-slate-700">Let our early childhood specialists walk you through the ECEC Lab experience.</p>
    </div>
    <div class="max-w-3xl mx-auto bg-white/95 rounded-3xl p-6 sm:p-10 shadow-xl border border-white/80">
      <form class="space-y-5" onsubmit="event.preventDefault(); alert('Thank you! Our specialists will reach out to schedule your demo.');">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">School Name *</label>
          <input type="text" required placeholder="e.g. Little Stars Nursery School" class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all" />
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
          <textarea rows="3" placeholder="Tell us about your age groups, class size, or any specific requirements..." class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-4 py-3 text-sm focus:border-brand-navy focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-navy/20 transition-all"></textarea>
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
