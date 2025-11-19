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
                    <div class="text-white font-bold  md:text-5xl sm:text-2xl pt-10">Création d'entreprise</div>
                    <div class="text-white font-medium md:text-xl pt-10 flex items-center">
                        <span>Accueil</span>
                        <span class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 6 10" fill="none">
                                <path d="M0.146447 9.85355C-0.0488155 9.65829 -0.0488155 9.34171 0.146447 9.14645L4.29289 5L0.146447 0.853553C-0.0488155 0.658291 -0.0488155 0.341708 0.146447 0.146446C0.341709 -0.0488167 0.658291 -0.0488167 0.853553 0.146446L5.35355 4.64645C5.54882 4.84171 5.54882 5.15829 5.35355 5.35355L0.853553 9.85355C0.658291 10.0488 0.341709 10.0488 0.146447 9.85355Z" fill="white"/>
                            </svg>
                        </span>
                        <span class="font-bold">Créez votre entreprise</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-screen-lg pt-10 mb-[5%]">
        <div class="bg-white py-2 px-3">
            <h1 class="text-2xl md:text-2xl text-first-orange mb-5 font-semibold">Le Bureau de Création d’Entreprise</h1>
            <p class="text-justify text-xl sm:text-md pt-4">
                Le Bureau de Création d’Entreprise est une branche de l’APIX qui a pour principal objectif d’aider les entrepreneurs dans leur démarche pour formaliser leurs activités, en 48h. Certains Ministères et corps de l’administration Sénégalaise (Ministère de la Justice, MEFP, ANSD, Ministère du Travail, du dialogue social et des relations avec les institutions, OAPI) sont représentés au niveau de ce bureau et tous sont indispensables à la création d’entreprise ou de société. Le BCE permet l’enregistrement des statuts, la déclaration de l’ouverture d’établissement, la délivrance du registre de commerce, de l’identifiant fiscal et de la déclaration d’existence.
            </p>
        </div>
        <div class="bg-slate-200 rounded-lg py-8 px-12 mt-10">
            <h1 class="text-2xl md:text-2xl text-first-orange mb-5 mt-5 font-semibold">Les formes juridiques qu’on y trouve sont :</h1>
            <p class="text-justify md:text-2xl sm:text-md pt-4">
                <ul class="list-disc mx-4 md:text-xl sm:text-md">
                    <li>L’Entreprise individuelle ;</li>
                    <li>Le GIE ;</li>
                    <li>La Société à Responsabilité Limitée (SARL);</li>
                    <li>La Société Anonyme (SA);</li>
                    <li>La Société en Nom Collectif (SNC);</li>
                    <li>La Société en Commandite Simple (SCS);</li>
                    <li>La Société Civile;</li>
                    <li>La Société par Action Simplifiée (SAS)</li>
                </ul>
            </p>

            <h1 class="text-2xl md:text-2xl text-first-orange mb-10 mt-10 font-semibold">Documents utiles</h1>
            <p class="text-justify md:text-2xl sm:text-md pt-4">
                <ul class="mx-4 md:text-md sm:text-md">
                    <li class="py-3">
                        <a href="" class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 29 29" fill="none">
                                <path d="M25.375 18.125V22.9583C25.375 23.5993 25.1204 24.214 24.6672 24.6672C24.214 25.1204 23.5993 25.375 22.9583 25.375H6.04167C5.40073 25.375 4.78604 25.1204 4.33283 24.6672C3.87961 24.214 3.625 23.5993 3.625 22.9583V18.125" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.45801 12.0833L14.4997 18.125L20.5413 12.0833" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.5 18.125V3.625" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="mx-4">Nom du document</span>
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="" class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 29 29" fill="none">
                                <path d="M25.375 18.125V22.9583C25.375 23.5993 25.1204 24.214 24.6672 24.6672C24.214 25.1204 23.5993 25.375 22.9583 25.375H6.04167C5.40073 25.375 4.78604 25.1204 4.33283 24.6672C3.87961 24.214 3.625 23.5993 3.625 22.9583V18.125" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.45801 12.0833L14.4997 18.125L20.5413 12.0833" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.5 18.125V3.625" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="mx-4">Nom du document</span>
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="" class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 29 29" fill="none">
                                <path d="M25.375 18.125V22.9583C25.375 23.5993 25.1204 24.214 24.6672 24.6672C24.214 25.1204 23.5993 25.375 22.9583 25.375H6.04167C5.40073 25.375 4.78604 25.1204 4.33283 24.6672C3.87961 24.214 3.625 23.5993 3.625 22.9583V18.125" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.45801 12.0833L14.4997 18.125L20.5413 12.0833" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.5 18.125V3.625" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="mx-4">Nom du document</span>
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="" class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 29 29" fill="none">
                                <path d="M25.375 18.125V22.9583C25.375 23.5993 25.1204 24.214 24.6672 24.6672C24.214 25.1204 23.5993 25.375 22.9583 25.375H6.04167C5.40073 25.375 4.78604 25.1204 4.33283 24.6672C3.87961 24.214 3.625 23.5993 3.625 22.9583V18.125" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.45801 12.0833L14.4997 18.125L20.5413 12.0833" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.5 18.125V3.625" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="mx-4">Nom du document</span>
                        </a>
                    </li>

                </ul>
            </p>
        </div>
    </div>

    @include('partials.footerv2')
    @include('layouts.v1.partials._script')
    <script src="{{asset('assets/libs/splide/js/splide.min.js')}}"></script>
    @stack('myJS')
</body>

</html>
