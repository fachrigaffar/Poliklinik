<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-lg">
                        {{ __("Selamat datang kembali,") }} <span class="font-semibold">{{ Auth::user()->nama }}</span>!
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Ini adalah halaman dashboard Anda. Di sini Anda dapat melihat ringkasan informasi kesehatan dan jadwal temu Anda.") }}
                    </p>

                    {{-- Contoh Konten Tambahan untuk Dashboard Pasien --}}
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Anda</h3>
                        <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2 lg:grid-cols-3">
                            <div class="p-6 bg-gray-50 rounded-lg dark:bg-gray-700">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <h4 class="ml-3 text-md font-semibold text-gray-700 dark:text-gray-200">Jadwal Temu Berikutnya</h4>
                                </div>
                                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">10 Juni 2025, 14:00</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">dengan Dr. Budi Santoso</p>
                                <a href="#" class="inline-block mt-3 text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Lihat Detail &rarr;</a>
                            </div>

                            <div class="p-6 bg-gray-50 rounded-lg dark:bg-gray-700">
                                <div class="flex items-center">
                                     <svg class="w-6 h-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.967l-1.59.955a6 6 0 01-3.86.967l-2.387-.477a2 2 0 00-1.022.547m3.228 4.212a2 2 0 001.022.547l2.387.477a6 6 0 003.86-.967l1.59-.955a6 6 0 013.86-.967l2.387.477a2 2 0 001.022-.547M3 10a7 7 0 1114 0H3z"></path></svg>
                                    <h4 class="ml-3 text-md font-semibold text-gray-700 dark:text-gray-200">Pemeriksaan Terakhir</h4>
                                </div>
                                <p class="mt-2 text-gray-700 dark:text-gray-300">20 Mei 2025 - Pemeriksaan Rutin</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Hasil: Baik</p>
                                <a href="#" class="inline-block mt-3 text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Lihat Riwayat Lengkap &rarr;</a>
                            </div>

                             <div class="p-6 bg-gray-50 rounded-lg dark:bg-gray-700">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M9 6h6M9 12h6M9 18h6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <h4 class="ml-3 text-md font-semibold text-gray-700 dark:text-gray-200">Resep Obat Aktif</h4>
                                </div>
                                <p class="mt-2 text-gray-700 dark:text-gray-300">Amoxicillin 500mg (Sisa 5 hari)</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Vitamin C (Sisa 10 hari)</p>
                                <a href="#" class="inline-block mt-3 text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Lihat Semua Resep &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
