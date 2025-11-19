<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.v1.partials._head')
    <link rel="stylesheet" href="{{ asset('assets/libs/splide/css/splide.min.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d6e5e;
            --primary-dark: #0a5649;
            --primary-light: #e0f2f1;
            --secondary: #2c5282;
            --secondary-dark: #1e3a8a;
            --accent: #ecc94b;
            --first-orange: #f97316;
            --light: #f8f9fa;
            --dark: #2d3748;
        }
        
        .institutional-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .institutional-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("{{ asset('assets/images/pattern.png') }}") repeat;
            opacity: 0.05;
            pointer-events: none;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--first-orange);
            border-radius: 3px;
        }
        
        .institutional-card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }
        
        .institutional-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .responsive-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
  @include('partials.head')
<body class="leading-normal tracking-normal text-gray-800 bg-gray-50" style="font-family: 'Poppins', sans-serif; overflow-x: hidden;">

    <!-- En-tête institutionnel amélioré -->
    <header class="institutional-header text-white py-20 md:py-28 px-4 sm:px-6 relative">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col items-start">
                <nav class="flex text-sm mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-white hover:text-gray-200">
                                <i class="fas fa-home mr-2"></i>
                                Accueil
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
                                <span class="text-white font-medium">Programmes</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <h1 class="text-3xl md:text-5xl font-bold mb-4">
                    Registre des programmes
                </h1>
                <p class="text-lg md:text-xl text-white/90 max-w-3xl">
                    Découvrez l'ensemble des programmes de formation proposés par notre institution.
                </p>
            </div>
        </div>
    </header>

    <main class="py-12 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Section titre avec effet institutionnel -->
            <div class="text-center mb-12">
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-800 inline-block">
                    Catalogue des Programmes
                </h2>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Explorez notre offre complète de programmes de formation professionnelle
                </p>
            </div>

            <!-- Contenu principal -->
            <div class="bg-white institutional-card p-6 md:p-8">
                @include('layouts.v1.partials._alert')

                <!-- Barre de recherche/filtre -->
                <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Rechercher un programme...">
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Filtrer par :</span>
                        <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                            <option>Tous les domaines</option>
                            <option>Informatique</option>
                            <option>Commerce</option>
                            <option>Industrie</option>
                        </select>
                    </div>
                </div>

                <!-- Liste des programmes -->
                <div class="responsive-table">
                    <livewire:Etablissements.front-liste-programme/>
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="px-3 py-1 rounded bg-primary text-white">1</a>
                        <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">2</a>
                        <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">3</a>
                        <span class="px-2 text-gray-400">...</span>
                        <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Section d'appel à l'action -->
            <div class="mt-16 bg-gradient-to-r from-primary to-secondary rounded-xl p-8 text-center text-white">
                <h3 class="text-2xl font-bold mb-4">Vous souhaitez plus d'informations ?</h3>
                <p class="mb-6 max-w-2xl mx-auto text-white/90">
                    Notre équipe est à votre disposition pour répondre à toutes vos questions concernant nos programmes de formation.
                </p>
                <button class="bg-white text-primary font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
                    <i class="fas fa-envelope mr-2"></i> Contactez-nous
                </button>
            </div>
        </div>
    </main>

    @include('partials.footer')
    
    @include('layouts.v1.partials._script')
    <script src="{{asset('assets/libs/splide/js/splide.min.js')}}"></script>
    <script>
        // Script pour améliorer l'interactivité
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au survol
            const cards = document.querySelectorAll('.institutional-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.borderLeftColor = 'var(--first-orange)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.borderLeftColor = 'var(--primary)';
                });
            });
            
            // Gestion responsive du tableau
            function checkTableResponsive() {
                if (window.innerWidth < 768) {
                    document.querySelector('.responsive-table').classList.add('overflow-x-auto');
                } else {
                    document.querySelector('.responsive-table').classList.remove('overflow-x-auto');
                }
            }
            
            window.addEventListener('resize', checkTableResponsive);
            checkTableResponsive();
        });
    </script>
    @stack('myJS')
</body>
</html>
