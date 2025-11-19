<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('layouts.v1.partials._head')

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Turf (pour le masque monde - Sénégal) -->
  <script defer src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

  <!-- MarkerCluster -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
  <script defer src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Tailwind (CDN) + couleurs -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#0d6e5e',
            'primary-dark': '#0a5649',
            'primary-light': '#e0f2f1',
            secondary: '#2c5282',
            'secondary-dark': '#1e3a8a',
            accent: '#ecc94b',
            dark: '#2d3748',
            light: '#f8f9fa',
          }
        }
      }
    }
  </script>

  <!-- Styles -->
  <style>
    :root{
      --primary:#0d6e5e;
      --primary-dark:#0a5649;
      --primary-light:#e0f2f1;
      --secondary:#2c5282;
      --secondary-dark:#1e3a8a;
      --accent:#ecc94b;
      --light:#f8f9fa;
      --dark:#2d3748;
    }
    body.font-roboto { font-family: 'Roboto', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol', sans-serif; }
    .gradient-bg{background:linear-gradient(135deg,var(--primary) 0%,var(--secondary) 100%);}
    .hover-scale{transition:transform .3s ease, box-shadow .3s ease;}
    .hover-scale:hover{transform:translateY(-2px); box-shadow:0 10px 15px -3px rgba(0,0,0,.1);}
    .footer-institution{background:linear-gradient(to right,var(--primary-dark),var(--secondary-dark)); border-top:4px solid var(--accent);}
    .footer-link{transition:all .3s ease; position:relative;}
    .footer-link:hover{color:#fff; transform:translateX(5px);}
    .footer-link:after{content:''; position:absolute; width:0; height:2px; bottom:-2px; left:0; background-color:var(--accent); transition:width .3s ease;}
    .footer-link:hover:after{width:100%;}
    #map{height:560px; border-radius:12px; overflow:hidden;}
    .leaflet-tooltip { font-weight:600; background:#fff; border:1px solid #cbd5e1; color:#1f2937; }
  </style>
</head>

<body class="font-roboto text-gray-800 bg-gray-50 min-h-screen flex flex-col">
  @include('partials.head')

  <!-- Hero -->
<section class="py-12 md:py-20 px-4 sm:px-6 lg:px-8 bg-white" id="acceuil">
  <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center">
    <!-- Texte d’introduction -->
    <div class="w-full lg:w-1/2 lg:pr-10 mb-10 lg:mb-0">
      <br><h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-gray-900">
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
          Bienvenue sur la plateforme
        </span>
      </h1>
<br>
      <p class="text-lg md:text-xl text-gray-700 mb-8 leading-relaxed">
        AMIE-FPT : Application de Management Intégrée des Établissements de Formation Professionnelle et Technique
      </p>
      <div class="flex flex-col sm:flex-row gap-4 items-start">
        <a href="{{ url('/request') }}"
           class="bg-primary text-white hover:bg-emerald-800 focus:ring-4 focus:ring-emerald-300 font-semibold py-3 px-6 rounded-md shadow-md transition">
          Demande d’ouverture d’un établissement privé 
        </a>
      </div>
    </div>

    <!-- Carte ou visuel -->
    <div class="w-full lg:w-1/2 mt-10 lg:mt-0">
    </div>
  </div>
</section>
<br> </br>

  <!-- Carte + Panneau -->

  <!-- Features -->
  <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
          Application de Management Intégrée des Établissements de la FPT
        </h2>
        <div class="w-20 h-1 bg-primary mx-auto"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-sm hover-scale border border-gray-100">
          <div class="text-primary mb-4 text-4xl"><i class="fas fa-chart-line"></i></div>
          <h3 class="text-xl font-semibold mb-3">Gestion intégrée</h3>
          <p class="text-gray-600">Solution complète pour la gestion administrative et pédagogique des établissements.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm hover-scale border border-gray-100">
          <div class="text-primary mb-4 text-4xl"><i class="fas fa-users-cog"></i></div>
          <h3 class="text-xl font-semibold mb-3">Suivi des apprenants</h3>
          <p class="text-gray-600">Outils performants pour le suivi individualisé des parcours de formation.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm hover-scale border border-gray-100">
          <div class="text-primary mb-4 text-4xl"><i class="fas fa-file-alt"></i></div>
          <h3 class="text-xl font-semibold mb-3">Reporting automatisé</h3>
          <p class="text-gray-600">Génération de rapports statistiques pour le pilotage du système.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer-institution text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div class="mb-8">
          <div class="flex items-center mb-4">
            <div class="bg-white p-2 rounded-lg mr-3">
              <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="5" fill="#0d6e5e"/>
                <path d="M10 20 L30 20 M20 10 L20 30" stroke="white" stroke-width="3" stroke-linecap="round"/>
                <circle cx="20" cy="20" r="8" stroke="white" stroke-width="2" fill="none"/>
              </svg>
            </div>
            <span class="text-xl font-bold">AMIE-FPT</span>
          </div>
          <p class="text-gray-300 mb-4 text-sm">
            Plateforme officielle du Ministère de la Formation Professionnelle et Technique pour la gestion des établissements.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-300 hover:text-white text-lg"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-300 hover:text-white text-lg"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-300 hover:text-white text-lg"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>

        <div class="mb-8">
          <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-700">Ministère</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-300 footer-link">Organisation</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Directions</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Services rattachés</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Stratégies</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Partenaires</a></li>
          </ul>
        </div>

        <div class="mb-8">
          <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-700">Ressources</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-300 footer-link">Publications</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Documents officiels</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Formations</a></li>
            <li><a href="#" class="text-gray-300 footer-link">FAQ</a></li>
            <li><a href="#" class="text-gray-300 footer-link">Guides</a></li>
          </ul>
        </div>

        <div class="mb-8">
          <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-700">Nous contacter</h3>
          <address class="not-italic text-gray-300 text-sm">
            <div class="flex items-start mb-3">
              <i class="fas fa-map-marker-alt mt-1 mr-3 text-accent"></i>
              <span>Ministère de la Formation Professionnelle<br>Sphère ministérielle Habib Thiam, Diamniadio, Dakar, Sénégal</span>
            </div>
            <div class="flex items-center mb-3">
              <i class="fas fa-phone-alt mr-3 text-accent"></i>
              <span>+221 33 865 70 70</span>
            </div>
            <div class="flex items-center mb-3">
              <i class="fas fa-envelope mr-3 text-accent"></i>
              <span>celluleinformatique@formation.gouv.sn</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-clock mr-3 text-accent"></i>
              <span>Lun–Ven : 8h00–18h00</span>
            </div>
          </address>
        </div>
      </div>

      <div class="border-t border-gray-700 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center">
        <div class="text-gray-400 text-xs mb-4 md:mb-0">
          &copy; {{ date('Y') }} Ministère de la Formation professionnelle et technique - Tous droits réservés
        </div>
        <div class="flex flex-wrap justify-center gap-4 text-xs">
          <a href="#" class="text-gray-400 hover:text-white transition">Mentions légales</a>
          <a href="#" class="text-gray-400 hover:text-white transition">Politique de confidentialité</a>
          <a href="#" class="text-gray-400 hover:text-white transition">Accessibilité</a>
          <a href="#" class="text-gray-400 hover:text-white transition">CGU</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts header (menu) -->
  <script>
    const header   = document.getElementById("header");
    const navAction= document.getElementById("navAction");
    const toToggle = document.querySelectorAll(".toggleColour");
    const navMenuDiv = document.getElementById("nav-content");
    const navMenu = document.getElementById("nav-toggle");

    if (header && navAction && navMenuDiv) {
      window.addEventListener("scroll", function () {
        if (window.scrollY > 10) {
          header.classList.add("bg-white", "shadow-md");
          header.classList.remove("bg-transparent");
          navAction.classList.remove("bg-white");
          navAction.classList.add("gradient-bg");
          navAction.classList.replace("text-gray-800", "text-white");
          toToggle.forEach(el => { el.classList.add("text-gray-800"); el.classList.remove("text-white"); });
        } else {
          header.classList.remove("bg-white", "shadow-md");
          header.classList.add("bg-transparent");
          navAction.classList.remove("gradient-bg");
          navAction.classList.add("bg-white");
          navAction.classList.replace("text-white", "text-gray-800");
          toToggle.forEach(el => { el.classList.add("text-white"); el.classList.remove("text-gray-800"); });
        }
      });

      function toggleMobileMenu(){
        navMenuDiv.classList.toggle("hidden");
        navMenuDiv.classList.toggle("animate-fadeIn");
      }
      if (navMenu) navMenu.addEventListener("click", toggleMobileMenu);

      const style = document.createElement('style');
      style.textContent = `
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(-10px); }
          to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn .3s ease-out forwards; }
      `;
      document.head.appendChild(style);
    }
  </script>


  @stack('myJS')
</body>
</html>
