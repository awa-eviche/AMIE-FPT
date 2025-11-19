<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la question') }}
        </h2>
    </x-slot>

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="{{ route('faqs.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                questions</a>
        </div>
        <div class="w-full mx-auto">
            <form class="bg-white pt-6 pb-8 mb-4" action="{{ route('faqs.update',$faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="/dashboard" class="text-maquette-gris">Accueil</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p><a href="{{route('faqs.index')}}">FAQs</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Modifier</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Formulaire de modification
                            </h3>
                            <div class="p-5">
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="valeur"
                                               class="block text-gray-700 text-sm font-bold mb-2">Question<span
                                                class="text-red-600 mx-2">*</span></label>
                                        <input type="text" value="{{ $faq->question ?? old('question') ?? '' }}"
                                               required
                                               class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                               id="question" name="question">
                                        </select>
                                        @error('cle')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="valeur"
                                               class="block text-gray-700 text-sm font-bold mb-2">Réponse</label>
                                        <textarea
                                            class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                            name="reponse" id="reponse" cols="10"
                                            rows="5">{{$faq->reponse ?? old('reponse') ?? '' }}</textarea>
                                        @error('valeur')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="valeur"
                                               class="block text-gray-700 text-sm font-bold mb-2">Priorité</label>
                                        <input type="number" value="{{$faq->priority ?? old('priority') ?? '' }}"
                                               class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                               id="priority" name="priority">
                                        @error('valeur')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>


                            </div>

                        </div>
                        <button type="submit"
                                class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">
                            Enregistrer
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
