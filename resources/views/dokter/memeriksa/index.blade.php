<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Daftar Periksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <section>
                    <header class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Antrian Pasien Anda') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Berikut adalah daftar pasien yang telah membuat janji temu dan menunggu untuk diperiksa.') }}
                        </p>
                    </header>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg dark:bg-gray-800 dark:text-green-400" role="alert"
                             x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No. Antrian</th>
                                    <th scope="col" class="px-6 py-3">Nama Pasien</th>
                                    <th scope="col" class="px-6 py-3">Keluhan</th>
                                    <th scope="col" class="px-6 py-3">Jadwal</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($janjiPeriksas as $janji)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $janji->no_antrian }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $janji->pasien->nama ?? 'Pasien tidak ditemukan' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $janji->keluhan }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $janji->jadwalPeriksa->hari ?? '' }}, {{ \Carbon\Carbon::parse($janji->jadwalPeriksa->jam_mulai ?? '')->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('dokter.memeriksa.form', $janji->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Periksa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada pasien dalam antrian saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
