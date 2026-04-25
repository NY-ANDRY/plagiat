<x-layout.app>
    <div class="flex flex-col flex-1 max-h-screen overflow-hidden">
        <x-layout.header />
        <main class="flex-1 flex flex-col overflow-hidden">
            <div class="flex flex-col h-full">
                <div class="b-b flex items-center w-full gap-2">
                    <a href="{{ $backUrl }}" class="box b-r flex activable">
                        <x-lucide-arrow-left class="text-black w-6" />
                    </a>
                    <div class="flex-1 flex items-center justify-between">

                        @if (request()->query('file'))
                            <div
                                class="box b-r flex items-center h-full text-base text-neutral-800 font-light tracking-wide">
                                {{ request()->query('file') }}
                            </div>
                        @endif

                        <div
                            class="box flex-1 flex items-center justify-center gap-10 h-full text-base text-neutral-800 font-light relative">
                            <span>
                                {{ $submission1->student->name }}
                            </span>
                            <span class="font-bold text-xl relative bottom-px">
                                {{ $pr->rate * 100 }}%
                            </span>
                            <span>
                                {{ $submission2->student->name }}
                            </span>
                        </div>

                        @if (request()->query('file2'))
                            <div
                                class="box b-l flex items-center h-full text-base text-neutral-800 font-light tracking-wide">
                                {{ request()->query('file2') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex w-full h-full">
                    <div class="explorer w-64 b-r overflow-y-auto overflow-x-hidden">
                        <x-editor.explorer :structure="$structure1" />
                    </div>
                    <div class="editor flex-1 overflow-auto">
                        <x-editor.editor-double :code1="$code1" :language1="$language1" :mediaType1="$mediaType1"
                            :mediaData1="$mediaData1" :code2="$code2" :language2="$language2" :mediaType2="$mediaType2"
                            :mediaData2="$mediaData2" />
                    </div>
                    <div class="explorer w-64 b-l overflow-y-auto overflow-x-hidden">
                        <x-editor.explorer :structure="$structure2" :secondary="true" />
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout.app>