<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Pivot
{
    use SoftDeletes;

    protected $table = 'role_user';

    protected $dates = ['deleted_at'];

    public $incrementing = true;
}