<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="max-w-xl mx-auto">
                    <section>
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Tambah Data Obat') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Silakan isi form di bawah ini untuk menambahkan data obat ke dalam sistem.') }}
                            </p>
                        </header>

                        <form class="space-y-6" id="formObat" action="{{ route('dokter.obat.store') }}" method="POST">
                            @csrf

                            {{-- Nama Obat --}}
                            <div>
                                <label for="namaObat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nama Obat</label>
                                <input
                                    type="text"
                                    id="namaObat"
                                    name="nama_obat"
                                    value="{{ old('nama_obat') }}"
                                    class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Contoh: Paracetamol 500mg"
                                >
                                @error('nama_obat')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kemasan --}}
                            <div>
                                <label for="kemasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Kemasan</label>
                                <input
                                    type="text"
                                    id="kemasan"
                                    name="kemasan"
                                    value="{{ old('kemasan') }}"
                                    class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Contoh: Strip isi 10 tablet"
                                >
                                @error('kemasan')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div>
                                <label for="harga" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Harga</label>
                                <input
                                    type="number" {{-- Menggunakan type number untuk harga --}}
                                    id="harga"
                                    name="harga"
                                    value="{{ old('harga') }}"
                                    class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Contoh: 15000"
                                    min="0" {{-- Harga tidak boleh negatif --}}
                                >
                                @error('harga')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <a href="{{ route('dokter.obat.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Batal
                                </a>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
