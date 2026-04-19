<x-student-layout>
    <div class="flex flex-col h-full">
        <div class="b-b flex items-center w-full gap-2">
            <a href="{{ url()->previous() }}" class="box b-r flex activable">
                <x-lucide-arrow-left class="text-black w-6" />
            </a>
            <div class="box b-r flex items-center h-full text-base text-neutral-800 font-light">
                @if($submission)
                    {{ $submission->file_filename . "." . $submission->file_extension }}
                @endif
            </div>
            @if (request()->query('file'))
                <div class="box b-r flex items-center h-full text-base text-neutral-800 font-light tracking-wide">
                    {{ request()->query('file') }}
                </div>
            @endif
        </div>
        <div class="flex w-full h-full">
            <div class="explorer w-64 b-r overflow-y-auto overflow-x-hidden">
                <x-student.zip-explorer :structure="$structure" />
            </div>
            <div class="editor flex-1 overflow-auto">
                <x-monaco.editor :code="$code" :language="$language" :mediaType="$mediaType" :mediaData="$mediaData" />
            </div>
        </div>
    </div>
</x-student-layout>