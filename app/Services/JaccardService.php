<?php

namespace App\Services;

use App\Models\Plagiarism;

class JaccardService
{
    private FingerprintService $fingerprintService;

    public function __construct()
    {
        $this->fingerprintService = new FingerprintService;
    }

    public function process(Plagiarism $plagiarism): Plagiarism
    {
        // To be implemented
        return $plagiarism;
    }
}
