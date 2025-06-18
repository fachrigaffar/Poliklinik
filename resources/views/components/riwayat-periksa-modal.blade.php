
<div x-show="openModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-black bg-opacity-75"
     style="display: none;">

    <div @click="openModal = false" class="fixed inset-0"></div>

    <div x-show="openModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-4xl mx-auto my-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">

        <template x-if="selectedJanji">
            <div class="p-6 sm:p-8">
                {{-- Header Modal --}}
                <div class="flex items-center justify-between pb-4 mb-6 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Riwayat Pemeriksaan
                    </h3>
                    <button type="button" @click="openModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                {{-- Body Modal --}}
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-2">
                    {{-- Kolom Kiri: Informasi Janji Temu --}}
                    <div class="space-y-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Informasi Janji Temu</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Pasien</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100" x-text="selectedJanji.pasien.nama"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Dokter</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100" x-text="selectedJanji.jadwal_periksa.dokter.nama"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Poli</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">Poli Umum</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jadwal</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100" x-text="`${selectedJanji.jadwal_periksa.hari}, ${selectedJanji.jadwal_periksa.jam_mulai.substring(0,5)} - ${selectedJanji.jadwal_periksa.jam_selesai.substring(0,5)}`"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Keluhan Awal</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100" x-text="selectedJanji.keluhan"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Hasil Pemeriksaan --}}
                    <div class="space-y-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Hasil Pemeriksaan</h4>
                        <template x-if="selectedJanji.periksa">
                             <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Diperiksa</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100" x-text="new Date(selectedJanji.periksa.tanggal_periksa).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }).replace('pukul', '')"></p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Catatan Dokter</p>
                                    <div class="w-full p-3 mt-1 text-base text-gray-800 bg-gray-100 rounded-md dark:text-gray-200 dark:bg-gray-700" x-text="selectedJanji.periksa.catatan"></div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Resep Obat</p>
                                    <div class="mt-1 space-y-1">
                                        <template x-if="selectedJanji.periksa.detail_periksas && selectedJanji.periksa.detail_periksas.length > 0">
                                            <template x-for="detail in selectedJanji.periksa.detail_periksas" :key="detail.id">
                                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100" x-text="detail.obat.nama_obat"></p>
                                            </template>
                                        </template>
                                        <template x-if="!selectedJanji.periksa.detail_periksas || selectedJanji.periksa.detail_periksas.length === 0">
                                            <p class="text-base text-gray-500 dark:text-gray-400">- Tidak ada resep obat -</p>
                                        </template>
                                    </div>
                                </div>
                                <div class="pt-4 mt-2 border-t dark:border-gray-700">
                                    <div class="flex items-baseline justify-between">
                                        <p class="text-sm font-medium text-gray-500">Total Biaya</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white" x-text="`Rp${new Intl.NumberFormat('id-ID').format(selectedJanji.periksa.biaya_periksa)}`"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        {{-- Tampilan jika belum diperiksa --}}
                        <template x-if="!selectedJanji.periksa">
                            <div class="flex flex-col items-center justify-center h-full p-6 text-center bg-gray-50 rounded-lg dark:bg-gray-900/50">
                                <p class="mb-2 text-lg font-semibold">Menunggu Pemeriksaan</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Hasil akan tersedia di sini setelah dokter melakukan pemeriksaan.</p>
                                <div class="mt-4 p-4 text-center border-2 border-dashed rounded-lg dark:border-gray-600">
                                    <p class="font-semibold text-gray-700 dark:text-gray-200">Nomor Antrian Anda</p>
                                    <p class="text-4xl font-bold text-blue-600 dark:text-blue-400" x-text="selectedJanji.no_antrian"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Footer Modal --}}
                <div class="flex items-center justify-end p-4 mt-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="button" @click="openModal = false" class="px-4 py-2 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-200 dark:text-gray-900 dark:hover:bg-gray-300 dark:focus:ring-offset-gray-800">
                        Tutup
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
