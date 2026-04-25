<?php

namespace App\Models;

use Database\Factories\ExamStatusHistoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamStatusHistory extends Pivot
{
    /** @use HasFactory<ExamStatusHistoryFactory> */
    use HasFactory;

    protected $table = 'exam_statut_history';

    public $incrementing = true;

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ExamStatus::class, 'status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
