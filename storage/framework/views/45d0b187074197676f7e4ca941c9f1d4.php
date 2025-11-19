<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMIE FPT - Footer Isolé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset spécifique au footer seulement */
        #amie-footer * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        
        #amie-footer {
            --primary: #0d6e5e;
            --primary-dark: #0a5649;
            --primary-light: #e0f2f1;
            --secondary: #2c5282;
            --secondary-dark: #1e3a8a;
            --accent: #ecc94b;
            --light: #f8f9fa;
            --dark: #2d3748;
            --gray: #718096;
            
            /* Couleurs des réseaux sociaux */
            --facebook: #3b5998;
            --whatsapp: #25D366;
            --linkedin: #0077B5;
            --youtube: #FF0000;
            
            /* Styles isolés pour le footer */
            background: linear-gradient(to right, var(--primary-dark), var(--secondary-dark));
            border-top: 4px solid var(--accent);
            position: relative;
            overflow: hidden;
            color: white;
        }
        
        #amie-footer .footer-banner {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            z-index: 0;
        }
        
        #amie-footer .footer-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(10, 86, 73, 0.9), rgba(30, 58, 138, 0.9));
            z-index: 1;
        }
        
        #amie-footer .footer-content {
            position: relative;
            z-index: 2;
        }
        
        #amie-footer .footer-link {
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        #amie-footer .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        
        #amie-footer .footer-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }
        
        #amie-footer .footer-link:hover:after {
            width: 100%;
        }
        
        /* Style des icônes sociales */
        #amie-footer .footer-social-icons {
            display: flex;
            gap: 12px;
            margin-top: 1rem;
        }
        
        #amie-footer .footer-social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 18px;
        }
        
        #amie-footer .footer-social-icon.facebook { background-color: var(--facebook); }
        #amie-footer .footer-social-icon.whatsapp { background-color: var(--whatsapp); }
        #amie-footer .footer-social-icon.linkedin { background-color: var(--linkedin); }
        #amie-footer .footer-social-icon.youtube { background-color: var(--youtube); }
        
        #amie-footer .footer-social-icon:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        /* Utilitaires Tailwind-like isolés */
        #amie-footer .text-white { color: white; }
        #amie-footer .text-gray-300 { color: rgba(255, 255, 255, 0.7); }
        #amie-footer .text-gray-400 { color: rgba(255, 255, 255, 0.5); }
        #amie-footer .text-accent { color: var(--accent); }
        #amie-footer .text-xl { font-size: 1.25rem; }
        #amie-footer .text-lg { font-size: 1.125rem; }
        #amie-footer .text-sm { font-size: 0.875rem; }
        #amie-footer .text-xs { font-size: 0.75rem; }
        
        #amie-footer .font-bold { font-weight: 700; }
        #amie-footer .font-semibold { font-weight: 600; }
        
        #amie-footer .bg-white { background-color: white; }
        
        #amie-footer .mx-auto { 
            margin-left: auto; 
            margin-right: auto; 
            max-width: 80rem;
        }
        
        #amie-footer .mt-auto { margin-top: auto; }
        #amie-footer .mb-8 { margin-bottom: 2rem; }
        #amie-footer .mb-4 { margin-bottom: 1rem; }
        #amie-footer .mb-3 { margin-bottom: 0.75rem; }
        #amie-footer .mr-3 { margin-right: 0.75rem; }
        #amie-footer .mt-1 { margin-top: 0.25rem; }
        #amie-footer .mt-8 { margin-top: 2rem; }
        
        #amie-footer .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        #amie-footer .px-4 { padding-left: 1rem; padding-right: 1rem; }
        #amie-footer .p-2 { padding: 0.5rem; }
        
        #amie-footer .flex { display: flex; }
        #amie-footer .items-center { align-items: center; }
        #amie-footer .items-start { align-items: flex-start; }
        #amie-footer .justify-center { justify-content: center; }
        #amie-footer .justify-between { justify-content: space-between; }
        
        #amie-footer .grid { display: grid; }
        #amie-footer .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        
        #amie-footer .gap-8 { gap: 2rem; }
        #amie-footer .gap-4 { gap: 1rem; }
        
        #amie-footer .space-y-2 > * + * { margin-top: 0.5rem; }
        
        #amie-footer .rounded-lg { border-radius: 0.5rem; }
        
        #amie-footer .border-b { border-bottom-width: 1px; }
        #amie-footer .border-t { border-top-width: 1px; }
        #amie-footer .border-gray-700 { border-color: rgba(255, 255, 255, 0.2); }
        
        #amie-footer .relative { position: relative; }
        #amie-footer .absolute { position: absolute; }
        
        #amie-footer .overflow-hidden { overflow: hidden; }
        
        #amie-footer .transition { transition: all 0.3s ease; }
        #amie-footer .hover\:text-white:hover { color: white; }
        
        /* Responsive */
        @media (max-width: 768px) {
            #amie-footer .footer-social-icons {
                justify-content: center;
            }
            
            #amie-footer .grid-cols-1, 
            #amie-footer .md\:grid-cols-3, 
            #amie-footer .lg\:grid-cols-4 {
                grid-template-columns: 1fr;
            }
            
            #amie-footer .md\:flex-row {
                flex-direction: column;
            }
            
            #amie-footer .md\:mb-0 {
                margin-bottom: 1rem;
            }
        }
        
        @media (min-width: 769px) {
            #amie-footer .md\:grid-cols-3 { 
                grid-template-columns: repeat(3, minmax(0, 1fr)); 
            }
            
            #amie-footer .md\:flex-row { 
                flex-direction: row; 
            }
            
            #amie-footer .md\:mb-0 { 
                margin-bottom: 0; 
            }
        }
        
        @media (min-width: 1024px) {
            #amie-footer .lg\:grid-cols-4 { 
                grid-template-columns: repeat(4, minmax(0, 1fr)); 
            }
            
            #amie-footer .lg\:px-8 { 
                padding-left: 2rem; 
                padding-right: 2rem; 
            }
        }
        
        #amie-footer .sm\:px-6 { 
            padding-left: 1.5rem; 
            padding-right: 1.5rem; 
        }
    </style>
</head>
<body>
   
  
    <!-- Footer avec encapsulation des styles -->
    <footer id="amie-footer" class="mt-auto">
        <!-- Banner en arrière-plan -->
        <div class="footer-banner"></div>
        <!-- Overlay pour améliorer la lisibilité -->
        <div class="footer-overlay"></div>
        
        <div class="footer-content mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Logo et description -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-white p-2 rounded-lg mr-3">
                            
                        </div>
                        <span class="text-xl font-bold">AMIE-FPT</span>
                    </div>
                    <p class="text-gray-300 mb-4 text-sm">
                        Plateforme officielle du Ministère de la Formation Professionnelle et Technique pour la gestion des établissements.
                    </p>
                    <div class="footer-social-icons">
                        <a href="#" class="footer-social-icon facebook" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="footer-social-icon whatsapp" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="footer-social-icon linkedin" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="footer-social-icon youtube" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Liens Institutionnels -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-700">Ministère</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="footer-link">Organisation</a></li>
                        <li><a href="#" class="footer-link">Directions</a></li>
                        <li><a href="#" class="footer-link">Services rattachés</a></li>
                        <li><a href="#" class="footer-link">Stratégies</a></li>
                        <li><a href="#" class="footer-link">Partenaires</a></li>
                    </ul>
                </div>

                <!-- Liens Utiles -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-700">Ressources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="footer-link">Publications</a></li>
                        <li><a href="#" class="footer-link">Documents officiels</a></li>
                        <li><a href="#" class="footer-link">Formations</a></li>
                        <li><a href="#" class="footer-link">FAQ</a></li>
                        <li><a href="#" class="footer-link">Guides</a></li>
                    </ul>
                </div>

                <!-- Contact Institutionnel -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-700">Nous contacter</h3>
                    <address class="not-italic text-gray-300 text-sm">
                        <div class="flex items-start mb-3">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-accent"></i>
                            <span>Ministère de la Formation Professionnelle et Technique<br>Sphère ministérielle Habib Thiam, Diamniadio, Dakar, Sénégal</span>
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
                            <span>Lun-Ven: 8h00-18h00</span>
                        </div>
                    </address>
                </div>
            </div>

            <!-- Copyright et Mentions légales -->
            <div class="border-t border-gray-700 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-xs mb-4 md:mb-0">
                    &copy; 2025 Ministère de la Formation Professionnelle et Technique - Tous droits réservés
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
</body>
</html><?php /**PATH /var/www/html/pgi/resources/views/partials/footer.blade.php ENDPATH**/ ?>