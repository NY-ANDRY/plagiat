<?php

namespace App\Interface;

interface IPlagiarismResults
{
    /**
     * @return IPlagiarismResult[]
     */
    public function getResults(): array;
    public function getSimilarity(): float;
}
