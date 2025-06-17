<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Janji_periksa;
use App\Models\Periksa;
use App\Models\Detail_periksa;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    /**
     * Menampilkan daftar janji periksa yang perlu ditangani oleh dokter.
     */
    public function index()
    {
        $idDokter = Auth::id();

        $janjiPeriksas = Janji_periksa::whereHas('jadwalPeriksa', function ($query) use ($idDokter) {
            $query->where('id_dokter', $idDokter);
        })
        ->whereDoesntHave('periksa')
        ->with(['pasien', 'jadwalPeriksa.dokter'])
        ->orderBy('no_antrian', 'asc')
        ->get();

        return view('dokter.memeriksa.index', compact('janjiPeriksas'));
    }

    /**
     * Menampilkan form untuk memeriksa pasien.
     * REVISI: Tidak lagi membuat record secara otomatis.
     */
    public function periksa(Janji_periksa $janjiPeriksa)
    {
        if ($janjiPeriksa->jadwalPeriksa->id_dokter !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Hanya mencari data periksa yang sudah ada
        $periksa = Periksa::where('id_janji_periksa', $janjiPeriksa->id)->first();

        if (!$periksa) {
            // Jika belum ada, buat instance BARU DI MEMORI (TIDAK DISIMPAN).
            $periksa = new Periksa([
                'id_janji_periksa' => $janjiPeriksa->id,
                'tanggal_periksa' => now(),
                'catatan' => $janjiPeriksa->keluhan, // Catatan awal diisi dengan keluhan
                'biaya_periksa' => 0,
            ]);
            // Buat relasi kosong agar tidak error di view
            $periksa->setRelation('detailPeriksas', collect());
        } else {
            // Jika sudah ada, load relasi obatnya
            $periksa->loadMissing('detailPeriksas.obat');
        }

        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.memeriksa.periksa', compact('janjiPeriksa', 'periksa', 'obats'));
    }

    /**
     * Menyimpan atau memperbarui data hasil pemeriksaan.
     * REVISI: Method ini sekarang menerima Janji_periksa, bukan Periksa.
     */
    public function simpanPemeriksaan(Request $request, Janji_periksa $janjiPeriksa)
    {
        if ($janjiPeriksa->jadwalPeriksa->id_dokter !== Auth::id()) {
             abort(403, 'Akses ditolak.');
        }

        $validatedData = $request->validate([
            'tanggal_periksa' => 'required|date_format:Y-m-d\TH:i',
            'catatan' => 'required|string',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id',
        ]);

        DB::beginTransaction();
        try {
            // Menggunakan updateOrCreate untuk menangani create dan update dalam satu method.
            $periksa = Periksa::updateOrCreate(
                ['id_janji_periksa' => $janjiPeriksa->id],
                [
                    'tanggal_periksa' => Carbon::parse($validatedData['tanggal_periksa'])->format('Y-m-d H:i:s'),
                    'catatan' => $validatedData['catatan'],
                    'biaya_periksa' => 0, // Akan di-override di bawah
                ]
            );

            $totalBiayaObat = 0;
            $periksa->detailPeriksas()->delete();

            if ($request->filled('obat_ids')) {
                foreach ($request->obat_ids as $idObat) {
                    Detail_periksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat,
                    ]);
                    $obat = Obat::find($idObat);
                    if ($obat) {
                        $totalBiayaObat += $obat->harga;
                    }
                }
            }

            $biayaKonsultasi = 150000;

            // Update biaya periksa setelah semua dihitung
            $periksa->biaya_periksa = $biayaKonsultasi + $totalBiayaObat;
            $periksa->save();

            DB::commit();

            return redirect()->route('dokter.memeriksa.index')->with('success', 'Data pemeriksaan pasien berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan pada server. Gagal menyimpan data.')->withInput();
        }
    }
}
