<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plagiarism extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'algo_id',
        'exam_id',
        'rate',
    ];

    /**
     * Get the algorithm used for this plagiarism check.
     */
    public function algo(): BelongsTo
    {
        return $this->belongsTo(Algo::class);
    }

    /**
     * Get the exam that owns the plagiarism check.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the algorithm properties used for this check.
     */
    public function algoProps(): HasMany
    {
        return $this->hasMany(PlagiarismAlgoProp::class);
    }

    /**
     * Get the results for this plagiarism check.
     */
    public function results(): HasMany
    {
        return $this->hasMany(PlagiarismResult::class);
    }
}
