@php
    $nav_menu = Cache::rememberForever('nav_menu', function () {
        return menuGetBySlug('nav-menu');
    });
    $setting = Cache::get('setting');
@endphp

<!-- BEGIN: TopNavBar (Common CMS-Managed Header) -->
<header
  class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all duration-300"
  id="navbar">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">

    <!-- Logo -->
    <a class="flex items-center gap-2 transition-transform hover:scale-105" href="{{ route('home') }}">
      <img alt="{{ config('app.name', 'Skillvation') }}" class="h-8 sm:h-9 w-auto object-contain" src="{{ asset('designs/img/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset($setting?->logo ?? 'frontend/img/logo/logo.svg') }}';" />
    </a>

    <!-- Desktop Navigation (CMS Dynamic Menu) -->
    <nav class="hidden lg:flex gap-1 xl:gap-2 items-center" id="main-nav">
      @if ($nav_menu)
        @foreach ($nav_menu as $menu)
          @php
            $linkUrl = $menu['link'] === '#' ? 'javascript:void(0);' : url($menu['link']);
            $isActive = $menu['link'] !== '#' && (
              request()->is(ltrim($menu['link'], '/')) || 
              (request()->path() === '/' && $menu['link'] === '/') ||
              request()->fullUrlIs($linkUrl)
            );
          @endphp

          @if (!empty($menu['child']) && count($menu['child']) > 0)
            <!-- Dropdown Menu -->
            <div class="relative group">
              <button type="button" class="nav-link inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-200 {{ $isActive ? 'text-primary bg-blue-50/60 font-bold' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                <span>{{ $menu['label'] }}</span>
                <i class="fa-solid fa-chevron-down text-[10px] opacity-70 group-hover:rotate-180 transition-transform duration-200"></i>
              </button>

              <div class="absolute left-0 top-full pt-2 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-1 z-50">
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-2 space-y-1">
                  @foreach ($menu['child'] as $child)
                    <a href="{{ url($child['link']) }}" class="block px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-primary hover:bg-blue-50/60 transition-colors">
                      {{ $child['label'] }}
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          @else
            <!-- Standard Menu Item -->
            <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-200 {{ $isActive ? 'text-primary bg-blue-50/60 font-bold' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}"
              href="{{ $linkUrl }}">
              {{ $menu['label'] }}
            </a>
          @endif
        @endforeach
      @else
        <!-- Fallback if menu is empty -->
        <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:text-primary" href="{{ route('home') }}">Home</a>
        <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:text-primary" href="{{ route('skill2school') }}">Skill 2 Skool</a>
        <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:text-primary" href="{{ route('upskill4teacher') }}">Upskill 4 Teacher</a>
        <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:text-primary" href="{{ route('ttt') }}">TTT</a>
        <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:text-primary" href="{{ route('labs') }}">LABS</a>
        <a class="nav-link px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:text-primary" href="{{ route('courses') }}">Courses</a>
      @endif
    </nav>

    <!-- Auth Buttons & Action Area -->
    <div class="flex items-center gap-3 sm:gap-4">
      @auth
        @if (auth()->user()->role === 'school')
          <a href="{{ route('school.dashboard') }}" class="bg-primary hover:bg-primary-dark text-white px-4 sm:px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow inline-flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-graduation-cap text-xs"></i>
            <span>School Portal</span>
          </a>
        @elseif (auth()->user()->role === 'instructor' && auth()->user()->instructorStatus() === 'approved')
          <a href="{{ route('instructor.dashboard') }}" class="bg-primary hover:bg-primary-dark text-white px-4 sm:px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow inline-flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-chalkboard-user text-xs"></i>
            <span>Instructor Portal</span>
          </a>
        @else
          <a href="{{ route('student.dashboard') }}" class="bg-primary hover:bg-primary-dark text-white px-4 sm:px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow inline-flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-user-graduate text-xs"></i>
            <span>My Learning</span>
          </a>
        @endif
        
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="p-2 text-slate-400 hover:text-red-500 rounded-lg hover:bg-red-50 text-sm font-medium transition-colors" title="Logout">
            <i class="fa-solid fa-right-from-bracket"></i>
          </button>
        </form>
      @else
        <a href="{{ route('register') }}" class="hidden sm:inline-block text-primary font-bold hover:text-primary-dark transition-colors text-xs sm:text-sm px-2">
          Sign Up
        </a>
        <a href="https://sso.myskool.club/login?client_id=skillvation&redirect_uri=https%3A%2F%2Fskillvation.com%2Fcallback&state=4jWtX7gbTl2fWjN2" class="hidden sm:inline-block text-slate-600 font-bold hover:text-primary transition-colors text-xs sm:text-sm px-2">
          SSO Login
        </a>
        <a href="{{ route('login') }}" style="background-color: #1976d2; color: #ffffff;" class="bg-primary hover:bg-primary-dark text-white px-4 sm:px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow inline-flex items-center justify-center">
          Login
        </a>
      @endauth

      <!-- Mobile Hamburger Toggle -->
      <button
        class="lg:hidden flex flex-col gap-1.5 p-2 rounded-lg text-slate-700 hover:bg-slate-100 focus:outline-none"
        aria-label="Toggle navigation menu"
        id="mobile-menu-btn"
        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
        <span class="block w-5 h-0.5 bg-slate-700 transition-all"></span>
        <span class="block w-5 h-0.5 bg-slate-700 transition-all"></span>
        <span class="block w-5 h-0.5 bg-slate-700 transition-all"></span>
      </button>
    </div>
  </div>

  <!-- Mobile Dropdown Menu (CMS Dynamic Menu) -->
  <div class="lg:hidden hidden bg-white border-t border-slate-100 px-4 py-4 space-y-1 shadow-lg max-h-[80vh] overflow-y-auto" id="mobile-menu">
    @if ($nav_menu)
      @foreach ($nav_menu as $menu)
        @php
          $linkUrl = $menu['link'] === '#' ? 'javascript:void(0);' : url($menu['link']);
          $isActive = $menu['link'] !== '#' && (
            request()->is(ltrim($menu['link'], '/')) || 
            (request()->path() === '/' && $menu['link'] === '/') ||
            request()->fullUrlIs($linkUrl)
          );
        @endphp

        @if (!empty($menu['child']) && count($menu['child']) > 0)
          <div class="py-1">
            <span class="block px-3 py-1.5 text-xs font-extrabold uppercase tracking-wider text-slate-400">
              {{ $menu['label'] }}
            </span>
            <div class="pl-3 space-y-1 border-l-2 border-slate-100 ml-2 mt-1">
              @foreach ($menu['child'] as $child)
                <a href="{{ url($child['link']) }}" class="block px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-700 hover:text-primary hover:bg-blue-50">
                  {{ $child['label'] }}
                </a>
              @endforeach
            </div>
          </div>
        @else
          <a class="block px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $isActive ? 'text-primary bg-blue-50 font-bold' : 'text-slate-700 hover:text-primary hover:bg-slate-50' }}"
            href="{{ $linkUrl }}">
            {{ $menu['label'] }}
          </a>
        @endif
      @endforeach
    @endif

    <div class="pt-4 mt-2 flex flex-col gap-2 border-t border-slate-100">
      @auth
        <a href="{{ auth()->user()->role === 'school' ? route('school.dashboard') : (auth()->user()->role === 'instructor' ? route('instructor.dashboard') : route('student.dashboard')) }}" class="text-primary font-bold text-sm px-3 py-1.5">
          Go to Dashboard
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="text-red-500 font-bold text-sm text-left w-full px-3 py-1.5">
            Logout
          </button>
        </form>
      @else
        <a href="{{ route('register') }}" class="text-primary font-bold text-sm px-3 py-1.5">Sign Up</a>
        <a href="https://sso.myskool.club/login?client_id=skillvation&redirect_uri=https%3A%2F%2Fskillvation.com%2Fcallback&state=4jWtX7gbTl2fWjN2" class="text-slate-700 font-bold text-sm px-3 py-1.5">SSO Login</a>
        <a href="{{ route('login') }}" style="background-color: #1976d2; color: #ffffff;" class="bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-full text-sm font-bold transition-colors w-full text-center block shadow-sm">
          Login
        </a>
      @endauth
    </div>
  </div>
</header>
<!-- END: TopNavBar -->
