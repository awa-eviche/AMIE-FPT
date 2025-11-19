<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMIE FPT - Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d6e5e;
            --primary-dark: #0a5649;
            --primary-light: #e0f2f1;
            --secondary: #2c5282;
            --accent: #ecc94b;
            --light: #f8f9fa;
            --dark: #2d3748;
            --gray: #718096;
            --gray-light: #e2e8f0;
            
            /* Couleurs des réseaux sociaux */
            --facebook: #3b5998;
            --whatsapp: #25D366;
            --linkedin: #0077B5;
            --youtube: #FF0000;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9fafb;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Utilitaires */
        .mr-2 { margin-right: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            white-space: nowrap;
            border: 0;
        }
        
        /* Bannière avec image de fond */
        .top-banner {
            position: relative;
            min-height: 180px;
            background-image: url('<?php echo e(asset("frontAssets2/banner.jpg")); ?>');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            flex-wrap: wrap;
            z-index: 100;
        }
        
        /* Conteneur du texte et logo MFPT */
        .banner-content {
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 2;
            max-width: 70%;
            flex: 1;
        }
        
        .mfpt-logo {
            height: 70px;
            width: auto;
            max-width: 100%;
        }
        
        .banner-text {
            color: #0b0101;
            flex: 1;
        }
        
        .banner-text h1 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1px;
            color: #0b0101;
        }
        
        .banner-text h2 {
            font-size: 1rem;
            font-weight: normal;
            margin-bottom: 1px;
            color: #0b0101;
        }
        
        .banner-text h3 {
            font-size: 0.8rem;
            font-weight: normal;
            font-style: italic;
            color: #0b0101;
        }
        
        /* Conteneur des icônes sociales dans la bannière */
        .banner-social-icons {
            display: flex;
            gap: 10px;
            z-index: 2;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .banner-social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .banner-social-icon i {
            position: relative;
            z-index: 2;
        }
        
        .banner-social-icon.facebook { background-color: rgba(59, 89, 152, 0.8); }
        .banner-social-icon.whatsapp { background-color: rgba(37, 211, 102, 0.8); }
        .banner-social-icon.linkedin { background-color: rgba(0, 119, 181, 0.8); }
        .banner-social-icon.youtube { background-color: rgba(255, 0, 0, 0.8); }
        
        .banner-social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .navbar {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 90;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 40px;
            transition: all 0.3s ease;
            max-width: 100%;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            align-items: center;
        }
        
        .nav-item {
            position: relative;
            margin: 0 0.3rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.8rem;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.9rem;
        }
        
        .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
        }
        
        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            border-radius: 3px 3px 0 0;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 70%;
        }
        
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .btn-login {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 1px solid var(--primary-light);
            font-size: 0.9rem;
        }
        
        .btn-login:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .btn-primary {
            display: flex;
            align-items: center;
            padding: 0.5rem 1.2rem;
            background: var(--primary);
            color: white;
            text-decoration: none;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 5px rgba(13, 110, 94, 0.2);
            font-size: 0.9rem;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(13, 110, 94, 0.25);
        }
        
        .mobile-menu-btn {
            display: none;
            flex-direction: column;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 100;
        }
        
        .mobile-menu-btn span {
            width: 100%;
            height: 2.5px;
            background: var(--dark);
            margin: 2px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(4px, 4px);
        }
        
        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -5px);
        }
        
        /* Menu mobile */
        .mobile-menu {
            position: fixed;
            top: 180px;
            left: 0;
            width: 100%;
            height: calc(100vh - 180px);
            background: white;
            z-index: 80;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            padding: 1.5rem;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        .mobile-nav-item {
            margin-bottom: 1.2rem;
        }
        
        .mobile-nav-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 0;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            border-bottom: 1px solid var(--gray-light);
            transition: all 0.3s ease;
        }
        
        .mobile-nav-link:hover {
            color: var(--primary);
            padding-left: 0.5rem;
        }
        
        .mobile-social-icons {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin: 1.5rem 0;
            flex-wrap: wrap;
        }
        
        .mobile-social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .mobile-social-icon.facebook { background: var(--facebook); }
        .mobile-social-icon.whatsapp { background: var(--whatsapp); }
        .mobile-social-icon.linkedin { background: var(--linkedin); }
        .mobile-social-icon.youtube { background: var(--youtube); }
        
        .mobile-social-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }
        
        .mobile-actions {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-light);
        }
        
        .mobile-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            text-align: center;
            padding: 0.8rem;
            margin-bottom: 0.8rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .mobile-btn-login {
            color: var(--primary);
            border: 1px solid var(--primary-light);
        }
        
        .mobile-btn-login:hover {
            background: var(--primary-light);
        }
        
        .mobile-btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 3px 5px rgba(13, 110, 94, 0.2);
        }
        
        .mobile-btn-primary:hover {
            background: var(--primary-dark);
        }
        
        @media (max-width: 968px) {
            .top-banner {
                min-height: auto;
                padding: 15px;
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
                gap: 15px;
                z-index: 100;
            }
            
            .banner-content {
                flex-direction: row;
                gap: 15px;
                max-width: 65%;
                align-items: center;
            }
            
            .mfpt-logo {
                height: 60px;
            }
            
            .banner-text h1 {
                font-size: 1rem;
            }
            
            .banner-text h2 {
                font-size: 0.9rem;
            }
            
            .banner-text h3 {
                font-size: 0.8rem;
            }
            
            .banner-social-icons {
                margin-top: 0;
                gap: 8px;
            }
            
            .banner-social-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
            
            .nav-menu, .nav-actions {
                display: none;
            }
            
            .mobile-menu-btn {
                display: flex;
            }
            
            .nav-container {
                height: 60px;
                padding: 0 1rem;
            }
            
            .logo img {
                height: 36px;
            }
            
            .mobile-menu {
                top: 150px;
                height: calc(100vh - 150px);
            }
        }
        
        @media (max-width: 640px) {
            .top-banner {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                min-height: 160px;
            }
            
            .banner-content {
                flex-direction: column;
                max-width: 100%;
                gap: 10px;
            }
            
            .banner-text {
                text-align: center;
            }
            
            .banner-social-icons {
                width: 100%;
                justify-content: center;
            }
            
            .mobile-menu {
                top: 160px;
                height: calc(100vh - 160px);
            }
        }
        
        @media (min-width: 969px) {
            .mobile-menu {
                display: none;
            }
        }
        
        /* Contenu principal */
        .main-content {
            padding: 2rem;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Bannière avec image de fond et icônes sociales -->
    <div class="top-banner">
        <div class="banner-content">
            <img src="<?php echo e(asset('frontAssets2/flagSN.png')); ?>" alt="Logo Ministère de la Formation professionnelle et technique" class="mfpt-logo">
            <div class="banner-text">
                <h1>République du Sénégal</h1>
                <h2>Un peuple - Un but - Une Foi</h2>
                <h3>Ministère de l'Emploi et de la Formation professionnelle et technique</h3>
            </div>
        </div>
        
        <div class="banner-social-icons">
            <a href="https://facebook.com" class="banner-social-icon facebook" aria-label="Page Facebook" target="_blank" rel="noopener">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://wa.me" class="banner-social-icon whatsapp" aria-label="Contact WhatsApp" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://linkedin.com" class="banner-social-icon linkedin" aria-label="Page LinkedIn" target="_blank" rel="noopener">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://youtube.com" class="banner-social-icon youtube" aria-label="Chaîne YouTube" target="_blank" rel="noopener">
                <i class="fab fa-youtube"></i>
            </a>
        </div>
    </div>

    <!-- Barre de navigation améliorée -->
    <nav class="navbar" id="navbar" aria-label="Navigation principale">
        <div class="nav-container">
            <!-- Logo -->
            <div class="logo">
                <a href="<?php echo e(url('/')); ?>" aria-label="Accueil AMIEFPT">
                    <img src="<?php echo e(asset('frontAssets2/images/logoamifpt.jpg')); ?>" alt="Logo AMIEFPT">
                </a>
            </div>

            <!-- Menu Desktop -->
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?php echo e(url('/')); ?>#accueil" class="nav-link active">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('front.programmes')); ?>" class="nav-link">
                        <i class="fas fa-book mr-2"></i>Programmes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('front.etablissements')); ?>" class="nav-link">
                        <i class="fas fa-school mr-2"></i>Etablissements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(url('/carto')); ?>" class="nav-link">
                        <i class="fas fa-map-marked-alt mr-2"></i>SIG
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(url('/')); ?>" class="nav-link">
                        <i class="fas fa-building mr-2"></i>Constructions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(url('/')); ?>" class="nav-link">
                        <i class="fas fa-briefcase mr-2"></i>Insertion
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('contact')); ?>" class="nav-link">
                        <i class="fas fa-envelope mr-2"></i>Contact
                    </a>
                </li>
            </ul>

            <!-- Actions -->
            <div class="nav-actions">
                <a href="<?php echo e(route('login')); ?>" class="btn-login">
                    <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                </a>
            </div>

            <!-- Bouton menu mobile -->
            <button class="mobile-menu-btn" id="mobile-menu-btn" aria-expanded="false" aria-controls="mobile-menu" aria-label="Menu principal">
                <span class="sr-only">Menu principal</span>
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Menu Mobile -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-nav">
            <div class="mobile-nav-item">
                <a href="<?php echo e(url('/')); ?>#accueil" class="mobile-nav-link">
                    <i class="fas fa-home mr-3"></i>Accueil
                </a>
            </div>
            <div class="mobile-nav-item">
                <a href="<?php echo e(route('front.programmes')); ?>" class="mobile-nav-link">
                    <i class="fas fa-book mr-3"></i>Programmes
                </a>
            </div>
            <div class="mobile-nav-item">
                <a href="<?php echo e(route('front.etablissements')); ?>" class="mobile-nav-link">
                    <i class="fas fa-school mr-3"></i>Etablissements
                </a>
            </div>
            <div class="mobile-nav-item">
                <a href="<?php echo e(url('/carto')); ?>" class="mobile-nav-link">
                    <i class="fas fa-map-marked-alt mr-3"></i>SIG
                </a>
            </div>
            <div class="mobile-nav-item">
                <a href="<?php echo e(url('/')); ?>" class="mobile-nav-link">
                    <i class="fas fa-building mr-3"></i>Constructions
                </a>
            </div>
            <div class="mobile-nav-item">
                <a href="<?php echo e(url('/')); ?>" class="mobile-nav-link">
                    <i class="fas fa-briefcase mr-3"></i>Insertion
                </a>
            </div>
            <div class="mobile-nav-item">
                <a href="<?php echo e(route('contact')); ?>" class="mobile-nav-link">
                    <i class="fas fa-envelope mr-3"></i>Contact
                </a>
            </div>
        </div>

        <!-- Icônes des réseaux sociaux version mobile -->
        <div class="mobile-social-icons">
            <a href="https://facebook.com" class="mobile-social-icon facebook" aria-label="Page Facebook" target="_blank" rel="noopener">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://wa.me" class="mobile-social-icon whatsapp" aria-label="Contact WhatsApp" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://linkedin.com" class="mobile-social-icon linkedin" aria-label="Page LinkedIn" target="_blank" rel="noopener">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://youtube.com" class="mobile-social-icon youtube" aria-label="Chaîne YouTube" target="_blank" rel="noopener">
                <i class="fab fa-youtube"></i>
            </a>
        </div>

        <div class="mobile-actions">
            <a href="<?php echo e(route('login')); ?>" class="mobile-btn mobile-btn-login">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </a>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            // Gestion du scroll pour l'effet de navbar
            window.addEventListener('scroll', function() {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Gestion du menu mobile
            mobileMenuBtn.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.classList.toggle('active');
                mobileMenu.classList.toggle('active');
                this.setAttribute('aria-expanded', !isExpanded);
                
                // Empêcher le défilement du corps lorsque le menu est ouvert
                if (mobileMenu.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            });
            
            // Fermer le menu mobile en cliquant sur un lien
            const mobileLinks = mobileMenu.querySelectorAll('.mobile-nav-link, .mobile-social-icon, .mobile-btn');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenuBtn.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = 'auto';
                });
            });
            
            // Fermer le menu mobile en cliquant à l'extérieur
            document.addEventListener('click', function(event) {
                const isClickInsideNav = navbar.contains(event.target);
                const isClickInsideMenu = mobileMenu.contains(event.target);
                
                if (!isClickInsideNav && !isClickInsideMenu && mobileMenu.classList.contains('active')) {
                    mobileMenuBtn.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = 'auto';
                }
            });

            // Fermer le menu mobile avec la touche Échap
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && mobileMenu.classList.contains('active')) {
                    mobileMenuBtn.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/AMIE-FPT/resources/views/partials/head.blade.php ENDPATH**/ ?>