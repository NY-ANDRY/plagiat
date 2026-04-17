<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamFileExtension extends Pivot
{
    use SoftDeletes;

    protected $table = 'exam_file_extension';

    public $incrementing = true;
}
