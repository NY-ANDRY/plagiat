<?php

namespace App\Services;

use App\Models\Bloom;
use App\Models\Plagiarism;
use App\Models\PlagiarismAlgoProp;
use App\Models\Submission;
use Illuminate\Support\Facades\Log;

class JaccardService
{
    private FingerprintService $fingerprintService;

    public function __construct()
    {
        $this->fingerprintService = new FingerprintService;
    }

    public function process(Plagiarism $plagiarism): Plagiarism
    {
        Log::info('Starting Jaccard similarity check for Plagiarism ID: '.$plagiarism->id);
        Log::info('Add blooms begin');
        $this->addBlooms($plagiarism);
        Log::info('Add blooms end');

        Log::info('begin');
        $result = $this->compareAll($plagiarism);
        Log::info('Add compare end');

        return $result;
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
        $b1 = $s1->blooms()->first();
        $b2 = $s2->blooms()->first();

        if (! $b1 || ! $b2) {
            return 0;
        }

        $array1 = $b1->array;
        $array2 = $b2->array;

        $count1 = \strlen($array1);
        $count2 = \strlen($array2);

        if ($count1 != $count2) {
            throw new \Exception('Bloom arrays must be of the same size');
        }

        $intersection = 0;
        $union = 0;

        for ($i = 0; $i < $count1; $i++) {
            if ($array1[$i] == '1' || $array2[$i] == '1') {
                $union++;
            }
            if ($array1[$i] == '1' && $array2[$i] == '1') {
                $intersection++;
            }
        }

        if ($union == 0) {
            return 0;
        }

        return $intersection / $union;
    }

    public function addBlooms(Plagiarism $plagiarism): void
    {
        $props = $plagiarism->algoProps->all();
        $k = (int) $this->getProps($props, 'k');
        $hashCount = (int) $this->getProps($props, 'c');
        $arraySize = (int) $this->getProps($props, 's');

        foreach ($plagiarism->exam->submissions as $submission) {
            $this->addBloom($submission, $k, $arraySize, $hashCount);
        }
    }

    public function addBloom(Submission $submission, $k, $arraySize, $hashCount): void
    {
        $rawContent = $submission->getRawContent();

        $kMers = $this->fingerprintService->separate($rawContent, $k);
        $bloom = str_repeat('0', $arraySize);

        foreach ($kMers as $kM) {
            $indexs = $this->fingerprintService->getIndex($kM, $arraySize, $hashCount);
            foreach ($indexs as $index) {
                $bloom[$index] = '1';
            }
        }

        $b = new Bloom(['array' => $bloom]);
        $submission->setBloom($b);
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
