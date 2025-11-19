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
  <div class="w-full bg-contact bg-no-repeat bg-cover bg-center flex flex-col sm:justify-between items-beetween sm:pt-0">
    <div class="flex flex-wrap">
      <div class="md:w-2/5 lg:w-3/5 xl:w-2/5 md:py-44 md:px-36 sm:py-10 sm:px-12 wc-full">
        <div class="flex flex-col ...">
          <div class="text-white font-bold  md:text-5xl sm:text-2xl pt-10">Contact</div>
          <div class="text-white font-medium md:text-xl pt-10 flex items-center">
            <span>Accueil</span>
            <span class="mx-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 6 10" fill="none">
                <path d="M0.146447 9.85355C-0.0488155 9.65829 -0.0488155 9.34171 0.146447 9.14645L4.29289 5L0.146447 0.853553C-0.0488155 0.658291 -0.0488155 0.341708 0.146447 0.146446C0.341709 -0.0488167 0.658291 -0.0488167 0.853553 0.146446L5.35355 4.64645C5.54882 4.84171 5.54882 5.15829 5.35355 5.35355L0.853553 9.85355C0.658291 10.0488 0.341709 10.0488 0.146447 9.85355Z" fill="white" />
              </svg>
            </span>
            <span class="font-bold">Contact</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mx-auto max-w-screen-lg pt-10 mb-[5%]">
    <h1 class="text-2xl text-first-orange pb-10 justify-center">Pour toute Information ou assistance en matière d'investissement ou de projet au Sénégal </h1>

    <div class="mx-auto max-w-screen-lg">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 flex flex-col">
          <div class="text-first-orange">
            <span class="px-2"><i class="fab fa-facebook fa-2x"></i></span>
            <span class="px-2"><i class="fab fa-twitter  fa-2x"></i></span>
            <span class="px-2"><i class="fab fa-linkedin fa-2x"></i></span>
            <span class="px-2"><i class="fab fa-instagram  fa-2x"></i></span>
            <span class="px-2"><i class="fab fa-youtube  fa-2x"></i></span>
          </div>
        </div>
        <div class="flex flex-col">
        @include('layouts.v1.partials._alert')
          <div class="rounded-2xl border-2 border-gray-500 p-12">
            <form method="POST" action="{{ route('contacter_apix') }}" class="max-w-2xl mt-2">
              @csrf

              <div class="mb-4 w-full">

                <div class="relative h-11 w-full">
                  <input class="placeholder-shown:border-blue-gray-200 disabled:border-0 disabled:bg-blue-gray-50 w-full gray-input rounded-sm" placeholder="Nom et prénom" type="text" name="name" id="name" />
                </div>
              </div>
            
              <div class="mb-4 w-full">
                <div class="relative h-11 w-full">
                  <input class="placeholder-shown:border-blue-gray-200 disabled:border-0 disabled:bg-blue-gray-50 w-full gray-input rounded-sm" placeholder="Adresse e-mail" type="text" name="email" id="email" />
                </div>
              </div>
              <div class="relative  w-full">
                <textarea class="placeholder-shown:border-blue-gray-200 disabled:border-0 disabled:bg-blue-gray-50 w-full gray-input rounded-sm" placeholder="Message" type="text" name="message" id="message" rows="6"></textarea>
              </div>
              <div class="mt-4">
                <button type="submit" class="w-1/3 border-solid border-2 border-first-orange bg-white text-first-orange px-2 py-3 hover:text-white  hover:bg-first-orange font-black">ENVOYER</button>
              </div>
            </form>

          </div>
        </div>
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