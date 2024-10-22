<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class ProgramKerja extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "program_kerjas";

    protected $guarded = [
        'id',
    ];

    public function tor()
    {
        return $this->hasMany(Tor::class, 'proker_id', 'id');
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
