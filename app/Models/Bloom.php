<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bloom extends Model
{
    protected $fillable = [
        'submission_id',
        'raw_project_id',
        'array',
    ];

    /**
     * Get the submission that owns the fingerprint.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get the raw project that owns the fingerprint.
     */
    public function rawProject(): BelongsTo
    {
        return $this->belongsTo(RawProject::class);
    }
}
