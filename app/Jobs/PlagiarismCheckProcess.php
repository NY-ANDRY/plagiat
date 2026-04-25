<?php

namespace App\Jobs;

use App\Models\Plagiarism;
use App\Models\PlagiarismStatut;
use App\Services\PlagiarismChecker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PlagiarismCheckProcess implements ShouldQueue
{
    use Queueable;

    private $idPlagiarism;
    private $plagiarism;

    /**
     * Create a new job instance.
     */
    public function __construct($idPlagiarism)
    {
        $this->idPlagiarism = $idPlagiarism;
        $this->plagiarism = Plagiarism::find($this->idPlagiarism);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $processingStatus = PlagiarismStatut::where('name', 'processing')->firstOrCreate(['name' => 'processing']);
        $this->plagiarism->statuses()->syncWithoutDetaching([$processingStatus->id]);

        $checker = new PlagiarismChecker();
        $checker->check($this->plagiarism);

        $doneStatus = PlagiarismStatut::where('name', 'done')->firstOrCreate(['name' => 'done']);
        $this->plagiarism->statuses()->syncWithoutDetaching([$doneStatus->id]);
    }

    public function failed(\Throwable $exception): void
    {
        $failedStatus = PlagiarismStatut::where('name', 'failed')->firstOrCreate(['name' => 'failed']);
        $this->plagiarism->statuses()->syncWithoutDetaching([$failedStatus->id]);
    }
}
