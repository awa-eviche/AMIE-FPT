<div
    x-data="{ open: false }"
    class="relative"
>
    @if ($notification->read_at == null)
        <x-dropdown align="right">
            <x-slot name="trigger">
                <p class="flex justify-end mx-3 mt-1">
                    <span class="w-min py-1 px-2 bg-gray-100 rounded">
                        <svg width="15" height="10" viewBox="0 0 18 4" fill="none"
                            >
                            <g id="Iconly/Light-Outline/More-Circle">
                                <g id="More-Circle">
                                    <g id="Combined-Shape">
                                        <path
                                            d="M17.5 2C17.5 1.06211 16.7419 0.303986 15.804 0.303986H15.787C14.8508 0.303986 14.0995 1.06211 14.0995 2C14.0995 2.9379 14.8661 3.69602 15.804 3.69602C16.7419 3.69602 17.5 2.9379 17.5 2Z"
                                            fill="#f37930" />
                                        <path
                                            d="M10.6995 2C10.6995 1.06211 9.94138 0.303986 9.00348 0.303986H8.98822C8.05032 0.303986 7.30068 1.06211 7.30068 2C7.30068 2.9379 8.06559 3.69602 9.00348 3.69602C9.94138 3.69602 10.6995 2.9379 10.6995 2Z"
                                            fill="#f37930" />
                                        <path
                                            d="M3.90051 2C3.90051 1.06211 3.14239 0.303986 2.2045 0.303986H2.18923C1.25134 0.303986 0.5 1.06211 0.5 2C0.5 2.9379 1.2666 3.69602 2.2045 3.69602C3.14239 3.69602 3.90051 2.9379 3.90051 2Z"
                                            fill="#f37930" />
                                    </g>
                                </g>
                            </g>
                        </svg>

                    </span>
                </p>
            </x-slot>

            <x-slot name="content">
                <div class="cursor-pointer border shadow-xl p-2 py-3">
                    <p class="flex items-center" wire:click="marquerCommeLue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3" fill ="#f37930" height="12" width="12" viewBox="0 0 512 512">
                            <path d="M160 96a96 96 0 1 1 192 0A96 96 0 1 1 160 96zm80 152V512l-48.4-24.2c-20.9-10.4-43.5-17-66.8-19.3l-96-9.6C12.5 457.2 0 443.5 0 427V224c0-17.7 14.3-32 32-32H62.3c63.6 0 125.6 19.6 177.7 56zm32 264V248c52.1-36.4 114.1-56 177.7-56H480c17.7 0 32 14.3 32 32V427c0 16.4-12.5 30.2-28.8 31.8l-96 9.6c-23.2 2.3-45.9 8.9-66.8 19.3L272 512z"/>
                        </svg>
                        <span class="text-xs">Marquer comme lu</span>

                    </p>
                </div>

            </x-slot>
        </x-dropdown>
    @endif

    <div
        x-data="{ linkHover: false }"
        class="flex items-center justify-between py-2 px-3 hover:bg-gray-100 bg-opacity-20"
        @mouseover="linkHover = true"
        @mouseleave="linkHover = false"
        @click="open = !open"
    >
        <div class="w-full flex justify-between items-center">
            <div class="flex items-center ">
                <div class="h-2 w-4 rounded-full {{ $notification->read_at == null? 'bg-first-orange' :'bg-gray-500'}}"></div>
                <div class="text-sm ml-3 h-10 overflow-hidden" :class="{ 'h-auto': open }">
                    <p class="text-first-orange font-black capitalize " :class=" linkHover ? 'text-primary' : ''">
                        {{ $data_decoded['topic'] }}

                    </p>
                    <p class="text-xs font-black text-gray-500 " >
                        {{ $data_decoded['message'] }}
                    </p>

                    <p class="flex justify-end mt-3">
                        <a class="bg-first-orange rounded py-1 px-2 text-bold text-xs text-white hover:bg-blue-900"
                        @if ($consultable)

                            href="{{ route($objects->route, $objects->entity->id) }}"
                            @else
                                href="#"
                            @endif
                        >consulter</a>

                    </p>
                </div>

            </div>
            <div class="ml-2 w-40 text-end">

                <span class="text-xs font-bold {{ $notification->read_at == null ? 'text-first-orange' : 'text-gray-500' }}">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

    </div>
    <hr>
</div>
