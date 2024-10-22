<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Permission\Traits\HasRoles;

class coa extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "coas";

    protected $guarded = [
        'id',
    ];

    public function kegiatan ()
    {
        return $this->hasMany(Kegiatan::class, 'coa_id', 'id');
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
