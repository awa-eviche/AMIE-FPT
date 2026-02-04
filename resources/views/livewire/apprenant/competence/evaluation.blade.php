<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">

        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <div class="font-bold text-lg text-green-600">
                <!-- @if($inscription && $inscription->apprenant)
                    Évaluation de :
                    {{ $inscription->apprenant->prenom }}
                    {{ $inscription->apprenant->nom }}
                    [{{ $inscription->apprenant->matricule ?? '-' }}]
                @endif -->
            </div>

            @if(auth()->user()->hasRole('formateur'))
                <button wire:click="save"
                    class="bg-first-orange px-4 py-2 text-white hover:bg-orange-600 rounded-md shadow">
                    <i class="fa fa-save"></i>&nbsp; Enregistrer les changements
                </button>
            @endif
        </div>

        {{-- MESSAGE SUCCESS --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
                {{ session('message') }}
            </div>
        @endif

        {{-- SELECT SEMESTRE --}}
        <div class="flex items-center justify-end mb-4">
            <label class="block text-sm font-bold text-gray-700 mr-2">
                Semestre :
            </label>
            <select wire:model="semestre"
                id="selectedsemestre"
                class="border border-gray-300 rounded shadow-sm text-sm">
                <option value="">Sélectionnez un semestre</option>
                <option value="1">Premier semestre</option>
                <option value="2">Deuxième semestre</option>
            </select>
        </div>

        {{-- COMPÉTENCES GÉNÉRALES --}}
        <h2 class="font-bold text-lg mb-2">
            Compétences Générales
        </h2>

        <table class="w-full border mb-6">
            <thead>
                <tr class="bg-first-orange text-white text-xs uppercase border-b">
                    <th class="px-4 py-2 border">Compétence</th>
                    <th class="px-4 py-2 border">Discipline</th>
                    <th class="px-4 py-2 border">MCC</th>
                    <th class="px-4 py-2 border">Composition</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($competencesGenerales as $competence)
                    @foreach($competence->ressources as $ressource)
                        <tr>
                            <td class="border px-4 py-2 font-bold">{{ $competence->nom }}</td>
                            <td class="border px-4 py-2">{{ $ressource->nom }}</td>

                            @php
                                $devoir = \App\Models\DevoirAPC::where('ressource_id', $ressource->id)->first();
                                $mcc = $devoir?->mcc ?? 0;
                            @endphp

                            <td class="border px-4 py-2 text-center font-bold text-green-700">
                                {{ $mcc }}
                            </td>

                            <td class="border px-4 py-2 text-center">
                                <input type="number"
                                    wire:model="compositions.{{ $ressource->id }}"
                                    min="0" max="20" step="0.5"
                                    class="border border-gray-300 p-1 w-full text-center">
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        {{-- COMPÉTENCES PARTICULIÈRES --}}
        <h2 class="font-bold text-lg mb-2">
            Compétences Particulières
        </h2>

        <table class="w-full border">
            <thead class="bg-first-orange text-white text-sm">
                <tr>
                    <th class="border px-2 py-2">Compétence</th>
                    <th class="border px-2 py-2">Discipline</th>
                    <th class="border px-2 py-2">MCC</th>
                    <th class="border px-2 py-2">Composition</th>
                    <th class="border px-2 py-2">Acquis</th>
                    <th class="border px-2 py-2">Non acquis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($competencesParticulieres as $competence)
                    @foreach($competence->ressources as $ressource)
                        <tr>
                            <td class="border px-2 py-2 font-bold text-center">
                                {{ $competence->nom }}
                            </td>

                            <td class="border px-2 py-2 text-center">
                                {{ $ressource->nom }}
                            </td>

                            <td class="border px-2 py-2 text-center font-bold text-green-700">
                                {{ $mccs[$ressource->id] ?? 0 }}
                            </td>

                            <td class="border px-2 py-2 text-center">
                                <input type="number"
                                    wire:model="compositions.{{ $ressource->id }}"
                                    min="0" max="20" step="0.5"
                                    class="border rounded px-2 py-1 w-24 text-center">
                            </td>

                            <td class="border px-2 py-2 text-center">
                                @if(($acquis[$ressource->id] ?? false) === true)
                                    <span class="text-green-600 text-lg">✔</span>
                                @endif
                            </td>

                            <td class="border px-2 py-2 text-center">
                                @if(isset($acquis[$ressource->id]) && !$acquis[$ressource->id])
                                    <span class="text-red-600 text-lg">✖</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('scriptsAdditionnels')
    @include('layouts.v1.partials.swal._script')
@endsection
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('refreshAcquis', () => {
            @this.compositions = {...@this.compositions};
        });
    });
</script>
