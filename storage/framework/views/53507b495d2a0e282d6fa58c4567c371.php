<!DOCTYPE html>
<html>
<head>
    <title>Rapport d'évaluation</title>
</head>
<body>
    <h1>Rapport d'évaluation pour l'apprenant <?php echo e(optional($evaluation->inscription)->apprenant->nom ?? 'Non disponible'); ?> <?php echo e(optional($evaluation->inscription)->apprenant->prenom ?? 'Non disponible'); ?></h1>
    <p>Semestre: <?php echo e($evaluation->semestre); ?></p>
    <p>Matière: <?php echo e(optional($evaluation->matiere)->nom ?? 'Non disponible'); ?></p>
    <p>Coef: <?php echo e($evaluation->coef); ?></p>
    <p>Note CC: <?php echo e($evaluation->note_cc); ?></p>
    <p>Note Composition: <?php echo e($evaluation->note_composition); ?></p>
</body>
</html>
<?php /**PATH /var/www/html/amie-fpt/resources/views/evaluation/pdf_template.blade.php ENDPATH**/ ?>