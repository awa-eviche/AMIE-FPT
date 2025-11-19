<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex justify-between items-center">
        <span class="text-first-orange font-bold text-sm">
                <a href="{{ route('commune.index') }}">Liste des communes </a>
                    / <span class="text-orange-600"> Commune de
                    {{ $commune->nom }}</span></span>
            <!-- <a href="{{ route('commune.create') }}"
                class="px-3 rounded-md py-3 flex text-white text-sm text-center bg-first-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector"
                            d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z"
                            fill="white" />
                    </g>
                
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg><span class="mx-2">Ajouter un commune</span>
            </a> -->
        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                
                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                   Détails de la commune
                        <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1 float-end"
                           href="{{ route('commune.edit', $commune->id) }}">
                           Modifier
                       </a>
                               </h3>
            <div class="border border-gray-200 p-4">
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Code de la commune : </span>
                        <span>
                            <b>{{ $commune->code ?? ' - ' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>Nom de la commune : </span>
                        <span>
                            <b>{{ $commune->libelle ?? ' -' }}</b>
                        </span>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>
