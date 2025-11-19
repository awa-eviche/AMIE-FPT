<div>
    <p><?php echo e($warning); ?></p>
    <!--[if BLOCK]><![endif]--><?php if($demande->documents->count()!= 0): ?>
        <div class="flex justify-between p-3 mt-3">
            <p class="font-bold text-xl">Pièce jointes</p>
            <div class="flex">
                <!--[if BLOCK]><![endif]--><?php if($readyToSign): ?>
                    <button wire:click="toggleReadyToSign" class="bg-red-800 mr-3 hover:bg-red-900 text-white font-bold px-3 py-2 rounded hover:shadow">Annuler</button>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <button <?php echo e($disabled ? 'disabled' : ''); ?>  wire:click="signer" class="flex items-center bg-green-800 hover:bg-green-900 hover:shadow-xl text-white font-bold px-3 py-2 rounded hover:shadow">
                    <span class="mr-2">
                        Signer
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 512 512">
                        <path fill="white" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                    </svg>
                </button>

            </div>
        </div>
        
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'timeToConfirme','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'timeToConfirme','maxWidth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('2xl')]); ?>
            <div class="p-4">
                <div class="">
                    <p class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" height="150" fill="orange" viewBox="0 0 512 512">
                            <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                        </svg>

                    </p>
                    <p class="text-2xl">Assurez-vous que ces informations sont valides !</p>
                    <p>Si elles ne sont pas valides, il faut les modifier ou contacter l'admin avant de procéder à la signature</p>
                    <p class="text-sm text-first-orange">Si vous continuez, sachez que vous allez recevoir un mail et un sms qui seront essentiel pour la signature.</p>

                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Prénom :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-maquette"><?php echo e(Auth::user()->prenom); ?></span>
                        </div>
                    </div>

                    <hr>
                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Nom :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-maquette"><?php echo e(Auth::user()->nom); ?></span>
                        </div>
                    </div>

                    <hr>
                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Email :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-maquette"><?php echo e(Auth::user()->email); ?></span>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Libellé :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-maquette"><?php echo e(Auth::user()->telephone); ?></span>
                        </div>
                    </div>

                    <hr>


                </div>
                <div class="flex justify-end mt-4">
                    <button  wire:click="toggleTimeToConfirm" class="cursor-pointer bg-red-800 hover:shadow-xl hover:bg-red-900 py-2 rounded px-3 text-center text-white">
                        fermer
                    </button>
                    <button <?php echo e($disabled ? "disabled" : ''); ?> wire:click="signerUnDocument" class="ml-3 flex items-center cursor-pointer bg-green-800 hover:bg-green-900 hover:shadow-xl py-2 rounded px-3 text-center text-white">
                        <span class="mr-3">
                            Procéder à la signature
                        </span>
                        <svg height="20" viewBox="0 0 512 512" style="fill : white">
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                        </svg>
                    </button>


                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
   

        <!--[if BLOCK]><![endif]--><?php if($lienSignature != null): ?>
            <p class="pl-4">clique sur ce lien pour continuer la signature</p>
            <a class="text-green-500 pl-4 cursor-pointer" href="<?php echo e($lienSignature); ?>"><?php echo e($lienSignature); ?></a>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="mt-5 border border-gray-100">
            <ul class="list-disc pl-4 flex flex-wrap">

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $demande->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">
                        <!--[if BLOCK]><![endif]--><?php if($readyToSign): ?>
                            <div class="mr-2">
                                <input type="radio" name="idDocumentToSign" value="<?php echo e($document->id); ?>" id="<?php echo e($document->id); ?>" wire:model="idDocumentToSign">

                            </div>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="flex items-center w-[250px] overflow-hidden">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#068F7D"/>
                                <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#068F7D"/>
                            </svg>

                            <span class="ml-3 w-[225px] overflow-hidden"><?php echo e($document["nom"]); ?></span>
                        </div>
                        <div class="flex items-center w-[60px] justify-between">
                            <a href="<?php echo e(asset('/storage/' . $document->lien_ressource)); ?>" target="_blank">
                                <svg width="18" height="18" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_747_2897)">
                                    <path d="M0.916992 6.99998C0.916992 6.99998 3.25033 2.33331 7.33366 2.33331C11.417 2.33331 13.7503 6.99998 13.7503 6.99998C13.7503 6.99998 11.417 11.6666 7.33366 11.6666C3.25033 11.6666 0.916992 6.99998 0.916992 6.99998Z" stroke="#068F7D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7.3335 8.75C8.29999 8.75 9.0835 7.9665 9.0835 7C9.0835 6.0335 8.29999 5.25 7.3335 5.25C6.367 5.25 5.5835 6.0335 5.5835 7C5.5835 7.9665 6.367 8.75 7.3335 8.75Z" stroke="#068F7D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_747_2897">
                                    <rect width="14" height="14" fill="white" transform="translate(0.333496)"/>
                                    </clipPath>
                                    </defs>
                                </svg>

                            </a>
                            <a href="<?php echo e(asset('/storage/' . $document->lien_ressource)); ?>" download>
                                <svg width="18" height="17" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5835 8.75V11.0833C12.5835 11.3928 12.4606 11.6895 12.2418 11.9083C12.023 12.1271 11.7262 12.25 11.4168 12.25H3.25016C2.94074 12.25 2.644 12.1271 2.4252 11.9083C2.20641 11.6895 2.0835 11.3928 2.0835 11.0833V8.75" stroke="#068F7D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.41699 5.83331L7.33366 8.74998L10.2503 5.83331" stroke="#068F7D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7.3335 8.75V1.75" stroke="#068F7D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                            </a>

                            <button wire:click="supprimerDocument(<?php echo e($document); ?>)">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 11L1 1M1 11L11 1" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>


                        </div>
                    </li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </ul>

        </div>
    <?php else: ?>
        <div class="min-h-screen">
            <p class="my-5  text-center text-first-orange font-black">Pas de documents trouvé pour la demande</p>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/etude-demande/gerer-document.blade.php ENDPATH**/ ?>