{{-- Années de l'apprenant : une fois réinscrit, il a une inscription par année et son compte
     pointe sur la plus récente. Chaque année ouvre la page de notes de sa classe (PPO ou APC). --}}
@php
    $inscriptionsApprenant = \App\Models\Inscription::with('classe', 'anneeAcademique')
        ->where('apprenant_id', $inscription->apprenant_id)
        ->get()
        ->sortByDesc(fn ($i) => $i->anneeAcademique->code ?? '')
        ->values();
@endphp

@if($inscriptionsApprenant->count() > 1)
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <span class="text-sm font-semibold text-gray-600 mr-1">Année :</span>
        @foreach($inscriptionsApprenant as $insc)
            <a href="{{ route(($insc->classe->modalite ?? '') === 'APC' ? 'mes.notes.apc' : 'mes.notes', $insc->id) }}"
               class="px-4 py-2 rounded-full text-xs font-semibold transition"
               style="{{ $insc->id === $inscription->id ? 'background-color: #236F46; color: white;' : 'background-color: #e5e7eb; color: #374151;' }}">
                {{ $insc->anneeAcademique->code ?? '-' }} · {{ $insc->classe->libelle ?? '-' }}
            </a>
        @endforeach
    </div>
@endif
