<div>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner une métier
        </label>
        <x-input id="matiere_id" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="matiere_id" value="{{$matiere->nom }} " required autofocus autocomplete="inscription_id"  />
    </div>

    <!-- Champ de mariere qui apparaît uniquement lorsque le métier est sélectionné -->
    @if(!empty($matieres))
        <div class="mb-4 mx-auto w-full">
            <label class="block text-gray-700 text-sm font-bold" for="matiere">
                Sélectionner une matiere
            </label>
            <select id="matiere_id" name="matiere_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
                <option value="">Sélectionnez une matiere</option>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                @endforeach
            </select>
        </div>
    @endif

</div>
