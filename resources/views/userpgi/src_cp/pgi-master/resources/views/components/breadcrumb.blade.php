<nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->last)
                <li class="text-first-orange">
                   {{ $breadcrumb['name'] }}
                </li>
              
            @else
                <li class="text-gray-500">
                <a href="{{ $breadcrumb['url'] }}" class="text-gray-500">{{ $breadcrumb['name'] }}</a>
                </li>
                <li>
                   <span><i class="font-bold">/</i></span>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
