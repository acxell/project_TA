<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Permission\Traits\HasRoles;

class Aktivitas extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "aktivitas";

    protected $fillable = [
        'kegiatan_id',
        'waktu_aktivitas',
        'penjelasan',
        'kategori',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    public function kebutuhanAnggaran()
    {
        return $this->hasMany(kebutuhanAnggaran::class, 'aktivitas_id', 'id');
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
