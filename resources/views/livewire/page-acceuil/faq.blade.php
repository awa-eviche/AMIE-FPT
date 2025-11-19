<div>
    <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
        <p>
            <a href="/dashboard" class="text-maquette-gris">Accueil</a>
            <span class="mx-2 text-maquette-gris">/</span>
        </p>
        <p><a href="{{route('liste.index')}}">Page d'acceuil</a>

            <span class="mx-2 text-maquette-gris">/</span>
        </p>
        <p class="text-first-orange">FAQs</p>
        <p></p>
    </div>


    <div class="flex mb-5 justify-between">
        <div class="flex">
            <span href="#"
                  class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor"
                     viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                          clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher"
                   class="form-input text-sm px-4 py-3 w-max shadow-sm border-white">
        </div>
        <div class="flex">
            <a href="{{route('faqs.create')}}"
               class="px-3 rounded-md py-3 flex text-white text-sm text-center bg-first-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector"
                              d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z"
                              fill="white"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                <span class="mx-2">Ajouter une question</span>
            </a>
        </div>
    </div>


    <div class="w-full rounded-lg shadow-xs p-0">

        <div class="text-sm w-full p-0 overflow-x-auto">
            <table class="w-full border-t mb-3">
                <thead>
                <tr
                    class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                    {{-- <th class="px-4 py-3">N° </th> --}}
                    <th class="px-4 py-4 text-white">Question</th>
                    <th class="px-4 py-4 text-white">Ordre</th>
                    <th class="px-4 py-4 text-white">Status</th>
                    <th class="px-4 py-4 text-white text-end">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                @forelse ($faqs as $question)
                    <tr class="text-gray-700 ">
                        <td class="px-4 py-3 border-b">{{ $question->question ?? ' - ' }}</td>
                        <td class="px-4 py-3 border-b">{{ $question->priority ?? ' - ' }}</td>
                        <td class="px-4 py-3 border-b">
                                <span
                                    class="py-2 px-4 {{ $question->status == 'active' ? 'bg-green-100 text-green' : 'bg-red-100 text-red' }} rounded">
                                    {{ $question->status == 'active' ? 'Activé' : 'Désactivé' }}
                                </span>
                        </td>
                        <td class="px-4 py-3 border-b flex justify-end">
                            <a href="{{ route('faqs.edit', $question->id) }}"
                               class="flex items-center px-1 rounded-md py-1 border flex text-green-600
                               text-sm text-center bg-white border-green-600 hover:bg-green-600 hover:text-white
                               mx-2">
                                <i class="fa fa-edit"></i>
                            </a>

                            {!! Form::open(array(
                                                'method' => 'DELETE',
                                                'class' => 'delete-form',
                                                'style' => 'display: inline;',
                                                'route' => array('faqs.destroy', $question->id))) !!}
                            {{ csrf_field() }}
                            <a href="#delete" data-toggle="tooltip"
                               title="Supprimer cette question"
                               class="apix-delete flex items-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white">
                                <i class="fa fa-trash"></i>
                            </a>
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 font-bold text-lg text-center">Aucune donnée disponible</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @if($count > 10)
                <div class="flex justify-start items-center mt-5">
                    <button {{$startLimit == 0 ? 'disabled' : '' }} wire:click="prev" type="button"
                            class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14"
                             viewBox="0 0 11 14" fill="none">
                            <path id="Polygon 1"
                                  d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z"
                                  fill="black"/>
                        </svg>
                    </button>
                    <span class="text-md text-black mx-3">{{min($count,$startLimit+1)}} à {{ min($startLimit+10,$count) }} sur {{$count}}</span>
                    <button wire:click="next" {{($startLimit+10) >= $count ? 'disabled' : '' }} type="button"
                            class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                        <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path id="Polygon 1"
                                  d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z"
                                  fill="black"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>

</div>
