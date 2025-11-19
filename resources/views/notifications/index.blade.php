<x-app-layout>
    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-5 ml-5">
            <h1 class="text-2xl font-bold">Nouvelles notifications</h1>
        </div>
        <div>
            {{-- show only unread notification or all notification --}}
            <p>
                @if ($onlyUnread)
                    <a href="{{ route('notifications.all') }}" class="px-4 py-2 bg-first-orange text-white rounded-md">
                        Toutes les notifications
                    </a>

                @else
                <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-first-orange text-white rounded-md">
                    Uniquement les non lues
                </a>
                @endif
            </p>
        </div>
    </div>
    <div id="content" class="bg-white rounded pb-10">
        <!-- Course content -->

        <div class="inbox-wrapper full">
            <div class="filter-wrapper">
                {{-- <div class="filters flex items-center justify-between">
                    <p class="pull-right">
                        <button href="{{ url('/lms/index.php?r=inbox/inbox/axMarkUnmarkAsRead&amp;all=1') }}" class="px-4 py-2 bg-first-orange text-white rounded-md">
                Marquer tous comme lues
                </button>
                </p>
                <label for="onlyUnread" class="flex items-center">
                    <input type="checkbox" value="1" name="onlyUnread" id="onlyUnread">
                    <span class="ml-2">Afficher uniquement les notifications non lues</span>
                </label>
            </div>
            --}}
        </div>

        <br>

        {{-- <div class="items-wrapper"></div> --}}

        <p>
            <span class="no-more hidden">Plus de notifications à charger</span>
        </p>


        @if(count($notifications) > 0)
        @foreach ($notifications as $notification)
            @php
                // Assuming $n->data is already an array
                $data_decoded = json_decode($notification->data['data'], true);
            @endphp
            <livewire:one-notification :notification="$notification" :data_decoded="$data_decoded" :key="$notification->id" />
        @endforeach
        <div class="my-5 mb-5 flex justify-center">
            {{ $notifications->links() }}
        </div>
        @else
        <p class="text-first-orange mt-2 ml-5 text-xl">
          Aucune nouvelle notification
        </p>
        @endif
    </div>


</x-app-layout>
