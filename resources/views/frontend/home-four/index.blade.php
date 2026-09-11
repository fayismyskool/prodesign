@extends('frontend.home-four.layouts.master')

@section('meta_title', "Home — " . config('app.name', 'Skillvation'))
@section('meta_description', "The Global Skills Academy is dedicated to addressing labour skills gaps and empowering individuals for a future-ready workforce.")

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
  :root {
    --unesco-blue: #0077d4;
    --unesco-dark-blue: #0056b3;
    --unesco-navy: #0b2545;
    --unesco-bg-light: #f5f7fa;
    --unesco-border: #e2e8f0;
    --unesco-text-main: #1a202c;
    --unesco-text-muted: #4a5568;
    --unesco-card-stem: #0c4980;
    --unesco-card-green: #5a7722;
    --unesco-card-informal: #802330;
    --unesco-card-gender: #9b6215;
  }

  .unesco-gsa-page {
    color: var(--unesco-text-main);
    background-color: #ffffff;
    font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 17px;
    line-height: 1.7;
  }

  .unesco-gsa-page h1,
  .unesco-gsa-page h2,
  .unesco-gsa-page h3,
  .unesco-gsa-page h4 {
    color: var(--unesco-text-main);
    font-weight: 700;
    line-height: 1.25;
    margin-top: 0;
  }

  .unesco-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* ── Hero Banner ─────────────────────────────────── */
  .unesco-hero-banner {
    background: linear-gradient(135deg, #0b2545 0%, #0077d4 100%);
    color: #ffffff;
    padding: 60px 0;
  }
  .unesco-hero-banner h1 {
    color: #ffffff;
    font-size: clamp(34px, 4.5vw, 52px);
    margin-bottom: 12px;
  }
  .unesco-hero-banner p {
    font-size: 20px;
    color: #e2e8f0;
    margin: 0;
    max-width: 800px;
  }

  /* ── Pill Buttons ─────────────────────────────────── */
  .unesco-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background-color: var(--unesco-blue);
    color: #ffffff !important;
    padding: 12px 26px;
    border-radius: 9999px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(0, 119, 212, 0.25);
    border: none;
    cursor: pointer;
  }
  .unesco-pill-btn:hover {
    background-color: var(--unesco-dark-blue);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 119, 212, 0.35);
  }
  .unesco-pill-btn i {
    font-size: 13px;
    transition: transform 0.2s ease;
  }
  .unesco-pill-btn:hover i {
    transform: translateX(3px);
  }

  /* ── Sections Layout ─────────────────────────────── */
  .unesco-section {
    padding: 65px 0;
    border-bottom: 1px solid #edf2f7;
  }
  .unesco-section.no-border {
    border-bottom: none;
  }
  .unesco-section.bg-light {
    background-color: var(--unesco-bg-light);
  }

  .unesco-grid-2col {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: center;
  }
  .unesco-grid-2col.equal {
    grid-template-columns: 1fr 1fr;
  }

  /* ── Video / Media Cards ─────────────────────────── */
  .unesco-media-card {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    background: #000;
  }
  .unesco-media-card img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }
  .unesco-media-card:hover img {
    transform: scale(1.03);
  }
  .unesco-media-caption {
    font-size: 12px;
    color: #718096;
    margin-top: 8px;
    text-align: right;
  }
  .unesco-play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 68px;
    height: 68px;
    background-color: var(--unesco-blue);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease;
    text-decoration: none;
  }
  .unesco-media-card:hover .unesco-play-btn {
    transform: translate(-50%, -50%) scale(1.1);
    background-color: #ffffff;
    color: var(--unesco-blue);
  }

  /* ── 4 Color Stat Cards ──────────────────────────── */
  .unesco-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin: 40px 0;
  }
  .unesco-stat-card {
    padding: 32px 24px;
    border-radius: 4px;
    color: #ffffff;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    min-height: 220px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }
  .unesco-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
    color: #ffffff !important;
  }
  .unesco-stat-card .stat-title {
    font-size: 26px;
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: 12px;
    color: #ffffff;
  }
  .unesco-stat-card .stat-desc {
    font-size: 15px;
    line-height: 1.5;
    color: rgba(255, 255, 255, 0.92);
  }

  .stat-card-stem { background-color: var(--unesco-card-stem); }
  .stat-card-green { background-color: var(--unesco-card-green); }
  .stat-card-informal { background-color: var(--unesco-card-informal); }
  .stat-card-gender { background-color: var(--unesco-card-gender); }

  /* ── Split Training Banner ───────────────────────── */
  .unesco-split-banner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: #0077d4;
    color: #ffffff;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 50px;
  }
  .unesco-split-banner-left {
    padding: 50px 45px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
    margin: 20px;
    border-radius: 2px;
  }
  .unesco-split-banner-left h2 {
    color: #ffffff;
    font-size: 36px;
    margin-bottom: 16px;
  }
  .unesco-split-banner-left p {
    font-size: 18px;
    color: #e2e8f0;
    margin: 0;
  }
  .unesco-split-banner-right img {
    width: 100%;
    height: 100%;
    min-height: 320px;
    object-fit: cover;
  }

  /* ── Partner Lists ───────────────────────────────── */
  .unesco-partner-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
    padding: 0;
    list-style: none;
  }
  .unesco-partner-pills li a {
    display: inline-block;
    padding: 6px 14px;
    background: #e8f3fc;
    color: var(--unesco-blue);
    font-weight: 600;
    font-size: 14px;
    border-radius: 4px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .unesco-partner-pills li a:hover {
    background: var(--unesco-blue);
    color: #ffffff;
  }
  .unesco-partner-pills li span {
    display: inline-block;
    padding: 6px 14px;
    background: #edf2f7;
    color: var(--unesco-text-muted);
    font-weight: 600;
    font-size: 14px;
    border-radius: 4px;
  }

  /* ── Quotes ──────────────────────────────────────── */
  .unesco-quote-box {
    margin: 40px 0;
    padding: 30px 36px;
    background: #f7fafc;
    border-left: 5px solid var(--unesco-blue);
    border-radius: 0 8px 8px 0;
  }
  .unesco-quote-box p {
    font-size: 18px;
    font-style: italic;
    color: #2d3748;
    margin: 0 0 12px;
    line-height: 1.65;
  }
  .unesco-quote-box cite {
    font-size: 14px;
    font-weight: 700;
    color: var(--unesco-blue);
    font-style: normal;
  }

  /* ── GSA Mission in Figures Cards ────────────────── */
  .unesco-figures-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-top: 32px;
  }
  .unesco-figure-card {
    background-color: #f1f4f6;
    padding: 36px 28px;
    border-radius: 8px;
    min-height: 380px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    border: none;
    box-shadow: none;
    text-align: left;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }
  .unesco-figure-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
  }
  .unesco-figure-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 28px;
    flex-shrink: 0;
  }
  .unesco-figure-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }
  .unesco-figure-number {
    font-size: 44px;
    font-weight: 700;
    color: #212121;
    line-height: 1.1;
    margin-bottom: 8px;
  }
  .unesco-figure-label {
    font-size: 18px;
    font-weight: 600;
    color: #212121;
    line-height: 1.3;
    text-transform: none;
    letter-spacing: normal;
  }
  .unesco-figure-subtext {
    font-size: 16px;
    font-weight: 400;
    color: #212121;
    margin-top: 6px;
    line-height: 1.4;
  }

  /* ── Regional Statistics ─────────────────────────── */
  .unesco-regional-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-top: 36px;
  }
  .unesco-regional-card {
    background: #ffffff;
    border: 1px solid var(--unesco-border);
    border-top: 4px solid var(--unesco-blue);
    padding: 28px;
    border-radius: 4px;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s ease;
  }
  .unesco-regional-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
    color: inherit;
  }
  .unesco-regional-card h3 {
    font-size: 20px;
    color: var(--unesco-blue);
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .unesco-regional-card p {
    font-size: 15px;
    color: var(--unesco-text-muted);
    margin: 0;
  }

  /* ── News Cards ──────────────────────────────────── */
  .unesco-news-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-top: 40px;
  }
  .unesco-news-card {
    background: #ffffff;
    border: 1px solid var(--unesco-border);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s ease;
  }
  .unesco-news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
    color: inherit;
  }
  .unesco-news-content {
    padding: 22px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    justify-content: space-between;
  }
  .unesco-news-tag {
    color: var(--unesco-blue);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 10px;
  }
  .unesco-news-title {
    font-size: 16px;
    font-weight: 700;
    line-height: 1.45;
    color: var(--unesco-text-main);
    margin: 0 0 16px;
  }
  .unesco-news-date {
    font-size: 13px;
    color: #a0aec0;
    font-weight: 500;
  }

  /* ── Global Coalition Footer Block ────────────────── */
  .unesco-coalition-block {
    background: var(--unesco-navy);
    color: #ffffff;
    padding: 60px 0;
  }
  .unesco-coalition-block h2 {
    color: #ffffff;
    font-size: 34px;
    margin-bottom: 16px;
  }
  .unesco-coalition-block p {
    color: #cbd5e0;
    font-size: 17px;
    max-width: 600px;
  }
  .unesco-social-links {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 24px;
  }
  .unesco-social-links a {
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    padding: 6px 14px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 4px;
    transition: all 0.2s ease;
  }
  .unesco-social-links a:hover {
    background-color: var(--unesco-blue);
    border-color: var(--unesco-blue);
    color: #ffffff;
  }

  /* ── Responsive Queries ──────────────────────────── */
  @media (max-width: 992px) {
    .unesco-grid-2col,
    .unesco-grid-2col.equal {
      grid-template-columns: 1fr;
      gap: 36px;
    }
    .unesco-stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    .unesco-split-banner {
      grid-template-columns: 1fr;
    }
    .unesco-figures-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    .unesco-regional-grid {
      grid-template-columns: 1fr;
    }
    .unesco-news-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 600px) {
    .unesco-stats-grid,
    .unesco-figures-grid,
    .unesco-news-grid {
      grid-template-columns: 1fr;
    }
    .unesco-split-banner-left {
      padding: 30px 20px;
      margin: 10px;
    }
  }
</style>
@endpush

@section('contents')
<div class="unesco-gsa-page">

  <!-- 1. Hero Title Banner -->
  <section class="unesco-hero-banner">
    <div class="unesco-container">
      <h1>UNESCO's Global Skills Academy</h1>
      <p>Empowering youth and adults for the future of work</p>
    </div>
  </section>

  <!-- 2. Intro Section with Video Feature -->
  <section class="unesco-section">
    <div class="unesco-container">
      <div class="unesco-grid-2col">
        <div>
          <p>
            The Global Skills Academy (GSA) is an initiative dedicated to addressing the pressing labour skills gaps and empowering individuals for a future-ready workforce. Under the umbrella of <a href="https://www.unesco.org/en/global-education-coalition" target="_blank" rel="noopener" class="text-blue-600 underline font-semibold">UNESCO Global Education Coalition</a> and in line with <a href="https://unesdoc.unesco.org/ark:/48223/pf0000383360" target="_blank" rel="noopener" class="text-blue-600 underline font-semibold">UNESCO Strategy for Technical and Vocational Education and Training (TVET)</a>, the GSA is committed to supporting ten million youth and adults globally in building essential skills for improved employability by 2029.
          </p>
          <p class="mt-4">
            The GSA focuses on empowering learners with key skills, including digital literacy, entrepreneurial skills, and green technologies. These skills are crucial for navigating the rapidly evolving job market driven by technological, economic, and societal transformations.
          </p>
        </div>
        
        <div>
          <div class="unesco-media-card">
            <img src="https://www.unesco.org/sites/default/files/styles/banner_tablet/public/2024-04/global-skills-academy.jpg.webp?itok=u0wH1aKC" alt="Global Skills Academy Mission">
            <a href="https://www.youtube.com/watch?v=pRSPI0cEXnE" target="_blank" rel="noopener" class="unesco-play-btn" aria-label="Play GSA Mission Video">
              <i class="fa-solid fa-play"></i>
            </a>
          </div>
          <div class="unesco-media-caption">© UNESCO</div>
        </div>
      </div>

      <div class="mt-8">
        <p>
          To achieve this goal, the GSA leverages strategic partnerships and mobilizes 230 TVET institutions across 150 countries through the UNESCO and <a href="https://unevoc.unesco.org/home/fwd2About+the+UNEVOC+Network" target="_blank" rel="noopener" class="text-blue-600 underline font-semibold">UNEVOC networks</a>. By analyzing the evolving labour market’s skills supply and demand, the GSA offers free training and mentorship programs. These programs empower learners with in-demand skills, including digital literacy and skills, green technologies, and entrepreneurial capabilities.
        </p>
        <p class="mt-3">
          The GSA is dedicated to bridging this skills gap and empowering individuals to thrive in our 21st-century economy.
        </p>
      </div>
    </div>
  </section>

  <!-- 3. Skills for the Future Global Platform -->
  <section class="unesco-section bg-light">
    <div class="unesco-container">
      <div class="unesco-grid-2col">
        <div>
          <h2 class="text-3xl font-bold mb-4">Skills for the Future Global Platform</h2>
          <p>
            The <a href="https://www.unesco.org/en/global-education-coalition/skills-academy/skills-future?hub=182955" target="_blank" rel="noopener" class="text-blue-600 underline font-semibold">Skills for the Future platform</a> is an open-access global hub convened by UNESCO’s Global Skills Academy, in collaboration with KPMG International. The platform empowers businesses, civil society, and youth to scale up impact, foster inclusive partnerships, and accelerate progress toward SDG 4 on Quality Education. By connecting initiatives and amplifying collective action, it aims to build a more inclusive, resilient, and future-ready generation.
          </p>
          <p class="font-bold text-gray-900 mt-4 mb-6">
            Become part of a global movement to equip young people for the future of work!
          </p>
          <a href="https://www.unesco.org/en/global-education-coalition/skills-academy/skills-future" target="_blank" rel="noopener" class="unesco-pill-btn">
            <span>Explore existing skills initiatives and share your initiatives</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>

        <div>
          <div class="unesco-media-card">
            <img src="https://www.unesco.org/sites/default/files/styles/split_tablet/public/2024-05/global-skills-academy-opportunities.jpg.webp?itok=5GfJn6uJ" alt="Skills for the Future Global Platform">
            <a href="https://www.youtube.com/watch?v=ItnwUnRESUc" target="_blank" rel="noopener" class="unesco-play-btn" aria-label="Play Skills Platform Video">
              <i class="fa-solid fa-play"></i>
            </a>
          </div>
          <div class="unesco-media-caption">© UNESCO</div>
        </div>
      </div>

      <!-- 4 Colored Stat Cards -->
      <div class="unesco-stats-grid">
        <a href="https://unesdoc.unesco.org/ark:/48223/pf0000389406" target="_blank" rel="noopener" class="unesco-stat-card stat-card-stem">
          <div class="stat-title">Only 1 in 4</div>
          <div class="stat-desc">employees in STEM is a woman</div>
        </a>

        <a href="https://economicgraph.linkedin.com/en-us/research/global-green-skills-report" target="_blank" rel="noopener" class="unesco-stat-card stat-card-green">
          <div class="stat-title">Only 12%</div>
          <div class="stat-desc">of jobs have green skills, while 22 % of job postings require at least one green skill</div>
        </a>

        <a href="https://unevoc.unesco.org/up/Supporting_Education_and_Skills_Development_Systems_for_Informal_Workers_Recovery_After_the_Pandemic.pdf" target="_blank" rel="noopener" class="unesco-stat-card stat-card-informal">
          <div class="stat-title">58%</div>
          <div class="stat-desc">of global workers are still in informal employment</div>
        </a>

        <a href="https://www.itu.int/en/mediacentre/backgrounders/Pages/bridging-the-gender-divide.aspx" target="_blank" rel="noopener" class="unesco-stat-card stat-card-gender">
          <div class="stat-title">Gender gap</div>
          <div class="stat-desc">in digital access and divide is the biggest obstacle for development for skills for the future</div>
        </a>
      </div>

      <div class="space-y-4 text-gray-700">
        <p>
          Globally, one out of five individuals aged 15-34 remain disengaged from education, employment, or training (<a href="https://www.ilo.org/global/research/global-reports/weso/WCMS_865332/lang--en/index.htm" target="_blank" rel="noopener" class="text-blue-600 underline font-medium">International Labour Organization <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i></a>). That translates to 360 million young individuals seeking opportunities to build a brighter future through quality education, training and employment opportunities.
        </p>
        <p>
          The rapid pace of technological, economic, and societal transformations compounds this issue. Recent reports from the World Economic Forum indicate that 43% of business tasks are expected to be automated by 2027. This suggests the need for widespread reskilling (the process of acquiring new skills or knowledge to perform a different job or task) or upskilling initiatives to ensure employees globally can navigate the changing demands of the labour market (<a href="https://www.weforum.org/publications/the-future-of-jobs-report-2025/" target="_blank" rel="noopener" class="text-blue-600 underline font-medium">World’s Economic Forum “ Futures of Jobs” Report <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i></a>).
        </p>
      </div>
    </div>
  </section>

  <!-- 4. AI EmpowerED Section -->
  <section class="unesco-section">
    <div class="unesco-container">
      <div class="unesco-grid-2col">
        <div>
          <h2 class="text-3xl font-bold mb-4">AI EmpowerED: Equipping teachers and learners for an AI-driven future</h2>
          <p>
            Through UNESCO’s Global Skills Academy, in partnership with Microsoft Elevate, KPMG International and Tablet Academy, AI EmpowerED supports TVET systems to equip educators and learners with practical and responsible AI skills for the future of work. By combining together global partnerships, national training networks and certification pathways, the programme expands access to AI learning at scale – empowering teachers to drive change in the classroom and enabling learners to develop the digital competencies needed to succeed in tomorrow’s economies.
          </p>
          <p class="font-bold text-gray-900 mt-4 mb-6">
            Discover how AI-empowered skills are creating new pathways to inclusion, innovation, and employability worldwide.
          </p>
          <a href="https://www.unesco.org/en/global-education-coalition/skills-academy/ai-empowered-ed?hub=182955" target="_blank" rel="noopener" class="unesco-pill-btn">
            <span>Learn more</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>

        <div>
          <div class="unesco-media-card">
            <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2026-07/ai-empowered-2.JPG?itok=gTcKy0mc" alt="AI EmpowerED Learning Session">
          </div>
          <div class="unesco-media-caption">© Tablet Academy</div>
        </div>
      </div>

      <!-- Quote -->
      <div class="unesco-quote-box">
        <p>“I need to train in entrepreneurship and digital marketing. This way, I will be able to compete in the job market or start my own business.”</p>
        <cite>Jules Beugré Djoman, GSA student, Côte d'Ivoire</cite>
      </div>
    </div>
  </section>

  <!-- 5. Our Training Opportunities (Split Banner + 4 Tracks) -->
  <section class="unesco-section bg-light" id="training-opportunities">
    <div class="unesco-container">
      
      <!-- Split Blue Hero Block -->
      <div class="unesco-split-banner">
        <div class="unesco-split-banner-left">
          <h2>Our training opportunities</h2>
          <p>Explore our partners' free, certifiable training opportunities in digital, green, entrepreneurial skills and career-oriented mentorship programs.</p>
        </div>
        <div class="unesco-split-banner-right">
          <img src="https://www.unesco.org/sites/default/files/styles/split_tablet/public/2024-05/global-skills-academy-opportunities.jpg.webp?itok=5GfJn6uJ" alt="Training Opportunities">
        </div>
      </div>

      <!-- Track 1: Digital Skills -->
      <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="unesco-grid-2col">
          <div>
            <h2 class="text-2xl font-bold mb-3 text-blue-900">Digital skills</h2>
            <p class="text-gray-700 mb-4">
              Digital competence receives a growing demand, with more than 75% of companies looking to adopt digital technologies such as big data, cloud computing and artificial intelligence, and 86% of companies incorporating digital platforms in their digital marketing strategies in the next five years (<a href="https://www.weforum.org/publications/the-future-of-jobs-report-2023/digest/" target="_blank" rel="noopener" class="text-blue-600 underline">The Future of Jobs Report 2023</a>).
            </p>
            <p class="font-semibold text-gray-800 mb-2">Access free, certifiable digital literacy and skills training with our partners:</p>
            <ul class="unesco-partner-pills">
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/aleph" target="_blank">Aleph Inc.</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/anthology" target="_blank">Anthology</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/china-pocy" target="_blank">China POCY Group</a></li>
              <li><span>Cisco</span></li>
              <li><span>Coursera</span></li>
              <li><span>Fundación Telefónica</span></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/giz-atingi" target="_blank">GIZ-atingi</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/huawei" target="_blank">Huawei</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/ibm" target="_blank">IBM</a></li>
              <li><span>ITU</span></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/ai-empowered-ed" target="_blank">Microsoft</a></li>
              <li><span>Orange</span></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/outsystems" target="_blank">Outsystems</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/pix" target="_blank">Pix</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/technovation" target="_blank">Technovation</a></li>
            </ul>
          </div>
          <div>
            <div class="unesco-media-card">
              <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2024-04/global-skills-academy-digital.jpg.webp?itok=nU_r_Oc7" alt="Digital Skills Training">
            </div>
            <div class="unesco-media-caption">© UNESCO</div>
          </div>
        </div>
      </div>

      <!-- Track 2: Green Skills -->
      <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="unesco-grid-2col">
          <div>
            <h2 class="text-2xl font-bold mb-3 text-green-900">Green skills</h2>
            <p class="text-gray-700 mb-4">
              Green expertise is hired 1.19x more, and demand for green and sustainability skills has grown by more than 60% since 2016 in economies like sustainable fashion, environmental services and renewable energy. Projection shows demand will outstrip supply in 5 years' time, emphasizing the critical need for green skills development (<a href="https://economicgraph.linkedin.com/research/global-green-skills-report" target="_blank" rel="noopener" class="text-blue-600 underline">Global Green Skills Report 2023</a>).
            </p>
            <p class="font-semibold text-gray-800 mb-2">Access free, certifiable green and sustainability skills training with our partners:</p>
            <ul class="unesco-partner-pills">
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/festo" target="_blank">FESTO</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/giz-atingi" target="_blank">GIZ-atingi</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/ibm" target="_blank">IBM</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/siemens-stiftung" target="_blank">Siemens Stiftung</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/skilled" target="_blank">SkillEd</a></li>
              <li><span>WHO Academy</span></li>
            </ul>
          </div>
          <div>
            <div class="unesco-media-card">
              <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2024-04/global-skills-academy-green.jpg.webp?itok=6NYmTPp0" alt="Green Skills Training">
            </div>
            <div class="unesco-media-caption">© UNESCO</div>
          </div>
        </div>
      </div>

      <!-- Track 3: Entrepreneurial Skills -->
      <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="unesco-grid-2col">
          <div>
            <h2 class="text-2xl font-bold mb-3 text-red-900">Entrepreneurial skills</h2>
            <p class="text-gray-700 mb-4">
              Entrepreneurial and transversal skills can boost careers by developing empathy, agility and readiness to learn, improving communication and project management, identifying opportunities and building leadership.
            </p>
            <p class="font-semibold text-gray-800 mb-2">Access free, certifiable entrepreneurial and transversal skills training with our partners:</p>
            <ul class="unesco-partner-pills">
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/generation-global" target="_blank">Generation Global</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/giz-atingi" target="_blank">GIZ-atingi</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/hp" target="_blank">HP LIFE</a></li>
            </ul>
          </div>
          <div>
            <div class="unesco-media-card">
              <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2024-04/global-skills-academy-entrepreneurial.jpg.webp?itok=6tZLaLrK" alt="Entrepreneurial Skills Training">
            </div>
            <div class="unesco-media-caption">© UNESCO</div>
          </div>
        </div>
      </div>

      <!-- Track 4: Mentorship Programmes -->
      <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="unesco-grid-2col">
          <div>
            <h2 class="text-2xl font-bold mb-3 text-amber-900">Mentorship programmes</h2>
            <p class="text-gray-700 mb-4">
              Mentorship programs provide each mentee a unique experience through a dedicated mentor from industry, providing insights and experience about study and personal development, giving guidance in career planning and advancement, opening doors for potential job opportunities.
            </p>
            <p class="font-semibold text-gray-800 mb-2">Enroll in free mentorship programs with our partners:</p>
            <ul class="unesco-partner-pills">
              <li><span>DIOR</span></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/kpmg" target="_blank">KPMG</a></li>
              <li><a href="https://www.unesco.org/en/global-education-coalition/skills-academy/ja-americas" target="_blank">Junior Achievement Americas</a></li>
            </ul>
          </div>
          <div>
            <div class="unesco-media-card">
              <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2024-04/global-skills-academy-mentorship.jpg.webp?itok=1JonceNt" alt="Mentorship Programmes">
            </div>
            <div class="unesco-media-caption">© UNESCO</div>
          </div>
        </div>

        <div class="unesco-quote-box mt-6">
          <p>“I'd say that UNESCO is doing a great job in bridging the gap between students and quality education in developing countries. The Global Skills Academy Initiative has also exposed students like me to experience a new way, the digital way, of enjoying quality education.”</p>
          <cite>Tolulope Omoyeni, Women@DIOR Nigeria</cite>
        </div>
      </div>

    </div>
  </section>

  <!-- 6. Our Working Model -->
  <section class="unesco-section">
    <div class="unesco-container">
      <div class="unesco-grid-2col">
        <div>
          <h2 class="text-3xl font-bold mb-4">Our working model</h2>
          <p class="text-gray-700 mb-4">
            Partnerships sit at the heart of the Global Skills Academy’s (GSA) success. The GSA leverages multi-stakeholder partnerships and mobilizes over 230 Technical and Vocational Education and Training institutions across 150 countries through UNESCO and the UNEVOC Network.
          </p>
          <p class="font-semibold text-gray-800 mb-2">The GSA connects:</p>
          <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
            <li>Member States</li>
            <li>institutions</li>
            <li>individual learners</li>
          </ul>
          <p class="text-gray-700">
            to a wide range of training programs offered by UNESCO’s Global Education Coalition partners. This expansive network enables GSA to reach learners worldwide, ensuring that no one is left behind in accessing quality training.
          </p>
        </div>

        <div>
          <div class="unesco-media-card bg-white p-4 border border-gray-200">
            <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2025-02/gsa-working-model.jpg.webp?itok=I9GRnb5g" alt="UNESCO GSA Working Model" style="object-fit: contain;">
          </div>
          <div class="unesco-media-caption">© UNESCO</div>
        </div>
      </div>
    </div>
  </section>

  <!-- 7. GSA Mission in Figures -->
  <section class="unesco-section">
    <div class="unesco-container">
      <h2 class="text-3xl font-bold mb-6 text-gray-900">GSA mission in figures</h2>
      
      <div class="unesco-figures-grid">
        <!-- Card 1: 25 partners -->
        <div class="unesco-figure-card">
          <div class="unesco-figure-circle">
            <img src="https://www.unesco.org/sites/default/files/styles/square_120/public/2022-10/NGO%20partnership%20hero%20image.jpg.webp?itok=AIhaldR9" alt="25 Partners">
          </div>
          <div class="unesco-figure-number">25</div>
          <div class="unesco-figure-label">partners</div>
        </div>

        <!-- Card 2: 1+ million learners -->
        <div class="unesco-figure-card">
          <div class="unesco-figure-circle">
            <img src="https://www.unesco.org/sites/default/files/styles/square_120/public/2022-03/higher%20education%20main%20page.jpg.webp?itok=tlbFBvUW" alt="1+ Million Learners">
          </div>
          <div class="unesco-figure-number">1+ million</div>
          <div class="unesco-figure-label">learners</div>
        </div>

        <!-- Card 3: 170+ TVET institutions -->
        <div class="unesco-figure-card">
          <div class="unesco-figure-circle">
            <img src="https://www.unesco.org/sites/default/files/styles/square_120/public/2024-04/global-skills-academy-impact-institutions.jpg.webp?itok=LOF40NAx" alt="170+ TVET institutions">
          </div>
          <div class="unesco-figure-number">170+</div>
          <div class="unesco-figure-label">TVET institutions</div>
          <div class="unesco-figure-subtext">mobilized across the world</div>
        </div>

        <!-- Card 4: 63 countries -->
        <div class="unesco-figure-card">
          <div class="unesco-figure-circle">
            <img src="https://www.unesco.org/sites/default/files/styles/square_120/public/2022-07/world-map.JPG?itok=6Y5Kudha" alt="63 Countries">
          </div>
          <div class="unesco-figure-number">63</div>
          <div class="unesco-figure-label">countries</div>
        </div>
      </div>
    </div>
  </section>

  <!-- 8. Regional Statistics -->
  <section class="unesco-section">
    <div class="unesco-container">
      <h2 class="text-3xl font-bold mb-2">Regional statistics</h2>
      <p class="text-gray-600 mb-6">Skills gaps look different around the world.</p>

      <div class="unesco-regional-grid">
        <a href="https://blogs.worldbank.org/en/nasikiliza/empowering-africa-s-youth--bridging-the-digital-skills-afe-gap" target="_blank" rel="noopener" class="unesco-regional-card">
          <h3><span>Africa</span> <i class="fa-solid fa-arrow-right text-sm"></i></h3>
          <p>230 million digital jobs will be created in Sub-Saharan Africa by 2030.</p>
        </a>

        <a href="https://impact.economist.com/perspectives/sites/default/files/bridging_the_skills_gap_fuelling_careers_and_the_economy_in_asia_pacific.pdf" target="_blank" rel="noopener" class="unesco-regional-card">
          <h3><span>Asia-Pacific</span> <i class="fa-solid fa-arrow-right text-sm"></i></h3>
          <p>86 million workers in Asia-Pacific require reskilling or upskilling to match the pace of technological change.</p>
        </a>

        <a href="https://www.ilo.org/resource/news/ilo-despite-lower-unemployment-rate-2023-recovery-labour-markets-latin" target="_blank" rel="noopener" class="unesco-regional-card">
          <h3><span>Latin America and Caribbean</span> <i class="fa-solid fa-arrow-right text-sm"></i></h3>
          <p>The unemployment rate for young people is 14%, more than double the overall rate of 6.5%.</p>
        </a>
      </div>

      <div class="unesco-quote-box mt-8">
        <p>“GSA is an amazing platform to unite many training and learning offerings that learners, educational institutions, education systems can choose from. HP is happy and proud to be able to contribute to this platform.”</p>
        <cite>Dr. Markus Schwertel, GSA Partner, Hewlett Packard</cite>
      </div>
    </div>
  </section>

  <!-- 9. Ready to make a positive impact? CTA -->
  <section class="unesco-section bg-light">
    <div class="unesco-container">
      <div class="unesco-grid-2col">
        <div>
          <h2 class="text-3xl font-bold mb-4">Ready to make a positive impact?</h2>
          <p class="text-gray-700 mb-6">
            Partnerships with organisations prepared to offer free training and skills development opportunities at scale are considered on a regular basis. For further discussion contact us at <a href="mailto:gsa@unesco.org" class="text-blue-600 font-semibold">gsa@unesco.org</a>.
          </p>
          <a href="mailto:gsa@unesco.org" class="unesco-pill-btn">
            <span>Contact us</span>
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
          </a>
        </div>

        <div>
          <div class="unesco-media-card bg-white p-4 border border-gray-200">
            <img src="https://www.unesco.org/sites/default/files/styles/paragraph_medium_tablet/public/2025-12/gsa-logos.png.webp?itok=qtvIx9k6" alt="UNESCO GSA Partner Logos" style="object-fit: contain;">
          </div>
          <div class="unesco-media-caption">© UNESCO</div>
        </div>
      </div>
    </div>
  </section>

  <!-- 10. News Section -->
  <section class="unesco-section">
    <div class="unesco-container">
      <h2 class="text-3xl font-bold mb-2">News</h2>
      <p class="text-gray-600">Latest updates from the Global Skills Academy network</p>

      <div class="unesco-news-grid">
        <a href="https://www.unesco.org/en/articles/china-southeast-asia-tvet-management-capacity-building-workshop-successfully-concluded" target="_blank" rel="noopener" class="unesco-news-card">
          <div class="unesco-news-content">
            <div>
              <div class="unesco-news-tag">News</div>
              <div class="unesco-news-title">China-Southeast Asia TVET Management Capacity Building Workshop Successfully Concluded</div>
            </div>
            <div class="unesco-news-date">3 July 2026</div>
          </div>
        </a>

        <a href="https://www.unesco.org/en/articles/unescos-global-skills-academy-expanding-digital-and-ai-skills-across-tvet-systems-kenya" target="_blank" rel="noopener" class="unesco-news-card">
          <div class="unesco-news-content">
            <div>
              <div class="unesco-news-tag">News</div>
              <div class="unesco-news-title">UNESCO's Global Skills Academy: expanding digital and AI skills across TVET systems in Kenya</div>
            </div>
            <div class="unesco-news-date">18 June 2026</div>
          </div>
        </a>

        <a href="https://www.unesco.org/en/articles/unescos-global-skills-academy-tesda-expands-access-free-digital-skills-and-ai-courses-philippines" target="_blank" rel="noopener" class="unesco-news-card">
          <div class="unesco-news-content">
            <div>
              <div class="unesco-news-tag">News</div>
              <div class="unesco-news-title">UNESCO's Global Skills Academy: TESDA expands access to free digital skills and AI courses in the Philippines</div>
            </div>
            <div class="unesco-news-date">10 June 2026</div>
          </div>
        </a>

        <a href="https://www.unesco.org/en/articles/unescos-global-education-coalition-empowers-ugandas-educators-ai-and-digital-skills-inclusive-tvet" target="_blank" rel="noopener" class="unesco-news-card">
          <div class="unesco-news-content">
            <div>
              <div class="unesco-news-tag">Article</div>
              <div class="unesco-news-title">UNESCO's Global Education Coalition empowers Uganda's educators with AI and digital skills</div>
            </div>
            <div class="unesco-news-date">29 April 2026</div>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- 11. UNESCO's Global Education Coalition Footer Block -->
  <section class="unesco-coalition-block">
    <div class="unesco-container">
      <div class="unesco-grid-2col">
        <div>
          <h2>UNESCO's Global Education Coalition</h2>
          <p>
            UNESCO's Global Education Coalition brings partners together to build resilient education systems and accelerate action for quality education around the world.
          </p>
          <div class="mt-6">
            <a href="https://www.unesco.org/en/global-education-coalition" target="_blank" rel="noopener" class="unesco-pill-btn" style="background-color: #ffffff; color: var(--unesco-navy) !important;">
              <span>Learn more</span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
          <div class="unesco-social-links">
            <a href="https://www.instagram.com/unesco/?hl=en" target="_blank" rel="noopener"><i class="fa-brands fa-instagram mr-1"></i> Instagram</a>
            <a href="https://www.linkedin.com/company/unesco" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin mr-1"></i> LinkedIn</a>
            <a href="https://www.youtube.com/UNESCO" target="_blank" rel="noopener"><i class="fa-brands fa-youtube mr-1"></i> YouTube</a>
            <a href="https://x.com/UNESCO" target="_blank" rel="noopener"><i class="fa-brands fa-x-twitter mr-1"></i> X</a>
            <a href="https://www.tiktok.com/@unesco?lang=en" target="_blank" rel="noopener"><i class="fa-brands fa-tiktok mr-1"></i> TikTok</a>
            <a href="https://www.facebook.com/unesco/" target="_blank" rel="noopener"><i class="fa-brands fa-facebook mr-1"></i> Facebook</a>
          </div>
        </div>

        <div class="flex justify-center lg:justify-end">
          <img src="https://www.unesco.org/sites/default/files/styles/square_144/public/2022-01/ed_global_coalition.jpg.webp?itok=wC2teMlJ" alt="UNESCO Global Education Coalition" style="width: 160px; height: 160px; border-radius: 8px;">
        </div>
      </div>
    </div>
  </section>

</div>
@endsection
