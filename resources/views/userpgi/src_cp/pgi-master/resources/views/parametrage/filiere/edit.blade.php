<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification de la  filiere') }}
        </h2>
    </x-slot>
    {{--le bouton pour le retour en arrière  --}}

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route('filiere.index')}}"  class="text-maquette">Accueil</a>
              <span class="mx-2 text-maquette">/</span>
            <a href="{{route('filiere.index')}}"  class="text-maquette">Référentiel</a>
              <span class="mx-2 text-maquette">/</span>
        <p> <a href="{{route('filiere.index')}}" >Filiere  </a>
            
            <span class="mx-2 text-maquette">/</span>
        </p>

        <p class="text-first-orange">Modification de la Filiere</p>
        </p>
      
    </div>

    {{--  --}}
    <div class="rounded-sm w-full p-4 mt-2">

        <div class="rounded-sm w-full">
            <div class="w-full mx-auto max-w-6xl">
                <form action="{{ route('filiere.update', $filiere->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Modification de la Filiére 
                    </h3>
                    <div class="border border-gray-200 p-4">
                    @method('PUT')
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="code">
                                Code <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="code" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="code" value="{{ $filiere->code }}" required autofocus autocomplete="nom" />
                            @error('code')
                                <span class="text-xs text-red-500">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="nom">
                                Nom <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="nom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nom" value="{{ $filiere->nom }}" required autofocus autocomplete="nom" />
                            @error('code')
                                <span class="text-xs text-red-500">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                    </div>


                    <div class="form-group">
 <label for="secteur_id">Sélectionner un secteur :</label>
    <select class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow" id="secteur_id" name="secteur_id">
        <option value="">Choisir un secteur</option>
        @foreach($secteur as $secteurs)
            <option value="{{ $secteurs->id }}">{{ $secteurs->libelle }}</option>
        @endforeach
    </select>
</div>
                    
                    
                    
                    <div class="mb-4 mx-auto w-full">
                        <label class="enlever_shadow block text-gray-700 text-sm font-bold " for="description">
                            Description
                        </label>
                        <textarea value="{{ $filiere->description }}" class="enlever_shadow shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-first-orange" id="description" name="description" required rows="4" placeholder="Description">{{$filiere->description}}</textarea>
                        @error('description')
                            <span class="text-xs text-red-500">
                                {{$message}}
                            </span>
                        @enderror
                    </div>


                    <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="flex items-center bg-first-orange text-white rounded-md px-5 py-1 hover:bg-cyan-700">
                        <span class="mr-2">Enregistrer</span>
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.6979 6.55208L12.4479 0.302083C12.3519 0.208384 12.2387 0.134107 12.1146 0.0833333C11.9854 0.030851 11.8477 0.00260216 11.7083 0H3.375C2.5462 0 1.75134 0.32924 1.16529 0.915291C0.57924 1.50134 0.25 2.2962 0.25 3.125V15.625C0.25 16.4538 0.57924 17.2487 1.16529 17.8347C1.75134 18.4208 2.5462 18.75 3.375 18.75H15.875C16.7038 18.75 17.4987 18.4208 18.0847 17.8347C18.6708 17.2487 19 16.4538 19 15.625V7.29167C19.0008 7.15458 18.9745 7.01868 18.9227 6.89176C18.8708 6.76485 18.7945 6.64942 18.6979 6.55208ZM6.5 2.08333H10.6667V4.16667H6.5V2.08333ZM12.75 16.6667H6.5V13.5417C6.5 13.2654 6.60975 13.0004 6.8051 12.8051C7.00045 12.6097 7.2654 12.5 7.54167 12.5H11.7083C11.9846 12.5 12.2496 12.6097 12.4449 12.8051C12.6403 13.0004 12.75 13.2654 12.75 13.5417V16.6667ZM16.9167 15.625C16.9167 15.9013 16.8069 16.1662 16.6116 16.3616C16.4162 16.5569 16.1513 16.6667 15.875 16.6667H14.8333V13.5417C14.8333 12.7129 14.5041 11.918 13.918 11.332C13.332 10.7459 12.5371 10.4167 11.7083 10.4167H7.54167C6.71286 10.4167 5.91801 10.7459 5.33196 11.332C4.74591 11.918 4.41667 12.7129 4.41667 13.5417V16.6667H3.375C3.09873 16.6667 2.83378 16.5569 2.63843 16.3616C2.44308 16.1662 2.33333 15.9013 2.33333 15.625V3.125C2.33333 2.84873 2.44308 2.58378 2.63843 2.38843C2.83378 2.19308 3.09873 2.08333 3.375 2.08333H4.41667V5.20833C4.41667 5.4846 4.52641 5.74955 4.72176 5.9449C4.91711 6.14025 5.18207 6.25 5.45833 6.25H11.7083C11.9846 6.25 12.2496 6.14025 12.4449 5.9449C12.6403 5.74955 12.75 5.4846 12.75 5.20833V3.55208L16.9167 7.71875V15.625Z" fill="white"/>
                        </svg>
                    </button>
                    </div>
                </form>
            

            </div>
        </div>

    </div>



</x-app-layout>
