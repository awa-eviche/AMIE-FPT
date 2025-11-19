<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sliders') }}
        </h2>
    </x-slot>

    <div class="">
        @include('layouts.v1.partials._alert')
        <div class="max-w-10xl mx-auto">
            <div class="flex justify-between py-4">
                <span class="text-black text-sm">Liste de mes sliders</span>
            </div>
        </div>

        @livewire('front.sliders')

    </div>
</x-app-layout>
