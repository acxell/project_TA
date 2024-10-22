<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Tor extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = 'tors';

    protected $guarded = ['id'];

    public function proker()
    {
        return $this->belongsTo(ProgramKerja::class, 'proker_id', 'id');
    }

    public function rab()
    {
        return $this->hasOne(Rab::class, 'tor_id', 'id');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'tor_id', 'id');
    }

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class, 'tor_id', 'id');
    }

    public function indikatorKegiatan()
    {
        return $this->hasMany(IndikatorKegiatan::class, 'tor_id', 'id');
    }

    public function outcomeKegiatan()
    {
        return $this->hasMany(OutcomeKegiatan::class, 'tor_id', 'id');
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'coa_id', 'id');
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
