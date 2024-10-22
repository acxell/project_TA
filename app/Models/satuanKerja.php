<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Permission\Traits\HasRoles;

class satuanKerja extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "satuan_kerjas";

    protected $guarded = [
        'id',
    ];

    public function unit ()
    {
        return $this->hasMany(Unit::class, 'satuan_id', 'id');
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
