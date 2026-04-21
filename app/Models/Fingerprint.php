<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fingerprint extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'submission_id',
        'raw_project_id',
        'hash_value',
        'position',
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
