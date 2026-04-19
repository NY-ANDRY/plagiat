<x-layout.app>

    <x-layout.sidebar :nav="$nav" />

    <div class="flex flex-col flex-1 max-h-full overflow-hidden">
        <x-layout.header />

        <main class="flex-1 flex flex-col overflow-hidden overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

</x-layout.app>