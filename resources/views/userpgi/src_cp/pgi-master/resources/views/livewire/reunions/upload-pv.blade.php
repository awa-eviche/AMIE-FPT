<div class="px-3 relative">
    <div wire:loading class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-50">
        <div class="w-full h-full flex items-center justify-center">
            <p class="text-first-orange text-sm">charging ...</p>
        </div>
    </div>
    @if ($realPv)
        <div>
            <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">
                <div class="flex items-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#F37930"/>
                        <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#F37930"/>
                    </svg>

                    <span class="ml-3">{{$realPv["nom"]}}</span>
                </div>
                <div class="flex items-center w-[60px] justify-between">
                    <a href="{{ asset('/storage/' . $realPv->lien_ressource) }}" target="_blank">
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
                    <a href="{{ asset('/storage/' . $realPv->lien_ressource) }}" download>
                        <svg width="18" height="17" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5835 8.75V11.0833C12.5835 11.3928 12.4606 11.6895 12.2418 11.9083C12.023 12.1271 11.7262 12.25 11.4168 12.25H3.25016C2.94074 12.25 2.644 12.1271 2.4252 11.9083C2.20641 11.6895 2.0835 11.3928 2.0835 11.0833V8.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.41699 5.83331L7.33366 8.74998L10.2503 5.83331" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7.3335 8.75V1.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    </a>
                    @if ($autoriser)
                        <button wire:click="supprimerPv">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 11L1 1M1 11L11 1" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                    @endif


                </div>
            </li>
            @if ($autoriser)
                <div class="flex justify-end">
                    <button wire:click="transmettrePV" class="bg-first-orange text-white text-bold rouned px-3 py-1 hover:shadow-xl rounded">Transmettre le PV </button>
                </div>
            @endif

            @if ($reunion->membres->contains(Auth::user()) && $reunion->etat == App\Enums\ReunionEtatEnum::ASIGNE)
                <div>
                    <livewire:reunions.valider-pv :reunion="$reunion" />
                </div>
            @endif
        </div>

    @else
        <div class="flex justify-end my-2">
            @if ($uploadPermi && !$isModifying)
                <button {{$disabled ? "disabled" : '' }} wire:click="toggleIsModifying" class="bg-first-orange text-white px-3 py-2 text-sm font-bold rounded">Uploader PV</button>

            @endif

        </div>
        @if ($isModifying)
            <div class="border border-gray-200 p-3">
                <div class="mt-4 mx-auto">
                    <div class="input_file_container mx-auto">
                        <input wire:model="pvFile" class="styled_input_file" id="pvFile" type="file">
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
                        @error('pvFile')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                        @enderror


                    </div>

                </div>
                <div class="flex justify-end mt-3">
                    <button {{$disabled ? "disabled" : '' }} wire:click="toggleIsModifying" class="mr-3 bg-red-800 hover:bg-red-900 hover:shadow-xl text-white px-3 py-2 text-sm text-bold rounded">
                        Annuler</button>
                    <button {{$disabled ? "disabled" : '' }} wire:click="uploadPV" class="flex items-center bg-first-orange hover:shadow-xl text-white px-3 py-2 text-sm text-bold rounded">
                        <span class="mr-2">Upload</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                        </svg>
                    </button>

                </div>

            </div>
        @endif
    @endif
</div>
