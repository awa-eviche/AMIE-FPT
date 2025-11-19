<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.v1.partials._head')
    <link rel="stylesheet" href="{{asset('assets/libs/splide/css/splide.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d6e5e;
            --primary-dark: #0a5649;
            --primary-light: #e0f2f1;
            --secondary: #2c5282;
            --secondary-dark: #1e3a8a;
            --accent: #ecc94b;
            --light: #f8f9fa;
            --dark: #2d3748;
            --gray: #718096;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--dark);
            background-color: var(--light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header fixe */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Hero section améliorée */
        .hero-section {
            background: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95)), url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230d6e5e' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            padding: 8rem 0 6rem;
        }
        
        /* Statistiques */
        .stats-container {
            background: linear-gradient(to right, var(--primary-dark), var(--secondary-dark));
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .stat-item {
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .stat-item:not(:last-child):after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 1px;
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Cards améliorées */
        .feature-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        /* Section témoignages */
        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-top: 2rem;
        }
        
        .testimonial-card:before {
            content: '"';
            position: absolute;
            top: -15px;
            left: 20px;
            font-size: 5rem;
            color: var(--primary-light);
            font-family: Georgia, serif;
            line-height: 1;
        }
        
        /* Boutons améliorés */
        .btn-primary-custom {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        .btn-outline-custom {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-outline-custom:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Footer amélioré */
        .footer-institution {
            background: linear-gradient(to right, var(--primary-dark), var(--secondary-dark));
            border-top: 4px solid var(--accent);
        }
        
        .footer-link {
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            text-decoration: none;
        }
        
        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .footer-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }
        
        .footer-link:hover:after {
            width: 100%;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 6rem 0 4rem;
            }
            
            .stat-item:after {
                display: none;
            }
            
            .stat-item {
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .stat-item:last-child {
                border-bottom: none;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
       @include('partials.head')
    <!-- Header fixe avec ancien logo -->
 
    <!-- Hero Section améliorée -->
    <section class="hero-section" id="acceuil">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="w-full lg:w-1/2 lg:pr-10 mb-10 lg:mb-0 animate-fade-in-up">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-gray-900 mb-6">
                        <span class="gradient-text">Bienvenue à la solution AMIE FPT</span><br>
                        <span class="text-3xl sm:text-4xl">Plateforme de Management Intégré</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-700 mb-8 leading-relaxed">
                        Application de Management Intégré des Établissements de Formation professionnelle et technique, développée par le Ministère de la Formation professionnelle et technique du Sénégal.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <a href="{{url('/request')}}" class="btn-primary-custom">
                            <i class="fas fa-school mr-2"></i>Ouvrir un établissement privé
                        </a>
                        <a href="#features" class="btn-outline-custom">
                            <i class="fas fa-info-circle mr-2"></i>En savoir plus
                        </a>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 mt-10 lg:mt-0 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <img class="w-full max-w-2xl mx-auto rounded-lg shadow-xl" src="{{asset('frontAssets2/images/amiefptsn2.png')}}" alt="Illustration AMIE-FPT" />
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques -->
    <section class="py-12 px-4 sm:px-6 lg:px-8" id="stats">
        <div class="max-w-7xl mx-auto stats-container text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-700">
                <div class="stat-item">
                    <div class="text-4xl font-bold mb-2">+126</div>
                    <div class="text-sm uppercase tracking-wider">Centre de Formation professionnelle</div>
                </div>
                <div class="stat-item">
                    <div class="text-4xl font-bold mb-2">+12</div>
                    <div class="text-sm uppercase tracking-wider">Lycées techniques</div>
                </div>
                <div class="stat-item">
                    <div class="text-4xl font-bold mb-2">46</div>
                    <div class="text-sm uppercase tracking-wider">Départements</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section avec les nouvelles fonctionnalités -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50" id="features">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Modules Intégrés</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Découvrez les outils complets de gestion du système de formation professionnelle et technique</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Gestion des données de base -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Données de base</h3>
                    <p class="text-gray-600 text-center">Administration des filières, métiers, compétences, éléments de compétence, matières et critères d'évaluation.</p>
                </div>
                
                <!-- Gestion des classes -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Gestion des classes</h3>
                    <p class="text-gray-600 text-center">Création, organisation et suivi des classes et niveaux de formation.</p>
                </div>
                
                <!-- Gestion des apprenants -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Gestion des apprenants</h3>
                    <p class="text-gray-600 text-center">Enregistrement, suivi des parcours, mise à jour des informations administratives et académiques.</p>
                </div>
                
                <!-- Gestion des évaluations -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Gestion des évaluations</h3>
                    <p class="text-gray-600 text-center">Paramétrage et exploitation des évaluations selon les approches APC et PPO.</p>
                </div>

                <!-- Gestion documentaire -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Gestion documentaire</h3>
                    <p class="text-gray-600 text-center">Production, partage, archivage et consultation sécurisée des documents pédagogiques et administratifs.</p>
                </div>
                
                <!-- Collecte de données -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-poll"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Collecte de données</h3>
                    <p class="text-gray-600 text-center">Administration et collecte des enquêtes et questionnaires en ligne.</p>
                </div>
                
                <!-- Gestion des demandes -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Gestion des demandes</h3>
                    <p class="text-gray-600 text-center">Traitement et traçabilité des différentes requêtes des usagers (extension de filière, changement de dénomination, etc.).</p>
                </div>
                
                <!-- Gestion administrative et sécurité -->
                <div class="feature-card p-6 hover-scale">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-center">Admin & Sécurité</h3>
                    <p class="text-gray-600 text-center">Suivi de l'historique des actions, administration des rôles et des permissions pour garantir transparence et traçabilité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Institutionnel -->
@include('partials.footer')

    <script>
        // Animation au défilement
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animate-fade-in-up');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(el);
            });
            
            // Gestion du scroll pour le header fixe
            window.addEventListener('scroll', function() {
                const header = document.getElementById('header');
                if (window.scrollY > 50) {
                    header.classList.add('shadow-lg');
                } else {
                    header.classList.remove('shadow-lg');
                }
            });
        });
    </script>
    @stack('myJS')
</body>
</html>