<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class pengguna extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "penggunas";

    protected $guarded = [
        'id',
        'unit_id',
    ];

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
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
