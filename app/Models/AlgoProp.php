<?php

namespace App\Models;

use Database\Factories\AlgoPropFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlgoProp extends Model
{
    /** @use HasFactory<AlgoPropFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'algo_id',
        'name',
        'about'
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
