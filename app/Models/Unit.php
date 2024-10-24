<?php

namespace App\Models;

use App\Http\Controllers\SatuanController;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Unit extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "units";

    protected $guarded = [
        'id',
    ];

    public function penggunas(){
        return $this->hasMany(pengguna::class, 'unit_id', 'id');
    }

    public function satuan()
    {
        return $this->belongsTo(satuanKerja::class, 'satuan_id', 'id');
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