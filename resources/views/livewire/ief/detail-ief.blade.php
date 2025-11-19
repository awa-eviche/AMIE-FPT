<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex justify-between items-center">
            <span class="text-first-orange font-bold text-sm">
                <a href="{{ route('ief.index') }}">Liste des iefs </a>
                / <span class="text-orange-600">
                    {{ $ief->libelle }}</span></span>
        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">

                <div class="border border-gray-200">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Détails de l'ief
                        <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1" href="{{ route('ief.edit', $ief->id) }}" style='position:relative;left: 80%;'>
                            Modifier
                        </a>
                    </h3>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Nom : </span>
                            <span>
                                <b>{{ $ief->nom ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Email : </span>
                            <span>
                                <b>{{ $ief->email ?? ' -' }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">

                        <div>
                            <span>Telephone : </span>
                            <span>
                                <b>{{ $ief->telephone ?? ' -' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Adresse : </span>
                            <span>
                                <b>{{ $ief->adresse ?? ' -' }}</b>
                            </span>
                        </div>

                    </div>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">

                        <div>
                            <span>IA : </span>
                            <span>
                                <b>{{ $ief->ia->nom ?? ' -' }}</b>
                            </span>
                        </div>
                        
                    </div>
                    <div class="text-black mt-3 text-sm">
                    <span>Zone de couverture :  @foreach($ief->communes as $commune) {{ $commune->libelle}}   @endforeach </span>
                    </div>

                </div>
            </div>
        </div>

    </div>