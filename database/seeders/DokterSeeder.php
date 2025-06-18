<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Poli;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan data poli sudah ada
        $this->createDefaultPolisIfNotExist();

        // Ambil ID poli yang sudah ada dengan pengecekan null
        $poliPenyakitDalam = Poli::where('nama_poli', 'Penyakit Dalam')->first()?->id;
        $poliAnak = Poli::where('nama_poli', 'Anak')->first()?->id;
        $poliGigi = Poli::where('nama_poli', 'Gigi')->first()?->id;

        // Validasi jika poli tidak ditemukan
        if (!$poliPenyakitDalam || !$poliAnak || !$poliGigi) {
            throw new \Exception('Data poli tidak lengkap. Harap jalankan PoliSeeder terlebih dahulu.');
        }

        $users = [
            // Dokter Penyakit Dalam
            [
                'nama' => 'Dr. Budi Santoso, Sp.PD',
                'email' => 'budi.santoso@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
                'nik' => '3175062505800001',
                'no_hp' => '081234567890',
                'id_poli' => $poliPenyakitDalam,
                'no_rm' => null,
            ],

            // Dokter Anak
            [
                'nama' => 'Dr. Siti Rahayu, Sp.A',
                'email' => 'siti.rahayu@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Anggrek No. 45, Jakarta Pusat',
                'nik' => '3175064610790002',
                'no_hp' => '081234567891',
                'id_poli' => $poliAnak,
                'no_rm' => null,
            ],

            // Dokter Gigi
            [
                'nama' => 'Dr. Ahmad Wijaya, Sp.KG',
                'email' => 'ahmad.wijaya@klinik.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Melati No. 78, Jakarta Barat',
                'nik' => '3175061505780003',
                'no_hp' => '081234567892',
                'id_poli' => $poliGigi,
                'no_rm' => null,
            ],

            // Pasien
            [
                'nama' => 'Fachri Gaffar',
                'email' => 'fachri@gmail.com',
                'password' => Hash::make('fachri123'),
                'role' => 'pasien',
                'alamat' => 'Jl. Mawar No. 10, Jakarta Selatan',
                'nik' => '3175062505800004',
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

    protected function createDefaultPolisIfNotExist(): void
    {
        $defaultPolis = [
            'Penyakit Dalam' => 'Pelayanan kesehatan untuk penyakit dalam',
            'Anak' => 'Pelayanan kesehatan untuk anak-anak',
            'Gigi' => 'Pelayanan kesehatan gigi dan mulut'
        ];

        foreach ($defaultPolis as $nama => $deskripsi) {
            Poli::firstOrCreate(
                ['nama_poli' => $nama],
                ['deskripsi' => $deskripsi]
            );
        }
    }
}
