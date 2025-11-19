<div class="p-4">
    <div class="grid md:grid-cols-1 md:gap-6 pt-2">
        <div class="mb-4">
            <label for="competence" class="block text-gray-700 text-sm font-bold mb-2">Compétence<span class="text-red-600 mx-2">*</span></label>
            <select value="{{ old('competence') ?? ''}}" wire:model="competence" wire:change="loadEcompetences()" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="competence" name="competence" >
                <option value="">Sélectionner la compétence</option>
                @foreach ($competences ?? [] as $competence)
                    <option value="{{$competence->id}}">{{$competence->libelle}}</option>
                @endforeach
            </select>
            @error('competence')
                {{$message}}
            @enderror
        </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
        <div class="mb-4">
            <label for="ecompetence" class="block text-gray-700 text-sm font-bold mb-2">Element de compétence<span class="text-red-600 mx-2">*</span></label>
            <select value="{{ old('ecompetence') ?? ''}}" wire:model="ecompetence" wire:change="loadCriteres()" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="ecompetence" name="ecompetence" >
                <option value="">Sélectionner l'élément de compétence</option>
                @foreach ($ecompetences ?? [] as $ec)
                    <option value="{{$ec->id}}">{{$ec->libelle}}</option>
                @endforeach
            </select>
            @error('ecompetence')
                {{$message}}
            @enderror
        </div>
        <div class="mb-4">
            <label for="critere" class="block text-gray-700 text-sm font-bold mb-2">Critère<span class="text-red-600 mx-2">*</span></label>
            <select value="{{ old('critere') ?? ''}}" wire:model="commune" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="critere" name="critere" >
                <option value="">Sélectionner le critère</option>
                @foreach ($criteres ?? [] as $critere)
                    <option value="{{$critere->id}}">{{$critere->libelle}}</option>
                @endforeach
            </select>
            @error('critere')
                {{$message}}
            @enderror
        </div>
    </div>


    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
        <div class="mb-4">
            <label for="evaluation" class="block text-gray-700 text-sm font-bold mb-2">Evaluation<span class="text-red-600 mx-2">*</span></label>
            <select value="{{ old('evaluation') ?? ''}}" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="evaluation" name="evaluation" >
                <option value="">Selectionner un statut</option>
                <option value="A">Acquis</option>
                <option value="NA">Non Acquis</option>
            </select>
            @error('evaluation')
                {{$message}}
            @enderror
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date<span class="text-red-600 mx-2">*</span></label>
            <input type="date" value="{{ old('date') ?? ''}}" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="date" name="date" >
            @error('date')
                {{$message}}
            @enderror
        </div>
    </div>
</div>
