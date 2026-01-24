<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        // 'is_active', // ← HAPUS INI agar user tidak bisa set sendiri
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'is_active' => false,  // ✅ DEFAULT FALSE
        'role' => 'user',       // ✅ DEFAULT ROLE USER
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
        'deleted_at'        => 'datetime',
    ];

    /**
     * Check if user is admin
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

    /**
     * Attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Scope: Get only active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get only inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}
