<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'PGI') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-... (CDN integrity code)" crossorigin="anonymous" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

  @yield('customCss')
  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Styles -->
  @livewireStyles
</head>

<body class="font-sans antialiased">
  <div class="relative h-screen overflow-hidden bg-[#E6E6E6] rounded-2xl">
    <div x-data="{ isOpen: true }" class="flex items-start justify-between">
      {{-- sidebar --}}
      <div x-show="isOpen" {{-- class="md:block md:relative md:w-80 h-screen shadow-lg z-50 hidden fixed" --}} class="md:block md:relative md:w-80 h-screen shadow-lg z-50 fixed" id="md_sidebar">
        @include('layouts.navigation')
      </div>

      {{-- page content --}}

      <div class="flex flex-col w-full pl-0 md:space-y-4">
        {{-- header --}}
        @include('layouts.v1.partials._header')




        <div class="pb-10 h-screen">
            <div class="h-full pt-1 pb-24 pl-6 pr-6 overflow-auto md:pt-6 md:pr-6 md:pl-6 mb-10">
                @include('layouts.v1.partials._alert')
              {{ $slot }}

            </div>

        </div>

      </div>
    </div>
  </div>
  

  @stack('modals')
  @livewireScripts
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>

  @yield('customJs')

</body>

</html>
