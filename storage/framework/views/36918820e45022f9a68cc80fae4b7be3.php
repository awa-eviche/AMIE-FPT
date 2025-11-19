<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des apprenants - <?php echo e($classe->libelle); ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
<h1 style="font-size:16px;">
    <span style="font-weight:bold;">Etablissement :</span>
    <span style="font-weight:normal;"><?php echo e($classe->etablissement->sigle ?? $classe->etablissement->nom); ?></span>
</h1>

<h2 style="font-size:14px;">
    <span style="font-weight:bold;">Année académique :</span>
    <span style="font-weight:normal;"><?php echo e($anneeAcademique->code ?? '-'); ?></span>
</h2>

<h2 style="font-size:14px;">
    <span style="font-weight:bold;">Classe :</span>
    <span style="font-weight:normal;"><?php echo e($classe->libelle); ?></span>
</h2>

   

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénoms</th>
                <th>Date de naissance</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($inscription->apprenant->matricule ?? '-'); ?></td>
                    <td><?php echo e($inscription->apprenant->nom ?? '-'); ?> <?php echo e($inscription->apprenant->prenom ?? ''); ?></td>
                    <td><?php echo e(optional($inscription->apprenant)->date_naissance ? \Carbon\Carbon::parse($inscription->apprenant->date_naissance)->format('d-m-Y') : '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH /var/www/html/pgi/resources/views/classe/pdf.blade.php ENDPATH**/ ?>