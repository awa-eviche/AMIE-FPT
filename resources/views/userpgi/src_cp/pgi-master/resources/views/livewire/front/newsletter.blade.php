<div>
    <div class="flex">
        <input type="email" wire:model="email" wire:keydown="$refresh"  placeholder="Inscrivez vous ici" class="form-input white-placeholder font-bold text-white text-sm px-4 py-3 w-1/2 shadow-md bg-transparent no-border-r border-white rounded-lg rounded-r-none">
        <span class="px-2 py-3 w-max shadow-md bg-transparent border-r border-t border-b border-white rounded-lg rounded-l-none	">
            <button wire:click="save" {{$correct ? '' : 'disabled'}}>
                <span href="#" class="border-transparent px-2 py-2 flex text-black text-sm text-center rounded-full  {{$correct ? 'bg-orange-600' : 'bg-slate-100'}} items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 30 24" fill="none">
                        <path d="M6.53418 12H23.8321" stroke="{{$correct ? 'white' : 'black'}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15.1836 5L23.8326 12L15.1836 19" stroke="{{$correct ? 'white' : 'black'}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </button>
        </span>
    </div>

    <small class="{{$correct ? 'text-emerald-500' : 'text-white'}} font-bold">{{$message}}</small>
</div>
