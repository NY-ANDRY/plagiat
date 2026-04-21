<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlgoProp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'algo_id',
        'name',
    ];

    /**
     * Get the algorithm that owns the property.
     */
    public function algo(): BelongsTo
    {
        return $this->belongsTo(Algo::class);
    }

    /**
     * Get the specific properties used in plagiarism checks.
     */
    public function plagiarismAlgoProps(): HasMany
    {
        return $this->hasMany(PlagiarismAlgoProp::class, 'algo_prop_id');
    }
}
