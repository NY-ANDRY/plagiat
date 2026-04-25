
@if ($mediaType)
    <div class="flex items-center justify-center w-full h-full bg-neutral-50 p-6">
        @if (str_starts_with($mediaType, 'image/'))
            <img src="{{ $mediaData }}" alt="{{ request()->query('file') }}" class="max-w-full max-h-full object-contain rounded shadow" />
        @elseif (str_starts_with($mediaType, 'video/'))
            <video controls class="max-w-full max-h-full rounded shadow">
                <source src="{{ $mediaData }}" type="{{ $mediaType }}">
                Votre navigateur ne supporte pas la lecture vidéo.
            </video>
        @elseif (str_starts_with($mediaType, 'audio/'))
            <audio controls class="w-full max-w-md">
                <source src="{{ $mediaData }}" type="{{ $mediaType }}">
                Votre navigateur ne supporte pas la lecture audio.
            </audio>
        @elseif ($mediaType === 'application/pdf')
            <iframe src="{{ $mediaData }}" class="w-full h-full" frameborder="0"></iframe>
        @endif
    </div>
@else
    @vite('resources/js/editor.js')

    <div id="editor" class="w-full h-full"></div>

    <script>
        window.editorConfig = {
            value: @json($code),
            language: @json($language)
        };
        document.addEventListener('DOMContentLoaded', () => {
            window.initEditor();
        });
    </script>
@endif