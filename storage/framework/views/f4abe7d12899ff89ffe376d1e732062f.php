<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'type' => 'default'
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'type' => 'default'
]); ?>
<?php foreach (array_filter(([
    'type' => 'default'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
switch($type) {
    case('info'):
        $color = 'bg-gray-300';
        break;

    case('danger'):
        $color = 'bg-red-500';
        break;

    case('warning'):
        $color = 'bg-orange-500';
        break;

    default:
        $color = 'bg-blue-500';
        break;
}
?>

<span <?php echo e($attributes->merge(['class' => "$color rounded-full px-2 py-1 text-white text-xs font-semibold"])); ?>>
    <?php echo e($slot); ?>

</span>
<?php /**PATH /var/www/html/amie-fpt/resources/views/components/badge.blade.php ENDPATH**/ ?>