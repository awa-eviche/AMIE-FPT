<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
  <!-- Carte 1 -->
  <div class="bg-white shadow-lg p-4 rounded-lg">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-blue-500 text-white">
        <i class="fas fa-burn"></i>
      </div>
      <div class="ml-4">
        <p class="text-sm text-gray-600">Demande total</p>
        <p class="text-lg font-semibold text-gray-800">500</p>
      </div>
    </div>
  </div>

  <!-- Carte 2 -->
  <div class="bg-white shadow-lg p-4 rounded-lg">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-green-500 text-white">
        <i class="fab fa-creative-commons-share"></i>
      </div>
      <div class="ml-4">
        <p class="text-sm text-gray-600">Demandes en cours</p>
        <p class="text-lg font-semibold text-gray-800">150</p>
      </div>
    </div>
  </div>

  <!-- Carte 3 -->
  <div class="bg-white shadow-lg p-4 rounded-lg">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-yellow-500 text-white">
        <i class="fas fa-clipboard-check"></i>
      </div>
      <div class="ml-4">
        <p class="text-sm text-gray-600">Demandes validées</p>
        <p class="text-lg font-semibold text-gray-800">200</p>
      </div>
    </div>
  </div>

  <!-- Carte 4 -->
  <div class="bg-white shadow-lg p-4 rounded-lg">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-red-500 text-white">
        <i class="fas fa-chart-bar"></i>
      </div>
      <div class="ml-4">
        <p class="text-sm text-gray-600">Demandes rejetées</p>
        <p class="text-lg font-semibold text-gray-800">50</p>
      </div>
    </div>
  </div>
</div>

    </div>
</x-app-layout>
