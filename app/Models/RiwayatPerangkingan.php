<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerangkingan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_perangkingans';
    protected $fillable = [
        'id',
        'kegiatan_id',
        'tanggal_penerimaan',
        'hasil_akhir',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
