<?php

namespace App\Models;

use Database\Factories\FileTypeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'url_icon'])]
class FileType extends Model
{
    /** @use HasFactory<FileTypeFactory> */
    use HasFactory, SoftDeletes;

    public function restrictions(): HasMany
    {
        return $this->hasMany(FileRestriction::class);
    }

    public function iconUrl(): string
    {
        return $this->url_icon
            ? asset('storage/'.$this->url_icon)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name);
    }
}
