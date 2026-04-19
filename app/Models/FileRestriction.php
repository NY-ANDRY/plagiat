<?php

namespace App\Models;

use Database\Factories\FileRestrictionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'file_type_id', 'file_extension_id', 'url_icon'])]
class FileRestriction extends Model
{
    /** @use HasFactory<FileRestrictionFactory> */
    use HasFactory, SoftDeletes;

    public function fileType(): BelongsTo
    {
        return $this->belongsTo(FileType::class);
    }

    public function fileExtension(): BelongsTo
    {
        return $this->belongsTo(FileExtension::class);
    }

    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class, 'exam_file_restriction', 'restriction_id', 'exam_id')
            ->using(ExamFileRestriction::class)
            ->withTimestamps();
    }

    public function iconUrl(): string
    {
        return $this->url_icon
            ? asset('storage/'.$this->url_icon)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name);
    }
}
