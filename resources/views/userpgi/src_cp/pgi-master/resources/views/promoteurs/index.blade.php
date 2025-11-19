<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-10xl mx-auto">
            <div class="flex flex-wrap justify-stretch">
                <div class="flex-grow mx-2 my-4 shadow-md rounded-lg px-8 py-12 bg-black text-gray-500">
                    <div class="flex items-center">
                        <div class="flex-none rounded-full text-white bg-zinc-600 px-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                <g id="wallet-2.6 1">
                                <path id="Vector" d="M13.1503 1.94666H6.85033C3.70033 1.94666 2.91699 2.78832 2.91699 6.14666V15.53C2.91699 17.7467 4.13366 18.2717 5.60866 16.6883L5.61699 16.68C6.30033 15.955 7.34199 16.0133 7.93366 16.805L8.77533 17.93C9.45033 18.8217 10.542 18.8217 11.217 17.93L12.0587 16.805C12.6587 16.005 13.7003 15.9467 14.3837 16.68C15.867 18.2633 17.0753 17.7383 17.0753 15.5217V6.14666C17.0837 2.78832 16.3003 1.94666 13.1503 1.94666ZM12.292 9.23832H7.70866C7.36699 9.23832 7.08366 8.95499 7.08366 8.61332C7.08366 8.27166 7.36699 7.98832 7.70866 7.98832H12.292C12.6337 7.98832 12.917 8.27166 12.917 8.61332C12.917 8.95499 12.6337 9.23832 12.292 9.23832Z" fill="#929EAE"/>
                                </g>
                            </svg>
                        </div>
                        <div class="px-4">
                            Demandes totales
                            <p class="py-2 text-white font-bold text-xl">500</p>
                        </div>
                    </div>
                </div>
                <div class="flex-grow mx-2 my-4 shadow-md rounded-lg px-8 py-12 bg-white text-gray-500">
                    <div class="flex items-center">
                        <div class="flex-none rounded-full text-black bg-slate-200 px-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21"
                                fill="none">
                                <rect width="21" height="21" fill="#57595C" />
                                <g id="Dashboard" clip-path="url(#clip0_510_1716)">
                                    <rect width="1440" height="935" transform="translate(-1177 -153)"
                                        fill="#E1E1E1" />
                                    <g id="Frame 412">
                                        <g id="Frame 411">
                                            <g id="Frame 410">
                                                <g id="Cards, Graph, Transaction">
                                                    <g id="Cards">
                                                        <g id="Total Balance">
                                                            <rect x="-30.75" y="-41" width="263.75" height="103"
                                                                rx="10" fill="#F8F8F8" />
                                                            <g id="Icon">
                                                                <circle id="Ellipse 2" cx="10.25" cy="10.5"
                                                                    r="21" fill="#EBE8E8" />
                                                                <g id="wallet-2.6 1">
                                                                    <path id="Vector"
                                                                        d="M13.4003 1.94666H7.10033C3.95033 1.94666 3.16699 2.78832 3.16699 6.14666V15.53C3.16699 17.7467 4.38366 18.2717 5.85866 16.6883L5.86699 16.68C6.55033 15.955 7.59199 16.0133 8.18366 16.805L9.02533 17.93C9.70033 18.8217 10.792 18.8217 11.467 17.93L12.3087 16.805C12.9087 16.005 13.9503 15.9467 14.6337 16.68C16.117 18.2633 17.3253 17.7383 17.3253 15.5217V6.14666C17.3337 2.78832 16.5503 1.94666 13.4003 1.94666ZM12.542 9.23832H7.95866C7.61699 9.23832 7.33366 8.95499 7.33366 8.61332C7.33366 8.27166 7.61699 7.98832 7.95866 7.98832H12.542C12.8837 7.98832 13.167 8.27166 13.167 8.61332C13.167 8.95499 12.8837 9.23832 12.542 9.23832Z"
                                                                        fill="#1B212D" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_510_1716">
                                        <rect width="1440" height="935" fill="white"
                                            transform="translate(-1177 -153)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="px-4">
                            Demandes en cours
                            <p class="py-2 text-black font-bold text-xl">150</p>
                        </div>
                    </div>
                </div>
                <div class="flex-grow mx-2 my-4 shadow-md rounded-lg px-8 py-12 bg-white text-gray-500">
                    <div class="flex items-center">
                        <div class="flex-none rounded-full text-black bg-slate-200 px-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21"
                                fill="none">
                                <rect width="21" height="21" fill="#57595C" />
                                <g id="Dashboard" clip-path="url(#clip0_510_1716)">
                                    <rect width="1440" height="935" transform="translate(-1177 -153)"
                                        fill="#E1E1E1" />
                                    <g id="Frame 412">
                                        <g id="Frame 411">
                                            <g id="Frame 410">
                                                <g id="Cards, Graph, Transaction">
                                                    <g id="Cards">
                                                        <g id="Total Balance">
                                                            <rect x="-30.75" y="-41" width="263.75" height="103"
                                                                rx="10" fill="#F8F8F8" />
                                                            <g id="Icon">
                                                                <circle id="Ellipse 2" cx="10.25" cy="10.5"
                                                                    r="21" fill="#EBE8E8" />
                                                                <g id="wallet-2.6 1">
                                                                    <path id="Vector"
                                                                        d="M13.4003 1.94666H7.10033C3.95033 1.94666 3.16699 2.78832 3.16699 6.14666V15.53C3.16699 17.7467 4.38366 18.2717 5.85866 16.6883L5.86699 16.68C6.55033 15.955 7.59199 16.0133 8.18366 16.805L9.02533 17.93C9.70033 18.8217 10.792 18.8217 11.467 17.93L12.3087 16.805C12.9087 16.005 13.9503 15.9467 14.6337 16.68C16.117 18.2633 17.3253 17.7383 17.3253 15.5217V6.14666C17.3337 2.78832 16.5503 1.94666 13.4003 1.94666ZM12.542 9.23832H7.95866C7.61699 9.23832 7.33366 8.95499 7.33366 8.61332C7.33366 8.27166 7.61699 7.98832 7.95866 7.98832H12.542C12.8837 7.98832 13.167 8.27166 13.167 8.61332C13.167 8.95499 12.8837 9.23832 12.542 9.23832Z"
                                                                        fill="#1B212D" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_510_1716">
                                        <rect width="1440" height="935" fill="white"
                                            transform="translate(-1177 -153)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="px-4">
                            Demandes validées
                            <p class="py-2 text-black font-bold text-xl">200</p>
                        </div>
                    </div>
                </div>
                <div class="flex-grow mx-2 my-4 shadow-md rounded-lg px-8 py-12 bg-white text-gray-500">
                    <div class="flex items-center">
                        <div class="flex-none rounded-full text-black bg-slate-200 px-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                viewBox="0 0 21 21" fill="none">
                                <rect width="21" height="21" fill="#57595C" />
                                <g id="Dashboard" clip-path="url(#clip0_510_1716)">
                                    <rect width="1440" height="935" transform="translate(-1177 -153)"
                                        fill="#E1E1E1" />
                                    <g id="Frame 412">
                                        <g id="Frame 411">
                                            <g id="Frame 410">
                                                <g id="Cards, Graph, Transaction">
                                                    <g id="Cards">
                                                        <g id="Total Balance">
                                                            <rect x="-30.75" y="-41" width="263.75" height="103"
                                                                rx="10" fill="#F8F8F8" />
                                                            <g id="Icon">
                                                                <circle id="Ellipse 2" cx="10.25" cy="10.5"
                                                                    r="21" fill="#EBE8E8" />
                                                                <g id="wallet-2.6 1">
                                                                    <path id="Vector"
                                                                        d="M13.4003 1.94666H7.10033C3.95033 1.94666 3.16699 2.78832 3.16699 6.14666V15.53C3.16699 17.7467 4.38366 18.2717 5.85866 16.6883L5.86699 16.68C6.55033 15.955 7.59199 16.0133 8.18366 16.805L9.02533 17.93C9.70033 18.8217 10.792 18.8217 11.467 17.93L12.3087 16.805C12.9087 16.005 13.9503 15.9467 14.6337 16.68C16.117 18.2633 17.3253 17.7383 17.3253 15.5217V6.14666C17.3337 2.78832 16.5503 1.94666 13.4003 1.94666ZM12.542 9.23832H7.95866C7.61699 9.23832 7.33366 8.95499 7.33366 8.61332C7.33366 8.27166 7.61699 7.98832 7.95866 7.98832H12.542C12.8837 7.98832 13.167 8.27166 13.167 8.61332C13.167 8.95499 12.8837 9.23832 12.542 9.23832Z"
                                                                        fill="#1B212D" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_510_1716">
                                        <rect width="1440" height="935" fill="white"
                                            transform="translate(-1177 -153)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="px-4">
                            Demandes rejetées
                            <p class="py-2 text-black font-bold text-xl">50</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
