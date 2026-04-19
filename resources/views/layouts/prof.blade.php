<x-layout.app>

    <x-layout.sidebar :nav="$nav" />

    <div class="flex flex-col flex-1">
        <x-layout.header />

        <main class="flex-1 flex flex-col">
            {{ $slot }}
        </main>
    </div>

</x-layout.app>