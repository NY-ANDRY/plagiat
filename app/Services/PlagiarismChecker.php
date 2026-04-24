<?php

namespace App\Services;

use App\Interface\IPlagiarismResults;
use App\Interface\IProjects;

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

    public function compare(IProjects $projects): IPlagiarismResults
    {
        $result = $this->clean($projects);
        $algo = $projects->getAlgo();

        switch (strtoupper($algo->name)) {
            case 'WINNOWING':
                $result = $this->winnowingService->process($projects);
                break;

            case 'JACCARD':
                $result = $this->jaccardService->process($projects);
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
