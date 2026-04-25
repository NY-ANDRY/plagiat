<div class="flex-1 flex flex-col">
    <div class="b-b flex items-center justify-between">
        <div class="flex font-light">

            <div class="box-sm b-r flex ">
                {{ $plagiarism->algo->name }}
            </div>
            @foreach ($plagiarism->algoProps as $props)

                <div class="box-sm b-r flex items-center gap-2">
                    <span>{{ $props->algoProp->name }}</span>
                    <span>-></span>
                    <span>{{ $props->value }}</span>
                </div>

            @endforeach
        </div>

        <div class="flex box-sm font-thin text-sm">{{ $plagiarism->results()->count() }}</div>
    </div>

    <div class="flex flex-col">

        @foreach ($results as $result)

            <div class="b-b flex items-center text-sm relative">
                <div class="box b-r pl-10! flex w-78 items-center justify-baseline gap-10 font-medium">
                    <img src="{{ $result->submission1->student->imageUrl() }}" class="w-8 h-8 mask mask-decagon" alt="">
                    <div class="flex-1 max-w-full line-clamp-1">
                        {{ $result->submission1->student->name }}
                    </div>
                </div>
                <div class="box b-r flex w-24 items-center justify-center h-full font-black text-xs relative top-px">
                    <x-lucide-scale class="w-6 text-neutral-400" />
                </div>

                <div class="box b-r pl-10! flex w-78 items-center justify-baseline gap-10 font-medium">
                    <img src="{{ $result->submission2->student->imageUrl() }}" class="w-8 h-8 mask mask-decagon" alt="">
                    <div class="flex-1 max-w-full line-clamp-1">
                        {{ $result->submission2->student->name }}
                    </div>
                </div>

                <div class="box b-r flex w-48 items-center justify-center h-full">
                    {{ $result->rate * 100 . "%" }}
                </div>

                <a href="{{ route('submission.plagiarism', $result) }}" class="box activable h-full flex-1 flex items-center justify-center">
                    <x-lucide-scan-eye class="w-6 text-neutral-400" />
                </a>
            </div>

        @endforeach

    </div>
</div>