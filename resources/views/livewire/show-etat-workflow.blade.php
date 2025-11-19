<div class="flex flex-wrap bg-white rounded">

    <livewire:detail-etat :etatWorkflow="$etatWorkflow"/>
    <div class="w-full md:w-1/2 p-4">
        <livewire:manage-profil-access :etatWorkflow="$etatWorkflow"/>

        <livewire:manage-type-notification :etatWorkflow="$etatWorkflow"/>


    </div>


</div>
