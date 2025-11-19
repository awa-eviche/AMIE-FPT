<div>
    <div wire:loading class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100">
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
    </div>
    @if ($is_charging)
        <div class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100 z-50">
            <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
            <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
            <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        </div>

    @endif
    <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm">
        <div class="max-w-7xl sm:px-2 lg:px-2 mx-3">

            <table class="min-w-full border border-gray-300 text-sm rounded-lg">
                <thead class="border-maquette-gris">
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">Email </th>
                        <td class="py-2 px-4 border-b w-2/3 border-l ">{{$donnees["email"]}}</td>
                    </tr>
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">Nom </th>
                        <td class="py-2 px-4 border-b w-2/3 border-l ">{{$donnees["nom"]}}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">Prénom</th>
                        <td class="py-2 px-4 border-b w-2/3 border-l ">{{$donnees["prenom"]}}</td>
                    </tr>
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">Date de naissance</th>
                        <td class="py-2 px-4 border-b w-2/3 border-l">{{$donnees["date_naissance"]}}</td>
                    </tr>
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">Lieu de naissance</th>
                        <td class="py-2 px-4 border-b w-2/3 border-l">{{$donnees["lieu_naissance"]}}</td>
                    </tr>
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">Adresse</th>
                        <td class="py-2 px-4 border-b w-2/3 border-l">{{$donnees["adresse"]}}</td>
                    </tr>
                    <tr class="flex">
                        <th class="w-1/3 flex items-center py-2 px-2 border-b">N° Téléphone </th>
                        <td class="py-2 px-4 border-b w-2/3 border-l">{{$donnees["telephone"]}}</td>
                    </tr>
                </tbody>
            </table>


        </div>

        <div class="max-w-7xl sm:px-2 lg:px-2 mx-3">
            <table class="min-w-full border border-gray-300 text-sm rounded-lg">
                <tr class="flex">
                    <th class="w-1/3 flex items-center py-2 px-2 border-b justify-start">Nom de l'entreprise</th>
                    <td class="py-2 px-4 border-b w-2/3 border-l ">{{$donnees["nom_entreprise"]}}</td>
                </tr>

                <tr class="flex">
                    <th class="w-1/3 flex items-center py-2 px-2 border-b justify-start">Email entreprise</th>
                    <td class="py-2 px-4 border-b w-2/3 border-l ">{{$donnees["email"]}}</td>
                </tr>
                <tr class="flex">
                    <th class="w-1/3 flex items-center py-2 px-2 border-b">NINEA</th>
                    <td class="py-2 px-4 border-b w-2/3 border-l ">{{$donnees["ninea"]}}</td>
                </tr>
                <tr class="flex">
                    <th class="w-1/3 flex items-center py-2 px-2 border-b">Effectif</th>
                    <td class="py-2 px-4 border-b w-2/3 border-l">{{$donnees["effectif"]}}</td>
                </tr>
                <tr class="flex">
                    <th class="w-1/3 flex items-center flex-start py-2 px-2 border-b">Date de création</th>
                    <td class="py-2 px-4 border-b w-2/3 border-l">{{$donnees["date_creation"]}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div>
        <div class="p-4 border rounded bg-white shadow">
            <h2 class="text-xl font-bold mb-4">Liste des Documents</h2>
            <ul class="list-disc pl-4 flex flex-wrap">

                @foreach($donnees["fichiers"] as $fichier)
                    @foreach ($fichier as $item)
                        <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">
                            <div class="flex items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#F37930"/>
                                    <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#F37930"/>
                                </svg>

                                <span class="ml-3 overflow-hidden">{{$item}}</span>
                            </div>
                            <div class="flex items-center w-[60px] justify-between">
                                <a href="" target="_blank">
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
                                <a href="" download>
                                    <svg width="18" height="17" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5835 8.75V11.0833C12.5835 11.3928 12.4606 11.6895 12.2418 11.9083C12.023 12.1271 11.7262 12.25 11.4168 12.25H3.25016C2.94074 12.25 2.644 12.1271 2.4252 11.9083C2.20641 11.6895 2.0835 11.3928 2.0835 11.0833V8.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.41699 5.83331L7.33366 8.74998L10.2503 5.83331" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.3335 8.75V1.75" stroke="#F37930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                </a>

                            </div>
                        </li>

                    @endforeach

                @endforeach
            </ul>

        </div>
    </div>


    <div class="flex justify-between mt-4">
        <button wire:click="back" class="flex items-center bg-black py-2 px-6 rounded text-white text-sm" type="submit">
            <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 6.5002L7.5 0.56632L7.5 12.4341L0 6.5002Z" fill="white"/>
                </svg>

            <span class="font-bold ml-3">
                Précédent

            </span>
        </button>

        <div class="flex">
            <button wire:click="enregistrerBrouillon" class="hover:bg-blue-800 flex items-center bg-first-orange py-2 px-6 rounded text-white text-sm mr-2" type="submit">
                <svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.6979 6.55208L12.4479 0.302083C12.3519 0.208384 12.2387 0.134107 12.1146 0.0833333C11.9854 0.030851 11.8477 0.00260216 11.7083 0H3.375C2.5462 0 1.75134 0.32924 1.16529 0.915291C0.57924 1.50134 0.25 2.2962 0.25 3.125V15.625C0.25 16.4538 0.57924 17.2487 1.16529 17.8347C1.75134 18.4208 2.5462 18.75 3.375 18.75H15.875C16.7038 18.75 17.4987 18.4208 18.0847 17.8347C18.6708 17.2487 19 16.4538 19 15.625V7.29167C19.0008 7.15458 18.9745 7.01868 18.9227 6.89176C18.8708 6.76485 18.7945 6.64942 18.6979 6.55208ZM6.5 2.08333H10.6667V4.16667H6.5V2.08333ZM12.75 16.6667H6.5V13.5417C6.5 13.2654 6.60975 13.0004 6.8051 12.8051C7.00045 12.6097 7.2654 12.5 7.54167 12.5H11.7083C11.9846 12.5 12.2496 12.6097 12.4449 12.8051C12.6403 13.0004 12.75 13.2654 12.75 13.5417V16.6667ZM16.9167 15.625C16.9167 15.9013 16.8069 16.1662 16.6116 16.3616C16.4162 16.5569 16.1513 16.6667 15.875 16.6667H14.8333V13.5417C14.8333 12.7129 14.5041 11.918 13.918 11.332C13.332 10.7459 12.5371 10.4167 11.7083 10.4167H7.54167C6.71286 10.4167 5.91801 10.7459 5.33196 11.332C4.74591 11.918 4.41667 12.7129 4.41667 13.5417V16.6667H3.375C3.09873 16.6667 2.83378 16.5569 2.63843 16.3616C2.44308 16.1662 2.33333 15.9013 2.33333 15.625V3.125C2.33333 2.84873 2.44308 2.58378 2.63843 2.38843C2.83378 2.19308 3.09873 2.08333 3.375 2.08333H4.41667V5.20833C4.41667 5.4846 4.52641 5.74955 4.72176 5.9449C4.91711 6.14025 5.18207 6.25 5.45833 6.25H11.7083C11.9846 6.25 12.2496 6.14025 12.4449 5.9449C12.6403 5.74955 12.75 5.4846 12.75 5.20833V3.55208L16.9167 7.71875V15.625Z" fill="white"/>
                </svg>
                <span class="font-bold">
                    Enregistrer comme brouillon

                </span>
            </button>

            <button wire:click="soumettre" class="flex items-center bg-cyan-700 hover:bg-green-600 py-2 px-6 rounded text-white text-sm text-bold" type="submit">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5917 6.00822C15.5142 5.93011 15.4221 5.86811 15.3205 5.82581C15.219 5.7835 15.11 5.76172 15 5.76172C14.89 5.76172 14.7811 5.7835 14.6796 5.82581C14.578 5.86811 14.4858 5.93011 14.4084 6.00822L8.20004 12.2249L5.59171 9.60822C5.51127 9.53052 5.41632 9.46942 5.31227 9.42842C5.20823 9.38742 5.09713 9.36731 4.98531 9.36924C4.87349 9.37118 4.76315 9.39512 4.66058 9.4397C4.55802 9.48427 4.46524 9.54862 4.38754 9.62905C4.30984 9.70949 4.24875 9.80444 4.20774 9.90848C4.16674 10.0125 4.14663 10.1236 4.14856 10.2354C4.1505 10.3473 4.17444 10.4576 4.21902 10.5602C4.2636 10.6627 4.32794 10.7555 4.40837 10.8332L7.60837 14.0332C7.68584 14.1113 7.77801 14.1733 7.87956 14.2156C7.98111 14.2579 8.09003 14.2797 8.20004 14.2797C8.31005 14.2797 8.41897 14.2579 8.52052 14.2156C8.62207 14.1733 8.71424 14.1113 8.79171 14.0332L15.5917 7.23322C15.6763 7.15518 15.7438 7.06047 15.79 6.95506C15.8361 6.84964 15.86 6.7358 15.86 6.62072C15.86 6.50563 15.8361 6.3918 15.79 6.28638C15.7438 6.18096 15.6763 6.08625 15.5917 6.00822Z" fill="white"/>
                </svg>
                <span class="ml-2 font-bold">Soumettre</span>


            </button>

        </div>
    </div>

</div>

