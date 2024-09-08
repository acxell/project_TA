<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Rab extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "rabs";

    protected $fillable = [
        'nama_kegiatan',
        'total_biaya',
        'biaya_terbilang',
        'tor_id',
        'status',
    ];

    public function tor(){
        return $this->belongsTo(Tor::class, 'tor_id', 'id');
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
