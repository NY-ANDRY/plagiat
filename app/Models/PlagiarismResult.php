<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlagiarismResult extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plagiarism_id',
        'submission_1_id',
        'submission_2_id',
        'rate',
    ];

    /**
     * Get the plagiarism check that owns this result.
     */
    public function plagiarism(): BelongsTo
    {
        return $this->belongsTo(Plagiarism::class);
    }

    /**
     * Get the first submission in the comparison.
     */
    public function submission1(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_1_id');
    }

    /**
     * Get the second submission in the comparison.
     */
    public function submission2(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_2_id');
    }
}
