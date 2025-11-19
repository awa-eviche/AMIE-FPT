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
                    <div class="text-white font-bold  md:text-5xl sm:text-2xl pt-10">Zones économiques</div>
                    <div class="text-white font-medium md:text-xl pt-10 flex items-center">
                        <span>Accueil</span>
                        <span class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 6 10" fill="none">
                                <path d="M0.146447 9.85355C-0.0488155 9.65829 -0.0488155 9.34171 0.146447 9.14645L4.29289 5L0.146447 0.853553C-0.0488155 0.658291 -0.0488155 0.341708 0.146447 0.146446C0.341709 -0.0488167 0.658291 -0.0488167 0.853553 0.146446L5.35355 4.64645C5.54882 4.84171 5.54882 5.15829 5.35355 5.35355L0.853553 9.85355C0.658291 10.0488 0.341709 10.0488 0.146447 9.85355Z" fill="white"/>
                            </svg>
                        </span>
                        <span class="font-bold">Zones économiques</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-screen-lg pt-10 mb-[5%]">
        <div class="bg-white py-2 px-3 pb-10">
            <h1 class="text-2xl md:text-2xl text-first-orange mb-5 font-semibold">Présentation</h1>
            <p class="text-justify text-xl sm:text-md pt-4">
                Dans sa volonté d’opérer la transformation structurelle de l’économie à travers le développement de nouveaux secteurs créateurs de richesses, d’emplois et d’inclusion sociale, le Gouvernement du Sénégal a pris l’option stratégique de créer et de développer les « Zones Économiques Spéciales (ZES) ».
                Cette intention de rendre le Sénégal compétitif, réaffirmée dans le plan d’actions prioritaires ajusté et accéléré (PAP2A) repose sur la mise en place de hubs industriels et logistiques ayant pour vocation d’offrir un ensemble d’infrastructures et de services de qualité aux entreprises de production. Ce qui démontre la capacité du Sénégal à offrir des produits et des services à haute valeur ajoutée pour attirer les investisseurs à travers les ZES. Pour amorcer le développement des ZES, l’État du Sénégal a pris l’option de consentir des ressources financières considérables. Ces investissements stratégiques ont permis l’installation massive de promoteurs/développeurs sur le site de Diamniadio grâce à la construction de bâtiments administratifs, l’aménagement et la mise en place d’équipements nécessaires pour l’opérationnalité des zones.
            </p>
        </div>
        <div class="bg-white py-2 px-3">
            <h1 class="text-2xl md:text-2xl text-first-orange mb-5 font-semibold">Ambitions stratégiques des ZES</h1>
            <p class="text-justify text-xl sm:text-md pt-4">
                <ol class="list-decimal mx-4 md:text-xl sm:text-md">
                    <li>Attirer les investissements directs privés</li>
                    <li>Créer massivement des emplois</li>
                    <li>Créer une valeur ajoutée locale</li>
                    <li>Contribuer au rééquilibrage de la balance commerciale.<br>
                    Pour mettre en œuvre cet ambitieux projet, le Gouvernement du Sénégal à travers la loi 2017-06 du 06 janvier 2017 consacre APIX-S.A comme entité chargée de l’administration et de la gestion des Zones Économiques Spéciales.
                    <br>Ces efforts ont conduit à la création de cinq (05) ZES, que sont :
                    <ul class="list-disc mx-4 md:text-xl sm:text-md">
                        <li>Zone Économique Spéciale Intégrée de Diass (ZESID) sur 718 hectares ;</li>
                        <li>Parc Industriel Intégré de Diamniadio (P2ID) sur 53 hectares ;</li>
                        <li>Zone Économique Spéciale de Sandiara (ZESS) sur 100 hectares ;</li>
                        <li>Zone Économique Spéciale de Bargny- Sendou (ZESBS) sur 100 hectares;</li>
                        <li>Zone Économique Spéciale de Bélé – Kidira sur 1000 hectares.</li>
                    </ul>
                    APIX-S.A a mis en place les conditions nécessaires pour faciliter l’installation et l’accompagnement des promoteurs/développeurs.</li>
                </ol>
                <ul class="mt-5 mx-4 md:text-md sm:text-md">
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
