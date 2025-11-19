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
                    <div class="text-white font-bold  md:text-5xl sm:text-2xl pt-10">Secteurs porteurs</div>
                    <div class="text-white font-medium md:text-xl pt-10 flex items-center">
                        <span>Accueil</span>
                        <span class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 6 10" fill="none">
                                <path d="M0.146447 9.85355C-0.0488155 9.65829 -0.0488155 9.34171 0.146447 9.14645L4.29289 5L0.146447 0.853553C-0.0488155 0.658291 -0.0488155 0.341708 0.146447 0.146446C0.341709 -0.0488167 0.658291 -0.0488167 0.853553 0.146446L5.35355 4.64645C5.54882 4.84171 5.54882 5.15829 5.35355 5.35355L0.853553 9.85355C0.658291 10.0488 0.341709 10.0488 0.146447 9.85355Z" fill="white"/>
                            </svg>
                        </span>
                        <span class="font-bold">Secteurs porteurs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-screen-lg pt-10 mb-[5%]">
        <div class="bg-white py-2 px-3 pb-10">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl md:text-2xl text-first-orange mb-5 font-semibold">Bienvenue au Pays de la Téranga</h1>
                    <p class="text-left text-xl sm:text-md pt-4">
                        Le Sénégal est une destination attractive pour les investissements en Afrique de l’Ouest. Le pays regorge de talents jeunes, qualifiés et multilingues. Les secteurs émergents tels que les énergies, l’agro-industrie, l’économie bleue et verte, le numérique, le secteur financier, les industries créatives, le tourisme et l’immobilier offrent de grandes opportunités d’investissement. Le Sénégal dispose d’infrastructures modernes facilitant les échanges commerciaux et la connectivité régionale et internationale.
                    </p>
                </div>
                <img class="px-4 w2/5" src="{{asset('assets/images/back_secteurs.png')}}" alt="" srcset="">
            </div>
        </div>
        <div class="flex items-center">
            <div class="w-1/4">
                <ul class="mx-4 md:text-md sm:text-md">
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Agriculture</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Artisanat</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Capital Humain</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Économie Bleue</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Économie Numérique</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Économie Verte</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Énergie</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Finance</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Industrie Pharma</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Industrie</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Tourisme</a></li>
                    <li class="py-2"><a href="#" class="font-bold text-first-orange">Transport</a></li>
                </ul>
            </div>
            <div class="w-3/4 bg-slate-200 rounded-lg py-8 px-12 mt-10">
                <p class="text-justify md:text-xl sm:text-md pt-4">
                    La production végétale du Sénégal est en plein essor, avec un énorme potentiel de terres arables, d’irrigation et un climat favorable. Les cultures horticoles et céréalières sont en expansion, avec des opportunités d’exportation vers l’Afrique, l’Europe, les Etats-Unis et le Moyen-Orient. Les politiques gouvernementales favorables, l’accès aux marchés régionaux et internationaux et la disponibilité des matières premières de qualité représentent de grandes opportunités pour les investisseurs locaux et internationaux. L’agro-industrie offre également des opportunités d’investissement attractives avec des débouchés sur le marché local, régional et international.
                </p>
            </div>
        </div>
    </div>

    @include('partials.footerv2')
    @include('layouts.v1.partials._script')
    <script src="{{asset('assets/libs/splide/js/splide.min.js')}}"></script>
    @stack('myJS')
</body>

</html>
