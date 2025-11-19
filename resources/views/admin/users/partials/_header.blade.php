@php
    $activeBtn = 'text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2  focus:outline-none';
    $normalBtn = 'text-second-blue bg-gray-200 hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2  focus:outline-none';
    $btnTous = empty($selectedRole) ? $activeBtn : $normalBtn;



@endphp
<div>
    <div class="text-gray-900">
        <div class="flex">
            <div class="w-10/12">
                <form method="GET" action="{{ route('users.index') }}">
                <div class="grid grid-cols-7">
                                <div class="col-span-6"> <!-- First Column (80%) -->
                                <div class="relative w-full">
                                    <input type="search" id="search-dropdown" name="query" value="{{ request()->input('query') }}" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " placeholder="Saisissez une valeur de recherche">
                                    <a href="{{ route('users.index') }}" id="clear-button" class="hidden">
                                    <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4  hover:text-gray-900 " viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M17.293 5.293a1 1 0 0 0-1.414 0L10 10.586 4.707 5.293a1 1 0 0 0-1.414 1.414L8.586 12l-5.293 5.293a1 1 0 1 0 1.414 1.414L10 13.414l5.293 5.293a1 1 0 0 0 1.414-1.414L11.414 12l5.293-5.293a1 1 0 0 0 0-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    </button>
                                    </a>
                                    </div>
                                 </div>
                                 <div class="col-span-1"> <!-- Second Column (20%) -->
                                 <button type="submit" class="top-0 right-0 p-2.5 text-sm font-medium text-white bg-first-orange rounded-r-lg border border-first-orange hover:bg-first-orange focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                                        <span><i class="fa-solid fa-search pr-2"></i>Rechercher</span>
                                    </button>
                                </div>
                            </div>
                </form>
            </div>
            <div class="w-2/12">
                <div style="margin-left: 10px;">
                    <a href="{{ route('users.create') }}">
                        <button class="text-first-orange  ring-first-orange ring-2 bg-gray-100 hover:bg-first-orange  hover:text-white focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-3 mb-2">
                            <i class="fas fa-plus mr-1"></i> Nouvel utilisateur
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="relative">
    <div class="inset-y-4 pt-2 left-0">
        <a href="{{ route('users.index') }}">
            <button type="button" class="{{ empty($selectedRole) ? $activeBtn : $normalBtn }}">
                Tous ({{ $roleStats['total'] }})
            </button>
        </a>

        @foreach($roleStats['items'] as $key => $item)
            <a href="{{ route('users.index', ['role' => $key]) }}">
                <button type="button" class="{{ $selectedRole === $key ? $activeBtn : $normalBtn }}">
                    {{ $item['nom'] }} ({{ $item['nb'] }})
                </button>
            </a>
        @endforeach
    </div>
</div>

    </div>
</div>
