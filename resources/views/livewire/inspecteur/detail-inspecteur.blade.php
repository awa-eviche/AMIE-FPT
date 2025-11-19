<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Première colonne -->
            <div class="lg:w-full flex justify-between items-center px-4 py-2">
                <div>
                    <span class="text-gray-700 font-bold text-lg font-medium">
                        <a href="{{ route('inspecteur.index') }}"><span><i class="fa fa-angle-left"></i></span> </a>
                        <span class="text-gray-700 text-xl font-bold pl-2">
                        {{ $inspecteur->prenom }} {{ $inspecteur->nom }}</span></span>
                </div>
                <div>

                    <a href="{{route('inspecteur.create')}}" class="px-3 rounded-md py-3 flex text-white text-xs font-bold text-center bg-orange-400 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                                <path id="Vector" d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z" fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_705_6988">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg><span class="mx-2">Ajouter</span>

                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                <div class="flex justify-between text-black items-center">
                    <span class="text-first-orange font-bold text-md">Informations générales</span>
                    <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1" href="{{ route('inspecteur.edit', $inspecteur->id) }}">
                        Modifier
                    </a>
                </div>
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Prenom : </span>
                        <span>
                            <b>{{ $inspecteur->prenom ?? ' Non renseigné ' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>Nom : </span>
                        <span>
                            <b>{{ $inspecteur->nom ?? 'Non renseigné' }}</b>
                        </span>
                    </div>
                </div>

                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Telephone : </span>
                        <span>
                            <b>{{ $inspecteur->telephone ?? ' Non renseigné ' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>Email : </span>
                        <span>
                            <b>{{ $inspecteur->email ?? 'Non renseigné' }}</b>
                        </span>
                    </div>
                </div>

                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Specialite : </span>
                        <span>
                            <b>{{ $inspecteur->specialite ?? ' Non renseigné ' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>IA : </span>
                        <span>
                            <b>{{ $inspecteur->ia->nom ?? 'Non renseigné' }}</b>
                        </span>
                    </div>
                </div>
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>IEF : </span>
                        <span>
                            <b>{{ $inspecteur->ief->nom ?? 'Non renseigné ' }}</b>
                        </span>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>

</div>