<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Jadwal_periksa;
use App\Models\Janji_periksa;
use App\Models\Poli;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'alamat',
        'nik',
        'no_hp',
        'no_rm',
        'poli',
    ];

    public function JadwalPeriksas()
    {
        return $this->hasMany(Jadwal_periksa::class, 'id_dokter', 'id');
    }

    public function JanjiPeriksas()
    {
        return $this->hasMany(Janji_periksa::class, 'id_pasien', 'id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


}
