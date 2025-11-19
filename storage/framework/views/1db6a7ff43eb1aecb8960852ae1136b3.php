<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('layouts.v1.partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/splide/css/splide.min.css')); ?>">
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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-100: #f7fafc;
            --gray-200: #edf2f7;
            --gray-300: #e2e8f0;
            --gray-400: #cbd5e0;
            --gray-500: #a0aec0;
            --gray-600: #718096;
            --gray-700: #4a5568;
            --gray-800: #2d3748;
            --gray-900: #1a202c;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius: 8px;
            --radius-lg: 12px;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.6;
        }
        
        .institutional-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
            position: relative;
            overflow: hidden;
            padding: 5rem 0;
        }
        
        .institutional-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("<?php echo e(asset('assets/images/pattern.png')); ?>") repeat;
            opacity: 0.05;
            pointer-events: none;
        }
        
        .header-content {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }
        
        .breadcrumb a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .breadcrumb a:hover {
            color: white;
        }
        
        .breadcrumb span {
            color: white;
            font-weight: 500;
        }
        
        .breadcrumb i {
            margin: 0 0.5rem;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .page-subtitle {
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 700px;
            margin-bottom: 2rem;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 2rem;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--first-orange);
            border-radius: 2px;
        }
        
        .institutional-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
        }
        
        .institutional-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: var(--gray-100);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--gray-200);
            background: var(--gray-100);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        
        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .pagination a {
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            background: white;
        }
        
        .pagination a:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
        }
        
        .pagination a.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .pagination span {
            color: var(--gray-500);
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: var(--radius-lg);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
            margin-top: 3rem;
        }
        
        .cta-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta-text {
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }
        
        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .cta-button i {
            margin-right: 0.5rem;
        }
        
        /* Table styles */
        .responsive-table {
            width: 100%;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        thead {
            background: var(--primary);
        }
        
        th {
            padding: 1rem;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        tbody tr {
            background: white;
            transition: var(--transition);
        }
        
        tbody tr:nth-child(even) {
            background: var(--gray-100);
        }
        
        tbody tr:hover {
            background: var(--primary-light);
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.95rem;
        }
        
        /* Alert styles */
        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }
        
        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }
        
        .alert i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .institutional-header {
                padding: 3rem 0;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .card-header, .card-body, .card-footer {
                padding: 1.25rem;
            }
            
            th, td {
                padding: 0.75rem;
            }
            
            .cta-section {
                padding: 2rem 1.5rem;
            }
            
            .cta-title {
                font-size: 1.5rem;
            }
            
            .cta-text {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .page-title {
                font-size: 1.75rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .pagination a, .pagination span {
                width: 2.25rem;
                height: 2.25rem;
                font-size: 0.875rem;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Utilities */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .mt-8 {
            margin-top: 2rem;
        }
        
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php echo $__env->make('partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- En-tête institutionnel amélioré -->
    <header class="institutional-header">
        <div class="header-content">
            <nav class="breadcrumb">
                <a href="#"><i class="fas fa-home"></i> Accueil</a>
                <i class="fas fa-chevron-right"></i>
                <span>Programmes</span>
            </nav>
            
            <h1 class="page-title">Registre des programmes</h1>
            <p class="page-subtitle">
                Découvrez l'ensemble des programmes de formation professionnelle proposés par notre institution.
            </p>
        </div>
    </header>

    <main class="animate-fadeIn" style="padding: 3rem 1.5rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <!-- Section titre avec effet institutionnel -->
            <div class="text-center mb-6">
                <h2 class="section-title">
                    Programmes de formation
                </h2>
                <p class="mt-4" style="color: var(--gray-600); max-width: 700px; margin: 0 auto;">
                    Explorez notre offre complète de programmes de formation professionnelle conçus pour répondre aux besoins du marché.
                </p>
            </div>

            <!-- Contenu principal -->
            <div class="institutional-card">
                <div class="card-body">
                    <?php echo $__env->make('layouts.v1.partials._alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                    <!-- Liste des programmes -->
                    <div class="responsive-table">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Etablissements.front-liste-programme', []);

$__html = app('livewire')->mount($__name, $__params, 'lw--2094876248-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <a href="#"><i class="fas fa-chevron-left"></i></a>
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <span>...</span>
                        <a href="#"><i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Section d'appel à l'action -->
            <div class="cta-section">
                <h3 class="cta-title">Vous souhaitez plus d'informations ?</h3>
                <p class="cta-text">
                    Notre équipe est à votre disposition pour répondre à toutes vos questions concernant nos programmes de formation.
                </p>
                <a href="#" class="cta-button">
                    <i class="fas fa-envelope"></i> Contactez-nous
                </a>
            </div>
        </div>
    </main>

    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('layouts.v1.partials._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('assets/libs/splide/js/splide.min.js')); ?>"></script>
    <script>
        // Script pour améliorer l'interactivité
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au survol
            const cards = document.querySelectorAll('.institutional-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                    card.style.boxShadow = 'var(--shadow-lg)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                    card.style.boxShadow = 'var(--shadow)';
                });
            });
            
            // Animation des lignes du tableau
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 100 + (index * 50));
            });
            
            // Animation des éléments de pagination
            const paginationItems = document.querySelectorAll('.pagination a, .pagination span');
            paginationItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                item.style.transition = 'opacity 0.3s ease, transform 0.3s ease, background 0.3s ease, color 0.3s ease';
                
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 500 + (index * 100));
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('myJS'); ?>
</body>
</html><?php /**PATH /var/www/html/pgi/resources/views/programmes.blade.php ENDPATH**/ ?>