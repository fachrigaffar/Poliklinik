<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Janji_periksa;
use App\Models\Detail_periksa;

class Periksa extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'id_janji_periksa',
        'tanggal_periksa',
        'catatan',
        'biaya_periksa',
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
    ];

    public function janjiPeriksa(): BelongsTo
    {
        return $this->belongsTo(Janji_periksa::class, 'id_janji_periksa');
    }

    public function detailPeriksas(): HasMany
    {
        return $this->hasMany(Detail_periksa::class, 'id_periksa');
    }

}
