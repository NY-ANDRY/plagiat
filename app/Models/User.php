<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'url_image'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()
            ->where('roles.name', $role)
            ->exists();
    }

    public function imageUrl(): string
    {
        $result = '';
        if ($this->url_image) {
            $result = asset('storage/' . $this->url_image);
        } else {
            $rand = mt_rand(1, 3);
            $result = asset("storage/placeholder/0{$rand}.jpg");
        }
        return $result;
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, 'creator_id');
    }
}
