<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Demandes') }}
        </h2>
    </x-slot>

    <div class="flex justify-end mb-4 px-4">

        <x-dropdown align="right">
            <x-slot name="trigger">
                <button class="bg-first-orange hover:first-orange text-white font-semibold py-2 px-4 rounded inline-flex items-center">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_705_6988)">
                            <path d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z" fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_705_6988">
                                <rect width="20" height="20" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="ml-1">Nouvelle demande</span>

                </button>
            </x-slot>

            <x-slot name="content">
                <div class="border shadow-xl">
                    @foreach ($typeDemandes as $typdeDemande)
                    <a class="bg-white hover:bg-gray-200 py-2 px-4 block whitespace-no-wrap" href="{{route("demande.create", $typdeDemande->id)}}">{{$typdeDemande->code}}</a>
                    @endforeach

                </div>

            </x-slot>
        </x-dropdown>
    </div>

    <div class="container py-2 rounded px-4">
        @if(isset($etablissementId))
        <livewire:demandes.liste-demande :etablissementId="$etablissementId" />
        @else
        <livewire:demandes.liste-demande />
        @endif
    </div>


</x-app-layout>