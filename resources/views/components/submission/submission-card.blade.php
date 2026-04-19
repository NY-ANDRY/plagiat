<div class="box flex gap-4 b-b">

    <a href="{{ route('student.exam.view', $submission->exam->id) }}"
        class="b-f flex flex-col items-center w-20 gap-4 px-2 py-4 activable">
        <x-lucide-file-archive class="w-6" />
        <div class="flex text-sm text-neutral-600 max-w-full">
            <p class="text-center leading-tight whitespace-normal wrap-break-word max-w-full line-clamp-3">
                {{ $submission->file_filename . "." . $submission->file_extension }}
            </p>
        </div>
    </a>

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
                @if (!$stop)
                    <span>-</span> {{$submission->created_at->format('d-m-Y')}}
                @endif
            </span>
            <span class="text-neutral-300 text-sm">
                @if ($stop)
                    {{$submission->created_at->format('d-m-Y')}}
                @else
                    <a href="{{ route('student.exam', $submission->exam->id) }}">
                        <button>view</button>
                    </a>
                @endif
            </span>
        </div>
    </div>

</div>