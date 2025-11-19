<div>
    
    <div class="w-full mr-4 border bg-gray-100 border-1 shadow p-2 rounded bg-light">
        <div class="flex w-1/5 items-center p-2 my-2 bg-white rounded-md dark:bg-darker">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                  </svg>
                  
              </div>
              <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Apprenants
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    <span class="siffre" style="color:rgba(227, 142, 24, 1);">{{ $count}}</span>&thinsp;&thinsp; &thinsp; &thinsp; <span class="prctg" style="font-size: 10px;">
      
                  </p>           
              </div>
            
        </div>
        <div class="w-1/6 flex items-center">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white">Tous</p>
        </div>
        <div class="flex justify-between items-center bg-gray-100">
            
            <div class="flex items-baseline my-2 w-full">
                {{-- <label for="selectedRegion" class="sr-only">Région</label>
                <select id="selectedRegion" wire:model="selectedRegion" wire:change="$refresh" name="selectedRegion"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Région</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id ??'' }}">{{ $region->libelle ?? ''}}</option> 
                    @endforeach
                </select> --}}

            </div>
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedCommune" class="sr-only">Départemant</label>
                <select id="selectedDepartemant" wire:model="selectedDepartemant" wire:change="$refresh" name="selectedDepartemant"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir un Départemant</option>
                    @if ($departements)
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id}}">{{ $departement->libelle ?? ''}}</option> 
                    @endforeach
                    @else
                    <option value="">Aucun département trouvé</option>
                    @endif
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedCommune" class="sr-only">Commune</label>
                <select id="selectedCommune" wire:model="selectedCommune" wire:change="$refresh" name="selectedCommune"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Commune</option>
                    @if ($communes)
                    @foreach ($communes as $commune)
                    <option value="{{ $commune->id }}">{{ $commune->libelle  }}</option> 
                    @endforeach
                    @else
                    <option value="">Aucune commune trouvée</option>
                    @endif
                </select>

            </div>
            
            
        </div>
        <div class="flex justify-between items-center bg-gray-100">
            
            
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedNiveau" class="sr-only">Niveaux</label>
                <select id="selectedNiveau" wire:model="selectedNiveau" wire:change="$refresh" name="selectedNiveau"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Niveaux</option>
                    @if ($niveaux)
                    @foreach ($niveaux as $niveau)
                    <option value="{{ $niveau->id }}">{{ $niveau->nom  }}</option> 
                    @endforeach
                    @else
                    <option value="">Aucun niveau trouvé</option>
                    @endif
                </select>

            </div>

            {{-- <div class="flex items-baseline">
                <label for="selectedClasse" class="sr-only">Classe</label>
                <select id="selectedClasse" wire:model="selectedClasse" wire:change="$refresh" name="selectedClasse"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Classe</option>
                    @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->libelle  }}</option> 
                    @endforeach
                </select>

            </div> --}}
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedFiliere" class="sr-only">Filiere</label>
                <select id="selectedFiliere" wire:model="selectedFiliere" wire:change="$refresh" name="selectedFiliere"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une filiere</option>
                    @if ($filieres)
                    @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->nom  }}</option> 
                    @endforeach
                    @else
                    <option value="">Aucune filière trouvée</option>
                    @endif
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                {{-- <label for="indicateur" class="block text-gray-700 text-sm font-bold mb-2"></label> --}}
                <select wire:model="selectedsexe" name="selectedsexe" wire:change="$refresh"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                <option >Filtrer par sexe</option>
                <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
        </div>
        
        <div class="p-2 w-full bg-white">
            <table class="w-full mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                        {{-- <th class="px-4 py-3">N° </th> --}}
                        <th class="px-1 text-gray-800">Identifiant</th>
                        <th class="px-1 text-gray-800">Nom et Prénoms</th>
                        <th class="px-1 text-gray-800">Commune</th>
                        <th class="px-1 text-gray-800">Etablissment</th>
                        <th class="px-1 text-gray-800">Niveau</th>
                        <th class="px-1 text-gray-800">Sexe</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                    @if ($apprenants)
                    @foreach ($apprenants as $apprenant)
                    <tr class="text-gray-700 ">
                        
                             <td class="p-2 border-b text-gray-500 ">
                                {{ $apprenant->matricule ?? ' - ' }}
                            </td>
                               <td class="p-2 border-b text-gray-500 ">
                                {{ $apprenant->nom ?? ' - ' }} {{ $apprenant->prenom?? ' - ' }}
                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                {{ $apprenant->commune->libelle ?? ' - ' }}
                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                
                                {{ $apprenant->etablissementSigle ?? ' - ' }}
                            </td>
                            
                            <td class="p-2 border-b text-gray-500 ">
                                {{ $apprenant->niveauName ?? ' - ' }}
                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                {{ $apprenant->sexe ?? ' - ' }}
                            </td>
                            {{-- <td class="p-2 border-b text-gray-500 text-center">
                                <a href="{{route('inscription.show',$apprenant->id)}}" class="text-greeen-600"><i class="fa fa-eye"></i></a>
                            </td> --}}
                        
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">Aucun apprenant trouvé</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
    </div>
    @if ($apprenants)
        {{ $apprenants->links() }}
    @endif
</div>
