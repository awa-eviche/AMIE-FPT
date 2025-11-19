<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('layouts.v1.partials._head')
  <link rel="stylesheet" href="{{asset('assets/libs/splide/css/splide.min.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,900&display=swap" rel="stylesheet" />
  <style>
    * {
      font-family: 'Source Sans Pro';
    }
  </style>
</head>

<body class="font-sans antialiased">

  <div class="bg-first-orange py-4"></div>
  @include('partials.head')
  <div class="w-full bg-entreprise bg-no-repeat bg-cover bg-center flex flex-col sm:justify-between items-beetween sm:pt-0">
    <div class="flex flex-wrap">
      <div class="md:w-2/5 lg:w-3/5 xl:w-2/5 md:py-44 md:px-36 sm:py-10 sm:px-12 wc-full">
        <div class="flex flex-col ...">
          <div class="text-white font-bold  md:text-5xl sm:text-2xl pt-10">{{$actualite->actualite_titre}}</div>
          <div class="text-white font-medium md:text-xl pt-10 flex items-center">
            <span>Accueil</span>
            <span class="mx-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 6 10" fill="none">
                <path d="M0.146447 9.85355C-0.0488155 9.65829 -0.0488155 9.34171 0.146447 9.14645L4.29289 5L0.146447 0.853553C-0.0488155 0.658291 -0.0488155 0.341708 0.146447 0.146446C0.341709 -0.0488167 0.658291 -0.0488167 0.853553 0.146446L5.35355 4.64645C5.54882 4.84171 5.54882 5.15829 5.35355 5.35355L0.853553 9.85355C0.658291 10.0488 0.341709 10.0488 0.146447 9.85355Z" fill="white" />
              </svg>
            </span>
            <span class="font-bold">Actualités</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mx-auto max-w-screen-lg pt-10 mb-[5%]">
    <h1 class="text-4xl text-first-orange pb-10">{{$actualite->actualite_titre}}</h1>
    <div class="flex flex-wrap justify-center -mx-4">
        <div class="w-full">
           {!! $actualite->actualite_corps !!}
        </div>
</div>

  </div>
  </div>

  @include('partials.footerv2')
  @include('layouts.v1.partials._script')
  <script src="{{asset('assets/libs/splide/js/splide.min.js')}}"></script>
  @stack('myJS')
</body>

</html>