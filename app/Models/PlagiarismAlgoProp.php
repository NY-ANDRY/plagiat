<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlagiarismAlgoProp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plagiarism_id',
        'algo_prop_id',
        'value',
    ];

    /**
     * Get the plagiarism check that owns this property value.
     */
    public function plagiarism(): BelongsTo
    {
        return $this->belongsTo(Plagiarism::class);
    }

    /**
     * Get the algorithm property definition for this value.
     */
    public function algoProp(): BelongsTo
    {
        return $this->belongsTo(AlgoProp::class);
    }
}
