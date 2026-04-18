<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau Référentiel') }}
        </h2>
    </x-slot>

    <!-- Fil d’ariane -->
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="#" class="text-maquette">Accueil</a>
            <span class="mx-2">/</span>
            <a href="{{ route('referentiel.index') }}" class="text-maquette">Référentiel</a>
            <span class="mx-2">/</span>
            <span class="text-first-orange">Nouveau</span>
        </p>
    </div>

    <div class="rounded-sm w-full">
        <div class="mx-auto max-w-5xl shadow-xl rounded">

            <form action="{{ route('referentiel.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white border-x-2 rounded px-8 pt-6 pb-8 mb-4">

                @csrf

                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                    Création d'un référentiel
                </h3>

                <div class="border border-gray-200 p-4">

                    <!-- Métier + Niveau -->
                          
                    <div class="flex flex-wrap w-full justify-evenly">

<!-- METIER -->
<div class="flex-grow mb-4 mr-2">
    <x-label>Métier</x-label>
    <select id="metier_id" name="metier_id"
        class="block w-full border-2 rounded text-sm px-2 py-2">
        <option value="">Choisir un métier</option>
        @foreach($metiers as $metier)
            <option value="{{ $metier->id }}">{{ $metier->nom }}</option>
        @endforeach
    </select>
</div>

<!-- NIVEAU -->
<div class="flex-grow mb-4 mr-2">
    <x-label>Niveaux (max 3)</x-label>

    <select id="niveau_etude_id" name="niveaux[]"
        multiple
        class="block w-full border-2 rounded text-sm px-2 py-2">
        <option value="">Choisir d'abord un métier</option>
    </select>

    <small class="text-gray-500">
        Maximum 3 niveaux
    </small>
</div>


</div>

                

                    <!-- Titre -->
                   

                   

                    <div class="mb-4">
    <x-label>Référentiels aux programmes (vous pouvez en ajouter plusieurs)</x-label>

    <div id="referentiels-container">

        <div class="flex gap-2 mb-2 referentiel-item">
            <select name="type_referentiel[]" class="border-2 rounded px-2 py-1 w-1/3">
            <option value="Referentiel métiers">AST</option>
            <option value="Referentiel de formation">Référentiel de formation</option>
             
                <option value="Référentiel metiers compétences">Référentiel métiers compétences</option>
                <option value="Référentiel de certification">Référentiel de certification</option>
                <option value="GOMP">GOMP</option>
            </select>

            <input type="text" name="titre[]" placeholder="Titre"
                   class="border-2 rounded px-2 py-1 w-1/3">

            <input type="file" name="fichier[]" class="border-2 rounded px-2 py-1 w-1/3">

            <button type="button" class="remove-btn text-red-500">X</button>
        </div>

    </div>

    <button type="button" id="add-btn"
        class="mt-2 bg-green-500 text-white px-3 py-1 rounded">
        + Ajouter un référentiel
    </button>
</div>

                    <!-- Bouton -->
                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="flex bg-first-orange text-white font-bold py-1 px-4 rounded">

                            <svg width="18" height="18" fill="white" class="mr-2">
                                <path d="M5 1v4H1v2h4v4h2V7h4V5H7V1z"/>
                            </svg>

                            Enregistrer
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
let selectedValues = [];

document.getElementById('metier_id').addEventListener('change', function () {

    let metierId = this.value;
    let niveauSelect = document.getElementById('niveau_etude_id');

    niveauSelect.innerHTML = '<option>Chargement...</option>';

    if (metierId) {
        fetch('/get-niveaux/' + metierId)
            .then(response => response.json())
            .then(data => {

                niveauSelect.innerHTML = '';

                data.forEach(niveau => {
                    niveauSelect.innerHTML += 
                        `<option value="${niveau.id}">${niveau.nom}</option>`;
                });

                selectedValues = []; // reset
            });
    } else {
        niveauSelect.innerHTML = '<option>Choisir d\'abord un métier</option>';
    }
});

// 🔥 limiter à 3
document.getElementById('niveau_etude_id').addEventListener('change', function () {

    let selected = Array.from(this.selectedOptions).map(option => option.value);

    if (selected.length > 3) {
        alert('Maximum 3 niveaux autorisés');

        // enlever le dernier choisi
        this.options[this.selectedIndex].selected = false;
    }
});
</script>

<script>
document.getElementById('add-btn').addEventListener('click', function () {

    let container = document.getElementById('referentiels-container');

    let newItem = `
    <div class="flex gap-2 mb-2 referentiel-item">
        <select name="type_referentiel[]" class="border-2 rounded px-2 py-1 w-1/3">
             <option value="Referentiel métiers">AST</option>
            <option value="Referentiel de formation">Référentiel de formation</option>
             
                <option value="Référentiel metiers compétences">Référentiel métiers compétences</option>
                <option value="Référentiel de certification">Référentiel de certification</option>
                <option value="GOMP">GOMP</option>
        </select>

        <input type="text" name="titre[]" placeholder="Titre"
               class="border-2 rounded px-2 py-1 w-1/3">

        <input type="file" name="fichier[]" class="border-2 rounded px-2 py-1 w-1/3">

        <button type="button" class="remove-btn text-red-500">X</button>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', newItem);
});

// supprimer ligne
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-btn')){
        e.target.parentElement.remove();
    }
});
</script>
</x-app-layout>