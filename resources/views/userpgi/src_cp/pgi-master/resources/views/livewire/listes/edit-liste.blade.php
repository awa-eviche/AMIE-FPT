<div class="bg-white shadow rounded-sm w-full p-4">
    <h2 class="font-bold text-maquette-gris text-xl">
        Edition
    </h2>
    <div class="w-full mx-auto">
        <form class="bg-white shadow-md rounded pt-6 pb-8 mb-4" action="{{ route('etablissement.update', $etablissement->id) }}" method="POST">
            <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm">

                <div class="max-w-7xl sm:px-2 lg:px-4 shadow-xl">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Edition de la liste
                    </h3>
                    <div class="border border-gray-200 p-4">
                        @csrf
                        @method('PUT')
                        

                
                    </div>

                

                    <button type="submit" class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>
                </div>
            </div>





        </form>

    </div>
</div>
