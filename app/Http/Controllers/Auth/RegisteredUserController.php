<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
            'nik' => ['required', 'string', 'max:16', 'unique:'.User::class],
        ]);

        // Cek apakah pasien dengan no_ktp tersebut sudah ada
        $existingPatient = User::where('nik', $request->nik)->first();

        if ($existingPatient) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $currentYearMonth = date('Ym'); // Format: 202411 untuk November 2024

        // Hitung jumlah pasien yang terdaftar dengan tahun dan bulan yang sama
        $patientCount = User::where('no_rm', 'like', $currentYearMonth . '-%')->count();

        // Buat no_rm dengan format tahun-bulan-urutan
        $no_rm = $currentYearMonth . '-' . str_pad($patientCount + 1, 3, '0', STR_PAD_LEFT);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien', // Set role sebagai pasien
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'no_rm' => $no_rm,

        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('pasien.dashboard', absolute: false));
    }
}
