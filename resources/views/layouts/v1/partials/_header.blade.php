<?php
setlocale(LC_TIME, 'fr_FR.utf8');
$dateActuelle = strftime("%d %B %Y %H:%M");
?>
{{-- header --}}
<header class="z-10 pt-1">
    <div class="container flex items-center justify-between h-full px-6 mx-auto">
        
       
        <!-- Brand -->
        <a href="{{route('dashboard')}}"
            class="inline-block text-2xl font-bold tracking-wider uppercase text-primary-dark dark:text-light">
            <div class="flex-1 lg:mr-32">
                @if(Auth()->user()->personnel && Auth()->user()->personnel->etablissement)
                    <div class="text-xxl" style="color:#f7ac42; font-weight: bolder;">
                        <span class="text-poppins_black ">{{Auth()->user()->personnel->etablissement->nom}}</span>
                    </div>
                @endif
                <span class="text-poppins" style="font-size:14px;">
                    Bonjour, <span class="text-poppins_black text-first-orange">{{Auth()->user()->prenom.' '.Auth()->user()->nom}}</span>
                </span>
                <p class="heure text-sm text-center sm:text-justify" >
                    {{$dateActuelle}}
                </p>

            </div>
        </a>
        <button @click="isMobileSubMenuOpen = !isMobileSubMenuOpen"
            class="p-1 transition-colors duration-200 rounded-md text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark md:hidden focus:outline-none focus:ring">
            <span class="sr-only">Open sub manu</span>
            <span aria-hidden="true">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </span>
        </button>

        <!-- Desktop Right buttons -->
        <nav aria-label="Secondary" class="hidden space-x-2 md:flex md:items-center">
            <!-- Toggle dark theme button -->
            <!-- Notification button -->
            <livewire:notification-menu />
            &thinsp;&thinsp;{{Auth()->user()->prenom.' '.Auth()->user()->nom}}&thinsp;
            <!-- Settings button -->

            <!-- User avatar button -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open; $nextTick(() => { if(open){ $refs.userMenu.focus() } })"
                    type="button" aria-haspopup="true" :aria-expanded="open ? 'true' : 'false'"
                    class="transition-opacity duration-200 rounded-full dark:opacity-75 dark:hover:opacity-100 focus:outline-none focus:ring dark:focus:opacity-100">
                    <span class="sr-only">Avatar</span>
                    <img class="w-10 h-10 rounded-full" src="{{asset('backofficeAssets/build/images/imagepgi.svg')}}"
                        alt="MFP CI" />
                </button>
                <!-- User dropdown menu -->
                <div x-show="open" x-ref="userMenu"
                    x-transition:enter="transition-all transform ease-out"
                    x-transition:enter-start="translate-y-1/2 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition-all transform ease-in"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="translate-y-1/2 opacity-0" @click.away="open = false"
                    @keydown.escape="open = false"
                    class="absolute right-0 w-48 py-1 bg-white rounded-md shadow-lg top-12 ring-1 ring-black ring-opacity-5 dark:bg-dark focus:outline-none"
                    tabindex="-1" role="menu" aria-orientation="vertical" aria-label="User menu">
                    <a href="/user/profile" role="menuitem"
                        class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-primary">
                        Profil
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="menuitem"
                        class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-primary">
                        Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </nav>

        <!-- Mobile sub menu -->
        <nav x-transition:enter="transition duration-200 ease-in-out transform sm:duration-500"
            x-transition:enter-start="-translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0" x-show="isMobileSubMenuOpen"
            @click.away="isMobileSubMenuOpen = false"
            class="absolute flex items-center p-4 bg-white rounded-md shadow-lg dark:bg-darker top-16 inset-x-4 md:hidden"
            aria-label="Secondary">
            <div class="flex w-full justify-between">
                <!-- Notification button -->
                <button
                    @click="openNotificationsPanel(); $nextTick(() => { isMobileSubMenuOpen = false })"
                    class="p-2 transition-colors duration-200 rounded-full text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                    <span class="sr-only">Open notifications panel</span>
                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <div class="relative ml-auto" x-data="{ open: false }">
                    <button @click="open = !open" type="button" aria-haspopup="true"
                        :aria-expanded="open ? 'true' : 'false'"
                        class="block transition-opacity duration-200 rounded-full dark:opacity-75 dark:hover:opacity-100 focus:outline-none focus:ring dark:focus:opacity-100">
                        <span class="sr-only">User menu</span>
                        <img class="w-10 h-10 rounded-full" src="{{asset('backofficeAssets/build/images/imagepgi.svg')}}"
                            alt="{{Auth()->user()->prenom.' '.Auth()->user()->nom}}" />
                    </button>

                    <div x-show="open" x-transition:enter="transition-all transform ease-out"
                        x-transition:enter-start="translate-y-1/2 opacity-0"
                        x-transition:enter-end="translate-y-0 opacity-100"
                        x-transition:leave="transition-all transform ease-in"
                        x-transition:leave-start="translate-y-0 opacity-100"
                        x-transition:leave-end="translate-y-1/2 opacity-0" @click.away="open = false"
                        class="absolute right-0 w-48 py-1 origin-top-right bg-white rounded-md shadow-lg top-12 ring-1 ring-black ring-opacity-5 dark:bg-dark"
                        role="menu" aria-orientation="vertical" aria-label="User menu">
                        <a href="/user/profile" role="menuitem"
                            class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-primary">
                            Profil
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  role="menuitem"
                            class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-primary">
                            Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
        </nav>
    
    
    </div>
</header>
