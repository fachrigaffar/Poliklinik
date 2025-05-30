<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
    ];

    public function detailPeriksa():HasMany
    {
        return $this->hasMany(Detail_periksa::class, 'id_obat');
    }
}
