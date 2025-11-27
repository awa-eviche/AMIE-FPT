<div class="relative">
    <div wire:loading class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-50">
        <div class="w-full h-full flex items-center justify-center">
            <p class="text-first-orange text-sm">charging ...</p>
        </div>
    </div>
    <?php if($isCharging): ?>
        <div class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-50">
            <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
            <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
            <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        </div>

    <?php endif; ?>
    <button wire:click="transmettre" class="bg-first-orange text-white rounded py-2 px-4 mr-5 font-bold">
        recuperer recepisse
    </button>
</div>
<?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/etude-demande/transmettre-recepisse.blade.php ENDPATH**/ ?>