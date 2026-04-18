<?php

namespace App\Models;

use Database\Factories\ExamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['title', 'about', 'close_date', 'creator_id'])]
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

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'exam_id');
    }

    public function fileExtensions(): BelongsToMany
    {
        return $this->belongsToMany(FileExtension::class)
            ->using(ExamFileExtension::class)
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(ExamStatus::class, 'exam_statuts_history', 'exam_id', 'status_id')
            ->withPivot(['user_id'])
            ->withTimestamps();
    }

    public function currentStatus(): ?ExamStatus
    {
        return $this->statuses()
            ->orderByPivot('date', 'desc')
            ->first();
    }

    public static function orderByOpenStatus()
    {
        $result = Exam::with([
            'creator',
            'fileExtensions',
            'statuses' => function ($query) {
                $query->orderByPivot('created_at', 'desc');
            }
        ])->get();

        $result = $result->sortByDesc(function ($exam) {
            $currentStatus = $exam->statuses->first();

            return $currentStatus && strtolower($currentStatus->label) === 'open' ? 1 : 0;
        })->values();

        return $result;
    }

    public static function details($id)
    {
        return Exam::with([
            'creator',
            'fileExtensions',
            'statuses' => function ($query) {
                $query->orderByPivot('created_at', 'desc');
            },
            'submissions.student'
        ])->find($id);
    }
}
