<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le Type de Notification') }}
        </h2>
    </x-slot>

    <div class="bg-white shadow rounded-sm w-full p-4">
        <h2 class="font-bold text-maquette-gris text-xl">
            Edition Type notification
        </h2>

    <div class="w-full max-w-md mx-auto">
        <form action="{{ route('type_notification.update', $typeNotification->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="action" class="block text-first-orange font-bold mb-2">Action :</label>
                <input type="text" id="action" name="action" class="form-input rounded-sm border-gray-200 shadow-sm mt-1 block w-full" value="{{ $typeNotification->action }}" required>
            </div>

            <div class="mb-4">
                <label for="message" class="block text-first-orange font-bold mb-2">Message :</label>
                <input type="text" id="message" name="message" class="form-input rounded-sm border-gray-200 shadow-sm mt-1 block w-full" value="{{ $typeNotification->message }}" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enregistrer
                </button>
                <a href="{{ route('type_notification.index') }}" class="text-gray-600 hover:text-gray-900">
                    Annuler
                </a>
            </div>
        </form>
    </div>


    </div>

</x-app-layout>
