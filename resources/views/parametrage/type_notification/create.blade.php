<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un Type de Notification') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route("type_notification.index")}}"  class="text-maquette-gris">Liste des type de notification</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p class="text-first-orange">Nouveau type de notification</p>
    </div>

    <div class="bg-white shadow rounded-sm w-full p-4">


        <div class="w-full max-w-md mx-auto text-sm">
            <form action="{{ route('type_notification.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <div class="mb-4">
                    <label for="action" class="block text-first-orange font-bold mb-2">Action :</label>
                    <input type="text" id="action" name="action" class="form-input rounded-sm border-2 border-gray-200 shadow-sm mt-1 block w-full" required>
                </div>

                {{-- <div class="mb-4">
                    <label for="message" class="block text-first-orange font-bold mb-2">Message :</label>
                    <input type="text" id="message" name="message" class="form-input rounded-sm border-gray-200 shadow-sm mt-1 block w-full" required>
                </div> --}}
                <div class="mb-4 mx-auto w-full">
                    <label class="block text-first-orange text-sm font-bold" for="message">
                        Message
                    </label>
                    <textarea class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="message" name="message" required rows="8" placeholder="message"></textarea>
                </div>


                <div class="flex items-center justify-between">
                    <a href="{{ route('type_notification.index') }}" class="bg-maquette-gris py-2 px-4 rounded text-first-orange hover:text-gray-900">
                        Annuler
                    </a>
                    <button type="submit" class="bg-first-orange hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>


    </div>

</x-app-layout>
