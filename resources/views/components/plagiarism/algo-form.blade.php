<div class="b-r w-60 flex flex-col">
    <div class="box b-b capitalize text-sm font-light">algorithmes</div>
    @foreach ($algos as $algo)
        <a href="{{ request()->fullUrlWithQuery(['algo' => $algo->id]) }}" class="box b-b activable flex flex-col gap-4">
            <div class="flex capitalize text-sm font-medium">
                {{ $algo->name }}
            </div>
            <div class="flex text-sm font-thin">
                {{ $algo->about }}
            </div>
        </a>
    @endforeach
</div>

<div class="box flex flex-col flex-1">
    @if (!$curAlgo)
        <div class="flex-1 flex flex-col items-center justify-center gap-2">
            <x-lucide-brush-cleaning class="text-neutral-300 w-48" />
            <div class="flex text-2xl font-semibold text-neutral-400 capitalize">
                nothing to see
            </div>
        </div>
    @else
        <div class="flex flex-col gap-2">
            <div class="flex flex-col gap-2">
                <div class="flex capitalize text-md font-medium">
                    {{ $curAlgo->name }}
                </div>
                <div class="flex text-sm font-thin">
                    {{ $curAlgo->about }}
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex capitalize text-md font-medium">
                    Props
                </div>
                <form action="{{ route('plagiarism.compare') }}" class="flex flex-col gap-6 py-2 text-sm" method="POST">
                    @csrf
                    <input name="exam-id" type="hidden" value="{{ $idExam }}">
                    <input name="algo-id" type="hidden" value="{{ $curAlgo->id }}">

                    @foreach ($curAlgo->props as $prop)
                        <div class="flex">
                            <div class="flex flex-col w-48">
                                <div class="flex capitalize text-sm font-medium">
                                    {{ $prop->name }}
                                </div>
                                <div class="flex text-xs font-light text-neutral-500">
                                    {{ $prop->about }}
                                </div>
                            </div>
                            <div class="flex w-72">
                                <input name="props-{{ $prop->id }}" type="text" value="{{ $prop->default_value }}">
                            </div>
                        </div>
                    @endforeach
                    <div class="flex w-48">
                        <button type="submit" class="btn btn-primary">Compare</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>