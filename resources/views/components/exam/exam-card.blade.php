<a href="{{ $href }}" class="box b-b flex flex-col gap-6 w-full activable">
    <div class="flex flex-col gap-2">

        <div class="flex items-center justify-between">
            <div class="font-medium text-lg">{{ $exam->title }}</div>

            @php
                $status = $exam->statuses->first();
            @endphp

            @if ($status)
                <div class="flex items-center gap-2">
                    <span aria-label="status" class="status status-{{ strtolower($status->style) }} animate-bounce">
                    </span>
                    <span class="lowercase">
                        {{ $status->label }}
                    </span>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            @foreach ($exam->fileExtensions as $ext)
                <div class="flex items-center gap-2 text-neutral-600 text-xs border border-neutral-300 px-2 py-1">
                    <img src="{{ $ext->iconUrl() }}" class="w-4" alt="">
                    <span>{{ $ext->name }}</span>
                </div>
            @endforeach
        </div>

    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ $exam->creator->imageUrl() }}" class="w-8 mask mask-decagon" alt="">
            <div class="flex items-center gap-2">
                <span class="text-neutral-400 text-sm">
                    Created by:
                </span>
                <span class="text-sm">
                    {{ $exam->creator->name }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-neutral-400 text-sm">
                close date:
            </span>
            <span class="text-sm">
                {{ $exam->close_date->format('d-m-Y') }}
            </span>
        </div>
    </div>
</a>