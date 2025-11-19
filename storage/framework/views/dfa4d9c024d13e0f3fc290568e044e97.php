<!DOCTYPE html>
<html lang="fr">
<head>
     <?php echo $__env->make('layouts.v1.partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AMIE FPT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
        }
        
        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
        }
        
        .login-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .logo-container {
            margin-bottom: 2rem;
        }
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        
        .logo-icon {
            background-color: var(--white);
            color: var(--primary);
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: bold;
        }
        
        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .platform-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .features-list {
            list-style: none;
            margin-top: 2rem;
        }
        
        .features-list li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
        
        .features-list li::before {
            content: "✓";
            color: var(--accent);
            font-weight: bold;
            margin-right: 10px;
            background: var(--white);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }
        
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-form-container {
            width: 100%;
            max-width: 450px;
            background: var(--white);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: var(--gray);
            font-size: 1rem;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .input-field {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 1px solid var(--gray-light);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s;
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 94, 0.1);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
            accent-color: var(--primary);
        }
        
        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        
        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 1rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .login-button:hover {
            background: var(--primary-dark);
        }
        
        .support-contact {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-light);
            text-align: center;
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .support-link {
            color: var(--primary);
            text-decoration: none;
        }
        
        .support-link:hover {
            text-decoration: underline;
        }
        
        /* Styles pour les icônes sociales du footer */
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
        
        #amie-footer .footer-social-icon.facebook { background-color: #3b5998; }
        #amie-footer .footer-social-icon.whatsapp { background-color: #25D366; }
        #amie-footer .footer-social-icon.linkedin { background-color: #0077B5; }
        #amie-footer .footer-social-icon.youtube { background-color: #FF0000; }
        
        #amie-footer .footer-social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-left {
                padding: 2rem 1.5rem;
            }
            
            .login-content {
                max-width: 100%;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .login-form-container {
                padding: 2rem 1.5rem;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .forgot-password {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <?php echo $__env->make('partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <br>
    <br>
    <div class="login-container">
        <div class="login-left">
            <div class="login-content">
                <h1 class="welcome-title">Application de Management Intégré des Etablissements FPT</h1>
                
                <p class="platform-description">
                    Plateforme officielle de gestion des établissements de formation professionnelle et technique. Accédez à tous les outils nécessaires pour administrer votre institution.
                </p>
                
                <ul class="features-list">
                    <li>Gestion centralisée des établissements</li>
                    <li>Suivi pédagogique et administratif</li>
                    <li>Tableaux de bord personnalisés</li>
                    <li>Outils de reporting avancés</li>
                    <li>Environnement sécurisé et confidentiel</li>
                </ul>
            </div>
        </div>
        
        <div class="login-right">
            <div class="login-form-container">
                <div class="form-header">
                    <h2 class="form-title">Connexion à votre espace</h2>
                    <p class="form-subtitle">Accédez à votre compte administrateur</p>
                </div>
                
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="input-group">
                        <label for="email" class="input-label">Adresse email</label>
                        <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="votre@email.com">
                    </div>
                    
                    <div class="input-group">
                        <label for="password" class="input-label">Mot de passe</label>
                        <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password" placeholder="Votre mot de passe">
                    </div>
                    
                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember_me" name="remember">
                            <label for="remember_me">Se souvenir de moi</label>
                        </div>
                        
                        <a href="<?php echo e(route('password.request')); ?>" class="forgot-password">
                            Mot de passe oublié?
                        </a>
                    </div>
                    
                    <button type="submit" class="login-button">
                        Se connecter
                    </button>
                </form>
                
                <div class="support-contact">
                    <p>Besoin d'assistance? <a href="#" class="support-link">Contactez le support</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
<br>
<br>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</html><?php /**PATH /var/www/html/pgi/resources/views/auth/login.blade.php ENDPATH**/ ?>