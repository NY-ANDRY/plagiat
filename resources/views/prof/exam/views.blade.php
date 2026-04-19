<x-layout.prof>
    <div class="flex-1 flex">
        <div class="b-r flex flex-col w-2xl h-full">
            <div class="flex items-center justify-between">
                <div class="b-b w-full h-full flex items-center justify-between">
                    <div class="box h-full capitalize text-2xl font-semibold">your exams</div>
                </div>
            </div>
            @foreach ($exams as $exam)
                <x-exam.exam-card :exam="$exam" :href="route('prof.exam', $exam->id)" />
            @endforeach
        </div>
        <div class="b-r flex-1 flex flex-col h-full">
            <div class="flex items-center justify-between">
                <div class="b-b w-full h-full flex items-center justify-between">
                    <div class="box h-full capitalize text-2xl font-semibold">create exams</div>
                </div>
            </div>
            <div class="box flex flex-col">
                create
            </div>
        </div>
    </div>
</x-layout.prof>