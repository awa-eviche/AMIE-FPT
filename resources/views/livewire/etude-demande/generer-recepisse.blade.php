<div>
    @if ($isGeneratedRecepisse)
        <button class="bg-first-orange text-white rounded py-2 px-4 mr-5 font-bold">
            <p>Signer le document</p>
        </button>
    @else
        <button class="bg-first-orange text-white rounded py-2 px-4 mr-5 font-bold">
            <p wire:click="genererRecepisser">generer recepisse de dépôt</p>
        </button>
    @endif
</div>
