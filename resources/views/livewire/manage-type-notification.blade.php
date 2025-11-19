<div class="bg-white mt-3 container mx-auto p-4">
    <h3 class="font-bold mb-4">Type de Notification:</h3>


    <div class="flex justify-end mb-3">
        <button wire:click = "setTypeNotification" class="bg-first-orange py-0.5 text-sm hover:bg-cyan-700 px-3 text-white font-bold rounded">
            {{$isModifying ? "valider" : "Changer type notification" }}
        </button>
    </div>


    @if ($isModifying)
        <div class="mt-3 p-4 rounded">
            <label class="block text-white font-bold mb-2">Type de Notification:</label>
            @foreach($allTypeNotifications as $typeNotification)
                <label class="block mb-2">
                    <input title="{{$typeNotification->message}}" type="radio" name="type_notification_id" value="{{ $typeNotification->id }}" class="mr-2" wire:model="type_notification_id" @if($etatWorkflow->typeNotification && $etatWorkflow->typeNotification->id == $typeNotification->id) checked @endif>
                    {{ $typeNotification->action }}
                </label>
            @endforeach
        </div>


    @else
        @if($etatWorkflow->typeNotification)

            <div class="p-4 rounded mb-4">
                <p class="text-md font-bold mb-2 text-first-orange">{{ $etatWorkflow->typeNotification->action }}</p>
                <p class="ml-6 text-gray-500">{{ $etatWorkflow->typeNotification->message }}</p>
            </div>
            <hr>

            <div class="p-4 rounded-sm">
                <p class="font-bold text-first-orange">Profils à Notifiés:</p>

                    @if ($etatWorkflow->typeNotification->roles->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-3 py-3 bg-gray-50">
                                            N°
                                        </th>

                                        <th scope="col" class="px-3 py-3">
                                            Code
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-gray-50">
                                            nom
                                        </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etatWorkflow->typeNotification->roles as $profil)

                                        <tr class="border-b border-gray-200 ">

                                            <td class="px-3 py-2 font-medium whitespace-nowrap bg-gray-50 ">
                                                {{ $profil->name }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $profil->code }}
                                            </td>

                                            <td class="px-3 py-2">
                                                <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                                    <a href="{{route("profil.show", $profil->id)}}" class="text-gray-500">
                                                        <svg width="15" height="13" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <p class="text-sm text-gray-500 px-3">
                            Aucun profil à notifier pour ce type de notification pour l'instant
                        </p>
                    @endif
            </div>
        @else
            <p class="text-center">Aucun Type de Notification associé.</p>
        @endif

    @endif


</div>
