<?php

namespace App\Models;

use Database\Factories\PlagiarismStatutHistoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlagiarismStatutHistory extends Pivot
{
    /** @use HasFactory<PlagiarismStatutHistoryFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'plagiarism_statuts_history';

    public $incrementing = true;

    protected $fillable = [
        'plagiarism_id',
        'plagiarism_statut_id',
    ];

    /**
     * Get the plagiarism check associated with this history entry.
     */
    public function plagiarism(): BelongsTo
    {
        return $this->belongsTo(Plagiarism::class);
    }

    /**
     * Get the status associated with this history entry.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(PlagiarismStatut::class, 'plagiarism_statut_id');
    }
}
