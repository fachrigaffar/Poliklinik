<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Manajemen Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <section>
                    <header class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Daftar Jadwal Periksa Anda') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Kelola jadwal periksa Anda. Jadwal "Aktif" dapat dilihat dan dipilih pasien.') }}
                            </p>
                        </div>
                        <a href="{{ route('dokter.jadwal.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Tambah Jadwal Baru
                        </a>
                    </header>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg dark:bg-gray-800 dark:text-green-400" role="alert"
                             x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 rounded-lg dark:bg-gray-800 dark:text-red-400" role="alert"
                             x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                            {{ session('error') }}
                        </div>
                    @endif
                     @error('jadwal_overlap') {{-- Jika ada error dari validasi tumpang tindih --}}
                        <div class="p-3 mb-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300" role="alert">
                            {{ $message }}
                        </div>
                    @enderror


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Hari</th>
                                    <th scope="col" class="px-6 py-3">Jam Mulai</th>
                                    <th scope="col" class="px-6 py-3">Jam Selesai</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwals as $index => $jadwal)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td class="px-6 py-4">{{ $jadwal->hari }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($jadwal->status) {{-- true adalah aktif --}}
                                                <form action="{{ route('dokter.jadwal.status', $jadwal->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" title="Jadwal Saat Ini Aktif. Klik untuk Nonaktifkan."
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600">
                                                        Nonaktifkan
                                                    </button>
                                                </form>
                                            @else {{-- false adalah tidak aktif --}}
                                                <form action="{{ route('dokter.jadwal.status', $jadwal->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" title="Jadwal Saat Ini Tidak Aktif. Klik untuk Aktifkan."
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-500 dark:hover:bg-green-600">
                                                        Aktifkan
                                                    </button>
                                                </form>
                                            @endif
                                            <span class="block mt-1 text-xs {{ $jadwal->status ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                (Status: {{ $jadwal->status ? 'Aktif' : 'Tidak Aktif' }})
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('dokter.jadwal.edit', $jadwal->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-yellow-500 border border-transparent rounded-md shadow-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                                                    Edit
                                                </a>
                                                <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Anda belum memiliki jadwal periksa.
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
