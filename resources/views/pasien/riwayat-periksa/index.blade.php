<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Riwayat Periksa Saya') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: false, selectedJanji: null }">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <section>
                    <header class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Riwayat Janji Temu Anda') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Berikut adalah daftar semua janji temu yang telah Anda buat.') }}
                        </p>
                    </header>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Dokter & Poli</th>
                                    <th scope="col" class="px-6 py-3">Hari & Jadwal</th>
                                    <th scope="col" class="px-6 py-3">Antrian</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($janjiPeriksas as $janjiPeriksa)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">{{ $janjiPeriksa->jadwalPeriksa->dokter->nama ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">Poli Umum</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $janjiPeriksa->jadwalPeriksa->hari ?? '' }}, {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_mulai ?? '')->format('H:i') }} - {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_selesai ?? '')->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $janjiPeriksa->no_antrian }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- REVISI: Mengubah gaya status agar konsisten --}}
                                            @if ($janjiPeriksa->periksa)
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-green-600 rounded-md">
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded-md">
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button @click="selectedJanji = {{ json_encode($janjiPeriksa->load(['pasien', 'jadwalPeriksa.dokter', 'periksa.detailPeriksas.obat'])) }}; openModal = true"
                                                    class="px-6 py-2 text-sm font-medium text-white bg-blue-400 rounded-lg hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Anda belum memiliki riwayat periksa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        {{-- Memanggil komponen modal. Pastikan file komponen ini ada. --}}
        <x-riwayat-periksa-modal />
    </div>
</x-app-layout>
