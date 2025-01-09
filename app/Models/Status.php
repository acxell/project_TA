<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Status extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'statuses';

    public function statusKegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'status_id', 'id');
    }

    public function statusLPJ()
    {
        return $this->belongsTo(Lpj::class, 'status_id', 'id');
    }

    public function statusRetur()
    {
        return $this->belongsTo(Retur::class, 'status_id', 'id');
    }
}
