<?php

namespace App\Models;

use Database\Factories\ExamFileExtensionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamFileExtension extends Pivot
{
    /** @use HasFactory<ExamFileExtensionFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'exam_file_extension';

    public $incrementing = true;
}
