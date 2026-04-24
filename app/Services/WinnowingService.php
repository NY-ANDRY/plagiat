<?php

namespace App\Services;

use App\Interface\IPlagiarismResults;
use App\Interface\IProject;
use App\Interface\IProjects;
use App\Models\PlagiarismAlgoProp;

class WinnowingService
{
    private FingerprintService $fingerprintService;

    public function __construct()
    {
        $this->fingerprintService = new FingerprintService();
    }

    public function process(IProjects $projects): IPlagiarismResults
    {
        $this->addFingerprints($projects);
        $result = $this->compareAll($projects);

        return $result;
    }

    public function addFingerprints(IProjects $projects): void
    {
        $props = $projects->getAlgoProps();
        $k = $this->getProps($props, 'k');
        $w = $this->getProps($props, 'w');

        foreach ($projects->getProjects() as $project) {
            $this->addFingerprint($project, $k, $w);
        }
    }

    public function addFingerprint(IProject $project, $k, $w): void
    {
        $rawContent = $project->getRawContent();

        $fingerprint = $this->fingerprintService->separate($rawContent, $k);
        $fingerprint = $this->fingerprintService->hash($fingerprint);
        $fingerprint = $this->fingerprintService->reduce($fingerprint, $w);

        $project->setFingerprint($fingerprint);
    }

    public function compareAll(IProjects $projects): IPlagiarismResults
    {
        $result = $projects->getResultType();
        $prjs = $projects->getProjects();
        $count = \count($prjs);

        $results = [];
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $res = $result->getResultType();
                $res->setProject1($prjs[$i]);
                $res->setProject2($prjs[$j]);

                $similarity = $this->compare($prjs[$i], $prjs[$j]);
                $res->setSimilarity($similarity);

                $results[] = $res;
            }
        }
        $result->setResults($results);
        $average = 0;
        foreach ($results as $res) {
            $average += $res->getSimilarity();
        }

        $count = \count($results);

        if ($count > 0) {
            $average /= $count;
        } else {
            $average = 0;
        }

        $result->setSimilarity($average);

        return $result;
    }

    public function compare(IProject $p1, IProject $p2): float
    {
        $fg1 = $p1->getFingerprint();
        $fg2 = $p2->getFingerprint();


        $fg1 = array_unique(array_map(fn($f) => $f->hash_value, $fg1));
        $fg2 = array_unique(array_map(fn($f) => $f->hash_value, $fg2));

        sort($fg1);
        sort($fg2);

        $c1 = \count($fg1);
        $c2 = \count($fg2);

        $p1 = 0;
        $p2 = 0;

        $intersection = 0;
        $union = 0;

        while ($p1 < $c1 && $p2 < $c2) {
            if ($fg1[$p1] == $fg2[$p2]) {
                $intersection++;
                $p1++;
                $p2++;
            } elseif ($fg1[$p1] < $fg2[$p2]) {
                $p1++;
            } else {
                $p2++;
            }
            $union++;
        }

        $union += $c1 - $p1;
        $union += $c2 - $p2;

        if ($union <= 0) {
            return 0;
        }

        return $intersection / $union;
    }

    /**
     * @param PlagiarismAlgoProp[] $props
     */
    public function getProps(array $props, $name): string
    {
        $result = '';

        foreach ($props as $prop) {
            if ($prop->algoProp->name == $name) {
                return $prop->value;
            }
        }

        return $result;
    }
}
