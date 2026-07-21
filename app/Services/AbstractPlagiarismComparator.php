<?php

namespace App\Services;

use App\Models\Plagiarism;

abstract class AbstractPlagiarismComparator
{
    abstract public function process(Plagiarism $plagiarism): Plagiarism;
}
