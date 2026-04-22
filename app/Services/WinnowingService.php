<?php

namespace App\Services;

use App\Interface\IPlagiarismResults;
use App\Interface\IProjects;

class WinnowingService
{
    private FingerprintService $fingerprintService;

    public function __construct()
    {
        $this->fingerprintService = new FingerprintService();
    }

    public function compare(IProjects $projects, array $algoProps): IPlagiarismResults
    {
        return $projects->getResultType();
    }
}
