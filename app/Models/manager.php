<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = ['nama_lengkap', 'email', 'nomor_telepon', 'departemen_id'];

    // Relasi dengan tabel Departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }
}
