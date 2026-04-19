@php
    $requestedFile = request()->query('file');
@endphp

<ul @if($isRoot) class="menu w-full" @endif>
    @foreach($structure as $name => $item)
        @if(is_array($item))
            @php
                $folderPath = $currentPath === '' ? $name : $currentPath . '/' . $name;
                $isOpen = $requestedFile && str_starts_with($requestedFile, $folderPath . '/');
            @endphp
            <li>
                <details {{ $isOpen ? 'open' : '' }}>
                    <summary>
                        <x-lucide-folder class="w-4 h-4 mr-1 inline-block" />
                        <span class="truncate">{{ $name }}</span>
                    </summary>
                    <x-editor.explorer :structure="$item" :isRoot="false" :currentPath="$folderPath" />
                </details>
            </li>
        @else
            <li>
                <a href="{{ request()->fullUrlWithQuery(['file' => $item]) }}"
                    class="{{ request()->query('file') === $item ? 'bg-base-200 font-bold active' : '' }}">
                    <x-lucide-file class="w-4 h-4 mr-1 inline-block" />
                    <span class="truncate" title="{{ $name }}">{{ $name }}</span>
                </a>
            </li>
        @endif
    @endforeach
</ul>