<div class="flex flex-col h-full max-h-full">
    <div class="b-b w-full h-fit flex items-center justify-between">
        <div class="box h-full capitalize text-2xl font-semibold">Plagiarism</div>
    </div>
    <div class="flex-1 flex">

        @if (!$plagiarism)
            <x-plagiarism.algo-form :idAlgo="$idAlgo" :idExam="$idExam" />
        @else
            <x-plagiarism.states :idPlagiarism="$plagiarism->id" />
        @endif

    </div>
</div>