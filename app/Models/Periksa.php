<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periksa extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'tanggal_periksa',
        'catatan',
        'biaya_periksa',
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
    ];

    public function detailPeriksa()
    {
        return $this->hasMany(Detail_periksa::class, 'id_periksa');
    }

}
