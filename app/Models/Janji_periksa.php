<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Janji_periksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pasien',
        'id_jadwal_periksa',
        'keluhan',
        'no_antrian',
    ];

    public function pasien():BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
    
    public function jadwalPeriksa(): BelongsTo
    {
        return $this->belongsTo(Jadwal_periksa::class, 'id_jadwal_periksa');
    }

    public function periksa(): HasOne
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa');
    }
}
