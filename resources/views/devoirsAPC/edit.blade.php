<!DOCTYPE html>
<html>
<head>
    <title>Modifier les notes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier les notes : {{ $libelle }}</h1>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('devoirAPC.update', $devoirs->first()->id) }}">
            @csrf
            @method('PUT')
            
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3 text-left">Apprenant</th>
                        <th class="border p-3 text-left">Note actuelle</th>
                        <th class="border p-3 text-left">Nouvelle note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devoirs as $devoir)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">
                            {{ $devoir->inscription->apprenant->prenom ?? '' }}
                            {{ $devoir->inscription->apprenant->nom ?? '' }}
                        </td>
                        <td class="border p-3 text-center">
                            {{ $devoir->note ?? 'Non noté' }}/20
                        </td>
                        <td class="border p-3 text-center">
                            <input type="number"
                                   name="notes[{{ $devoir->id }}]"
                                   value="{{ $devoir->note ?? '' }}"
                                   step="0.01" min="0" max="20"
                                   class="border rounded px-3 py-2 w-32"
                                   placeholder="0.00">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="window.close()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Mettre à jour
                </button>
            </div>
        </form>
        
        <div class="mt-8 border-t pt-4">
            <p class="text-sm text-gray-600">
                Après modification, fermez cette fenêtre et rafraîchissez la liste des devoirs.
            </p>
        </div>
    </div>
    
    <script>
        // Fermer la fenêtre après soumission si réussie
        @if(session('success'))
            setTimeout(() => {
                if (window.opener) {
                    window.opener.location.reload();
                }
                window.close();
            }, 1500);
        @endif
    </script>
</body>
</html>