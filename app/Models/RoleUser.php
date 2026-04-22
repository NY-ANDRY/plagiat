<?php

namespace App\Models;

use Database\Factories\RoleUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Pivot
{
    /** @use HasFactory<RoleUserFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'role_user';

    protected $dates = ['deleted_at'];

    public $incrementing = true;
}
