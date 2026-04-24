<?php

namespace App\Interface;

interface IPlagiarismResults
{
    /**
     * @return IPlagiarismResult[]
     */
    public function getResults(): array;
    /**
     * @param IPlagiarismResult[]
     */
    public function setResults(array $results): void;
    public function getSimilarity(): float;
    public function setSimilarity(float $similarity): float;
    public function getResultType(): IPlagiarismResult;
}
