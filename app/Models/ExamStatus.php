<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamStatus extends Model
{
    protected $table = 'exam_statuts';

    protected $fillable = ['label', 'description', 'is_default'];
}
