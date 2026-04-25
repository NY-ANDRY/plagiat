<?php

namespace App\Models;

use Database\Factories\PlagiarismStatutFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlagiarismStatut extends Model
{
    /** @use HasFactory<PlagiarismStatutFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'plagiarism_statuts';

    protected $fillable = [
        'name',
        'about',
    ];
}
