<?php

namespace App\Interface;

interface IPlagiarismResult
{
    /**
     * @return IProject[]
     */
    public function getProject1(): array;
    /**
     * @return IProject[]
     */
    public function getProject2(): array;
    public function getSimilarity(): float;
    public function setProject1(IProject $project): void;
    public function setProject2(IProject $project): void;
    public function setSimilarity(float $similarity): void;
}
