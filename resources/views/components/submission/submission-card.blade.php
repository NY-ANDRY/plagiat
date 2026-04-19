<div class="box flex gap-4 b-b">
    <div class="b-f flex flex-col items-center w-20 gap-3 px-2 py-4">
        <x-lucide-file-archive class="w-6" />
        <div class="flex text-sm text-neutral-600 max-w-full">
            <p class=" whitespace-normal wrap-break-word max-w-full line-clamp-3">
                {{ $submission->file_filename . "." . $submission->file_extension }}
            </p>
        </div>
    </div>

    <div class="flex flex-col justify-between min-h-full overflow-hidden flex-1 py-2 gap-4">
        <div class="flex items-center justify-between">
            <span class="text-lg font-semibold tracking-wide">
                {{$submission->exam->title}}
            </span>
            <div class="flex items-center gap-2 text-neutral-300 text-sm">
                <span>by:</span>
                <span class=" text-neutral-600">
                    {{ $submission->exam->creator->name }}
                </span>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-neutral-300 text-sm">
                {{$submission->created_at->format('H:i')}}
            </span>
            <span class="text-neutral-300 text-sm">
                {{$submission->created_at->format('d-m-Y')}}
            </span>
        </div>
    </div>

</div>