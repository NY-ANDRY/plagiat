<?php

namespace App\Interface;

interface IProjects
{
    /**
     * @return IProject[]
     */
    public function getProjects(): array;
    public function getExtensions(): array;
    public function getRestrictions(): array;
    public function getResultType(): IPlagiarismResults;
}
