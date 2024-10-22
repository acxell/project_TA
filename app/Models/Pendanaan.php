<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Pendanaan extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "pendanaans";

    protected $guarded = [
        'id',
        'kegiatan_id',
        'user_id',
        'unit_id',
    ];


    //Relational
    public function kegiatan(){
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    public function unit()
    {
        return $this->hasOneThrough(Unit::class, Pengguna::class, 'id', 'id', 'user_id', 'unit_id');
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
