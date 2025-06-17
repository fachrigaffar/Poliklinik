<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Dr. Budi Santoso, Sp.PD',
                'email' => 'budi.santoso@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
                'nik' => '3175062505800001',
                'no_hp' => '081234567890',
                'poli' => 'Penyakit Dalam',
            ],
            [
                'nama' => 'Dr. Siti Rahayu, Sp.A',
                'email' => 'siti.rahayu@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Anggrek No. 45, Jakarta Pusat',
                'nik' => '3175064610790002',
                'no_hp' => '081234567891',
                'poli' => 'Anak',
            ],
            [
                'nama' => 'Dr. Ahmad Wijaya, Sp.OG',
                'email' => 'ahmad.wijaya@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Melati No. 78, Jakarta Barat',
                'nik' => '3175061505780003',
                'no_hp' => '081234567892',
                'poli' => 'Kebidanan dan Kandungan',
            ],
            [
                'nama' => 'Dr. Rina Putri, Sp.M',
                'email' => 'rina.putri@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Dahlia No. 32, Jakarta Timur',
                'nik' => '3175062708850004',
                'no_hp' => '081234567893',
                'poli' => 'Mata',
            ],
            [
                'nama' => 'Dr. Doni Pratama, Sp.THT',
                'email' => 'doni.pratama@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Kenanga No. 56, Jakarta Utara',
                'nik' => '3175061002820005',
                'no_hp' => '081234567894',
                'poli' => 'THT',
            ],
            [
                'nama' => 'fachri gaffar',
                'email' => 'fachri@gmail.com',
                'password' => Hash::make('fachri123'),
                'role' => 'pasien',
                'alamat' => 'Jl. Mawar No. 10, Jakarta Selatan',
                'nik' => '3175062505800006',
                'no_hp' => '081234567895',
                'no_rm' => 'RM001',
                'poli' => null,
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
