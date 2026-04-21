<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Algo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'about',
    ];

    /**
     * Get the properties for the algorithm.
     */
    public function props(): HasMany
    {
        return $this->hasMany(AlgoProp::class);
    }

    /**
     * Get the plagiarism checks that used this algorithm.
     */
    public function plagiarisms(): HasMany
    {
        return $this->hasMany(Plagiarism::class);
    }
}
