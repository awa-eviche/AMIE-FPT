<div x-data="app(<?php echo e($livewireStep); ?>)" x-init="init()" x-cloak class="rounded-sm bg-white shadow-xl py-3 mx-4 px-4 mb-5">

 <div class="mt-3">
 <!-- component -->
 <div class="flex justify-between text-base text-gray-600">

 

 <div class="text-right">
 <div class="w-8 h-8 bg-first-orange rounded-full flex items-center justify-center text-white text-sm ml-auto">
 <span x-show="step== 1">1</span>
 <svg x-show="step != 1" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M11.9433 0.246499C11.8658 0.168392 11.7736 0.106396 11.6721 0.0640889C11.5705 0.0217817 11.4616 0 11.3516 0C11.2416 0 11.1327 0.0217817 11.0311 0.0640889C10.9296 0.106396 10.8374 0.168392 10.7599 0.246499L4.5516 6.46317L1.94327 3.8465C1.86283 3.7688 1.76788 3.7077 1.66384 3.6667C1.55979 3.6257 1.44869 3.60559 1.33687 3.60752C1.22505 3.60946 1.11471 3.6334 1.01215 3.67798C0.909582 3.72255 0.816801 3.7869 0.739102 3.86733C0.661403 3.94777 0.600308 4.04272 0.559305 4.14676C0.518302 4.25081 0.498193 4.36191 0.500127 4.47373C0.502062 4.58555 0.526002 4.69589 0.57058 4.79845C0.615158 4.90102 0.679501 4.9938 0.759935 5.0715L3.95994 8.2715C4.03741 8.34961 4.12957 8.4116 4.23112 8.45391C4.33267 8.49622 4.44159 8.518 4.5516 8.518C4.66161 8.518 4.77053 8.49622 4.87208 8.45391C4.97363 8.4116 5.0658 8.34961 5.14327 8.2715L11.9433 1.4715C12.0279 1.39346 12.0954 1.29875 12.1415 1.19334C12.1877 1.08792 12.2115 0.974084 12.2115 0.858999C12.2115 0.743914 12.1877 0.630076 12.1415 0.52466C12.0954 0.419244 12.0279 0.324534 11.9433 0.246499Z" fill="white" />
 </svg>
 </div>
 <p class="mt-2 text-first-orange text-xs text-center">Informations générales</p>
 </div>

 

 <div class="h-1 w-full bg-first-orange mr-1 mt-3"></div>
 <div x-bind:class="{
 'bg-gray-400': step == 1,
 'bg-first-orange': step != 1
 }" class="h-1 w-full mt-3">
 </div>

 

 <div class="text-center">
 <div class="mx-auto">
 <div x-bind:class="{
 'bg-first-orange': step >= 2,
 'bg-gray-400': step < 2
 }" class="mx-auto w-8 h-8 rounded-full flex flex-col items-center justify-center text-white text-sm text-center">


 <span x-show="step <=2 ">2</span>
 <svg x-show="step > 2" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M11.9433 0.246499C11.8658 0.168392 11.7736 0.106396 11.6721 0.0640889C11.5705 0.0217817 11.4616 0 11.3516 0C11.2416 0 11.1327 0.0217817 11.0311 0.0640889C10.9296 0.106396 10.8374 0.168392 10.7599 0.246499L4.5516 6.46317L1.94327 3.8465C1.86283 3.7688 1.76788 3.7077 1.66384 3.6667C1.55979 3.6257 1.44869 3.60559 1.33687 3.60752C1.22505 3.60946 1.11471 3.6334 1.01215 3.67798C0.909582 3.72255 0.816801 3.7869 0.739102 3.86733C0.661403 3.94777 0.600308 4.04272 0.559305 4.14676C0.518302 4.25081 0.498193 4.36191 0.500127 4.47373C0.502062 4.58555 0.526002 4.69589 0.57058 4.79845C0.615158 4.90102 0.679501 4.9938 0.759935 5.0715L3.95994 8.2715C4.03741 8.34961 4.12957 8.4116 4.23112 8.45391C4.33267 8.49622 4.44159 8.518 4.5516 8.518C4.66161 8.518 4.77053 8.49622 4.87208 8.45391C4.97363 8.4116 5.0658 8.34961 5.14327 8.2715L11.9433 1.4715C12.0279 1.39346 12.0954 1.29875 12.1415 1.19334C12.1877 1.08792 12.2115 0.974084 12.2115 0.858999C12.2115 0.743914 12.1877 0.630076 12.1415 0.52466C12.0954 0.419244 12.0279 0.324534 11.9433 0.246499Z" fill="white" />
 </svg>


 </div>
 <p class="mt-2 text-xs text-center" x-bind:class="{
 'text-gray-500': step == 1,
 'text-first-orange': step != 1
 }">
 Informations de l'établissement
 </p>
 </div>
 </div>

 
 <div class="h-1 w-full bg-first-orange mr-1 mt-3" x-bind:class="{
 'bg-first-orange': step >= 2,
 'bg-gray-400': step < 2
 }">
 </div>
 <div class="h-1 w-full mt-3" x-bind:class="{
 'bg-first-orange': step >= 3,
 'bg-gray-400': step < 3
 }">
 </div>

 
 <div class="text-center">
 <div class="mx-auto">
 <div class="mx-auto w-8 h-8 rounded-full flex flex-col items-center justify-center text-white text-sm text-center" x-bind:class="{
 'bg-first-orange': step >= 3,
 'bg-gray-400': step < 3
 }">


 <span x-show="step <= 3">3</span>
 <svg x-show="step > 3" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M11.9433 0.246499C11.8658 0.168392 11.7736 0.106396 11.6721 0.0640889C11.5705 0.0217817 11.4616 0 11.3516 0C11.2416 0 11.1327 0.0217817 11.0311 0.0640889C10.9296 0.106396 10.8374 0.168392 10.7599 0.246499L4.5516 6.46317L1.94327 3.8465C1.86283 3.7688 1.76788 3.7077 1.66384 3.6667C1.55979 3.6257 1.44869 3.60559 1.33687 3.60752C1.22505 3.60946 1.11471 3.6334 1.01215 3.67798C0.909582 3.72255 0.816801 3.7869 0.739102 3.86733C0.661403 3.94777 0.600308 4.04272 0.559305 4.14676C0.518302 4.25081 0.498193 4.36191 0.500127 4.47373C0.502062 4.58555 0.526002 4.69589 0.57058 4.79845C0.615158 4.90102 0.679501 4.9938 0.759935 5.0715L3.95994 8.2715C4.03741 8.34961 4.12957 8.4116 4.23112 8.45391C4.33267 8.49622 4.44159 8.518 4.5516 8.518C4.66161 8.518 4.77053 8.49622 4.87208 8.45391C4.97363 8.4116 5.0658 8.34961 5.14327 8.2715L11.9433 1.4715C12.0279 1.39346 12.0954 1.29875 12.1415 1.19334C12.1877 1.08792 12.2115 0.974084 12.2115 0.858999C12.2115 0.743914 12.1877 0.630076 12.1415 0.52466C12.0954 0.419244 12.0279 0.324534 11.9433 0.246499Z" fill="white" />
 </svg>

 </div>
 <p class="mt-2 text-gray-500 text-xs text-center" x-bind:class="{
 'text-gray-500': step < 3,
 'text-first-orange': step >= 3
 }">
 Informations liées à la demande
 </p>
 </div>
 </div>

 
 <div class="h-1 w-full mr-1 mt-3" x-bind:class="{
 'bg-first-orange': step >= 3,
 'bg-gray-400': step < 3
 }">
 </div>
 <div class="h-1 w-full mt-3" x-bind:class="{
 'bg-first-orange': step >= 4,
 'bg-gray-400': step < 4
 }">
 </div>

 
 <div class="text-center">
 <div class="mx-auto">
 <div class="mx-auto w-8 h-8 rounded-full flex flex-col items-center justify-center text-white text-sm text-center" x-bind:class="{
 'bg-first-orange': step >= 4,
 'bg-gray-400': step < 4
 }">


 <span x-show="step <= 4">4</span>
 <svg x-show="step > 4" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M11.9433 0.246499C11.8658 0.168392 11.7736 0.106396 11.6721 0.0640889C11.5705 0.0217817 11.4616 0 11.3516 0C11.2416 0 11.1327 0.0217817 11.0311 0.0640889C10.9296 0.106396 10.8374 0.168392 10.7599 0.246499L4.5516 6.46317L1.94327 3.8465C1.86283 3.7688 1.76788 3.7077 1.66384 3.6667C1.55979 3.6257 1.44869 3.60559 1.33687 3.60752C1.22505 3.60946 1.11471 3.6334 1.01215 3.67798C0.909582 3.72255 0.816801 3.7869 0.739102 3.86733C0.661403 3.94777 0.600308 4.04272 0.559305 4.14676C0.518302 4.25081 0.498193 4.36191 0.500127 4.47373C0.502062 4.58555 0.526002 4.69589 0.57058 4.79845C0.615158 4.90102 0.679501 4.9938 0.759935 5.0715L3.95994 8.2715C4.03741 8.34961 4.12957 8.4116 4.23112 8.45391C4.33267 8.49622 4.44159 8.518 4.5516 8.518C4.66161 8.518 4.77053 8.49622 4.87208 8.45391C4.97363 8.4116 5.0658 8.34961 5.14327 8.2715L11.9433 1.4715C12.0279 1.39346 12.0954 1.29875 12.1415 1.19334C12.1877 1.08792 12.2115 0.974084 12.2115 0.858999C12.2115 0.743914 12.1877 0.630076 12.1415 0.52466C12.0954 0.419244 12.0279 0.324534 11.9433 0.246499Z" fill="white" />
 </svg>

 </div>
 <p class="mt-2 text-xs text-center" x-bind:class="{
 'text-gray-500': step < 4,
 'text-first-orange': step >= 4
 }">
 Pièces jointes
 </p>
 </div>
 </div>

 
 <div class="h-1 w-full mr-1 mt-3" x-bind:class="{
 'bg-first-orange': step >= 4,
 'bg-gray-400': step < 4
 }">
 </div>
 <div class="h-1 w-full mt-3" x-bind:class="{
 'bg-first-orange': step >= 5,
 'bg-gray-400': step < 5
 }">
 </div>

 
 <div>
 <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm" x-bind:class="{
 'bg-first-orange': step >= 5,
 'bg-gray-400': step < 5
 }">


 <span x-show="step <= 5">5</span>
 <svg x-show="step > 5" width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M11.9433 0.246499C11.8658 0.168392 11.7736 0.106396 11.6721 0.0640889C11.5705 0.0217817 11.4616 0 11.3516 0C11.2416 0 11.1327 0.0217817 11.0311 0.0640889C10.9296 0.106396 10.8374 0.168392 10.7599 0.246499L4.5516 6.46317L1.94327 3.8465C1.86283 3.7688 1.76788 3.7077 1.66384 3.6667C1.55979 3.6257 1.44869 3.60559 1.33687 3.60752C1.22505 3.60946 1.11471 3.6334 1.01215 3.67798C0.909582 3.72255 0.816801 3.7869 0.739102 3.86733C0.661403 3.94777 0.600308 4.04272 0.559305 4.14676C0.518302 4.25081 0.498193 4.36191 0.500127 4.47373C0.502062 4.58555 0.526002 4.69589 0.57058 4.79845C0.615158 4.90102 0.679501 4.9938 0.759935 5.0715L3.95994 8.2715C4.03741 8.34961 4.12957 8.4116 4.23112 8.45391C4.33267 8.49622 4.44159 8.518 4.5516 8.518C4.66161 8.518 4.77053 8.49622 4.87208 8.45391C4.97363 8.4116 5.0658 8.34961 5.14327 8.2715L11.9433 1.4715C12.0279 1.39346 12.0954 1.29875 12.1415 1.19334C12.1877 1.08792 12.2115 0.974084 12.2115 0.858999C12.2115 0.743914 12.1877 0.630076 12.1415 0.52466C12.0954 0.419244 12.0279 0.324534 11.9433 0.246499Z" fill="white" />
 </svg>

 </div>
 <p class="mt-2 text-gray-500 text-xs text-center" x-bind:class="{
 'text-gray-500': step < 5,
 'text-first-orange': step >= 5
 }">
 Récapitulatif
 </p>

 </div>
 </div>
 </div>
 <form wire:submit.prevent="something">
 <div class="relative">
 <div wire:loading class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-50">
 <div class="w-full h-full flex items-center justify-center">
 <p class="text-first-orange text-sm">charging ...</p>
 </div>
 </div>
 <!--[if BLOCK]><![endif]--><?php if($isCharging): ?>
 <div class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-50">
 <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
 <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
 <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
 </div>

 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <div class="mx-auto pt-3">

 <div x-show.transition="step == 6">
 <div class="bg-white rounded-lg p-10 flex items-center shadow justify-between">
 <div class="lg:flex items-center w-full">
 <div class="mr-4 mb-4 lg:mb-0 lg:w-1/2 p-5">
 <img src="<?php echo e(asset('/assets/images/imageFin.png')); ?>" alt="Image" class="w-full">
 </div>
 <div class="lg:w-1/2">
 <h2 class="font-black text-xl mb-2 text-first-orange uppercase">Votre demande est enregistrée avec succès</h2>
 <!-p class="font-black mb-3 text-black">Vous recevrez une notification par e-mail dès qu'une mise à jour sera disponible.<--/p>
 <p class="font-thin text-black">
 Nous vous remercions de votre confiance et vous encourageons à consulter régulièrement votre espace personnel pour suivre l'évolution de votre dossier. En cas de questions, notre équipe reste disponible pour vous accompagner dans toutes vos démarches. Nous nous engageons à vous offrir un service de qualité afin de faciliter vos interactions avec les services administratifs du secteur de la formation professionnelle.
 </p>

 <div class="flex justify-end mt-4">

 <!--[if BLOCK]><![endif]--><?php if(Auth()->user()): ?>
 <p>
 <a class="bg-first-orange rounded p-2 hover:bg-cyan-700 text-white font-bold text-sm" href="<?php echo e(route("demande.index")); ?>">Voir toutes les demandes</a>
 </p>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 </div>

 </div>


 </div>
 </div>

 <div x-show.transition="step != 6">
 <!-- Top Navigation -->
 


 <div class="w-full h-full" x-show.transition="step == 1">
 <!-- Champs pour l'utilisateur -->
 <div class="w-full mx-auto mb-4 m-4 rounded">
 <div class="flex items-center justify-between bg-gray-200 p-3">
 <p class="text-sm font-bold text-first-orange">Données utilisateur</p>
 </div>

 <div class="p-2 m-3">
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'prenom','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'prenom','class' => 'font-semibold text-black']); ?>
 Prénom <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.prenom','id' => 'prenom','class' => 'block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 text-black','type' => 'text','name' => 'prenom','value' => old('prenom'),'autofocus' => true,'autocomplete' => 'prenom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.prenom','id' => 'prenom','class' => 'block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 text-black','type' => 'text','name' => 'prenom','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('prenom')),'autofocus' => true,'autocomplete' => 'prenom']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'nom','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'nom','class' => 'font-semibold text-black']); ?>
 Nom <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.nom','id' => 'nom','class' => 'block text-black w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2','type' => 'text','name' => 'nom','value' => old('nom'),'autofocus' => true,'autocomplete' => 'nom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.nom','id' => 'nom','class' => 'block text-black w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2','type' => 'text','name' => 'nom','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('nom')),'autofocus' => true,'autocomplete' => 'nom']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'email','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'email','class' => 'font-semibold text-black']); ?>
 Email <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.email','id' => 'email','class' => 'block text-black w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2','type' => 'email','name' => 'email','value' => old('email'),'autocomplete' => 'email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.email','id' => 'email','class' => 'block text-black w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2','type' => 'email','name' => 'email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email')),'autocomplete' => 'email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'adresse','value' => ''.e(__('Adresse')).'','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'adresse','value' => ''.e(__('Adresse')).'','class' => 'font-semibold text-black']); ?>
 Adresse <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.adresse','id' => 'adresse','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2','type' => 'text','name' => 'adresse','value' => old('adresse'),'autofocus' => true,'autocomplete' => 'adresse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.adresse','id' => 'adresse','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2','type' => 'text','name' => 'adresse','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('adresse')),'autofocus' => true,'autocomplete' => 'adresse']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 </div>
 </div>

 </div>

 </div>

 
 <div class="w-full h-full" x-show.transition="step == 2">
 <div class="w-full mx-auto mb-4 rounded">
 <div class="flex items-center justify-between bg-gray-200 p-3">
 <p class="text-sm font-bold text-first-orange">Données de l'établissement</p>
 </div>
 <div class="p-2 m-3">

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'nom_etablissement','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'nom_etablissement','class' => 'font-semibold text-black']); ?>
 Nom de l'établissement <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.nom_etablissement','id' => 'nom_etablissement','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ','type' => 'text','name' => 'nom_etablissement','value' => old('nom_etablissement'),'autocomplete' => 'nom_etablissement']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.nom_etablissement','id' => 'nom_etablissement','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ','type' => 'text','name' => 'nom_etablissement','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('nom_etablissement')),'autocomplete' => 'nom_etablissement']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nom_etablissement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'email_etablissement','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'email_etablissement','class' => 'font-semibold text-black']); ?>
 Email de l'établissement <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.email_etablissement','id' => 'email_etablissement','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ','type' => 'text','name' => 'email_etablissement','value' => old('email_etablissement'),'autofocus' => true,'autocomplete' => 'email_etablissement']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.email_etablissement','id' => 'email_etablissement','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ','type' => 'text','name' => 'email_etablissement','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email_etablissement')),'autofocus' => true,'autocomplete' => 'email_etablissement']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email_etablissement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>
 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'selectedRegion','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'selectedRegion','class' => 'font-semibold text-black']); ?>
 Région <span class="text-red-500"></span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <select wire:model="selectedRegion" wire:change="onChangeRegion" wire:ignore class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="commune_id">
 <option value="">Choisir une région</option>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <option value="<?php echo e($region->id); ?>" wire:key="<?php echo e($region['id']); ?>"><?php echo e($region['libelle']); ?></option>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </select>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedRegion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'selectedDepartemant','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'selectedDepartemant','class' => 'font-semibold text-black']); ?>
 Département <span class="text-red-500"></span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <select wire:model="selectedDepartemant" wire:change="onChangeDepartement" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="commune_id">
 <option value="">Choisir un département</option>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <option value="<?php echo e($departement['id']); ?>" wire:key="<?php echo e($departement['id']); ?>"><?php echo e($departement['libelle']); ?></option>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </select>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedDepartemant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'commune_id','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'commune_id','class' => 'font-semibold text-black']); ?>
 Localisation <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <select wire:model="donnees.commune_id" wire:change="onChangeCommune" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="commune_id">
 <option value="">Choisir la localisation</option>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <option value="<?php echo e($com['id']); ?>" wire:key="<?php echo e($com['id']); ?>"><?php echo e($com['libelle']); ?></option>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </select>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['commune_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'date_creation','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'date_creation','class' => 'font-semibold text-black']); ?>
 Date de création <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'donnees.date_creation','id' => 'date_creation','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ','type' => 'date','name' => 'date_creation','value' => old('date_creation'),'autofocus' => true,'autocomplete' => 'date_creation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'donnees.date_creation','id' => 'date_creation','class' => 'text-black block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ','type' => 'date','name' => 'date_creation','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('date_creation')),'autofocus' => true,'autocomplete' => 'date_creation']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
 <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_creation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'type','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'type','class' => 'font-semibold text-black']); ?>
 Type <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <select wire:model="donnees.type" wire:change="onChangeType" wire:ignore class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type">
 <option value="">Choisir le type</option>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <option value="<?php echo e($type['valeur']); ?>" wire:key="<?php echo e($type['id']); ?>"><?php echo e($type['valeur']); ?></option>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </select> <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <div class="mb-4">
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'statut','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'statut','class' => 'font-semibold text-black']); ?>
 Statut <span class="text-red-500">*</span>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <select wire:model="donnees.statut" wire:change="onChangeStatut" wire:ignore class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="statut">
 <option value="">Choisir le statut</option>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <option value="<?php echo e($statut['valeur']); ?>" wire:key="<?php echo e($statut['id']); ?>"><?php echo e($statut['valeur']); ?></option>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </select> <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
 <span class="text-xs text-red-500">
 <?php echo e($message); ?>

 </span>
 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
 </div>
 </div>
 </div>


 </div>
 </div>
 
 <div class="w-full h-full" x-show.transition="step == 3">
 <div class="w-full mx-auto mb-4 rounded">
 <div class="flex items-center justify-between bg-gray-200 p-3">
 <p class="text-sm font-bold text-first-orange">Données de la demande</p>
 </div>

 <div class="p-2 m-3">
 <div class="pb-4">
 <div class="flex flex-wrap place-content-around mx-auto">
 <!--[if BLOCK]><![endif]--><?php if(($typeDemande)->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT') || ($typeDemande)->code == config('constants.requests.D-RECONNAISSANCE') || ($typeDemande)->code == config('constants.requests.D-EXTENSION-FILIERE')): ?>
 <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Param.DemandeOuvertureEtablissement', ['datasets' => $gotDemande->projets ?? []]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1167605570-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php elseif(($typeDemande)->code == config('constants.requests.D-AUTORISATION-DIRIGER')): ?>
 <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Param.DemandeAutorisationDiriger', ['datasets' => $gotDemande->projets ?? []]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1167605570-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php elseif(($typeDemande)->code == config('constants.requests.D-QUALIFICATION-FILIERE')): ?>
 <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Param.DemandeQualificationFiliere', ['datasets' => $gotDemande->projets ?? []]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1167605570-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php elseif(($typeDemande)->code == config('constants.requests.D-CHANGEMENT-DENOMINATION')): ?>
 <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Param.DemandeChangementDenomination', ['datasets' => $gotDemande->projets ?? []]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1167605570-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php elseif(($typeDemande)->code == config('constants.requests.D-SUBVENTION')): ?>
 <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Param.DemandeSubvention', ['datasets' => $gotDemande->projets ?? []]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1167605570-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php elseif(($typeDemande)->code == config('constants.requests.D-TRANSFERT-ETABLISSEMENT')): ?>
 <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Param.DemandeTransfertEtablissement', ['datasets' => $gotDemande->projets ?? []]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1167605570-5', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </div>
 </div>
 </div>

 </div>

 </div>

 
 <div class="bg-white w-full h-full my-5 px-4 " x-show.transition="step == 4">
 
 <div class="flex items-center justify-between p-3">
 <p class="font-bold text-first-orange">Pieces jointes</p>
 </div>
 <div class="flex flex-wrap place-content-around mx-auto rounded pb-5">
 

 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $typeDemande->listes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $typeDocument): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <div class="mt-4 flex">
 <div>
 <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'multiple_files'.e($index).'','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'multiple_files'.e($index).'','class' => 'font-semibold text-black']); ?>
 <?php echo e($typeDocument->libelle); ?>

  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
 <div class="input_file_container">
 <input wire:model="fichiers.fichier_<?php echo e($index); ?>" class="styled_input_file" type="file" id="multiple_files<?php echo e($index); ?>" type="file" multiple>
 <svg class="svg_input_file" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <g clip-path="url(#clip0_747_3670)">
 <path d="M19.5711 10.5856L11.4394 18.7173C9.87671 20.28 7.34526 20.28 5.78256 18.7173C4.21985 17.1546 4.21985 14.6231 5.78256 13.0604L14.6214 4.22161C15.5972 3.2458 17.1811 3.2458 18.1569 4.22161C19.1327 5.19741 19.1327 6.78133 18.1569 7.75714L10.7323 15.1818C10.3434 15.5707 9.707 15.5707 9.31809 15.1818C8.92918 14.7929 8.92918 14.1565 9.31809 13.7675L16.0356 7.05003L14.9749 5.98937L8.25743 12.7069C7.28162 13.6827 7.28162 15.2666 8.25743 16.2424C9.23324 17.2182 10.8172 17.2182 11.793 16.2424L19.2176 8.8178C20.7803 7.25509 20.7803 4.72365 19.2176 3.16095C17.6549 1.59824 15.1234 1.59824 13.5607 3.16095L4.7219 11.9998C2.57229 14.1494 2.57229 17.6284 4.7219 19.778C6.8715 21.9276 10.3505 21.9276 12.5001 19.778L20.6318 11.6462L19.5711 10.5856Z" fill="black" />
 </g>
 <defs>
 <clipPath id="clip0_747_3670">
 <rect width="24" height="24" fill="white" />
 </clipPath>
 </defs>
 </svg>
 


 </div>
 </div>

 </div>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->


 </div>



 <!--[if BLOCK]><![endif]--><?php if($isUpdating): ?>
 <div class="p-4 border rounded bg-white shadow">
 <h2 class="text-xl font-bold mb-4">Anciennement uploadé</h2>
 <ul class="list-disc pl-4 flex flex-wrap">

 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $gotDemande->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">
 <div class="flex items-center">
 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#F37930" />
 <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#F37930" />
 </svg>

 <span class="ml-3"><?php echo e($document["nom"]); ?></span>
 </div>
 <div class="flex items-center w-[60px] justify-between">
 <a href="<?php echo e(asset('/storage/' . $document->lien_ressource)); ?>" target="_blank">
 <svg width="18" height="18" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
 <g clip-path="url(#clip0_747_2897)">
 <path d="M0.916992 6.99998C0.916992 6.99998 3.25033 2.33331 7.33366 2.33331C11.417 2.33331 13.7503 6.99998 13.7503 6.99998C13.7503 6.99998 11.417 11.6666 7.33366 11.6666C3.25033 11.6666 0.916992 6.99998 0.916992 6.99998Z" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 <path d="M7.3335 8.75C8.29999 8.75 9.0835 7.9665 9.0835 7C9.0835 6.0335 8.29999 5.25 7.3335 5.25C6.367 5.25 5.5835 6.0335 5.5835 7C5.5835 7.9665 6.367 8.75 7.3335 8.75Z" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 </g>
 <defs>
 <clipPath id="clip0_747_2897">
 <rect width="14" height="14" fill="white" transform="translate(0.333496)" />
 </clipPath>
 </defs>
 </svg>

 </a>
 <a href="<?php echo e(asset('/storage/' . $document->lien_ressource)); ?>" download>
 <svg width="18" height="17" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M12.5835 8.75V11.0833C12.5835 11.3928 12.4606 11.6895 12.2418 11.9083C12.023 12.1271 11.7262 12.25 11.4168 12.25H3.25016C2.94074 12.25 2.644 12.1271 2.4252 11.9083C2.20641 11.6895 2.0835 11.3928 2.0835 11.0833V8.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 <path d="M4.41699 5.83331L7.33366 8.74998L10.2503 5.83331" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 <path d="M7.3335 8.75V1.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 </svg>

 </a>

 <button wire:click="supprimerDocument(<?php echo e($document); ?>)">
 <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M11 11L1 1M1 11L11 1" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 </svg>
 </button>


 </div>
 </li>

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </ul>

 </div>

 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </div>
 
 <div class="bg-white w-full h-full" x-show.transition="step == 5">
 <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white w-full rounded-sm">
 <div class="max-w-7xl sm:px-2 lg:px-2 mx-3">

 <table class="min-w-full border border-gray-300 text-sm rounded-lg">
 <thead class="border-maquette-gris">
 <tr class="flex">
 <th class="w-1/3 flex items-center py-2 px-2 border-b text-black">Email </th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["email"]); ?></td>
 </tr>
 <tr class="flex">
 <th class="w-1/3 flex items-center py-2 px-2 border-b text-black">Nom </th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["nom"]); ?></td>
 </tr>
 </thead>
 <tbody>
 <tr class="flex">
 <th class="w-1/3 flex items-center py-2 px-2 border-b text-black">Prénom</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["prenom"]); ?></td>
 </tr>
 <tr class="flex">
 <th class="w-1/3 flex items-center py-2 px-2 border-b text-black">Adresse</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["adresse"]); ?></td>
 </tr>
 </tbody>
 </table>


 </div>

 <div class="max-w-7xl sm:px-2 lg:px-2 mx-3">
 <table class="min-w-full border border-gray-300 text-sm rounded-lg">
 <tr class="flex">
 <th class="w-1/3 flex items-center py-2 px-2 border-b justify-start text-black">Nom de l'établissement</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["nom_etablissement"]); ?></td>
 </tr>

 <tr class="flex">
 <th class="w-1/3 flex items-center py-2 px-2 border-b justify-start text-black">Email établissement</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["email"]); ?></td>
 </tr>


 <tr class="flex">
 <th class="w-1/3 flex items-center flex-start py-2 px-2 border-b text-black">Date de création</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["date_creation"]); ?></td>
 </tr>
 <tr class="flex">
 <th class="w-1/3 flex items-center flex-start py-2 px-2 border-b text-black">Statut</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["statut"]); ?></td>
 </tr>
 <tr class="flex">
 <th class="w-1/3 flex items-center flex-start py-2 px-2 border-b text-black">Type</th>
 <td class="py-2 px-4 border-b w-2/3 border-l text-black"><?php echo e($donnees["type"]); ?></td>
 </tr>

 </table>
 </div>
 </div>



 <!--[if BLOCK]><![endif]--><?php if(($typeDemande)->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT') || ($typeDemande)->code == config('constants.requests.D-RECONNAISSANCE') || ($typeDemande)->code == config('constants.requests.D-EXTENSION-FILIERE')): ?>

 <div class="max-w-7xl sm:px-2 lg:px-2 mx-3">
 <!--[if BLOCK]><![endif]--><?php if(is_array($data) && count($data) > 0): ?>
 <table class="min-w-full border border-gray-300 text-sm rounded-lg">
 <thead>
 <tr class="bg-gray-100">
 <th class="py-2 px-4 border-b text-left text-black">Nom de la Filière</th>
 <th class="py-2 px-4 border-b text-left text-black">Nom du Niveau</th>
 </tr>
 </thead>
 <tbody>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <tr>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black">
 <?php echo e(isset($item['filiere']['nom']) ? htmlspecialchars($item['filiere']['nom']) : 'Nom de filière non disponible'); ?>

 </td>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black">
 <?php echo e(isset($item['niveau']['nom']) ? htmlspecialchars($item['niveau']['nom']) : 'Nom de niveau non disponible'); ?>

 </td>
 </tr>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </tbody>
 </table>

 <?php else: ?>
 <p class="text-black"></p> <!-- Si le tableau est vide -->
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </div>

 <?php else: ?>

 <div class="max-w-7xl sm:px-2 lg:px-2 mx-3">
 <!--[if BLOCK]><![endif]--><?php if(is_array($data) && count($data) > 0): ?>
 <table class="min-w-full border border-gray-300 text-sm rounded-lg">
 <thead>
 <tr class="bg-gray-100">
 <!--[if BLOCK]><![endif]--><?php if(isset($data['ancienne_adresse_etablissement']) || isset($data['nouvelle_adresse_etablissement'])): ?>
 <th class="py-2 px-4 border-b text-left text-black">Ancienne Adresse</th>
 <th class="py-2 px-4 border-b text-left text-black">Nouvelle Adresse</th>
 <?php elseif(isset($data['ancienne_denomination_etablissement']) || isset($data['nouvelle_denomination_etablissement'])): ?>
 <th class="py-2 px-4 border-b text-left text-black">Ancienne Dénomination</th>
 <th class="py-2 px-4 border-b text-left text-black">Nouvelle Dénomination</th>
 <?php elseif(isset($data['nom']) || isset($data['prenom'])): ?>
 <th class="py-2 px-4 border-b text-left text-black">Nom</th>
 <th class="py-2 px-4 border-b text-left text-black">Prénom</th>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </tr>
 </thead>
 <tbody>
 <tr>
 <!--[if BLOCK]><![endif]--><?php if(isset($data['ancienne_adresse_etablissement']) || isset($data['nouvelle_adresse_etablissement'])): ?>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black"><?php echo e(htmlspecialchars($data['ancienne_adresse_etablissement'])); ?></td>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black"><?php echo e(htmlspecialchars($data['nouvelle_adresse_etablissement'])); ?></td>
 <?php elseif(isset($data['ancienne_denomination_etablissement']) || isset($data['nouvelle_denomination_etablissement'])): ?>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black"><?php echo e(htmlspecialchars($data['ancienne_denomination_etablissement'])); ?></td>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black"><?php echo e(htmlspecialchars($data['nouvelle_denomination_etablissement'])); ?></td>
 <?php elseif(isset($data['nom']) || isset($data['prenom'])): ?>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black"><?php echo e(htmlspecialchars($data['nom'])); ?></td>
 <td class="py-2 px-4 border-b w-1/2 border-l text-black"><?php echo e(htmlspecialchars($data['prenom'])); ?></td>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </tr>
 </tbody>
 </table>
 <?php else: ?>
 <p>Aucune donnée disponible.</p> <!-- Si le tableau est vide -->
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 </div>


 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

 <div>
 <div class="p-4 rounded bg-white text-black">
 <h2 class="text-xl font-bold mb-4">Liste des Documents</h2>
 <ul class="list-disc pl-4 flex justify-between flex-wrap">

 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $donnees["fichiers"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fichier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $fichier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">
 <div class="flex items-center overflow-hidden">
 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#F37930" />
 <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#F37930" />
 </svg>

 <span class="ml-3 overflow-hidden"><?php echo e($item); ?></span>
 </div>

 </li>

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 </ul>

 </div>
 </div>

 </div>
 </div>
 </div>


 <div class="px-4 flex justify-between">
 <div>
 <p x-show="step > 1 && step != 4 && step != 6" @click="step--" class="cursor-pointer flex items-center bg-black py-2 px-6 rounded text-white text-sm">
 <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M0 6.5002L7.5 0.56632L7.5 12.4341L0 6.5002Z" fill="white" />
 </svg>

 <span class="font-bold ml-3">
 Précédent

 </span>
 </p>

 <p x-show="step == 4" wire:click="leaveStepFour('precedent')" class="cursor-pointer flex items-center bg-black py-2 px-6 rounded text-white text-sm">
 <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M0 6.5002L7.5 0.56632L7.5 12.4341L0 6.5002Z" fill="white" />
 </svg>

 <span class="font-bold ml-3">
 Précédent

 </span>
 </p>

 </div>

 <div class="flex w-full justify-end">
 <p x-show="step < 5 && step != 4" @click="step++" class="cursor-pointer flex items-center bg-first-orange py-2 px-6 rounded text-white text-sm text-bold">
 <span class="mr-2 font-bold">Suivant</span>
 <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M8 6.50005L0.5 12.4339L0.5 0.566167L8 6.50005Z" fill="white" />
 </svg>
 </p>
 <p x-show="step == 4" wire:click="leaveStepFour('suivant')" class="cursor-pointer flex items-center bg-first-orange py-2 px-6 rounded text-white text-sm text-bold">
 <span class="mr-2 font-bold">Suivant</span>
 <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M8 6.50005L0.5 12.4339L0.5 0.566167L8 6.50005Z" fill="white" />
 </svg>
 </p>
 
 <!--[if BLOCK]><![endif]--><?php if(Auth()->user()): ?>
 <p  wire:click="enregistrerBrouillon" x-show="step == 5" class="cursor-pointer flex items-center bg-first-orange py-2 px-6 rounded text-white text-sm mr-2">
 <svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M18.6979 6.55208L12.4479 0.302083C12.3519 0.208384 12.2387 0.134107 12.1146 0.0833333C11.9854 0.030851 11.8477 0.00260216 11.7083 0H3.375C2.5462 0 1.75134 0.32924 1.16529 0.915291C0.57924 1.50134 0.25 2.2962 0.25 3.125V15.625C0.25 16.4538 0.57924 17.2487 1.16529 17.8347C1.75134 18.4208 2.5462 18.75 3.375 18.75H15.875C16.7038 18.75 17.4987 18.4208 18.0847 17.8347C18.6708 17.2487 19 16.4538 19 15.625V7.29167C19.0008 7.15458 18.9745 7.01868 18.9227 6.89176C18.8708 6.76485 18.7945 6.64942 18.6979 6.55208ZM6.5 2.08333H10.6667V4.16667H6.5V2.08333ZM12.75 16.6667H6.5V13.5417C6.5 13.2654 6.60975 13.0004 6.8051 12.8051C7.00045 12.6097 7.2654 12.5 7.54167 12.5H11.7083C11.9846 12.5 12.2496 12.6097 12.4449 12.8051C12.6403 13.0004 12.75 13.2654 12.75 13.5417V16.6667ZM16.9167 15.625C16.9167 15.9013 16.8069 16.1662 16.6116 16.3616C16.4162 16.5569 16.1513 16.6667 15.875 16.6667H14.8333V13.5417C14.8333 12.7129 14.5041 11.918 13.918 11.332C13.332 10.7459 12.5371 10.4167 11.7083 10.4167H7.54167C6.71286 10.4167 5.91801 10.7459 5.33196 11.332C4.74591 11.918 4.41667 12.7129 4.41667 13.5417V16.6667H3.375C3.09873 16.6667 2.83378 16.5569 2.63843 16.3616C2.44308 16.1662 2.33333 15.9013 2.33333 15.625V3.125C2.33333 2.84873 2.44308 2.58378 2.63843 2.38843C2.83378 2.19308 3.09873 2.08333 3.375 2.08333H4.41667V5.20833C4.41667 5.4846 4.52641 5.74955 4.72176 5.9449C4.91711 6.14025 5.18207 6.25 5.45833 6.25H11.7083C11.9846 6.25 12.2496 6.14025 12.4449 5.9449C12.6403 5.74955 12.75 5.4846 12.75 5.20833V3.55208L16.9167 7.71875V15.625Z" fill="white" />
 </svg>
 <span class="font-bold">
 Enregistrer en brouillon

 </span>
 </p>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 
 <p  wire:click="soumettre" x-show="step == 5" <?php echo e($isCharging ? 'disabled' : ''); ?> class="cursor-pointer flex items-center bg-cyan-700 hover:bg-green-800 py-2 px-6 rounded text-white text-sm text-bold">

 <span class="mr-2 font-bold">Soumettre</span>
 <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M8 6.50005L0.5 12.4339L0.5 0.566167L8 6.50005Z" fill="white" />
 </svg>
 </p>


 </div>

 </div>

 </div>
 </form>

 <script>
 function app(livewireStep) {
 return {
 step: livewireStep,
 init() {
 Livewire.on('livewireStepUpdated', (newStep) => {
 this.step = newStep;
 });
 }
 }
 }
 </script>
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/demandes/new-demande.blade.php ENDPATH**/ ?>