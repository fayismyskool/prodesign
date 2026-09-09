@extends('frontend.home-four.layouts.master')

@section('meta_title', 'SkillBox Shop — ' . config('app.name', 'Skillvation'))
@section('meta_description', 'Explore our SkillBox collection: interactive learning kits, activity boxes, and STEM resources designed to empower young minds.')

@push('styles')
<style>
  /* ── SkillBox Custom Styles ─────────────────────────────────── */
  .skillbox-page-wrap {
    max-width: 1480px;
    margin: 0 auto;
    padding-bottom: 4rem;
  }

  /* Banner Image */
  .skillbox-banner-img {
    width: 100%;
    max-height: 480px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    margin-top: 0;
    margin-bottom: 1.5rem;
  }

  /* Control bar */
  .skillbox-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
  }

  .skillbox-search-wrap {
    position: relative;
    flex: 1 1 320px;
    max-width: 520px;
  }

  .skillbox-search-input {
    width: 100%;
    padding: 0.65rem 1rem 0.65rem 2.75rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    font-size: 0.95rem;
    background-color: #ffffff;
    transition: all 0.2s ease;
  }
  .skillbox-search-input:focus {
    outline: none;
    border-color: #E2002B;
    box-shadow: 0 0 0 3px rgba(226, 0, 43, 0.12);
  }

  .skillbox-search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
  }

  .skillbox-clear-search {
    position: absolute;
    right: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    cursor: pointer;
    border: none;
    background: transparent;
    display: none;
  }

  .skillbox-category-select {
    padding: 0.65rem 2.25rem 0.65rem 1rem;
    border-radius: 12px;
    border: 1px solid #E2002B70;
    font-size: 0.95rem;
    font-weight: 500;
    color: #1e293b;
    background-color: #ffffff;
    cursor: pointer;
    min-width: 200px;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23e2002b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.85rem center;
    background-size: 1rem;
    transition: all 0.2s ease;
  }
  .skillbox-category-select:focus {
    outline: none;
    border-color: #E2002B;
    box-shadow: 0 0 0 3px rgba(226, 0, 43, 0.12);
  }

  .skillbox-actions-grp {
    display: flex;
    align-items: center;
    gap: 1.25rem;
  }

  .skillbox-action-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .skillbox-action-btn:hover {
    background-color: #fff1f2;
    border-color: #fecdd3;
    color: #E2002B;
    transform: translateY(-2px);
  }

  .skillbox-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background-color: #E2002B;
    color: #ffffff;
    font-size: 0.65rem;
    font-weight: 700;
    width: 18px;
    height: 18px;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(226, 0, 43, 0.3);
  }

  /* Product Card */
  .skillbox-card {
    border-radius: 16px;
    overflow: hidden;
    background: #ffffff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid #E7E7E7;
  }
  .skillbox-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
  }

  .skillbox-card__img-box {
    position: relative;
    background-color: #f3f4f6;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    overflow: hidden;
    cursor: pointer;
  }

  .skillbox-card__img {
    max-width: 82%;
    max-height: 82%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }
  .skillbox-card:hover .skillbox-card__img {
    transform: scale(1.06);
  }

  .skillbox-card__wish-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(4px);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 5;
  }
  .skillbox-card__wish-btn:hover {
    background: #ffffff;
    transform: scale(1.1);
    color: #E2002B;
  }
  .skillbox-card__wish-btn.active {
    color: #E2002B;
    background: #ffffff;
  }

  .skillbox-card__body {
    padding: 1.25rem 1rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    background: #ffffff;
  }

  .skillbox-card__title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.4rem;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 2.6em;
  }

  .skillbox-card__stars {
    display: flex;
    align-items: center;
    gap: 2px;
    color: #f59e0b;
    font-size: 0.8rem;
    margin-bottom: 0.75rem;
  }

  .skillbox-card__price-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.5rem;
    border-top: 1px solid #f1f5f9;
  }

  .skillbox-card__price {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
  }

  .skillbox-card__old-price {
    font-size: 0.85rem;
    color: #94a3b8;
    text-decoration: line-through;
    margin-left: 0.5rem;
  }

  .skillbox-card__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.45rem 0.9rem;
    border-radius: 8px;
    background: #E2002B;
    color: #ffffff;
    font-size: 0.82rem;
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
  }
  .skillbox-card__btn:hover {
    background: #c50024;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(226, 0, 43, 0.25);
  }

  /* Benefits Section */
  .skillbox-benefits-section {
    position: relative;
    padding: 5rem 0 3rem;
    background-image: url("{{ asset('frontend/img/skillbox/skillbox_heading_bg.png') }}");
    background-size: cover;
    background-position: top center;
  }

  .benefit-card {
    border-radius: 20px;
    overflow: hidden;
    padding: 2rem;
    position: relative;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
  }
  .benefit-card--blue {
    background-color: #E2F3FD;
  }
  .benefit-card--peach {
    background-color: #FBF1E8;
  }

  .benefit-subcard {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .benefit-subcard__img {
    height: 180px;
    width: 100%;
    object-fit: cover;
  }

  .benefit-subcard__header {
    padding: 0.75rem 1rem;
    font-weight: 700;
    font-size: 1rem;
    color: #ffffff;
  }

  .benefit-subcard__body {
    padding: 1rem;
    font-size: 0.88rem;
    color: #475569;
    line-height: 1.5;
  }

  /* Geometric accent circles */
  .geo-circle-gold {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 3px solid #FAC584;
    position: absolute;
    pointer-events: none;
  }
  .geo-circle-sky {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 3px solid #87CEEB;
    position: absolute;
    pointer-events: none;
  }

  /* Toast Notification */
  .skillbox-toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #1e293b;
    color: #ffffff;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 9999;
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .skillbox-toast.show {
    transform: translateY(0);
    opacity: 1;
  }

  /* Pagination styles */
  .skillbox-page-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-weight: 600;
    font-size: 0.88rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .skillbox-page-btn:hover {
    border-color: #E2002B;
    color: #E2002B;
  }
  .skillbox-page-btn.active {
    background: #E2002B;
    border-color: #E2002B;
    color: #ffffff;
  }
</style>
@endpush

@section('contents')
<div class="bg-slate-50/60 min-h-screen pt-0 pb-16">

  <!-- ── Top Featured Banner (Full Width Screen Edge-to-Edge) ──────────────────────── -->
  <div class="w-full overflow-hidden mb-8">
    <img
      src="{{ asset('frontend/img/skillbox/skillbox_banner.png') }}"
      alt="SkillBox Hands-on Learning Kit"
      class="w-full h-auto max-h-[560px] object-cover block shadow-sm"
      onerror="this.onerror=null;this.src='https://pedaskills.com/static/media/skillBoxImg.54ef565f4b0836600035.png';"
    />
  </div>

  <div class="skillbox-page-wrap px-4 sm:px-6 lg:px-8">

    <!-- ── Filter & Search Control Bar ──────────────────────────────── -->
    <div class="skillbox-controls bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80">
      
      <!-- Search Input -->
      <div class="skillbox-search-wrap">
        <i class="fa-solid fa-magnifying-glass skillbox-search-icon"></i>
        <input
          type="text"
          id="productSearchInput"
          class="skillbox-search-input"
          placeholder="Search for products, kits, activities..."
          autocomplete="off"
        />
        <button id="clearSearchBtn" class="skillbox-clear-search" title="Clear search">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Category Selector Dropdown -->
      <div class="flex items-center gap-3">
        <select id="categoryFilter" class="skillbox-category-select">
          <option value="">All Categories</option>
          <option value="2">Activity Kits</option>
          <option value="7">Summer Camp</option>
          <option value="8">Annual Activity Kit</option>
        </select>
      </div>

      <!-- Actions: Wishlist & Cart -->
      <div class="skillbox-actions-grp ml-auto">
        <button id="wishlistHeaderBtn" class="skillbox-action-btn" title="View Wishlist">
          <i class="fa-solid fa-heart text-red-500 text-lg"></i>
          <span id="wishlistCountBadge" class="skillbox-badge">0</span>
        </button>

        <a href="{{ route('cart') }}" class="skillbox-action-btn" title="View Shopping Cart">
          <i class="fa-solid fa-cart-shopping text-slate-700 text-lg"></i>
          <span id="cartCountBadge" class="skillbox-badge">{{ Cart::content()->count() }}</span>
        </a>
      </div>

    </div>

    <!-- ── Products Grid Header ────────────────────────────────────── -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Available Learning Kits & Boxes</h2>
        <p class="text-sm text-slate-500 mt-0.5" id="productsCountText">Showing products</p>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sort by:</span>
        <select id="sortProducts" class="text-xs font-semibold bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 focus:outline-none focus:border-red-500">
          <option value="featured">Featured</option>
          <option value="price-asc">Price: Low to High</option>
          <option value="price-desc">Price: High to Low</option>
          <option value="name">Name (A-Z)</option>
        </select>
      </div>
    </div>

    <!-- ── Loading Skeleton ────────────────────────────────────────── -->
    <div id="productsLoading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
      @for ($i = 0; $i < 8; $i++)
      <div class="bg-white rounded-2xl p-4 border border-slate-200/60 animate-pulse flex flex-col gap-3">
        <div class="bg-slate-200 h-44 rounded-xl w-full"></div>
        <div class="bg-slate-200 h-4 rounded w-3/4"></div>
        <div class="bg-slate-200 h-3 rounded w-1/2"></div>
        <div class="flex justify-between items-center mt-auto pt-3 border-t border-slate-100">
          <div class="bg-slate-200 h-5 rounded w-1/3"></div>
          <div class="bg-slate-200 h-7 rounded w-1/4"></div>
        </div>
      </div>
      @endfor
    </div>

    <!-- ── Product Grid Container ──────────────────────────────────── -->
    <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12 hidden">
      <!-- Injected dynamically via JS -->
    </div>

    <!-- ── Empty State ─────────────────────────────────────────────── -->
    <div id="emptyState" class="hidden text-center py-16 px-4 bg-white rounded-2xl border border-slate-200/80 mb-12">
      <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
        <i class="fa-solid fa-box-open"></i>
      </div>
      <h3 class="text-lg font-bold text-slate-800">No Products Found</h3>
      <p class="text-sm text-slate-500 max-w-md mx-auto mt-1 mb-5">
        We couldn't find any products matching your selected search or category filters.
      </p>
      <button id="resetFiltersBtn" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-all">
        Clear All Filters
      </button>
    </div>

    <!-- ── Pagination Controls ─────────────────────────────────────── -->
    <div id="paginationWrap" class="flex justify-center items-center gap-2 mt-8 mb-16 hidden">
      <!-- Injected dynamically via JS -->
    </div>

  </div>

  <!-- ── Value Proposition & Benefits Section ──────────────────────── -->
  <section class="skillbox-benefits-section border-t border-slate-200 mt-8">
    <div class="skillbox-page-wrap px-4 sm:px-6 lg:px-8">
      
      <!-- Section Title Header -->
      <div class="text-center max-w-3xl mx-auto mb-14">
        <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-2">Our Comprehensive SkillBox Ecosystem</p>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
          Empowering Learners, Parents & Educators
        </h2>
        <p class="text-base text-slate-600">
          SkillBox integrates hands-on experiential materials, guided instruction, and collaborative activities aligned with modern NEP 2020 standards.
        </p>
      </div>

      <!-- 2 Major Benefit Pillars -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 relative">
        
        <!-- Left Pillar: For Children & Parents -->
        <div class="benefit-card benefit-card--blue">
          <div class="flex items-center gap-3 mb-6">
            <span class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-bold text-lg shadow-sm">1</span>
            <div>
              <h3 class="text-xl font-bold text-slate-900">Hands-on Experience & Family Engagement</h3>
              <p class="text-xs text-blue-700 font-medium">Transforming home and classroom environments</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <!-- For Children Subcard -->
            <div class="benefit-subcard">
              <img src="{{ asset('frontend/img/skillbox/forchildren.jpg') }}" alt="For Children" class="benefit-subcard__img" onerror="this.src='https://pedaskills.com/static/media/forchildren.cb0ca2e3ce3cfa06aa23.jpg';">
              <div class="benefit-subcard__header bg-blue-600">
                For Children
              </div>
              <div class="benefit-subcard__body">
                Engaging age-appropriate kits designed to develop critical problem-solving, sensory integration, robotics, and STEM curiosity.
              </div>
            </div>

            <!-- For Parents Subcard -->
            <div class="benefit-subcard">
              <img src="{{ asset('frontend/img/skillbox/forparent.jpg') }}" alt="For Parents" class="benefit-subcard__img" onerror="this.src='https://pedaskills.com/static/media/forparent.9d5f1719f115aa25a907.jpg';">
              <div class="benefit-subcard__header bg-amber-500">
                For Parents
              </div>
              <div class="benefit-subcard__body">
                Step-by-step guidance and parent-child collaborative milestones to track child cognitive growth without screen fatigue.
              </div>
            </div>

          </div>
        </div>

        <!-- Right Pillar: For School & Teachers -->
        <div class="benefit-card benefit-card--peach">
          <div class="flex items-center gap-3 mb-6">
            <span class="w-10 h-10 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">2</span>
            <div>
              <h3 class="text-xl font-bold text-slate-900">Institutional Curriculum & Educator Aids</h3>
              <p class="text-xs text-amber-800 font-medium">Structured NEP 2020 skill alignment for schools</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <!-- For School Subcard -->
            <div class="benefit-subcard">
              <img src="{{ asset('frontend/img/skillbox/preschool.jpg') }}" alt="For Preschools and Institutions" class="benefit-subcard__img" onerror="this.src='https://pedaskills.com/static/media/preschool.41c31751708329c32f36.jpg';">
              <div class="benefit-subcard__header bg-amber-600">
                For School
              </div>
              <div class="benefit-subcard__body">
                Turnkey activity boxes with complete semester mapping, material refills, assessment rubrics, and SAFAL/SQAAF compliance.
              </div>
            </div>

            <!-- For Teacher Subcard -->
            <div class="benefit-subcard">
              <img src="{{ asset('frontend/img/skillbox/forteacher.jpg') }}" alt="For Teachers" class="benefit-subcard__img" onerror="this.src='https://pedaskills.com/static/media/forteacher.957d27a152701bcfc948.jpg';">
              <div class="benefit-subcard__header bg-emerald-600">
                For Teacher
              </div>
              <div class="benefit-subcard__body">
                Ready-to-teach session manuals, flashcards, digital lesson blueprints, and master training support for seamless classroom execution.
              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- Inspirational Quote Bar -->
      <div class="mt-14 bg-gradient-to-r from-red-600 via-rose-600 to-amber-600 rounded-2xl p-8 sm:p-10 text-white shadow-xl text-center relative overflow-hidden">
        <div class="relative z-10 max-w-3xl mx-auto">
          <i class="fa-solid fa-quote-left text-3xl opacity-40 mb-3 block"></i>
          <p class="text-xl sm:text-2xl font-bold italic leading-relaxed mb-4">
            "Learning is not just about listening—it's about touching, making, exploring, and solving real challenges with hands-on joy."
          </p>
          <p class="text-xs uppercase tracking-widest text-red-100 font-semibold">— The SkillBox Philosophy</p>
        </div>
      </div>

    </div>
  </section>

</div>

<!-- ── Quick Toast Alert ───────────────────────────────────────────── -->
<div id="skillboxToast" class="skillbox-toast">
  <i id="toastIcon" class="fa-solid fa-circle-check text-emerald-400 text-xl"></i>
  <div>
    <h4 id="toastTitle" class="text-sm font-bold">Item Added</h4>
    <p id="toastMessage" class="text-xs text-slate-300">Action completed successfully.</p>
  </div>
</div>
@endsection

@push('scripts')
<script>
  (function() {
    'use strict';

    // App State
    let allProducts = [];
    let filteredProducts = [];
    let categories = [];
    let currentPage = 1;
    const perPage = 12;

    // Local Storage Wishlist State
    let wishlistIds = [];
    try {
      wishlistIds = JSON.parse(localStorage.getItem('skillbox_wishlist')) || [];
    } catch(e) {
      wishlistIds = [];
    }

    // DOM Elements
    const searchInput = document.getElementById('productSearchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortSelect = document.getElementById('sortProducts');
    const productsGrid = document.getElementById('productsGrid');
    const productsLoading = document.getElementById('productsLoading');
    const emptyState = document.getElementById('emptyState');
    const paginationWrap = document.getElementById('paginationWrap');
    const productsCountText = document.getElementById('productsCountText');
    const wishlistCountBadge = document.getElementById('wishlistCountBadge');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');
    const toast = document.getElementById('skillboxToast');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');

    // Update Wishlist Badge
    function updateWishlistBadge() {
      if (wishlistCountBadge) {
        wishlistCountBadge.textContent = wishlistIds.length;
      }
    }

    // Show Toast
    function showToast(title, message, isSuccess = true) {
      if (!toast) return;
      toastTitle.textContent = title;
      toastMessage.textContent = message;
      toastIcon.className = isSuccess 
        ? "fa-solid fa-circle-check text-emerald-400 text-xl" 
        : "fa-solid fa-heart text-red-400 text-xl";
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3500);
    }

    // Fetch Categories
    async function loadCategories() {
      try {
        const res = await fetch('/api/shop-categories');
        const json = await res.json();
        if (json && json.data && json.data.length > 0) {
          categories = json.data;
          categoryFilter.innerHTML = '<option value="">All Categories</option>' + 
            categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
        }
      } catch (err) {
        console.error('Error fetching categories:', err);
      }
    }

    // Fetch Products
    async function loadProducts() {
      productsLoading.classList.remove('hidden');
      productsGrid.classList.add('hidden');
      emptyState.classList.add('hidden');
      paginationWrap.classList.add('hidden');

      try {
        const res = await fetch('/api/shop-products');
        const json = await res.json();
        allProducts = json.data || [];
        applyFilters();
      } catch (err) {
        console.error('Error loading products:', err);
        allProducts = [];
        applyFilters();
      } finally {
        productsLoading.classList.add('hidden');
      }
    }

    // Filter & Sort Products
    function applyFilters() {
      const query = (searchInput.value || '').trim().toLowerCase();
      const selectedCat = categoryFilter.value;
      const sortBy = sortSelect.value;

      filteredProducts = allProducts.filter(item => {
        const title = (item.title || item.course_name || '').toLowerCase();
        const tags = (item.tags || '').toLowerCase();
        const catId = String(item.category_id || '');

        const matchesQuery = !query || title.includes(query) || tags.includes(query);
        const matchesCategory = !selectedCat || catId === selectedCat;

        return matchesQuery && matchesCategory;
      });

      // Sorting
      if (sortBy === 'price-asc') {
        filteredProducts.sort((a, b) => Number(a.price_discounted || a.price || 0) - Number(b.price_discounted || b.price || 0));
      } else if (sortBy === 'price-desc') {
        filteredProducts.sort((a, b) => Number(b.price_discounted || b.price || 0) - Number(a.price_discounted || a.price || 0));
      } else if (sortBy === 'name') {
        filteredProducts.sort((a, b) => (a.title || '').localeCompare(b.title || ''));
      }

      currentPage = 1;
      renderProducts();
    }

    // Render Products Grid & Pagination
    function renderProducts() {
      const total = filteredProducts.length;
      productsCountText.textContent = `Showing ${total} ${total === 1 ? 'product' : 'products'}`;

      if (total === 0) {
        productsGrid.classList.add('hidden');
        emptyState.classList.remove('hidden');
        paginationWrap.classList.add('hidden');
        return;
      }

      emptyState.classList.add('hidden');
      productsGrid.classList.remove('hidden');

      // Paginate
      const totalPages = Math.ceil(total / perPage);
      const startIdx = (currentPage - 1) * perPage;
      const paginatedItems = filteredProducts.slice(startIdx, startIdx + perPage);

      // Render Cards
      productsGrid.innerHTML = paginatedItems.map(item => {
        const id = item.id;
        const title = item.title || item.course_name || 'Activity Kit';
        const price = Number(item.price || 0);
        const discounted = Number(item.price_discounted || price);
        const hasDiscount = discounted < price;
        const image = item.image || item.image_small || 'https://pedaskills.com/static/media/skillBoxImg.54ef565f4b0836600035.png';
        const isWishlisted = wishlistIds.includes(Number(id));
        const rating = Number(item.rating || 5);

        return `
          <div class="skillbox-card">
            <div class="skillbox-card__img-box" onclick="window.location.href='/ProductDetails/${id}'">
              <img src="${image}" alt="${title}" class="skillbox-card__img" loading="lazy" onerror="this.onerror=null;this.src='https://pedaskills.com/static/media/skillBoxImg.54ef565f4b0836600035.png';" />
              <button 
                class="skillbox-card__wish-btn ${isWishlisted ? 'active' : ''}" 
                onclick="event.stopPropagation(); window.toggleWishlist(${id}, '${title.replace(/'/g, "\\'")}')"
                title="${isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist'}"
              >
                <i class="fa-solid fa-heart ${isWishlisted ? 'text-red-500' : ''}"></i>
              </button>
            </div>

            <div class="skillbox-card__body" onclick="window.location.href='/ProductDetails/${id}'" style="cursor: pointer;">
              <h3 class="skillbox-card__title" title="${title}">${title}</h3>
              
              <div class="skillbox-card__stars">
                ${Array(5).fill(0).map((_, idx) => `<i class="fa-solid fa-star ${idx < Math.round(rating) ? 'text-amber-400' : 'text-slate-200'}"></i>`).join('')}
                <span class="text-xs text-slate-400 ml-1.5">(4.9)</span>
              </div>

              <div class="skillbox-card__price-row">
                <div class="flex items-baseline">
                  <span class="skillbox-card__price">₹ ${discounted.toLocaleString('en-IN')}</span>
                  ${hasDiscount ? `<span class="skillbox-card__old-price">₹ ${price.toLocaleString('en-IN')}</span>` : ''}
                </div>
                <button 
                  class="skillbox-card__btn" 
                  onclick="window.quickAddToCart(${id}, '${title.replace(/'/g, "\\'")}', ${discounted})"
                >
                  <i class="fa-solid fa-cart-plus mr-1.5"></i> Order
                </button>
              </div>
            </div>
          </div>
        `;
      }).join('');

      // Render Pagination Controls
      if (totalPages > 1) {
        paginationWrap.classList.remove('hidden');
        let btns = '';

        if (currentPage > 1) {
          btns += `<button class="skillbox-page-btn" onclick="window.changePage(${currentPage - 1})"><i class="fa-solid fa-chevron-left"></i></button>`;
        }

        for (let p = 1; p <= totalPages; p++) {
          btns += `<button class="skillbox-page-btn ${p === currentPage ? 'active' : ''}" onclick="window.changePage(${p})">${p}</button>`;
        }

        if (currentPage < totalPages) {
          btns += `<button class="skillbox-page-btn" onclick="window.changePage(${currentPage + 1})"><i class="fa-solid fa-chevron-right"></i></button>`;
        }

        paginationWrap.innerHTML = btns;
      } else {
        paginationWrap.classList.add('hidden');
      }
    }

    // Global Handlers
    window.changePage = function(p) {
      currentPage = p;
      renderProducts();
      window.scrollTo({ top: document.getElementById('productsGrid').offsetTop - 120, behavior: 'smooth' });
    };

    window.toggleWishlist = function(id, title) {
      const numId = Number(id);
      const idx = wishlistIds.indexOf(numId);
      if (idx > -1) {
        wishlistIds.splice(idx, 1);
        showToast('Removed from Wishlist', `${title} removed.`, false);
      } else {
        wishlistIds.push(numId);
        showToast('Added to Wishlist', `${title} saved to your favorites.`, true);
      }
      localStorage.setItem('skillbox_wishlist', JSON.stringify(wishlistIds));
      updateWishlistBadge();
      renderProducts();
    };

    window.quickAddToCart = function(id, title, price) {
      showToast('Added to Cart', `${title} (₹${price}) has been added.`, true);
      const badge = document.getElementById('cartCountBadge');
      if (badge) {
        const cur = parseInt(badge.textContent || '0', 10);
        badge.textContent = cur + 1;
      }
    };

    // Event Listeners
    searchInput.addEventListener('input', function() {
      clearSearchBtn.style.display = this.value ? 'block' : 'none';
      applyFilters();
    });

    clearSearchBtn.addEventListener('click', function() {
      searchInput.value = '';
      this.style.display = 'none';
      applyFilters();
    });

    categoryFilter.addEventListener('change', applyFilters);
    sortSelect.addEventListener('change', applyFilters);

    resetFiltersBtn.addEventListener('click', function() {
      searchInput.value = '';
      clearSearchBtn.style.display = 'none';
      categoryFilter.value = '';
      sortSelect.value = 'featured';
      applyFilters();
    });

    document.getElementById('wishlistHeaderBtn')?.addEventListener('click', function() {
      if (wishlistIds.length === 0) {
        showToast('Your Wishlist is Empty', 'Browse products and tap the heart icon to add favorites.', false);
      } else {
        showToast('Wishlist', `You have ${wishlistIds.length} item(s) in your wishlist.`, true);
      }
    });

    // Initial Load
    updateWishlistBadge();
    loadCategories();
    loadProducts();

  })();
</script>
@endpush
