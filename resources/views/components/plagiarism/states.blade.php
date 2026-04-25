@if($plagiarism->currentStatus()->name === 'pending')

    <div class="flex-1 flex items-center justify-center gap-2">
        <span class="loading loading-bars loading-xl"></span>
    </div>

@elseif($plagiarism->currentStatus()->name === 'processing')

    <div class="flex-1 flex items-center justify-center gap-2">
        <span class="loading loading-bars loading-xl"></span>
    </div>

@elseif($plagiarism->currentStatus()->name === 'done')

    <x-plagiarism.details :idPlagiarism="$idPlagiarism" />

@else
    <div class="flex-1 flex items-center justify-center gap-2">
        something went wrong
    </div>
@endif