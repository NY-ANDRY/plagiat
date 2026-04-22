<?php

namespace App\Models;

use Database\Factories\RawProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawProject extends Model
{
    /** @use HasFactory<RawProjectFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'submission_id',
        'content',
    ];

    /**
     * Get the submission that owns the raw project.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get the fingerprints for the raw project.
     */
    public function fingerprints(): HasMany
    {
        return $this->hasMany(Fingerprint::class);
    }
}
