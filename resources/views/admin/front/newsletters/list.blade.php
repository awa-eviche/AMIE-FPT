<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alertes newsletters') }}
        </h2>
    </x-slot>

    <div class="">
        @include('layouts.v1.partials._alert')
        <div class="max-w-10xl mx-auto">
            <div class="flex justify-between py-4">
                <span class="text-black text-sm">Liste des alertes newsletters</span>
            </div>
        </div>

        @livewire('front.admin.newsletters')

    </div>
</x-app-layout>
