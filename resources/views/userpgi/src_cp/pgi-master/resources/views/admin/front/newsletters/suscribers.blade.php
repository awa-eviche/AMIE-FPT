<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Abonnés') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-10xl mx-auto">
            <div class="flex justify-between py-4">
                <span class="text-black text-sm">Liste des abonnés</span>
            </div>
        </div>

        @livewire('front.admin.suscribers')

    </div>
</x-app-layout>
