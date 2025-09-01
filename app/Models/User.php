<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'role',
        'on_duty',
        'last_seen_at',
        'phone',
        'city_municipality_id',
        'is_banned',
        'banned_reason'
    ];

    protected $casts = [
        'on_duty' => 'boolean',
        'last_seen_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function assignedReports()
    {
        return $this->hasMany(Report::class, 'officer_id');
    }

    public function isOfficer(): bool
    {
        return $this->role === 'officer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function city()
    {
        return $this->belongsTo(CitiesMunicipalities::class, 'city_municipality_id');
    }

    public function isBanned(): bool
    {
        return $this->is_banned;
    }
}
