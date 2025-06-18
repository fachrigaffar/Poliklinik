<?php

namespace App\Http\Controllers\pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Janji_periksa;


class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        $janjiPeriksas = Janji_periksa::where('id_pasien', Auth::id())
            ->with([
                'pasien',
                'jadwalPeriksa.dokter',
                'periksa.detailPeriksas.obat'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.riwayat-periksa.index')->with([
            'janjiPeriksas' => $janjiPeriksas,
        ]);
    }
}
