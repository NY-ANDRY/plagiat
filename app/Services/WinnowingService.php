<?php

namespace App\Services;

use App\Models\Plagiarism;
use App\Models\PlagiarismAlgoProp;
use App\Models\Submission;

class WinnowingService
{
    private FingerprintService $fingerprintService;

    public function __construct()
    {
        $this->fingerprintService = new FingerprintService;
    }

    public function process(Plagiarism $plagiarism): Plagiarism
    {
        $this->addFingerprints($plagiarism);
        $result = $this->compareAll($plagiarism);

        return $result;
    }

    public function addFingerprints(Plagiarism $plagiarism): void
    {
        $props = $plagiarism->algoProps->all();
        $k = (int) $this->getProps($props, 'k');
        $w = (int) $this->getProps($props, 'w');

        foreach ($plagiarism->exam->submissions as $submission) {
            $this->addFingerprint($submission, $k, $w);
        }
    }

    public function addFingerprint(Submission $submission, int $k, int $w): void
    {
        $rawContent = $submission->getRawContent();

        $fingerprint = $this->fingerprintService->separate($rawContent, $k);
        $fingerprint = $this->fingerprintService->hash($fingerprint);
        $fingerprint = $this->fingerprintService->reduce($fingerprint, $w);

        $submission->setFingerprintsList($fingerprint);
    }

    public function compareAll(Plagiarism $plagiarism): Plagiarism
    {
        $submissions = $plagiarism->exam->submissions;
        $count = $submissions->count();

        $totalSimilarity = 0;
        $comparisonCount = 0;

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $s1 = $submissions[$i];
                $s2 = $submissions[$j];

                $similarity = $this->compare($s1, $s2);

                $plagiarism->results()->create([
                    'submission_1_id' => $s1->id,
                    'submission_2_id' => $s2->id,
                    'rate' => $similarity,
                ]);

                $totalSimilarity += $similarity;
                $comparisonCount++;
            }
        }

        $average = $comparisonCount > 0 ? $totalSimilarity / $comparisonCount : 0;
        $plagiarism->update(['rate' => $average]);

        return $plagiarism;
    }

    public function compare(Submission $s1, Submission $s2): float
    {
        $fg1 = $s1->getFingerprintsList();
        $fg2 = $s2->getFingerprintsList();

        $fg1 = array_values(array_unique(array_map(fn ($f) => $f->hash_value, $fg1)));
        $fg2 = array_values(array_unique(array_map(fn ($f) => $f->hash_value, $fg2)));

        sort($fg1);
        sort($fg2);

        $c1 = \count($fg1);
        $c2 = \count($fg2);

        $i = 0;
        $j = 0;

        $intersection = 0;
        $union = 0;

        while ($i < $c1 && $j < $c2) {
            if ($fg1[$i] == $fg2[$j]) {
                $intersection++;
                $i++;
                $j++;
            } elseif ($fg1[$i] < $fg2[$j]) {
                $i++;
            } else {
                $j++;
            }
            $union++;
        }

        $union += $c1 - $i;
        $union += $c2 - $j;

        if ($union <= 0) {
            return 0;
        }

        return $intersection / $union;
    }

    /**
     * @param  PlagiarismAlgoProp[]  $props
     */
    public function getProps(array $props, string $name): string
    {
        foreach ($props as $prop) {
            if ($prop->algoProp->name == $name) {
                return $prop->value;
            }
        }

        return '';
    }
}
