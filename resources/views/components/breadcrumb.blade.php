@props(['items' => []])

<nav class="mb-1 text-sm text-gray-500" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
        <li><a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a></li>
        @foreach ($items as $label => $url)
            <li>/</li>
            @if ($url)
                <li><a href="{{ $url }}" class="hover:text-gray-700">{{ $label }}</a></li>
            @else
                <li class="font-medium text-gray-700">{{ $label }}</li>
            @endif
        @endforeach
    </ol>
</nav>