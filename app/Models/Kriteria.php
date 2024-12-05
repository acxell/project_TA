<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Kriteria extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "kriterias";

    protected $guarded = [
        'id',
    ];

    public function subkriteria ()
    {
        return $this->hasMany(Subkriteria::class, 'id_kriteria', 'id');
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
