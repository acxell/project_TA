<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class KategoriCoa extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = "kategori_coa";

    protected $guarded = [
        'id',
    ];

    public function kategoriCoa()
    {
        return $this->hasMany(coa::class, 'kategori_coa_id', 'id');
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
