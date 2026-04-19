<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamFileRestriction extends Pivot
{
    protected $table = 'exam_file_restriction';

    public $incrementing = true;
}
