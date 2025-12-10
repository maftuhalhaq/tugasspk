<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    // KUNCI SUKSES: Pakai guarded kosong agar semua kolom boleh diisi
    protected $fillable = [
        'user_id',
        'preferred_religion',
        'strict_religion',
        'preferred_domisili',
        'strict_domisili',
        'min_age',
        'max_age',
        'preferred_income_level',
        'strict_income',
        'preferred_education_level',
        'strict_education',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}