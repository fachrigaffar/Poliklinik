<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal_periksa extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function dokter():BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function janjiPeriksa():HasMany
    {
        return $this->hasMany(Janji_periksa::class, 'id_jadwal_periksa');
    }
}
