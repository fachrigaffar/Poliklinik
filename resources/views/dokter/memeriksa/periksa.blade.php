<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ $periksa->id ? 'Edit Pemeriksaan Pasien' : 'Mulai Pemeriksaan Pasien' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="max-w-2xl mx-auto">
                    <section>
                        <header class="mb-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ $periksa->id ? 'Edit Hasil Pemeriksaan' : 'Form Pemeriksaan' }}
                                </h2>
                                <a href="{{ route('dokter.memeriksa.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                                    &larr; Kembali ke Daftar Periksa
                                </a>
                            </div>
                             <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Lengkapi detail pemeriksaan untuk pasien.') }}
                            </p>
                        </header>

                        @if(session('error'))
                            <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-400" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('dokter.memeriksa.simpan', $janjiPeriksa->id) }}" method="POST" class="space-y-6"
                              x-data="formPemeriksaanHandler({{ json_encode($obats) }}, {{ json_encode($periksa->detailPeriksas->pluck('obat.id')->toArray()) }})">
                            @csrf

                            <div>
                                <label for="nama_pasien" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nama Pasien</label>
                                <input type="text" id="nama_pasien" value="{{ $janjiPeriksa->pasien->nama ?? 'N/A' }}"
                                       class="block w-full p-2.5 text-sm text-gray-700 border border-gray-300 rounded-lg bg-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed" readonly>
                            </div>

                            <div>
                                <label for="tanggal_periksa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tanggal & Jam Periksa</label>
                                <input type="datetime-local" name="tanggal_periksa" id="tanggal_periksa"
                                       value="{{ old('tanggal_periksa', $periksa->tanggal_periksa ? Carbon\Carbon::parse($periksa->tanggal_periksa)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                                       class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @error('tanggal_periksa')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Catatan</label>
                                <textarea id="catatan" name="catatan" rows="4"
                                          class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          placeholder="Masukkan catatan diagnosa, tindakan, dll." required>{{ old('catatan', $periksa->catatan) }}</textarea>
                                @error('catatan')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Daftar Obat dengan Checkbox --}}
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Resep Obat</label>
                                <div class="p-4 border border-gray-300 rounded-lg max-h-60 overflow-y-auto space-y-3 dark:border-gray-600">
                                    @forelse ($obats as $obat)
                                        <div class="flex items-center">
                                            <input id="obat-{{ $obat->id }}" name="obat_ids[]" value="{{ $obat->id }}" type="checkbox"
                                                   x-model="selectedObatIds"
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="obat-{{ $obat->id }}" class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $obat->nama_obat }} - Rp{{ number_format($obat->harga, 0, ',', '.') }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada data obat yang tersedia.</p>
                                    @endforelse
                                </div>
                                @error('obat_ids')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                             <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-100">Total Biaya Pemeriksaan</label>
                                 <p class="p-2.5 text-xl font-bold text-gray-900 border border-gray-200 rounded-md dark:text-white dark:border-gray-600 bg-gray-50 dark:bg-gray-700" x-text="`Rp${totalBiaya.toLocaleString('id-ID')}`"></p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-text="`Termasuk biaya konsultasi Rp${biayaKonsultasi.toLocaleString('id-ID')} dan biaya obat Rp${totalHargaObat.toLocaleString('id-ID')}`"></p>
                            </div>

                            <div class="flex items-center justify-end gap-4 pt-6">
                                <a href="{{ route('dokter.memeriksa.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                    Simpan Hasil Pemeriksaan
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function formPemeriksaanHandler(allObats, initialSelectedObatIds = []) {
            return {
                allObats: allObats.map(o => ({ ...o, harga: parseFloat(o.harga) || 0 })),
                // REVISI: Mengganti komentar Bahasa Indonesia untuk menghindari potensi error parsing
                // Cast to string to match checkbox values
                selectedObatIds: initialSelectedObatIds.map(String),
                biayaKonsultasi: 150000,

                get totalHargaObat() {
                    return this.allObats
                        .filter(obat => this.selectedObatIds.includes(String(obat.id)))
                        .reduce((sum, obat) => sum + obat.harga, 0);
                },

                get totalBiaya() {
                    return this.totalHargaObat + this.biayaKonsultasi;
                }
            }
        }
    </script>
</x-app-layout>
