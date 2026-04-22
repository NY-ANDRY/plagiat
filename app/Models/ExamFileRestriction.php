<?php

namespace App\Models;

use Database\Factories\ExamFileRestrictionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamFileRestriction extends Pivot
{
    /** @use HasFactory<ExamFileRestrictionFactory> */
    use HasFactory;
    protected $table = 'exam_file_restriction';

    public $incrementing = true;
}
