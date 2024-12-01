<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAbsensi extends Model
{
    protected $fillable = ['departemen_id', 'tanggal', 'jam_mulai', 'jam_selesai'];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}
