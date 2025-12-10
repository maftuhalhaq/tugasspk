<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // <--- WAJIB DITAMBAHKAN
        'gender',
        'religion',
        'domisili',
        'income_level',
        'education_level',
        'date_of_birth',
        'status',
        'profile_photo_path',
        'whatsapp',
        'instagram',
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
            // 'password' => 'hashed',  <--- SAYA KOMENTAR/HAPUS BIAR TIDAK DOUBLE HASH
        ];
    }

    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }
}