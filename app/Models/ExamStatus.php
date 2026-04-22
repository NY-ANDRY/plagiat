<?php

namespace App\Models;

use Database\Factories\ExamStatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamStatus extends Model
{
    /** @use HasFactory<ExamStatusFactory> */
    use HasFactory;
    protected $table = 'exam_statuts';

    protected $fillable = ['label', 'description', 'is_default'];
}
