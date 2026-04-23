<?php

namespace App\Interface;

use App\Models\FileExtension;
use App\Models\FileRestriction;

interface IProjects
{
    /**
     * @return IProject[]
     */
    public function getProjects(): array;

    /**
     * @return FileExtension[]
     */
    public function getExtensions(): array;
    /**
     * @return FileRestriction[]
     */
    public function getRestrictions(): array;
    public function getResultType(): IPlagiarismResults;
}
