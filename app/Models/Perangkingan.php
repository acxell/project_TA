<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Perangkingan extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = 'perangkingan';

    protected $guarded = ['id',];

    public function kegiatan ()
    {
        return $this->hasOne(Kegiatan::class, 'id', 'kegiatan_id');
    }

}
