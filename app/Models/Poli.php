<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poli extends Model
{
     use HasFactory;

    protected $table = 'polis';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
    ];

    /**
     * Relationship one-to-many ke model User dengan kondisi role dokter.
     */
    public function dokters()
    {
        return $this->hasMany(User::class, 'id_poli');
    }
}
