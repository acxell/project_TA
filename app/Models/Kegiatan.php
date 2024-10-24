<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;

class Kegiatan extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = 'kegiatans';

    protected $guarded = ['id',];

    protected $attributes = [
        'status' => 'Belum Diajukan',
    ];

    // Relasi ke TOR
    public function tor()
    {
        return $this->belongsTo(Tor::class, 'tor_id', 'id');
    }

    public function pesan_perbaikan()
    {
        return $this->hasMany(PesanPerbaikan::class, 'kegiatan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'id');
    }

    public function pendanaan()
    {
        return $this->hasMany(Pendanaan::class, 'kegiatan_id', 'id');
    }

    public function satuan()
    {
        return $this->hasOneThrough(satuanKerja::class, Unit::class, 'id', 'id', 'unit_id', 'satuan_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function lpj()
    {
        return $this->hasOne(Lpj::class, 'kegiatan_id', 'id');
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($kegiatan) {
            $kegiatan->tor()->delete();
        });
    }
}
