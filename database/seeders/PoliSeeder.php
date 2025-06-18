<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poli;
use App\Models\User;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Gigi',
                'deskripsi' => 'Menangani masalah kesehatan gigi dan mulut, seperti penambalan, pencabutan, dan pembersihan karang gigi.',
            ],
            [
                'nama_poli' => 'Anak',
                'deskripsi' => 'Memberikan layanan kesehatan komprehensif untuk bayi, anak-anak, dan remaja, termasuk imunisasi.',
            ],
            [
                'nama_poli' => 'Penyakit Dalam',
                'deskripsi' => 'Mendiagnosis dan menangani berbagai macam penyakit organ dalam pada orang dewasa tanpa pembedahan.',
            ],
        ];

        // REVISI: Menggunakan loop dan Eloquent create()
        foreach ($polis as $poli) {
            Poli::create($poli);
        }
    }
}
