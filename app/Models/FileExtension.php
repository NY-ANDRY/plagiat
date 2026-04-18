<?php

namespace App\Models;

use Database\Factories\FileExtensionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'extension', 'url_icon'])]
class FileExtension extends Model
{
    /** @use HasFactory<FileExtensionFactory> */
    use HasFactory, SoftDeletes;

    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class)
            ->using(ExamFileExtension::class)
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function iconUrl(): string
    {
        return $this->url_icon
            ? asset('storage/' . $this->url_icon)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
}
