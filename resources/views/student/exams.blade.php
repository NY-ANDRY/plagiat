<x-student-layout>
    <div class="flex min-h-full">
        <div class="flex flex-col ss-v">
            <h2 class="box b-b">exams</h2>
            @foreach ($exams as $exam)
                <a href="{{ route('student.exam', $exam->id) }}" class="box b-b  flex flex-col gap-6 w-200 activable">
                    <div class="flex flex-col gap-2">

                        <div class="flex items-center justify-between">
                            <div class="font-medium text-lg">{{ $exam->title }}</div>
                            <div class="flex items-center gap-2">
                                <div class="flex text-neutral-500 text-sm">
                                    <div class="flex items-center gap-2">
                                        <div aria-label="status"
                                            class="status status-{{ strtolower($exam->statuses->first()->style) }} animate-bounce">
                                        </div>
                                        <span class="lowercase">
                                            {{$exam->statuses->first()->label}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            @foreach ($exam->fileExtensions as $ext)
                                <div
                                    class="flex items-center gap-2 text-neutral-600 text-xs border border-neutral-300 px-2 py-1">
                                    <img src="{{ $ext->iconUrl() }}" class="w-4" alt="">
                                    <span>{{ $ext->name }}</span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ $exam->creator->imageUrl() }}" class="w-8 mask mask-circle" alt="">
                            <div class="flex items-center gap-2">
                                <span class="text-neutral-400 text-sm">
                                    Created by:
                                </span>
                                <span class="text-sm">
                                    {{ $exam->creator->name }}
                                </span>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex items-center gap-2">
                                <span class="text-neutral-400 text-sm">
                                    close date:
                                </span>
                                <span class="text-sm">
                                    {{ $exam->close_date->format('d-m-Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($exams->isEmpty())
            <p>Aucun examen disponible.</p>
        @endif
        <div class="box b-l min-h-full">
aa
        </div>
    </div>
</x-student-layout>