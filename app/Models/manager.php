<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// MODEL MANAGER SUDAH MEMILIKI PASSWORD


class Manager extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'departemen_id',
        'password', // Tambahkan ini
    ];

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->isDirty('password')) {
                $model->password = bcrypt($model->password);
            }
        });
    }
}
