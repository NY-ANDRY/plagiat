<x-layout.prof>
    <div class="flex-1 flex max-h-full">

        <div class="b-r flex flex-col w-lg h-full overflow-hidden overflow-y-auto">

            <div class="flex items-center justify-between">
                <div class="b-b w-full h-full flex items-center justify-between">
                    <div class="box h-full capitalize text-2xl font-semibold">submissions</div>
                </div>
            </div>

            <div class="flex flex-col">

                @foreach ($submissions as $submission)
                    <x-submission.submission-card :submission="$submission" :stop="true" />
                @endforeach

            </div>

        </div>

        <div class="b-r flex-1 flex flex-col h-full max-h-full overflow-hidden overflow-y-auto">
            <x-plagiarism.view :idExam="$exam->id" :idAlgo="$idAlgo" />
        </div>

    </div>
</x-layout.prof>