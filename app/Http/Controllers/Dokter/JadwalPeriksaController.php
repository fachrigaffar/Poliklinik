<?php

namespace App\Http\Controllers\Dokter; // Sesuai dengan namespace Anda

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal_periksa; // Pastikan path model ini benar
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Import Carbon

class JadwalPeriksaController extends Controller
{
    protected $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    // Helper untuk menghasilkan opsi jam dan menit
    private function getTimeOptions()
    {
        $hours = [];
        for ($h = 0; $h < 24; $h++) {
            $hours[] = str_pad($h, 2, '0', STR_PAD_LEFT);
        }

        $minutes = [];
        // Interval menit, misalnya per 15 menit
        for ($m = 0; $m < 60; $m += 15) {
            $minutes[] = str_pad($m, 2, '0', STR_PAD_LEFT);
        }
        // Atau per 30 menit
        //  for ($m = 0; $m < 60; $m += 30) {
        //      $minutes[] = str_pad($m, 2, '0', STR_PAD_LEFT);
        //  }
        
        // Atau setiap menit jika diperlukan
        // for ($m = 0; $m < 60; $m++) {
        //     $minutes[] = str_pad($m, 2, '0', STR_PAD_LEFT);
        // }


        return ['hours' => $hours, 'minutes' => $minutes];
    }

    public function index()
    {
        $jadwals = Jadwal_periksa::where('id_dokter', Auth::id())
                                ->orderByRaw("FIELD(hari, '".implode("', '", $this->hariOptions)."')")
                                ->orderBy('jam_mulai')
                                ->get();
        return view('dokter.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $hariOptions = $this->hariOptions;
        $timeOptions = $this->getTimeOptions();
        return view('dokter.jadwal.create', compact('hariOptions', 'timeOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => ['required', Rule::in($this->hariOptions)],
            'jam_mulai_jam' => ['required', Rule::in($this->getTimeOptions()['hours'])],
            'jam_mulai_menit' => ['required', Rule::in($this->getTimeOptions()['minutes'])],
            'jam_selesai_jam' => ['required', Rule::in($this->getTimeOptions()['hours'])],
            'jam_selesai_menit' => ['required', Rule::in($this->getTimeOptions()['minutes'])],
        ]);

        $jamMulai = $request->jam_mulai_jam . ':' . $request->jam_mulai_menit;
        $jamSelesai = $request->jam_selesai_jam . ':' . $request->jam_selesai_menit;

        // Validasi after:jam_mulai secara manual karena formatnya sudah digabung
        if (Carbon::parse($jamSelesai)->lte(Carbon::parse($jamMulai))) {
            return back()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.'])->withInput();
        }

        $idDokter = Auth::id();

        // Cek tumpang tindih jadwal
        $isOverlapping = Jadwal_periksa::where('id_dokter', $idDokter)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '<', $jamSelesai)
                      ->where('jam_selesai', '>', $jamMulai);
                })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '>=', $jamMulai)
                      ->where('jam_mulai', '<', $jamSelesai);
                })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_selesai', '>', $jamMulai)
                      ->where('jam_selesai', '<=', $jamSelesai);
                })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '<=', $jamMulai)
                      ->where('jam_selesai', '>=', $jamSelesai);
                });
            })->exists();

        if ($isOverlapping) {
            return back()->withErrors(['jadwal_overlap' => 'Jadwal yang Anda masukkan tumpang tindih dengan jadwal lain pada hari yang sama.'])->withInput();
        }

        Jadwal_periksa::create([
            'id_dokter' => $idDokter,
            'hari' => $request->hari,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'status' => true,
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal_periksa::where('id', $id)->where('id_dokter', Auth::id())->firstOrFail();
        $hariOptions = $this->hariOptions;
        $timeOptions = $this->getTimeOptions();
        return view('dokter.jadwal.edit', compact('jadwal', 'hariOptions', 'timeOptions'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal_periksa::where('id', $id)->where('id_dokter', Auth::id())->firstOrFail();

        $request->validate([
            'hari' => ['required', Rule::in($this->hariOptions)],
            'jam_mulai_jam' => ['required', Rule::in($this->getTimeOptions()['hours'])],
            'jam_mulai_menit' => ['required', Rule::in($this->getTimeOptions()['minutes'])],
            'jam_selesai_jam' => ['required', Rule::in($this->getTimeOptions()['hours'])],
            'jam_selesai_menit' => ['required', Rule::in($this->getTimeOptions()['minutes'])],
            'status' => 'required|boolean',
        ]);

        $jamMulai = $request->jam_mulai_jam . ':' . $request->jam_mulai_menit;
        $jamSelesai = $request->jam_selesai_jam . ':' . $request->jam_selesai_menit;

        if (Carbon::parse($jamSelesai)->lte(Carbon::parse($jamMulai))) {
            return back()->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai.'])->withInput();
        }

        $idDokter = Auth::id();

        $isOverlapping = Jadwal_periksa::where('id_dokter', $idDokter)
            ->where('hari', $request->hari)
            ->where('id', '!=', $jadwal->id)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                 $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '<', $jamSelesai)
                      ->where('jam_selesai', '>', $jamMulai);
                })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '>=', $jamMulai)
                      ->where('jam_mulai', '<', $jamSelesai);
                })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_selesai', '>', $jamMulai)
                      ->where('jam_selesai', '<=', $jamSelesai);
                })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '<=', $jamMulai)
                      ->where('jam_selesai', '>=', $jamSelesai);
                });
            })->exists();

        if ($isOverlapping) {
            return back()->withErrors(['jadwal_overlap' => 'Jadwal yang Anda masukkan tumpang tindih dengan jadwal lain pada hari yang sama.'])->withInput();
        }

        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'status' => (bool)$request->status,
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal_periksa::where('id', $id)->where('id_dokter', Auth::id())->firstOrFail();
        $jadwal->delete();
        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function updateStatus(Request $request, Jadwal_periksa $jadwal)
    {
        if ($jadwal->id_dokter !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        $jadwal->status = !$jadwal->status;
        $jadwal->save();
        return redirect()->route('dokter.jadwal.index')->with('success', 'Status jadwal berhasil diperbarui.');
    }
}
