<?php

namespace App\Services;

use App\Interface\IPlagiarismResults;
use App\Interface\IProjects;

class JaccardService
{
    private FingerprintService $fingerprintService;

    public function __construct()
    {
        $this->fingerprintService = new FingerprintService();
    }

    public function process(IProjects $projects): IPlagiarismResults
    {
        $props = $projects->getAlgoProps();

        return $projects->getResultType();
    }
}
