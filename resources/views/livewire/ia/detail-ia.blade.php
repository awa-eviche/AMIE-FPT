<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex justify-between items-center">
            <span class="text-first-orange font-bold text-sm">
                <a href="{{ route('ia.index') }}">Liste des ias </a>
                / <span class="text-orange-600">
                    {{ $ia->libelle }}</span></span>
        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">

                <div class="border border-gray-200">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Détails de l'Ia
                        <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1" href="{{ route('ia.edit', $ia->id) }}" style='position:relative;left: 80%;'>
                            Modifier
                        </a>
                    </h3>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Nom de l'ia : </span>
                            <span>
                                <b>{{ $ia->nom ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Email : </span>
                            <span>
                                <b>{{ $ia->email ?? ' -' }}</b>
                            </span>
                        </div>

                    </div>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">

                        <div>
                            <span>Telephone : </span>
                            <span>
                                <b>{{ $ia->telephone ?? ' -' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Adresse : </span>
                            <span>
                                <b>{{ $ia->adresse ?? ' -' }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="text-black mt-3 text-sm">
                    <span>Zone de couverture :  @foreach($ia->departements as $departement) {{ $departement->libelle}}   @endforeach </span>
                    </div>



                </div>
            </div>
        </div>

    </div>