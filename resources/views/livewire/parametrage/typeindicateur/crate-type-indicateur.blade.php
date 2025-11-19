<div>
    <form class="bg-white pt-6 pb-8 mb-4" action="{{ route('typeIndicateur.store') }}" method="POST">
        @csrf
        <div class="md:container md:mx-auto">
        <div class="w-full sm:px-2 lg:px-4 ">

            <div class="border border-gray-200">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Creation d'un nouveau type de survey
                        
                    </h3>
            <div class="p-5">
            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                <div class="mb-4">
                    <label for="code"
                        class="block text-gray-700 text-sm font-bold mb-2">code</label>
                    <input value="{{ old('code') ?? '' }}" type="text"
                        class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                        id="code" name="code">
                    @error('code')
                        {{ $message }}
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="libelle"
                        class="block text-gray-700 text-sm font-bold mb-2">Libellé</label>
                    <input value="{{ old('libelle') ?? '' }}" type="text"
                        class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                        id="libelle" name="libelle">
                    @error('libelle')
                        {{ $message }}
                    @enderror
                </div>
            </div>

        
        <div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold" for="description">
                    Description
                </label>
                <textarea class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="description" name="description" required cols="30" rows="5"></textarea>
                
            </div>
                @error('adresse')
                    {{ $message }}
                @enderror
        </div>
                       

                        

                    </div>

                </div>

            </div>
            <div class="w-full sm:px-2 lg:px-4 py-4">
                
                <button type="submit"
                class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

            </div>
           </div>
    </form>


</div>
