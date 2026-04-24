<?php

namespace App\Services;

use App\Models\Plagiarism;

class PlagiarismChecker
{
    private CleaningService $cleaningService;

    private WinnowingService $winnowingService;

    private JaccardService $jaccardService;

    public function __construct()
    {
        $this->cleaningService = new CleaningService;
        $this->winnowingService = new WinnowingService;
        $this->jaccardService = new JaccardService;
    }

    public function compare(Plagiarism $plagiarism): Plagiarism
    {
        $this->clean($plagiarism);
        $algo = $plagiarism->algo;

        switch (strtoupper($algo->name)) {
            case 'WINNOWING':
                $plagiarism = $this->winnowingService->process($plagiarism);
                break;

            case 'JACCARD':
                $plagiarism = $this->jaccardService->process($plagiarism);
                break;

            default:
                throw new \Exception('Unknown algorithm');
        }

        return $plagiarism;
    }

    public function clean(Plagiarism $plagiarism): void
    {
        $exam = $plagiarism->exam;
        $extensions = $exam->fileExtensions;
        $restrictions = $exam->fileRestrictions;

        foreach ($exam->submissions as $submission) {
            $rawData = $this->cleaningService->cleanProject($submission, $extensions->all(), $restrictions->all());
            $submission->setRawContent($rawData);
        }
    }
}
