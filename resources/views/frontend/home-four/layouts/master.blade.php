<!doctype html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>@yield('meta_title', config('app.name', 'Skillvation'))</title>
  <meta name="description" content="@yield('meta_description', '')">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset(Cache::get('setting')?->favicon ?? 'frontend/img/favicon.png') }}">

  <!-- Tailwind CSS & Fonts -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          },
          colors: {
            primary: '#1976d2',
            'primary-light': '#4791db',
            'primary-dark': '#115293',
            surface: '#ffffff',
            'surface-container': '#f9fafb',
            'on-surface': '#1f2937',
            'on-surface-variant': '#4b5563',
            outline: '#e5e7eb',
            brand: {
              navy: '#28246f',
              darknavy: '#1d1956',
              orange: '#f05f43',
              orangehover: '#e24e31',
              peach: '#ffe8dc',
              peachlight: '#fff4ee',
              lavender: '#ecebff',
              lavenderlight: '#f5f4ff',
              blue: '#e1ebfd',
              bluelight: '#f0f5fe',
              green: '#e3f9ec',
              cyan: '#e0f8fb',
              pink: '#ffe8f0',
            }
          },
          spacing: {
            'section-gap': '4rem',
            'gutter': '2rem',
            'margin-mobile': '1rem',
          },
          maxWidth: {
            'container-max': '1280px',
          },
          borderRadius: {
            'card': '0.75rem',
            'image': '1rem',
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #1f2937;
      background-color: #ffffff;
    }
    .pin-shadow {
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.15));
    }
    .card-hover {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 30px -10px rgba(40, 36, 111, 0.12);
    }
  </style>

  @stack('styles')
</head>

<body class="antialiased selection:bg-primary selection:text-white min-h-screen flex flex-col justify-between">

  <!-- Header -->
  @include('frontend.home-four.components.header')

  <!-- Main Content -->
  <main class="pt-16 flex-grow">
    @yield('contents')
  </main>

  <!-- Footer -->
  @include('frontend.home-four.components.footer')

  <!-- Dynamic JS Global Config -->
  <script>
    window.APP_CONFIG = {
      API_BASE_URL: "{{ url('/') }}",
      COURSES_API_URL: "{{ url('/api/collab-courses') }}",
      IMAGE_BASE_URL: "",
      IMAGE_FALLBACK: "{{ asset('designs/img/TTT-1.png') }}",
      APP_URL: "{{ url('/') }}"
    };
  </script>

  @stack('scripts')
</body>

</html>
