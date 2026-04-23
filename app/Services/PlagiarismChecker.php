<?php

namespace App\Services;

use App\Interface\IPlagiarismResult;
use App\Interface\IPlagiarismResults;
use App\Interface\IProject;
use App\Interface\IProjects;
use App\Models\Algo;
use App\Models\FileExtension;
use App\Models\FileRestriction;
use File;

class PlagiarismChecker
{
    private CleaningService $cleaningService;
    private WinnowingService $winnowingService;
    private JaccardService $jaccardService;

    public function __construct()
    {
        $this->cleaningService = new CleaningService();
        $this->winnowingService = new WinnowingService();
        $this->jaccardService = new JaccardService();
    }

    public function compare(IProjects $projects, string $algo, array $algoProps): IPlagiarismResults
    {
        $result = $this->clean($projects);

        switch (strtoupper($algo)) {
            case 'WINNOWING':
                $result = $this->winnowingService->compare($projects, $algoProps);
                break;

            case 'JACCARD':
                $result = $this->jaccardService->compare($projects, $algoProps);
                break;

            default:
                throw new \Exception('Unknown algorithm');
        }

        return $result;
    }

    public function clean(IProjects $projects): IProjects
    {
        foreach ($projects->getProjects() as $project) {
            $rawData = $this->cleaningService->cleanProject($project, $projects->getExtensions(), $projects->getRestrictions());
            $project->setRawContent($rawData);
        }
        return $projects;
    }

}
