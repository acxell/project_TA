<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Retur extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = 'returs';

    protected $guarded = ['id'];

    public function lpj()
    {
        return $this->belongsTo(Lpj::class, 'lpj_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
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
