<x-layout.prof>
    <div class="flex-1 flex">
        <div class="b-r flex flex-col w-lg h-full">
            <div class="flex items-center justify-between">
                <div class="b-b w-full h-full flex items-center justify-between">
                    <div class="box h-full capitalize text-2xl font-semibold">submissions</div>
                </div>
            </div>
            @foreach ($submissions as $submission)
                <x-submission.submission-card :submission="$submission"  :stop="true"/>
            @endforeach
        </div>
        <div class="b-r flex-1 flex flex-col h-full">
            
        </div>
    </div>
</x-layout.prof>