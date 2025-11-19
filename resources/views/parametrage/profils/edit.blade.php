<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel état') }}
        </h2>
    </x-slot>

   {{--    --}}
   <div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-bold mb-2">Modifier le Profil</h2>
            <form action="{{ route('profil.update', $role->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nom</label>
                    <input type="text" name="name" id="name" class="w-full border rounded py-2 px-3" value="{{ $role->name }}" required>
                </div>
                <div class="mb-4">
                    <label for="code" class="block text-gray-700 font-bold mb-2">Code</label>
                    <input type="text" name="code" id="code" class="w-full border rounded py-2 px-3" value="{{ $role->code }}" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea name="description" id="description" class="w-full border rounded py-2 px-3" rows="3">{{ $role->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Statut :</label>
                    <label class="mr-4">
                        <input type="radio" name="est_actif" value="1" class="form-radio text-blue-600" {{ $role->est_actif == 1 ? 'checked' : '' }}>
                        <span class="ml-2">Actif</span>
                    </label>
                    <label>
                        <input type="radio" name="est_actif" value="0" class="form-radio text-red-600" {{ $role->est_actif == 0 ? 'checked' : '' }}>
                        <span class="ml-2">Inactif</span>
                    </label>
                    @error('est_actif')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


</x-app-layout>
