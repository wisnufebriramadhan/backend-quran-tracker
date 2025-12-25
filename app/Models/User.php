<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property string|null $role
 * @property bool $is_active
 * @method bool isAdmin()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    /**
     * Check if user is admin (SQLite-safe)
     */
    public function isAdmin(): bool
    {
        return ($this->role ?? 'user') === 'admin';
    }

    /**
     * Quran reading logs
     */
    public function quranLogs()
    {
        return $this->hasMany(QuranLog::class);
    }
}
