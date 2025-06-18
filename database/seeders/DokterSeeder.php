<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Poli;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            ['nama_poli' => 'Penyakit Dalam', 'deskripsi' => 'Poli khusus penyakit dalam'],
            ['nama_poli' => 'Anak', 'deskripsi' => 'Poli khusus anak-anak'],
            ['nama_poli' => 'Kebidanan dan Kandungan', 'deskripsi' => 'Poli kebidanan dan kandungan'],
            ['nama_poli' => 'Mata', 'deskripsi' => 'Poli spesialis mata'],
            ['nama_poli' => 'THT', 'deskripsi' => 'Poli THT'],
            ['nama_poli' => 'Gigi', 'deskripsi' => 'Poli gigi dan mulut'],
        ];

        foreach ($polis as $poli) {
            Poli::firstOrCreate(['nama_poli' => $poli['nama_poli']], $poli);
        }

        // Get poli IDs for reference
        $poliPenyakitDalam = Poli::where('nama_poli', 'Penyakit Dalam')->first();
        $poliAnak = Poli::where('nama_poli', 'Anak')->first();
        $poliKebidanan = Poli::where('nama_poli', 'Kebidanan dan Kandungan')->first();
        $poliMata = Poli::where('nama_poli', 'Mata')->first();
        $poliTHT = Poli::where('nama_poli', 'THT')->first();
        $poliGigi = Poli::where('nama_poli', 'Gigi')->first();

        $users = [
            // Doctors
            [
                'nama' => 'Dr. Budi Santoso, Sp.PD',
                'email' => 'budi.santoso@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
                'nik' => '3175062505800001',
                'no_hp' => '081234567890',
                'id_poli' => $poliPenyakitDalam->id,
                'no_rm' => null,
            ],
            [
                'nama' => 'Dr. Siti Rahayu, Sp.A',
                'email' => 'siti.rahayu@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Anggrek No. 45, Jakarta Pusat',
                'nik' => '3175064610790002',
                'no_hp' => '081234567891',
                'id_poli' => $poliAnak->id,
                'no_rm' => null,
            ],
            [
                'nama' => 'Dr. Ahmad Wijaya, Sp.OG',
                'email' => 'ahmad.wijaya@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Melati No. 78, Jakarta Barat',
                'nik' => '3175061505780003',
                'no_hp' => '081234567892',
                'id_poli' => $poliKebidanan->id,
                'no_rm' => null,
            ],
            [
                'nama' => 'Dr. Rina Putri, Sp.M',
                'email' => 'rina.putri@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Dahlia No. 32, Jakarta Timur',
                'nik' => '3175062708850004',
                'no_hp' => '081234567893',
                'id_poli' => $poliMata->id,
                'no_rm' => null,
            ],
            [
                'nama' => 'Dr. Doni Pratama, Sp.THT',
                'email' => 'doni.pratama@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Kenanga No. 56, Jakarta Utara',
                'nik' => '3175061002820005',
                'no_hp' => '081234567894',
                'id_poli' => $poliTHT->id,
                'no_rm' => null,
            ],
            // Patient
            [
                'nama' => 'Fachri Gaffar',
                'email' => 'fachri@gmail.com',
                'password' => Hash::make('fachri123'),
                'role' => 'pasien',
                'alamat' => 'Jl. Mawar No. 10, Jakarta Selatan',
                'nik' => '3175062505800007',
                'no_hp' => '081234567895',
                'no_rm' => 'RM001',
                'id_poli' => null,
            ],

        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
