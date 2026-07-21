<?php

namespace App\Services;

use App\Models\Plagiarism;

class PlagiarismChecker
{
    private CleaningService $cleaningService;

    private AbstractPlagiarismComparator $plagiarismComparator;

    public function __construct()
    {
        $this->cleaningService = new CleaningService;
    }

    public function check(Plagiarism $plagiarism): Plagiarism
    {
        $this->clean($plagiarism);

        $this->setComparator($plagiarism);

        if ($this->plagiarismComparator != null) {
            $this->plagiarismComparator->process($plagiarism);
        } else {
            throw new \Exception('Comparator must be set');
        }

        return $plagiarism;
    }

    private function setComparator(Plagiarism $plagiarism): void
    {
        $algo = $plagiarism->algo;

        switch (strtoupper($algo->name)) {
            case 'WINNOWING':
                $this->plagiarismComparator = new WinnowingService;
                break;

            case 'JACCARD':
                $this->plagiarismComparator = new JaccardService;
                break;

            default:
                throw new \Exception('Unknown algorithm');
        }
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
