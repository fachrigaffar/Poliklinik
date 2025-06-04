<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tambah Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="max-w-xl mx-auto"> {{-- Wrapper untuk membatasi lebar form --}}
                    <section>
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Buat Jadwal Periksa Baru') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Isi detail di bawah ini untuk menambahkan jadwal periksa baru. Jadwal akan otomatis berstatus "Aktif".') }}
                            </p>
                        </header>

                        <form action="{{ route('dokter.jadwal.store') }}" method="POST" class="space-y-6">
                            @csrf

                            {{-- Hari --}}
                            <div>
                                <label for="hari" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Hari</label>
                                <select id="hari" name="hari" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Pilih Hari</option>
                                    {{-- $hariOptions diharapkan dikirim dari controller --}}
                                    @foreach($hariOptions as $hariOption)
                                        <option value="{{ $hariOption }}" {{ old('hari') == $hariOption ? 'selected' : '' }}>{{ $hariOption }}</option>
                                    @endforeach
                                </select>
                                @error('hari')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jam Mulai --}}
                            <div>
                                <label for="jam_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}"
                                       class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @error('jam_mulai')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jam Selesai --}}
                            <div>
                                <label for="jam_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}"
                                       class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @error('jam_selesai')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Error untuk jadwal_overlap (jika ada dari validasi di controller) --}}
                            @error('jadwal_overlap')
                                <div class="p-3 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <a href="{{ route('dokter.jadwal.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Batal
                                </a>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                    Simpan Jadwal
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
