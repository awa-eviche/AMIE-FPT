<div class="max-w-10xl mx-auto mt-5">
    <div class="flex justify-end">
        <input type="text" wire:model="searchFile" wire:keydown="$refresh" placeholder="Rechercher" class="form-input text-sm px-4 py-3 w-max rounded-md shadow-sm border-white">
        <span href="#" class=" mx-3 bg-transparent border-transparent px-4 rounded-md py-2 flex text-black text-sm text-center  bg-white items-center">
            <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"></path>
            </svg>
        </span>
    </div>

    <div class="py-10">
        <div class="w-full overflow-hidden rounded-lg shadow-xs p-0">
            <div class="text-sm w-full p-0">
                <table class="w-full">
                    <thead>
                  <tr class="text-xs font-bold font-black tracking-wide text-left text-maquette-gris uppercase border-b bg-first-orange ">
                        <th class="px-4 py-4 font-bold">Nom</th>
                        <th class="px-4 py-4 font-bold">Date de créarion</th>
                        <th class="px-4 py-4 font-bold text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                       
                        @forelse ($files as $file)
                            <tr class="bg-white">
                                <td class="px-4 py-4 font-bold">{{$file->libelle}}</td>
                                <td class="px-4 py-4 font-bold">{{date('d/m/Y',strtotime($file->created_at))}}</td>
                                <td class="px-4 py-4 font-bold flex justify-evenly items-center">
                                    
                                    <a href="{{ route('show.category', $file->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                                            <g id="Vector">
                                            <path d="M1.70996 7.43745C1.70996 7.43745 4.51542 1.43689 9.42496 1.43689C14.3345 1.43689 17.14 7.43745 17.14 7.43745C17.14 7.43745 14.3345 13.438 9.42496 13.438C4.51542 13.438 1.70996 7.43745 1.70996 7.43745Z" stroke="#1B212D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9.42496 9.15189C10.3718 9.15189 11.1394 8.38431 11.1394 7.43745C11.1394 6.49059 10.3718 5.723 9.42496 5.723C8.4781 5.723 7.71052 6.49059 7.71052 7.43745C7.71052 8.38431 8.4781 9.15189 9.42496 9.15189Z" stroke="#1B212D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="21" viewBox="0 0 16 21" fill="none">
                                            <path id="Vector" d="M5.09868 0.23645C4.37895 0.23645 3.76665 0.73733 3.53973 1.43645H1.79266C0.879723 1.43645 0.139648 2.24233 0.139648 3.23645V17.6365C0.139648 18.6305 0.879723 19.4365 1.79266 19.4365H4.55096C4.55899 19.2995 4.57862 19.1606 4.6108 19.0203L4.79077 18.2365H1.79266C1.48835 18.2365 1.24166 17.9678 1.24166 17.6365V3.23645C1.24166 2.90508 1.48835 2.63645 1.79266 2.63645H3.53973C3.76665 3.33557 4.37895 3.83645 5.09868 3.83645H8.4047C9.12442 3.83645 9.7367 3.33557 9.9636 2.63645H11.7107C12.015 2.63645 12.2617 2.90508 12.2617 3.23645V8.91447C12.6137 8.75022 12.9875 8.65875 13.3637 8.64005V3.23645C13.3637 2.24233 12.6236 1.43645 11.7107 1.43645H9.9636C9.7367 0.73733 9.12442 0.23645 8.4047 0.23645H5.09868ZM4.54768 2.03645C4.54768 1.70508 4.79437 1.43645 5.09868 1.43645H8.4047C8.70897 1.43645 8.9557 1.70508 8.9557 2.03645C8.9557 2.36782 8.70897 2.63645 8.4047 2.63645H5.09868C4.79437 2.63645 4.54768 2.36782 4.54768 2.03645ZM6.72937 16.2891L12.0515 10.4938C12.8563 9.61734 14.1613 9.61734 14.9661 10.4938C15.7708 11.3702 15.7708 12.7911 14.9661 13.6676L9.64402 19.4629C9.33369 19.8008 8.94491 20.0404 8.5192 20.1563L6.8685 20.6057C6.15061 20.8011 5.50037 20.0931 5.67985 19.3114L6.09251 17.5139C6.19895 17.0504 6.41908 16.627 6.72937 16.2891Z" fill="#212121"/>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                            <path id="Vector" d="M6.74134 3.22991H9.82734C9.82734 2.37774 9.13653 1.68691 8.28434 1.68691C7.43214 1.68691 6.74134 2.37774 6.74134 3.22991ZM5.58409 3.22991C5.58409 1.7386 6.79303 0.529663 8.28434 0.529663C9.77565 0.529663 10.9846 1.7386 10.9846 3.22991H15.4207C15.7403 3.22991 15.9993 3.48898 15.9993 3.80854C15.9993 4.1281 15.7403 4.38716 15.4207 4.38716H14.403L13.4988 13.731C13.3553 15.2139 12.109 16.3454 10.6191 16.3454H5.94954C4.45966 16.3454 3.21338 15.2139 3.06987 13.731L2.16563 4.38716H1.14796C0.828398 4.38716 0.569336 4.1281 0.569336 3.80854C0.569336 3.48898 0.828398 3.22991 1.14796 3.22991H5.58409ZM7.12709 6.89454C7.12709 6.57498 6.86802 6.31591 6.54846 6.31591C6.2289 6.31591 5.96984 6.57498 5.96984 6.89454V12.6808C5.96984 13.0003 6.2289 13.2594 6.54846 13.2594C6.86802 13.2594 7.12709 13.0003 7.12709 12.6808V6.89454ZM10.0202 6.31591C10.3398 6.31591 10.5988 6.57498 10.5988 6.89454V12.6808C10.5988 13.0003 10.3398 13.2594 10.0202 13.2594C9.70066 13.2594 9.44159 13.0003 9.44159 12.6808V6.89454C9.44159 6.57498 9.70066 6.31591 10.0202 6.31591ZM4.22174 13.6195C4.30785 14.5092 5.05561 15.1882 5.94954 15.1882H10.6191C11.5131 15.1882 12.2608 14.5092 12.3469 13.6195L13.2404 4.38716H3.32828L4.22174 13.6195Z" fill="#EE1414"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                           
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 font-bold text-lg text-center">Aucune donnée disponible</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $files->links() }}
                
            </div>
        </div>
    </div>

</div>
