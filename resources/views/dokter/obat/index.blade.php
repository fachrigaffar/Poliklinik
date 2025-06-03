<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <section>
                    <header class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Daftar Obat') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Berikut adalah daftar obat yang tersedia dalam sistem.') }}
                            </p>
                        </div>
                        <a href="{{ route('dokter.obat.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Tambah Obat
                        </a>
                    </header>

                    @if (session('status') === 'obat-created' || session('status') === 'obat-updated' || session('status') === 'obat-deleted')
                        <div class="p-4 mb-4 text-sm rounded-lg {{ session('status') === 'obat-deleted' ? 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400' : 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400' }}" role="alert"
                             x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 3000)">
                            @if(session('status') === 'obat-created')
                                {{ __('Obat berhasil ditambahkan.') }}
                            @elseif(session('status') === 'obat-updated')
                                {{ __('Obat berhasil diperbarui.') }}
                            @elseif(session('status') === 'obat-deleted')
                                {{ __('Obat berhasil dihapus.') }}
                            @endif
                        </div>
                    @endif

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Obat</th>
                                    <th scope="col" class="px-6 py-3">Kemasan</th>
                                    <th scope="col" class="px-6 py-3">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($obats as $index => $obat)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $obat->nama_obat }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $obat->kemasan }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ 'Rp' . number_format($obat->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- Button Edit --}}
                                                <a href="{{ route('dokter.obat.edit', $obat->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-yellow-500 border border-transparent rounded-md shadow-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                                                    Edit
                                                </a>

                                                {{-- Button Delete --}}
                                                <form action="{{ route('dokter.obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
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
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data obat.
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
