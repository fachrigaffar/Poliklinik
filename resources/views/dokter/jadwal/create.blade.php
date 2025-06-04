<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tambah Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="max-w-xl mx-auto">
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
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Jam Mulai</label>
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label for="jam_mulai_jam" class="sr-only">Jam Mulai (Jam)</label>
                                        <select id="jam_mulai_jam" name="jam_mulai_jam" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Jam</option>
                                            @foreach($timeOptions['hours'] as $hour)
                                                <option value="{{ $hour }}" {{ old('jam_mulai_jam') == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center font-semibold dark:text-gray-100">:</div>
                                    <div class="flex-1">
                                        <label for="jam_mulai_menit" class="sr-only">Jam Mulai (Menit)</label>
                                        <select id="jam_mulai_menit" name="jam_mulai_menit" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Menit</option>
                                            @foreach($timeOptions['minutes'] as $minute)
                                                <option value="{{ $minute }}" {{ old('jam_mulai_menit') == $minute ? 'selected' : '' }}>{{ $minute }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('jam_mulai_jam') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                @error('jam_mulai_menit') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Jam Selesai --}}
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Jam Selesai</label>
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label for="jam_selesai_jam" class="sr-only">Jam Selesai (Jam)</label>
                                        <select id="jam_selesai_jam" name="jam_selesai_jam" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Jam</option>
                                            @foreach($timeOptions['hours'] as $hour)
                                                <option value="{{ $hour }}" {{ old('jam_selesai_jam') == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="flex items-center font-semibold dark:text-gray-100">:</div>
                                    <div class="flex-1">
                                        <label for="jam_selesai_menit" class="sr-only">Jam Selesai (Menit)</label>
                                        <select id="jam_selesai_menit" name="jam_selesai_menit" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Menit</option>
                                            @foreach($timeOptions['minutes'] as $minute)
                                                <option value="{{ $minute }}" {{ old('jam_selesai_menit') == $minute ? 'selected' : '' }}>{{ $minute }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('jam_selesai_jam') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                @error('jam_selesai_menit') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                @error('jam_selesai') {{-- Untuk error validasi 'after' --}}
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

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
