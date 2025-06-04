<?php

namespace App\Http\Controllers\Dokter; // Sesuai dengan namespace Anda

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal_periksa; // Pastikan path model ini benar
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JadwalPeriksaController extends Controller
{
    // Opsi hari untuk dropdown
    protected $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    public function index()
    {
        $jadwals = Jadwal_periksa::where('id_dokter', Auth::id())
                                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')") // Urutan hari yang benar
                                ->orderBy('jam_mulai')
                                ->get();
        return view('dokter.jadwal.index', compact('jadwals')); // Path view sesuai struktur Anda
    }

    public function create()
    {
        $hariOptions = $this->hariOptions;
        return view('dokter.jadwal.create', compact('hariOptions')); // Path view sesuai struktur Anda
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hari' => ['required', Rule::in($this->hariOptions)],
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $idDokter = Auth::id();

        // Cek tumpang tindih jadwal
        $isOverlapping = Jadwal_periksa::where('id_dokter', $idDokter)
            ->where('hari', $validatedData['hari'])
            ->where(function ($query) use ($validatedData) {
                $query->where(function ($q) use ($validatedData) {
                    $q->where('jam_mulai', '<', $validatedData['jam_selesai'])
                      ->where('jam_selesai', '>', $validatedData['jam_mulai']);
                })->orWhere(function ($q) use ($validatedData) {
                    $q->where('jam_mulai', '>=', $validatedData['jam_mulai'])
                      ->where('jam_mulai', '<', $validatedData['jam_selesai']);
                })->orWhere(function ($q) use ($validatedData) {
                    $q->where('jam_selesai', '>', $validatedData['jam_mulai'])
                      ->where('jam_selesai', '<=', $validatedData['jam_selesai']);
                })->orWhere(function ($q) use ($validatedData) { // Mencakup sepenuhnya
                    $q->where('jam_mulai', '<=', $validatedData['jam_mulai'])
                      ->where('jam_selesai', '>=', $validatedData['jam_selesai']);
                });
            })->exists();

        if ($isOverlapping) {
            return back()->withErrors(['jadwal_overlap' => 'Jadwal yang Anda masukkan tumpang tindih dengan jadwal lain pada hari yang sama.'])->withInput();
        }

        Jadwal_periksa::create([
            'id_dokter' => $idDokter,
            'hari' => $validatedData['hari'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'status' => true, // Default status aktif (boolean true)
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal_periksa::where('id', $id)->where('id_dokter', Auth::id())->firstOrFail();
        $hariOptions = $this->hariOptions;
        return view('dokter.jadwal.edit', compact('jadwal', 'hariOptions')); // Path view sesuai struktur Anda
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal_periksa::where('id', $id)->where('id_dokter', Auth::id())->firstOrFail();

        $validatedData = $request->validate([
            'hari' => ['required', Rule::in($this->hariOptions)],
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|boolean', // Validasi status sebagai boolean (menerima true, false, 1, 0)
        ]);

        $idDokter = Auth::id();

        // Cek tumpang tindih jadwal, kecuali jadwal yang sedang diedit
        $isOverlapping = Jadwal_periksa::where('id_dokter', $idDokter)
            ->where('hari', $validatedData['hari'])
            ->where('id', '!=', $jadwal->id)
            ->where(function ($query) use ($validatedData) {
                 $query->where(function ($q) use ($validatedData) {
                    $q->where('jam_mulai', '<', $validatedData['jam_selesai'])
                      ->where('jam_selesai', '>', $validatedData['jam_mulai']);
                })->orWhere(function ($q) use ($validatedData) {
                    $q->where('jam_mulai', '>=', $validatedData['jam_mulai'])
                      ->where('jam_mulai', '<', $validatedData['jam_selesai']);
                })->orWhere(function ($q) use ($validatedData) {
                    $q->where('jam_selesai', '>', $validatedData['jam_mulai'])
                      ->where('jam_selesai', '<=', $validatedData['jam_selesai']);
                })->orWhere(function ($q) use ($validatedData) {
                    $q->where('jam_mulai', '<=', $validatedData['jam_mulai'])
                      ->where('jam_selesai', '>=', $validatedData['jam_selesai']);
                });
            })->exists();

        if ($isOverlapping) {
            return back()->withErrors(['jadwal_overlap' => 'Jadwal yang Anda masukkan tumpang tindih dengan jadwal lain pada hari yang sama.'])->withInput();
        }

        $jadwal->update([
            'hari' => $validatedData['hari'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'status' => (bool)$validatedData['status'], // Pastikan disimpan sebagai boolean
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal_periksa::where('id', $id)->where('id_dokter', Auth::id())->firstOrFail();
        // Pertimbangkan pengecekan pendaftaran aktif sebelum menghapus
        $jadwal->delete();
        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function updateStatus(Request $request, Jadwal_periksa $jadwal) // Menggunakan Route Model Binding
    {
        if ($jadwal->id_dokter !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $jadwal->status = !$jadwal->status; // Toggle nilai boolean status
        $jadwal->save();

        return redirect()->route('dokter.jadwal.index')->with('success', 'Status jadwal berhasil diperbarui.');
    }
}
