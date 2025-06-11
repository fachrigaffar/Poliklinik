<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Janji_periksa;
use App\Models\Jadwal_periksa;
use App\Models\User; // Pastikan model User sudah ada
use App\Models\Periksa;
use App\Models\Detail_periksa;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    // Menampilkan daftar janji periksa yang belum diperiksa oleh dokter yang login
    public function daftarPasienUntukDiperiksa()
    {
        $idDokter = Auth::id();

        $janjiPeriksas = Janji_periksa::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($query) use ($idDokter) {
                $query->where('id_dokter', $idDokter);
            })
            ->whereDoesntHave('periksa') // hanya yang belum diperiksa
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dokter.pemeriksaan.daftar_pasien', compact('janjiPeriksas'));
    }

    // Menampilkan form pemeriksaan berdasarkan janji periksa
    public function periksaPasienForm($idJanji)
    {
        $idDokter = Auth::id();

        $janji = Janji_periksa::with('pasien', 'jadwalPeriksa')
            ->where('id', $idJanji)
            ->whereHas('jadwalPeriksa', function ($query) use ($idDokter) {
                $query->where('id_dokter', $idDokter);
            })
            ->firstOrFail();

        $periksa = Periksa::firstOrCreate(
            ['id_janji_periksa' => $janji->id],
            [
                'id_pasien' => $janji->id_pasien ?? $janji->id_pasien, // pastikan relasi benar
                'id_dokter' => $idDokter,
                'tgl_periksa' => now(),
                'catatan' => null,
                'biaya_periksa' => 0,
            ]
        );

        if (!$periksa->wasRecentlyCreated && $periksa->catatan != null) {
            $periksa->load('detailPeriksas.obat');
        }

        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.pemeriksaan.form_periksa', compact('periksa', 'janji', 'obats'));
    }

    // Simpan data hasil pemeriksaan
    public function simpanPemeriksaan(Request $request, $idPeriksa)
    {
        $request->validate([
            'catatan' => 'required|string',
            'tgl_periksa' => 'required|date_format:Y-m-d H:i:s',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id',
        ]);

        $periksa = Periksa::where('id', $idPeriksa)
            ->where('id_dokter', Auth::id())
            ->firstOrFail();

        DB::beginTransaction();
        try {
            $totalBiayaObat = 0;

            $periksa->detailPeriksas()->delete(); // reset jika ada

            if ($request->has('obat_ids')) {
                foreach ($request->obat_ids as $idObat) {
                    Detail_periksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat,
                    ]);

                    $obat = Obat::find($idObat);
                    $totalBiayaObat += $obat->harga ?? 0;
                }
            }

            $biayaKonsultasi = 150000;

            $periksa->update([
                'catatan' => $request->catatan,
                'tgl_periksa' => Carbon::parse($request->tgl_periksa),
                'biaya_periksa' => $biayaKonsultasi + $totalBiayaObat,
            ]);

            DB::commit();
            return redirect()->route('dokter.pemeriksaan.daftar')->with('success', 'Pemeriksaan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['db_error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }
}
