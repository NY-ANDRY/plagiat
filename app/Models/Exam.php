<?php

namespace App\Models;

use Database\Factories\ExamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['title', 'close_date', 'creator_id'])]
class Exam extends Model
{
    /** @use HasFactory<ExamFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'close_date' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function fileExtensions(): BelongsToMany
    {
        return $this->belongsToMany(FileExtension::class)
            ->using(ExamFileExtension::class)
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }
}
