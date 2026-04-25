@if ($mediaType1 || $mediaType2)
    <div class="flex w-full h-full overflow-hidden">
        {{-- First Column --}}
        <div class="flex-1 b-r overflow-auto flex flex-col">
            @if ($mediaType1)
                <div class="flex-1 flex items-center justify-center p-6 bg-white">
                    @if (str_starts_with($mediaType1, 'image/'))
                        <img src="{{ $mediaData1 }}" alt="Preview 1" class="max-w-full max-h-full object-contain rounded shadow" />
                    @elseif (str_starts_with($mediaType1, 'video/'))
                        <video controls class="max-w-full max-h-full rounded shadow">
                            <source src="{{ $mediaData1 }}" type="{{ $mediaType1 }}">
                        </video>
                    @elseif (str_starts_with($mediaType1, 'audio/'))
                        <audio controls class="w-full max-w-md">
                            <source src="{{ $mediaData1 }}" type="{{ $mediaType1 }}">
                        </audio>
                    @elseif ($mediaType1 === 'application/pdf')
                        <iframe src="{{ $mediaData1 }}" class="w-full h-full" frameborder="0"></iframe>
                    @endif
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-neutral-300 italic">
                    No media content or file not found
                </div>
            @endif
        </div>

        {{-- Second Column --}}
        <div class="flex-1 overflow-auto flex flex-col">
            @if ($mediaType2)
                <div class="flex-1 flex items-center justify-center p-6 bg-white">
                    @if (str_starts_with($mediaType2, 'image/'))
                        <img src="{{ $mediaData2 }}" alt="Preview 2" class="max-w-full max-h-full object-contain rounded shadow" />
                    @elseif (str_starts_with($mediaType2, 'video/'))
                        <video controls class="max-w-full max-h-full rounded shadow">
                            <source src="{{ $mediaData2 }}" type="{{ $mediaType2 }}">
                        </video>
                    @elseif (str_starts_with($mediaType2, 'audio/'))
                        <audio controls class="w-full max-w-md">
                            <source src="{{ $mediaData2 }}" type="{{ $mediaType2 }}">
                        </audio>
                    @elseif ($mediaType2 === 'application/pdf')
                        <iframe src="{{ $mediaData2 }}" class="w-full h-full" frameborder="0"></iframe>
                    @endif
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-neutral-300 italic">
                    No media content or file not found
                </div>
            @endif
        </div>
    </div>
@else
    @vite('resources/js/editor-double.js')

    <div class="flex w-full h-full overflow-hidden">
        <div class="flex-1 h-full b-r flex flex-col">
            <div id="editor_1" class="flex-1 w-full"></div>
        </div>
        <div class="flex-1 h-full flex flex-col">
            <div id="editor_2" class="flex-1 w-full"></div>
        </div>
    </div>

    <script>
        window.editorConfig = {
            value_1: @json($code1),
            language_1: @json($language1),
            value_2: @json($code2),
            language_2: @json($language2),
        };
        document.addEventListener('DOMContentLoaded', () => {
            if (window.initEditor) {
                window.initEditor();
            }
        });
    </script>
@endif