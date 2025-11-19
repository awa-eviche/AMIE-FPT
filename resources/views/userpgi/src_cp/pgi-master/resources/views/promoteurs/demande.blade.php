@section('customCss')
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
@endsection

@section('customJs')
    <script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Demande') }} N° {{$demandeDetails->id}}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-10xl mx-auto">
            <div class="flex justify-between">
                <span class="text-black text-sm">Liste de mes demandes / <span class="text-orange-600"> Demande N° {{$demandeDetails->id}}</span></span>
            </div>
            <div class="flex flex-wrap justify-between  mt-8 mb-10">
                <div class="flex  w-2/3 gap-y-4 pr-4 flex-col">
                    <div class="rounded-lg shadow-sm px-8 py-5" style="background: var(--darkish-color-dark-1, #201E34);">
                        <div class="flex justify-between text-white items-center">
                            <span>Informations sur la demande</span>
                            <span class="text-orange-600 bg-orange-100 rounded-md shadow-md px-4 py-1">
                                En attente
                            </span>
                        </div>
                        <div class="flex justify-between text-white items-center mt-3 text-sm">
                            <span>N° d’enregistrement</span>
                            <span>
                                MGL0124877
                            </span>
                        </div>
                        <div class="flex justify-between text-white items-center mt-1 text-sm">
                            <span>Date  de dépôt</span>
                            <span>
                                {{date('d/m/Y',strtotime($demandeDetails->date_depot))}}
                            </span>
                        </div>
                        <div class="flex justify-between text-white items-center mt-1 mb-2 text-sm">
                            <span>Libelle du projet</span>
                            <span>
                                projet
                            </span>
                        </div>
                    </div>

                    <div class="mt-10 bg-white rounded-lg shadow-sm px-4 py-5">
                        <div class="border-b border-gray-200 mb-4">
                            <ul class="flex flex-wrap " id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                                <li class="w-1/2" role="presentation">
                                    <button class="font-bold w-full inline-block text-black hover:text-orange-600 hover:border-orange-300 rounded-t-lg py-4 px-4 text-sm font-medium text-left border-transparent border-b-2" id="history-tab" data-tabs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">Historiques</button>
                                </li>
                                <li class="w-1/2" role="presentation">
                                    <button class="font-bold w-full inline-block text-black hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-left border-transparent border-b-2 active" id="listing-tab" data-tabs-target="#listing" type="button" role="tab" aria-controls="listing" aria-selected="true">Demandes de liste</button>
                                </li>
                            </ul>
                        </div>
                        <div id="myTabContent">
                            <div class="bg-gray-50 p-4 rounded-lg hidden" id="history" role="tabpanel" aria-labelledby="history-tab">
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg" id="listing" role="tabpanel" aria-labelledby="listing-tab">
                                <div class="flex flex-wrap gap-8 justify-between">
                                    <div class="flex flex-col w-3/12 items-center border-blue-900 border-2 rounded-xl px-4 py-6 shadow-md">
                                        <span class="rounded-full shadow-md bg-gray-200 px-4 py-4">
                                            <svg class="w-5 h-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="wallet-2.6 1">
                                            <path id="Vector" d="M13.1494 1.44678H6.84935C3.69935 1.44678 2.91602 2.28844 2.91602 5.64678V15.0301C2.91602 17.2468 4.13268 17.7718 5.60768 16.1884L5.61602 16.1801C6.29935 15.4551 7.34102 15.5134 7.93268 16.3051L8.77435 17.4301C9.44935 18.3218 10.541 18.3218 11.216 17.4301L12.0577 16.3051C12.6577 15.5051 13.6994 15.4468 14.3827 16.1801C15.866 17.7634 17.0744 17.2384 17.0744 15.0218V5.64678C17.0827 2.28844 16.2994 1.44678 13.1494 1.44678ZM12.291 8.73844H7.70768C7.36602 8.73844 7.08268 8.45511 7.08268 8.11344C7.08268 7.77178 7.36602 7.48844 7.70768 7.48844H12.291C12.6327 7.48844 12.916 7.77178 12.916 8.11344C12.916 8.45511 12.6327 8.73844 12.291 8.73844Z" fill="#1A4085"/>
                                            </g>
                                            </svg>
                                        </span>
                                        <span class="mt-8 mb-5 text-md text-center">Libellé de la demande</span>
                                        <a href="javascript:void(0);" class="text-orange-600 text-sm">Voir plus -></a>
                                    </div>
                                    <div class="flex flex-col w-3/12 items-center border-blue-900 border-2 rounded-xl px-4 py-6 shadow-md">
                                        <span class="rounded-full shadow-md bg-gray-200 px-4 py-4">
                                            <svg class="w-5 h-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="wallet-2.6 1">
                                            <path id="Vector" d="M13.1494 1.44678H6.84935C3.69935 1.44678 2.91602 2.28844 2.91602 5.64678V15.0301C2.91602 17.2468 4.13268 17.7718 5.60768 16.1884L5.61602 16.1801C6.29935 15.4551 7.34102 15.5134 7.93268 16.3051L8.77435 17.4301C9.44935 18.3218 10.541 18.3218 11.216 17.4301L12.0577 16.3051C12.6577 15.5051 13.6994 15.4468 14.3827 16.1801C15.866 17.7634 17.0744 17.2384 17.0744 15.0218V5.64678C17.0827 2.28844 16.2994 1.44678 13.1494 1.44678ZM12.291 8.73844H7.70768C7.36602 8.73844 7.08268 8.45511 7.08268 8.11344C7.08268 7.77178 7.36602 7.48844 7.70768 7.48844H12.291C12.6327 7.48844 12.916 7.77178 12.916 8.11344C12.916 8.45511 12.6327 8.73844 12.291 8.73844Z" fill="#1A4085"/>
                                            </g>
                                            </svg>
                                        </span>
                                        <span class="mt-8 mb-5 text-md text-center">Libellé de la demande</span>
                                        <a href="javascript:void(0);" class="text-orange-600 text-sm">Voir plus -></a>
                                    </div>
                                    <div class="flex flex-col w-3/12 items-center border-blue-900 border-2 rounded-xl px-4 py-6 shadow-md">
                                        <span class="rounded-full shadow-md bg-gray-200 px-4 py-4">
                                            <svg class="w-5 h-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="wallet-2.6 1">
                                            <path id="Vector" d="M13.1494 1.44678H6.84935C3.69935 1.44678 2.91602 2.28844 2.91602 5.64678V15.0301C2.91602 17.2468 4.13268 17.7718 5.60768 16.1884L5.61602 16.1801C6.29935 15.4551 7.34102 15.5134 7.93268 16.3051L8.77435 17.4301C9.44935 18.3218 10.541 18.3218 11.216 17.4301L12.0577 16.3051C12.6577 15.5051 13.6994 15.4468 14.3827 16.1801C15.866 17.7634 17.0744 17.2384 17.0744 15.0218V5.64678C17.0827 2.28844 16.2994 1.44678 13.1494 1.44678ZM12.291 8.73844H7.70768C7.36602 8.73844 7.08268 8.45511 7.08268 8.11344C7.08268 7.77178 7.36602 7.48844 7.70768 7.48844H12.291C12.6327 7.48844 12.916 7.77178 12.916 8.11344C12.916 8.45511 12.6327 8.73844 12.291 8.73844Z" fill="#1A4085"/>
                                            </g>
                                            </svg>
                                        </span>
                                        <span class="mt-8 mb-5 text-md text-center">Libellé de la demande</span>
                                        <a href="javascript:void(0);" class="text-orange-600 text-sm">Voir plus -></a>
                                    </div>
                                    <div class="flex flex-col w-3/12 items-center border-blue-900 border-2 rounded-xl px-4 py-6 shadow-md">
                                        <span class="rounded-full shadow-md bg-gray-200 px-4 py-4">
                                            <svg class="w-5 h-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="wallet-2.6 1">
                                            <path id="Vector" d="M13.1494 1.44678H6.84935C3.69935 1.44678 2.91602 2.28844 2.91602 5.64678V15.0301C2.91602 17.2468 4.13268 17.7718 5.60768 16.1884L5.61602 16.1801C6.29935 15.4551 7.34102 15.5134 7.93268 16.3051L8.77435 17.4301C9.44935 18.3218 10.541 18.3218 11.216 17.4301L12.0577 16.3051C12.6577 15.5051 13.6994 15.4468 14.3827 16.1801C15.866 17.7634 17.0744 17.2384 17.0744 15.0218V5.64678C17.0827 2.28844 16.2994 1.44678 13.1494 1.44678ZM12.291 8.73844H7.70768C7.36602 8.73844 7.08268 8.45511 7.08268 8.11344C7.08268 7.77178 7.36602 7.48844 7.70768 7.48844H12.291C12.6327 7.48844 12.916 7.77178 12.916 8.11344C12.916 8.45511 12.6327 8.73844 12.291 8.73844Z" fill="#1A4085"/>
                                            </g>
                                            </svg>
                                        </span>
                                        <span class="mt-8 mb-5 text-md text-center">Libellé de la demande</span>
                                        <a href="javascript:void(0);" class="text-orange-600 text-sm">Voir plus -></a>
                                    </div>
                                    <div class="flex flex-col w-3/12 items-center border-blue-900 border-2 rounded-xl px-4 py-6 shadow-md">
                                        <span class="rounded-full shadow-md bg-gray-200 px-4 py-4">
                                            <svg class="w-5 h-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="wallet-2.6 1">
                                            <path id="Vector" d="M13.1494 1.44678H6.84935C3.69935 1.44678 2.91602 2.28844 2.91602 5.64678V15.0301C2.91602 17.2468 4.13268 17.7718 5.60768 16.1884L5.61602 16.1801C6.29935 15.4551 7.34102 15.5134 7.93268 16.3051L8.77435 17.4301C9.44935 18.3218 10.541 18.3218 11.216 17.4301L12.0577 16.3051C12.6577 15.5051 13.6994 15.4468 14.3827 16.1801C15.866 17.7634 17.0744 17.2384 17.0744 15.0218V5.64678C17.0827 2.28844 16.2994 1.44678 13.1494 1.44678ZM12.291 8.73844H7.70768C7.36602 8.73844 7.08268 8.45511 7.08268 8.11344C7.08268 7.77178 7.36602 7.48844 7.70768 7.48844H12.291C12.6327 7.48844 12.916 7.77178 12.916 8.11344C12.916 8.45511 12.6327 8.73844 12.291 8.73844Z" fill="#1A4085"/>
                                            </g>
                                            </svg>
                                        </span>
                                        <span class="mt-8 mb-5 text-md text-center">Libellé de la demande</span>
                                        <a href="javascript:void(0);" class="text-orange-600 text-sm">Voir plus -></a>
                                    </div>
                                    <div class="flex flex-col w-3/12 items-center border-blue-900 border-2 rounded-xl px-4 py-6 shadow-md">
                                        <span class="rounded-full shadow-md bg-gray-200 px-4 py-4">
                                            <svg class="w-5 h-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="wallet-2.6 1">
                                            <path id="Vector" d="M13.1494 1.44678H6.84935C3.69935 1.44678 2.91602 2.28844 2.91602 5.64678V15.0301C2.91602 17.2468 4.13268 17.7718 5.60768 16.1884L5.61602 16.1801C6.29935 15.4551 7.34102 15.5134 7.93268 16.3051L8.77435 17.4301C9.44935 18.3218 10.541 18.3218 11.216 17.4301L12.0577 16.3051C12.6577 15.5051 13.6994 15.4468 14.3827 16.1801C15.866 17.7634 17.0744 17.2384 17.0744 15.0218V5.64678C17.0827 2.28844 16.2994 1.44678 13.1494 1.44678ZM12.291 8.73844H7.70768C7.36602 8.73844 7.08268 8.45511 7.08268 8.11344C7.08268 7.77178 7.36602 7.48844 7.70768 7.48844H12.291C12.6327 7.48844 12.916 7.77178 12.916 8.11344C12.916 8.45511 12.6327 8.73844 12.291 8.73844Z" fill="#1A4085"/>
                                            </g>
                                            </svg>
                                        </span>
                                        <span class="mt-8 mb-5 text-md text-center">Libellé de la demande</span>
                                        <a href="javascript:void(0);" class="text-orange-600 text-sm">Voir plus -></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Document section -->
                <div class="flex w-1/3 ">
                    <div class="bg-white rounded-md shadow-sm flex-grow px-4 py-5">
                        <div class="flex justify-between">
                            <h2>Documents</h2>
                            <button class="text-gray-900">
                                <svg width="17" height="4" viewBox="0 0 17 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector" d="M1.96154 0C0.876154 0 0 0.893333 0 2C0 3.10667 0.876154 4 1.96154 4C3.04692 4 3.92308 3.10667 3.92308 2C3.92308 0.893333 3.04692 0 1.96154 0ZM15.0385 0C13.9531 0 13.0769 0.893333 13.0769 2C13.0769 3.10667 13.9531 4 15.0385 4C16.1238 4 17 3.10667 17 2C17 0.893333 16.1238 0 15.0385 0ZM8.5 0C7.41462 0 6.53846 0.893333 6.53846 2C6.53846 3.10667 7.41462 4 8.5 4C9.58538 4 10.4615 3.10667 10.4615 2C10.4615 0.893333 9.58538 0 8.5 0Z" fill="#929EAE"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-between px-4 py-4 mt-5" style="background-color: var(--C5, #F5F5F5);;">
                            <div class="flex justify-start items-center">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="bi:file-earmark-image">
                                    <g id="Group">
                                    <path id="Vector" d="M10.4199 10.5C10.7154 10.5 11.008 10.4418 11.281 10.3287C11.5539 10.2157 11.802 10.0499 12.0109 9.84099C12.2198 9.63206 12.3856 9.38402 12.4987 9.11104C12.6117 8.83806 12.6699 8.54547 12.6699 8.25C12.6699 7.95453 12.6117 7.66194 12.4987 7.38896C12.3856 7.11598 12.2198 6.86794 12.0109 6.65901C11.802 6.45008 11.5539 6.28434 11.281 6.17127C11.008 6.0582 10.7154 6 10.4199 6C9.82318 6 9.25089 6.23705 8.82893 6.65901C8.40698 7.08097 8.16992 7.65326 8.16992 8.25C8.16992 8.84674 8.40698 9.41903 8.82893 9.84099C9.25089 10.2629 9.82318 10.5 10.4199 10.5Z" fill="#1A4085"/>
                                    <path id="Vector_2" d="M21.666 21C21.666 21.7956 21.3499 22.5587 20.7873 23.1213C20.2247 23.6839 19.4617 24 18.666 24H6.66602C5.87037 24 5.1073 23.6839 4.5447 23.1213C3.98209 22.5587 3.66602 21.7956 3.66602 21V3C3.66602 2.20435 3.98209 1.44129 4.5447 0.87868C5.1073 0.316071 5.87037 0 6.66602 0L14.916 0L21.666 6.75V21ZM6.66602 1.5C6.26819 1.5 5.88666 1.65804 5.60536 1.93934C5.32405 2.22064 5.16602 2.60218 5.16602 3V18L8.50202 14.664C8.62024 14.5461 8.77444 14.4709 8.94019 14.4506C9.10594 14.4302 9.27374 14.4657 9.41702 14.5515L12.666 16.5L15.9015 11.97C15.9648 11.8815 16.0466 11.8078 16.1413 11.754C16.2359 11.7003 16.3412 11.6678 16.4496 11.6588C16.5581 11.6498 16.6672 11.6645 16.7694 11.702C16.8717 11.7394 16.9645 11.7986 17.0415 11.8755L20.166 15V6.75H17.166C16.5693 6.75 15.997 6.51295 15.575 6.09099C15.1531 5.66903 14.916 5.09674 14.916 4.5V1.5H6.66602Z" fill="#1A4085"/>
                                    </g>
                                    </g>
                                </svg>
                                <span class="mx-4 text-sm">Nom de la pièce jointe</span>
                                <svg class="w-4 h-2" width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle id="Ellipse 1" cx="2.16602" cy="2" r="1.5" fill="#767676"/>
                                </svg>
                            </div>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Eye" clip-path="url(#clip0_1130_652)">
                                    <path id="Vector" d="M0.583984 7.00004C0.583984 7.00004 2.91732 2.33337 7.00065 2.33337C11.084 2.33337 13.4173 7.00004 13.4173 7.00004C13.4173 7.00004 11.084 11.6667 7.00065 11.6667C2.91732 11.6667 0.583984 7.00004 0.583984 7.00004Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_652">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Download" clip-path="url(#clip0_1130_657)">
                                    <path id="Vector" d="M12.25 8.75V11.0833C12.25 11.3928 12.1271 11.6895 11.9083 11.9083C11.6895 12.1271 11.3928 12.25 11.0833 12.25H2.91667C2.60725 12.25 2.3105 12.1271 2.09171 11.9083C1.87292 11.6895 1.75 11.3928 1.75 11.0833V8.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M4.08398 5.83337L7.00065 8.75004L9.91732 5.83337" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_3" d="M7 8.75V1.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_657">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>

                        <div class="flex justify-between px-4 py-4 mt-5" style="background-color: var(--C5, #F5F5F5);;">
                            <div class="flex justify-start items-center">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="bi:file-earmark-image">
                                    <g id="Group">
                                    <path id="Vector" d="M10.4199 10.5C10.7154 10.5 11.008 10.4418 11.281 10.3287C11.5539 10.2157 11.802 10.0499 12.0109 9.84099C12.2198 9.63206 12.3856 9.38402 12.4987 9.11104C12.6117 8.83806 12.6699 8.54547 12.6699 8.25C12.6699 7.95453 12.6117 7.66194 12.4987 7.38896C12.3856 7.11598 12.2198 6.86794 12.0109 6.65901C11.802 6.45008 11.5539 6.28434 11.281 6.17127C11.008 6.0582 10.7154 6 10.4199 6C9.82318 6 9.25089 6.23705 8.82893 6.65901C8.40698 7.08097 8.16992 7.65326 8.16992 8.25C8.16992 8.84674 8.40698 9.41903 8.82893 9.84099C9.25089 10.2629 9.82318 10.5 10.4199 10.5Z" fill="#1A4085"/>
                                    <path id="Vector_2" d="M21.666 21C21.666 21.7956 21.3499 22.5587 20.7873 23.1213C20.2247 23.6839 19.4617 24 18.666 24H6.66602C5.87037 24 5.1073 23.6839 4.5447 23.1213C3.98209 22.5587 3.66602 21.7956 3.66602 21V3C3.66602 2.20435 3.98209 1.44129 4.5447 0.87868C5.1073 0.316071 5.87037 0 6.66602 0L14.916 0L21.666 6.75V21ZM6.66602 1.5C6.26819 1.5 5.88666 1.65804 5.60536 1.93934C5.32405 2.22064 5.16602 2.60218 5.16602 3V18L8.50202 14.664C8.62024 14.5461 8.77444 14.4709 8.94019 14.4506C9.10594 14.4302 9.27374 14.4657 9.41702 14.5515L12.666 16.5L15.9015 11.97C15.9648 11.8815 16.0466 11.8078 16.1413 11.754C16.2359 11.7003 16.3412 11.6678 16.4496 11.6588C16.5581 11.6498 16.6672 11.6645 16.7694 11.702C16.8717 11.7394 16.9645 11.7986 17.0415 11.8755L20.166 15V6.75H17.166C16.5693 6.75 15.997 6.51295 15.575 6.09099C15.1531 5.66903 14.916 5.09674 14.916 4.5V1.5H6.66602Z" fill="#1A4085"/>
                                    </g>
                                    </g>
                                </svg>
                                <span class="mx-4 text-sm">Nom de la pièce jointe</span>
                                <svg class="w-4 h-2" width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle id="Ellipse 1" cx="2.16602" cy="2" r="1.5" fill="#767676"/>
                                </svg>
                            </div>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Eye" clip-path="url(#clip0_1130_652)">
                                    <path id="Vector" d="M0.583984 7.00004C0.583984 7.00004 2.91732 2.33337 7.00065 2.33337C11.084 2.33337 13.4173 7.00004 13.4173 7.00004C13.4173 7.00004 11.084 11.6667 7.00065 11.6667C2.91732 11.6667 0.583984 7.00004 0.583984 7.00004Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_652">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Download" clip-path="url(#clip0_1130_657)">
                                    <path id="Vector" d="M12.25 8.75V11.0833C12.25 11.3928 12.1271 11.6895 11.9083 11.9083C11.6895 12.1271 11.3928 12.25 11.0833 12.25H2.91667C2.60725 12.25 2.3105 12.1271 2.09171 11.9083C1.87292 11.6895 1.75 11.3928 1.75 11.0833V8.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M4.08398 5.83337L7.00065 8.75004L9.91732 5.83337" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_3" d="M7 8.75V1.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_657">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>

                        <div class="flex justify-between px-4 py-4 mt-5" style="background-color: var(--C5, #F5F5F5);;">
                            <div class="flex justify-start items-center">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="bi:file-earmark-image">
                                    <g id="Group">
                                    <path id="Vector" d="M10.4199 10.5C10.7154 10.5 11.008 10.4418 11.281 10.3287C11.5539 10.2157 11.802 10.0499 12.0109 9.84099C12.2198 9.63206 12.3856 9.38402 12.4987 9.11104C12.6117 8.83806 12.6699 8.54547 12.6699 8.25C12.6699 7.95453 12.6117 7.66194 12.4987 7.38896C12.3856 7.11598 12.2198 6.86794 12.0109 6.65901C11.802 6.45008 11.5539 6.28434 11.281 6.17127C11.008 6.0582 10.7154 6 10.4199 6C9.82318 6 9.25089 6.23705 8.82893 6.65901C8.40698 7.08097 8.16992 7.65326 8.16992 8.25C8.16992 8.84674 8.40698 9.41903 8.82893 9.84099C9.25089 10.2629 9.82318 10.5 10.4199 10.5Z" fill="#1A4085"/>
                                    <path id="Vector_2" d="M21.666 21C21.666 21.7956 21.3499 22.5587 20.7873 23.1213C20.2247 23.6839 19.4617 24 18.666 24H6.66602C5.87037 24 5.1073 23.6839 4.5447 23.1213C3.98209 22.5587 3.66602 21.7956 3.66602 21V3C3.66602 2.20435 3.98209 1.44129 4.5447 0.87868C5.1073 0.316071 5.87037 0 6.66602 0L14.916 0L21.666 6.75V21ZM6.66602 1.5C6.26819 1.5 5.88666 1.65804 5.60536 1.93934C5.32405 2.22064 5.16602 2.60218 5.16602 3V18L8.50202 14.664C8.62024 14.5461 8.77444 14.4709 8.94019 14.4506C9.10594 14.4302 9.27374 14.4657 9.41702 14.5515L12.666 16.5L15.9015 11.97C15.9648 11.8815 16.0466 11.8078 16.1413 11.754C16.2359 11.7003 16.3412 11.6678 16.4496 11.6588C16.5581 11.6498 16.6672 11.6645 16.7694 11.702C16.8717 11.7394 16.9645 11.7986 17.0415 11.8755L20.166 15V6.75H17.166C16.5693 6.75 15.997 6.51295 15.575 6.09099C15.1531 5.66903 14.916 5.09674 14.916 4.5V1.5H6.66602Z" fill="#1A4085"/>
                                    </g>
                                    </g>
                                </svg>
                                <span class="mx-4 text-sm">Nom de la pièce jointe</span>
                                <svg class="w-4 h-2" width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle id="Ellipse 1" cx="2.16602" cy="2" r="1.5" fill="#767676"/>
                                </svg>
                            </div>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Eye" clip-path="url(#clip0_1130_652)">
                                    <path id="Vector" d="M0.583984 7.00004C0.583984 7.00004 2.91732 2.33337 7.00065 2.33337C11.084 2.33337 13.4173 7.00004 13.4173 7.00004C13.4173 7.00004 11.084 11.6667 7.00065 11.6667C2.91732 11.6667 0.583984 7.00004 0.583984 7.00004Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_652">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Download" clip-path="url(#clip0_1130_657)">
                                    <path id="Vector" d="M12.25 8.75V11.0833C12.25 11.3928 12.1271 11.6895 11.9083 11.9083C11.6895 12.1271 11.3928 12.25 11.0833 12.25H2.91667C2.60725 12.25 2.3105 12.1271 2.09171 11.9083C1.87292 11.6895 1.75 11.3928 1.75 11.0833V8.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M4.08398 5.83337L7.00065 8.75004L9.91732 5.83337" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_3" d="M7 8.75V1.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_657">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>

                        <div class="flex justify-between px-4 py-4 mt-5" style="background-color: var(--C5, #F5F5F5);;">
                            <div class="flex justify-start items-center">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="bi:file-earmark-image">
                                    <g id="Group">
                                    <path id="Vector" d="M10.4199 10.5C10.7154 10.5 11.008 10.4418 11.281 10.3287C11.5539 10.2157 11.802 10.0499 12.0109 9.84099C12.2198 9.63206 12.3856 9.38402 12.4987 9.11104C12.6117 8.83806 12.6699 8.54547 12.6699 8.25C12.6699 7.95453 12.6117 7.66194 12.4987 7.38896C12.3856 7.11598 12.2198 6.86794 12.0109 6.65901C11.802 6.45008 11.5539 6.28434 11.281 6.17127C11.008 6.0582 10.7154 6 10.4199 6C9.82318 6 9.25089 6.23705 8.82893 6.65901C8.40698 7.08097 8.16992 7.65326 8.16992 8.25C8.16992 8.84674 8.40698 9.41903 8.82893 9.84099C9.25089 10.2629 9.82318 10.5 10.4199 10.5Z" fill="#1A4085"/>
                                    <path id="Vector_2" d="M21.666 21C21.666 21.7956 21.3499 22.5587 20.7873 23.1213C20.2247 23.6839 19.4617 24 18.666 24H6.66602C5.87037 24 5.1073 23.6839 4.5447 23.1213C3.98209 22.5587 3.66602 21.7956 3.66602 21V3C3.66602 2.20435 3.98209 1.44129 4.5447 0.87868C5.1073 0.316071 5.87037 0 6.66602 0L14.916 0L21.666 6.75V21ZM6.66602 1.5C6.26819 1.5 5.88666 1.65804 5.60536 1.93934C5.32405 2.22064 5.16602 2.60218 5.16602 3V18L8.50202 14.664C8.62024 14.5461 8.77444 14.4709 8.94019 14.4506C9.10594 14.4302 9.27374 14.4657 9.41702 14.5515L12.666 16.5L15.9015 11.97C15.9648 11.8815 16.0466 11.8078 16.1413 11.754C16.2359 11.7003 16.3412 11.6678 16.4496 11.6588C16.5581 11.6498 16.6672 11.6645 16.7694 11.702C16.8717 11.7394 16.9645 11.7986 17.0415 11.8755L20.166 15V6.75H17.166C16.5693 6.75 15.997 6.51295 15.575 6.09099C15.1531 5.66903 14.916 5.09674 14.916 4.5V1.5H6.66602Z" fill="#1A4085"/>
                                    </g>
                                    </g>
                                </svg>
                                <span class="mx-4 text-sm">Nom de la pièce jointe</span>
                                <svg class="w-4 h-2" width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle id="Ellipse 1" cx="2.16602" cy="2" r="1.5" fill="#767676"/>
                                </svg>
                            </div>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Eye" clip-path="url(#clip0_1130_652)">
                                    <path id="Vector" d="M0.583984 7.00004C0.583984 7.00004 2.91732 2.33337 7.00065 2.33337C11.084 2.33337 13.4173 7.00004 13.4173 7.00004C13.4173 7.00004 11.084 11.6667 7.00065 11.6667C2.91732 11.6667 0.583984 7.00004 0.583984 7.00004Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_652">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Download" clip-path="url(#clip0_1130_657)">
                                    <path id="Vector" d="M12.25 8.75V11.0833C12.25 11.3928 12.1271 11.6895 11.9083 11.9083C11.6895 12.1271 11.3928 12.25 11.0833 12.25H2.91667C2.60725 12.25 2.3105 12.1271 2.09171 11.9083C1.87292 11.6895 1.75 11.3928 1.75 11.0833V8.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M4.08398 5.83337L7.00065 8.75004L9.91732 5.83337" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_3" d="M7 8.75V1.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_657">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>

                        <div class="flex justify-between px-4 py-4 mt-5" style="background-color: var(--C5, #F5F5F5);;">
                            <div class="flex justify-start items-center">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="bi:file-earmark-image">
                                    <g id="Group">
                                    <path id="Vector" d="M10.4199 10.5C10.7154 10.5 11.008 10.4418 11.281 10.3287C11.5539 10.2157 11.802 10.0499 12.0109 9.84099C12.2198 9.63206 12.3856 9.38402 12.4987 9.11104C12.6117 8.83806 12.6699 8.54547 12.6699 8.25C12.6699 7.95453 12.6117 7.66194 12.4987 7.38896C12.3856 7.11598 12.2198 6.86794 12.0109 6.65901C11.802 6.45008 11.5539 6.28434 11.281 6.17127C11.008 6.0582 10.7154 6 10.4199 6C9.82318 6 9.25089 6.23705 8.82893 6.65901C8.40698 7.08097 8.16992 7.65326 8.16992 8.25C8.16992 8.84674 8.40698 9.41903 8.82893 9.84099C9.25089 10.2629 9.82318 10.5 10.4199 10.5Z" fill="#1A4085"/>
                                    <path id="Vector_2" d="M21.666 21C21.666 21.7956 21.3499 22.5587 20.7873 23.1213C20.2247 23.6839 19.4617 24 18.666 24H6.66602C5.87037 24 5.1073 23.6839 4.5447 23.1213C3.98209 22.5587 3.66602 21.7956 3.66602 21V3C3.66602 2.20435 3.98209 1.44129 4.5447 0.87868C5.1073 0.316071 5.87037 0 6.66602 0L14.916 0L21.666 6.75V21ZM6.66602 1.5C6.26819 1.5 5.88666 1.65804 5.60536 1.93934C5.32405 2.22064 5.16602 2.60218 5.16602 3V18L8.50202 14.664C8.62024 14.5461 8.77444 14.4709 8.94019 14.4506C9.10594 14.4302 9.27374 14.4657 9.41702 14.5515L12.666 16.5L15.9015 11.97C15.9648 11.8815 16.0466 11.8078 16.1413 11.754C16.2359 11.7003 16.3412 11.6678 16.4496 11.6588C16.5581 11.6498 16.6672 11.6645 16.7694 11.702C16.8717 11.7394 16.9645 11.7986 17.0415 11.8755L20.166 15V6.75H17.166C16.5693 6.75 15.997 6.51295 15.575 6.09099C15.1531 5.66903 14.916 5.09674 14.916 4.5V1.5H6.66602Z" fill="#1A4085"/>
                                    </g>
                                    </g>
                                </svg>
                                <span class="mx-4 text-sm">Nom de la pièce jointe</span>
                                <svg class="w-4 h-2" width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle id="Ellipse 1" cx="2.16602" cy="2" r="1.5" fill="#767676"/>
                                </svg>
                            </div>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Eye" clip-path="url(#clip0_1130_652)">
                                    <path id="Vector" d="M0.583984 7.00004C0.583984 7.00004 2.91732 2.33337 7.00065 2.33337C11.084 2.33337 13.4173 7.00004 13.4173 7.00004C13.4173 7.00004 11.084 11.6667 7.00065 11.6667C2.91732 11.6667 0.583984 7.00004 0.583984 7.00004Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_652">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <a href="javascript:void(0);">
                                <svg class="w-4 h-5" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Download" clip-path="url(#clip0_1130_657)">
                                    <path id="Vector" d="M12.25 8.75V11.0833C12.25 11.3928 12.1271 11.6895 11.9083 11.9083C11.6895 12.1271 11.3928 12.25 11.0833 12.25H2.91667C2.60725 12.25 2.3105 12.1271 2.09171 11.9083C1.87292 11.6895 1.75 11.3928 1.75 11.0833V8.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_2" d="M4.08398 5.83337L7.00065 8.75004L9.91732 5.83337" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="Vector_3" d="M7 8.75V1.75" stroke="#1A4085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1130_657">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
