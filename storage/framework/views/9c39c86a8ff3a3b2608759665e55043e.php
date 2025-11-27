<div class="flex flex-wrap bg-white rounded">

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('detail-etat', ['etatWorkflow' => $etatWorkflow]);

$__html = app('livewire')->mount($__name, $__params, 'lw-889698912-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <div class="w-full md:w-1/2 p-4">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('manage-profil-access', ['etatWorkflow' => $etatWorkflow]);

$__html = app('livewire')->mount($__name, $__params, 'lw-889698912-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('manage-type-notification', ['etatWorkflow' => $etatWorkflow]);

$__html = app('livewire')->mount($__name, $__params, 'lw-889698912-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>


    </div>


</div>
<?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/show-etat-workflow.blade.php ENDPATH**/ ?>