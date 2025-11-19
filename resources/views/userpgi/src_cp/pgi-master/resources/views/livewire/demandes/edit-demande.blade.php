<div class="bg-white shadow rounded-sm w-full p-4 mt-2 relative">

    {{-- @if ($uploading) --}}
    <div wire:loading class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-40">
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
    </div>

    {{-- @endif --}}
    <div class="w-full mx-auto">
        <form wire:submit.prevent class="bg-white rounded px-4 pt-6 pb-8 mb-4">

            <div class="mb-4 max-w-md mx-auto">
                <label class="block text-gray-700 font-bold " for="libelle">
                    Libellé
                </label>
                <input wire:model="donnees.libelle" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="libelle" type="text" name="libelle" required>
                @error('donnees.libelle')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- la partie pour ajouter et uploader de nouvel document --}}
            <div class="shadow p-4 border rounded bg-white shadow">


                <div class="flex flex-wrap mb-3 justify-evenly">
                    <div class="w-[400px]">
                        <label class="block text-gray-700 mb-0.75" for="libelle">
                            Nom document
                        </label>
                        <input wire:model="nomFichier" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-[300px]" id="nomFichier" type="text" name="nomFichier" required>
                        @error('nomFichier')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4 flex self-end">
                        <div class="input_file_container">
                            <input wire:model="fichier" class="styled_input_file" type="file" >
                            <svg class="svg_input_file" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_747_3670)">
                                    <path d="M19.5711 10.5856L11.4394 18.7173C9.87671 20.28 7.34526 20.28 5.78256 18.7173C4.21985 17.1546 4.21985 14.6231 5.78256 13.0604L14.6214 4.22161C15.5972 3.2458 17.1811 3.2458 18.1569 4.22161C19.1327 5.19741 19.1327 6.78133 18.1569 7.75714L10.7323 15.1818C10.3434 15.5707 9.707 15.5707 9.31809 15.1818C8.92918 14.7929 8.92918 14.1565 9.31809 13.7675L16.0356 7.05003L14.9749 5.98937L8.25743 12.7069C7.28162 13.6827 7.28162 15.2666 8.25743 16.2424C9.23324 17.2182 10.8172 17.2182 11.793 16.2424L19.2176 8.8178C20.7803 7.25509 20.7803 4.72365 19.2176 3.16095C17.6549 1.59824 15.1234 1.59824 13.5607 3.16095L4.7219 11.9998C2.57229 14.1494 2.57229 17.6284 4.7219 19.778C6.8715 21.9276 10.3505 21.9276 12.5001 19.778L20.6318 11.6462L19.5711 10.5856Z" fill="black"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_747_3670">
                                        <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>

                        </div>

                    </div>

                </div>
                <div>
                    <div class="flex justify-end mb-4 mx-auto">
                        <button wire:click="addDocument" class="bg-first-orange hover:bg-cyan-700 text-white px-4 rounded flex items-center">
                            Ajouter
                            <span class="ml-2">
                                <svg class="text-white" height="1em" viewBox="0 0 448 512">
                                    <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" fill="white"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                {{-- <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-4 rounded" wire:click="uploadDocuments">Valider upload</button> --}}


            </div>


            {{-- liste des documents déjà upload --}}
            <div class="mt-5 p-4 shadow border rounded bg-white shadow">
                <h2 class="text-first-orange font-bold mb-4">Liste des Documents</h2>
                <ul class="list-disc pl-4 flex flex-wrap">

                    @foreach($documents as $key=> $document)
                        <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">
                            <div class="flex items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#F37930"/>
                                    <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#F37930"/>
                                </svg>

                                <span class="ml-3">{{$document["nom"]}}</span>
                            </div>
                            <div class="flex items-center w-[60px] justify-between">
                                <a href="{{ asset('/storage/' . $document->lien_ressource) }}" target="_blank">
                                    <svg width="18" height="18" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_747_2897)">
                                        <path d="M0.916992 6.99998C0.916992 6.99998 3.25033 2.33331 7.33366 2.33331C11.417 2.33331 13.7503 6.99998 13.7503 6.99998C13.7503 6.99998 11.417 11.6666 7.33366 11.6666C3.25033 11.6666 0.916992 6.99998 0.916992 6.99998Z" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.3335 8.75C8.29999 8.75 9.0835 7.9665 9.0835 7C9.0835 6.0335 8.29999 5.25 7.3335 5.25C6.367 5.25 5.5835 6.0335 5.5835 7C5.5835 7.9665 6.367 8.75 7.3335 8.75Z" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_747_2897">
                                        <rect width="14" height="14" fill="white" transform="translate(0.333496)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>

                                </a>
                                <a href="{{ asset('/storage/' . $document->lien_ressource) }}" download>
                                    <svg width="18" height="17" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5835 8.75V11.0833C12.5835 11.3928 12.4606 11.6895 12.2418 11.9083C12.023 12.1271 11.7262 12.25 11.4168 12.25H3.25016C2.94074 12.25 2.644 12.1271 2.4252 11.9083C2.20641 11.6895 2.0835 11.3928 2.0835 11.0833V8.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.41699 5.83331L7.33366 8.74998L10.2503 5.83331" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.3335 8.75V1.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                </a>

                                <button wire:click="supprimerDocument({{$document}})">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 11L1 1M1 11L11 1" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>


                            </div>
                        </li>

                    @endforeach
                </ul>



            </div>





          <div class="flex items-center justify-end mt-4">
            <button wire:click="enregistrer" type="submit" class="bg-first-orange text-white rounded-md px-5 py-2 hover:bg-cyan-700">
              Enregistrer
            </button>
          </div>
        </form>
    </div>



</div>
