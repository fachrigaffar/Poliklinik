<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Buat Janji Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="max-w-xl mx-auto"> {{-- Wrapper untuk membatasi lebar form --}}
                    <section>
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Formulir Janji Periksa Baru') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Atur jadwal pertemuan dengan dokter untuk mendapatkan layanan konsultasi dan pemeriksaan kesehatan sesuai kebutuhan Anda.') }}
                            </p>
                        </header>

                        {{-- Form action ke route store dari controller Anda --}}
                        <form class="space-y-6" action="{{ route('pasien.janji-periksa.store') }}" method="POST">
                            @csrf

                            {{-- Nomor Rekam Medis (Readonly) --}}
                            <div>
                                <label for="no_rm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nomor Rekam Medis</label>
                                <input type="text" id="no_rm" name="no_rm"
                                       value="{{ $no_rm ?? 'Nomor RM Tidak Ditemukan' }}" {{-- Menggunakan variabel $no_rm dari controller --}}
                                       class="block w-full p-2.5 text-sm text-gray-700 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed"
                                       readonly>
                                {{-- Anda mungkin ingin menyembunyikan input ini jika tidak perlu ditampilkan, tapi tetap mengirimkan nilainya jika diperlukan di backend. Atau, controller store bisa mengambil no_rm dari Auth::user() juga. --}}
                            </div>

                            {{-- Pilihan Jadwal Dokter --}}
                            <div>
                                <label for="id_jadwal_periksa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Pilih Jadwal Dokter</label>
                                <select id="id_jadwal_periksa" name="id_jadwal_periksa" {{-- Nama field sesuai validasi controller --}}
                                        class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                    <option value="">-- Pilih Dokter dan Jadwal --</option>
                                    @if(isset($dokters) && $dokters->count() > 0)
                                        @foreach ($dokters as $dokter)
                                            {{-- Filter untuk hanya menampilkan dokter yang punya jadwal aktif --}}
                                            @if($dokter->jadwalPeriksas->where('status', true)->count() > 0)
                                                <optgroup label="Dr. {{ $dokter->nama }} ({{ $dokter->poli->nama_poli ?? 'Poli Umum' }})">
                                                    {{-- Loop melalui jadwalPeriksas yang sudah difilter status=true di controller --}}
                                                    @foreach ($dokter->jadwalPeriksas as $jadwalPeriksa)
                                                        <option value="{{ $jadwalPeriksa->id }}" {{ old('id_jadwal_periksa') == $jadwalPeriksa->id ? 'selected' : '' }}>
                                                            {{ $jadwalPeriksa->hari }} ({{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H:i') }})
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="" disabled>Tidak ada jadwal dokter yang tersedia saat ini.</option>
                                    @endif
                                </select>
                                @error('id_jadwal_periksa')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hanya jadwal dokter yang aktif yang ditampilkan.</p>
                            </div>

                            {{-- Keluhan --}}
                            <div>
                                <label for="keluhan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Keluhan</label>
                                <textarea id="keluhan" name="keluhan" rows="4"
                                          class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          placeholder="Deskripsikan keluhan yang Anda rasakan..." required>{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tombol Aksi dan Pesan Status --}}
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <a href="{{ url()->previous() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                    Buat Janji
                                </button>
                            </div>

                            {{-- Pesan flash dari controller --}}
                            @if (session('status') === 'janji-periksa-created' || session('success'))
                                <div class="mt-4" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                                    <p class="text-sm font-medium text-green-600 dark:text-green-400">
                                        {{ session('success') ?? __('Janji periksa berhasil dibuat.') }}
                                    </p>
                                </div>
                            @endif
                             @if (session('error'))
                                <div class="mt-4" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            @endif
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
