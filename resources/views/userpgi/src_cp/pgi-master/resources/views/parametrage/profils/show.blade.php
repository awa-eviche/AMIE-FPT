<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel état') }}
        </h2>
    </x-slot>

   {{--    --}}
    <div class="container mx-auto py-8 bg-white">
        <div class="w-1/2 pr-4">
            <h2 class="text-2xl font-bold mb-4">{{ $role->name }}</h2>
            <p class="text-gray-700 mb-2"><strong>Code :</strong> {{ $role->code }}</p>
            <p class="text-gray-700 mb-2"><strong>Description :</strong> {{ $role->description }}</p>
            <p class="text-gray-700 mb-2"><strong>Actif :</strong> {{ $role->est_actif ? 'Oui' : 'Non' }}</p>
        </div>

    </div>


</x-app-layout>
