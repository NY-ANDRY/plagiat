<?php

namespace App\Models;

use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[Fillable(['exam_id', 'student_id', 'url_file', 'file_extension', 'file_filename'])]
class Submission extends Model
{
    /** @use HasFactory<SubmissionFactory> */
    use HasFactory, SoftDeletes;

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public static function history($student_id)
    {
        return Submission::with(['exam'])->where('student_id', '=', $student_id)->orderByDesc('created_at')->get();
    }

    /**
     * Get the raw project associated with this submission.
     */
    public function rawProject(): HasOne
    {
        return $this->hasOne(RawProject::class);
    }

    /**
     * Get the fingerprints associated with this submission.
     */
    public function fingerprints(): HasMany
    {
        return $this->hasMany(Fingerprint::class);
    }

    /**
     * Get the plagiarism results where this submission was the first comparison target.
     */
    public function plagiarismResults1(): HasMany
    {
        return $this->hasMany(PlagiarismResult::class, 'submission_1_id');
    }

    /**
     * Get the plagiarism results where this submission was the second comparison target.
     */
    public function plagiarismResults2(): HasMany
    {
        return $this->hasMany(PlagiarismResult::class, 'submission_2_id');
    }

    public function getAbsolutePath(): string
    {
        return Storage::disk('public')->path($this->url_file);
    }

    public function getRawContent(): string
    {
        return $this->rawProject?->content ?? '';
    }

    public function setRawContent(string $rawContent): void
    {
        $this->rawProject()->updateOrCreate([], ['content' => $rawContent]);
    }

    public function getFingerprintsList(): array
    {
        return $this->fingerprints->all();
    }

    public function setFingerprintsList(array $fingerprints): void
    {
        $raw_project = $this->rawProject;
        foreach ($fingerprints as $fingerprint) {
           $fingerprint->raw_project_id = $raw_project->id;
        }
        $this->fingerprints()->delete();
        $this->fingerprints()->saveMany($fingerprints);
    }
}
