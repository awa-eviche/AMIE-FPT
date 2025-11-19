<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des évaluations APC') }}
        </h2>
    </x-slot>
    @section('stylesAdditionnels')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
    @endsection
    @section('jsAdditionnels')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @endsection
    <div class="bg-transparent shadow rounded-sm w-full p-4">
        <div class="bg-white pb-4 w-full mx-auto">
            <div class="md:container md:mx-auto">
                @livewire('param.ClasseSwitch')
            </div>
        </div>
    </div>
</x-app-layout>
