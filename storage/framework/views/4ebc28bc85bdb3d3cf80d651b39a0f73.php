<div class="container mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold text-left mb-8">Mon établissement</h1>

    <!--[if BLOCK]><![endif]--><?php if($etablissement): ?>
    <div class="bg-white shadow-md rounded-lg px-6 py-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col space-y-6">
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Nom:</span>
                    <span class="ml-2 text-gray-900 font-bold text-lg"><?php echo e($etablissement->nom ?? "Non renseigné"); ?></span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Acronym:</span>
                    <span class="ml-2 text-gray-900 font-bold text-lg"><?php echo e($etablissement->sigle ?? "Non renseigné"); ?></span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Adresse:</span>
                    <span class="ml-2 text-gray-900 text-lg"><?php echo e($etablissement->adresse ?? "Non renseigné"); ?></span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Boîte Postale:</span>
                    <span class="ml-2 text-gray-900 text-lg font-bold"><?php echo e($etablissement->boitePostale ?? "Non renseigné"); ?></span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Date de création:</span>
                    <span class="ml-2 text-gray-900 text-lg font-bold"><?php echo e(strftime('%d/%m/%Y', strtotime($etablissement->dateCreation)) ?? "Non renseigné"); ?></span>
                </div>
            </div>

            <div class="flex flex-col space-y-6">
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Site Web:</span>
                    <a href="<?php echo e($etablissement->siteWeb); ?>" class="ml-2 text-blue-500 hover:underline"><?php echo e($etablissement->siteWeb ?? "Non renseigné"); ?></a>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Email:</span>
                    <span class="ml-2 text-gray-900 text-lg"><?php echo e($etablissement->email ?? "Non renseigné"); ?></span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Téléphone:</span>
                    <span class="ml-2 text-gray-900 text-lg"><?php echo e($etablissement->telephone ?? "Non renseigné"); ?></span>
                </div>
                <div class="flex items-center  border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Reference:</span>
                    <span class="ml-2 text-gray-900 text-lg"><?php echo e($etablissement->reference); ?></span>
                </div>
                <div class="flex items-center  border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Commune:</span>
                    <span class="ml-2 text-gray-900 text-lg"><?php echo e($etablissement->commune->libelle ?? "Non renseigné"); ?></span>
                </div>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('modifier_mon_etablissement')): ?>
            <div class="px-2 pt-4 pb-2 text-left">
                    <a href="<?php echo e(route('etablissement.show', $etablissement->id)); ?>" class="mx-2 px-5 rounded-md py-4 flex text-white text-xs font-semibold text-center shadow-md bg-first-orange items-center justify-center">
                        <span class=" fas fa-edit"> Modifier</span>
                    </a>
                </div>
            <?php endif; ?>
            
        </div>

<?php endif; ?><!--[if ENDBLOCK]><![endif]--><?php /**PATH /var/www/html/pgi/resources/views/livewire/etablissements/info-etablissement.blade.php ENDPATH**/ ?>