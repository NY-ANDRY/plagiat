<x-student-layout>
    <div class="flex justify-between min-h-full gap-0">
        <div class="flex flex-col flex-1">
            <div class="box flex flex-col gap-2 b-b">

                <h2>{{ $exam->title }}</h2>

                <div class="flex gap-2">
                    @foreach ($exam->fileExtensions as $ext)
                        <div class="flex items-center gap-2 text-neutral-600 text-xs border border-neutral-300 px-2 py-1">
                            <img src="{{ $ext->iconUrl() }}" class="w-4" alt="">
                            <span>{{ $ext->name }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex w-2xl text-neutral-700 text-sm my-4">
                    {{ $exam->about }}
                </div>

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
            </div>

            <div class="box b-b flex flex-col gap-4 w-full">
                <h3>Participate</h3>
                <form action="{{ route('exam.submission', $exam->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Pick a file</legend>

                        <div class="flex gap-4">
                            <input type="file" name="file" class="file-input" />
                            <button>submit</button>
                        </div>

                        <label class="label">Max size 100MB</label>
                    </fieldset>
                </form>
            </div>
        </div>

        <div class="b-l flex flex-col w-2xl">
            <div class="box b-b flex">
                <h3>participants</h3>
            </div>
            <div class="box flex flex-col gap-5">
                @foreach ($exam->submissions as $submission)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $submission->student->imageUrl() }}" class="w-8 mask mask-decagon" alt="">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-neutral-800">
                                    {{ $submission->student->name }}
                                </span>
                            </div>
                        </div>
                        <div class="flex text-sm text-neutral-500">
                            {{ $submission->created_at->format('H:i d-m-Y') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-student-layout>