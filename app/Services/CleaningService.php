<?php

namespace App\Services;

use App\Interface\IPlagiarismResult;
use App\Interface\IProject;
use File;

class CleaningService
{

    public function __construct()
    {
    }


    public function clean(IProject $file, array $extensions, array $restriction): string
    {
        $result = '';
        return $result;
    }
}
