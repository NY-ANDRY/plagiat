<?php

namespace App\Interface;

use App\Models\Algo;
use App\Models\FileExtension;
use App\Models\FileRestriction;
use App\Models\PlagiarismAlgoProp;

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

    public function getAlgo(): Algo;

    /**
     * @return PlagiarismAlgoProp[]
     */
    public function getAlgoProps(): array;

}
