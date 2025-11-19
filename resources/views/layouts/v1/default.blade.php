<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.v1.partials._head')
</head>
<body class="font-sans antialiased">
    <div class="relative h-screen overflow-hidden bg-[#E6E6E6] rounded-2xl">
        <div  x-data="{ isOpen: true }" class="flex items-start justify-between">
        {{-- sidebar --}}
                <div  x-show="isOpen"
                {{-- class="md:block md:relative md:w-80 h-screen shadow-lg z-50 hidden fixed" --}}
                class="md:block md:relative md:w-80 h-screen shadow-lg z-50 fixed"
                id="md_sidebar"
                >
                    @include('layouts.navigation')
                </div>

            {{-- page content --}}
            <div class="flex flex-col w-full pl-0 md:space-y-4">
            @include('layouts.v1.partials._header')
                <div class="h-screen pt-6 pb-24 pl-6 pr-6 overflow-auto md:pt-6 md:pr-6 md:pl-6">
                    @include('layouts.v1.partials._alert')
                    @yield('content')
                </div>

            </div>
        </div>
    </div>
    </div>
    @include('layouts.v1.partials._script')
    @stack('myJS')
</body>

</html>
