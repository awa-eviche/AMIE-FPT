<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail type notification') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route("type_notification.index")}}"  class="text-maquette">Liste des type de notification</a>
        </p>
        <span class="mx-2 text-maquette">/</span>
        <p class="text-first-orange">Détail du type de notification</p>
    </div>


    <div class="flex flex-wrap bg-white p-3">
        <div class="w-full md:w-1/2 bg-white p-4">
            <div class="shadow h-full">
                <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                    <p class="text-first-orange font-bold">État rejet</p>
                </div>
                <div class="container bg-white p-4 rounded">
                    <div class="mt-4 mb-2 flex text-sm">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Action :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700">{{ $typeNotification->action }}</span>
                        </div>
                    </div>
                    <hr>

                    <div class="mt-4 mb-2 flex text-sm">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Message :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700">{{ $typeNotification->message }}</span>
                        </div>
                    </div>


                    <div class="mt-12 flex items-center justify-between">
                        <a href="{{ route('type_notification.index') }}" class="bg-first-orange text-white py-1 px-4 rounded">Retour</a>
                        <a href="{{route('type_notification.edit', $typeNotification->id)}}" class="bg-first-orange text-white py-1 px-4 rounded">Modifier</a>
                    </div>
                </div>

            </div>

        </div>


        <livewire:manage-notify-profil :typeNotification="$typeNotification"/>
    </div>



</x-app-layout>
