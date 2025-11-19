<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste Entreprise') }}
        </h2>
    </x-slot>

    <div class="container bg-white rounded">
        <!-- You could replace the parent container with your own container -->
        <div class="flex">
            <div class="py-2" x-data="{open: false}" @click="open = !open" x-transition.duration.500ms>
                <div class="space-x-1 cursor-pointer text-sm font-medium">
                    <div>Logan Nathan</div>
                    {{-- <div class="rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" x-show="open" x-cloak> --}}
                    <div x-show="open" x-cloak class="bg-red-500">
                        <div class="py-1">
                            <a href="/logout" class="text-gray-700 block px-4 py-2 text-sm">Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p>teste</p>
    </div>

    <div class="mr-8 mt-8 bg-white" style="width : 300px;" x-data="{open:false}">



        <p type="button" class="element_sidebar element_sidebar_acitf relative" @click="open = !open">
            <span class="text-left">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </span>
            <span class="mx-4 text-sm font-bold">
                <span>Paramètre</span>
            </span>
            <i
                x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }"
                class="fa-solid absolute right-0 mr-3"
            ></i>

        </p>

        <div class="shadow-inner relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
            <div class="p-3">
                element 1
            </div>
        </div>



    </div>

</x-app-layout>
