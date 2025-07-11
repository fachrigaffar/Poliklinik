<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="max-w-xl mx-auto">
                    <section>
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Perbarui Jadwal Periksa') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ubah detail jadwal periksa Anda di bawah ini.') }}
                            </p>
                        </header>

                        <form action="{{ route('dokter.jadwal.update', $jadwal->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT') {{-- Atau PATCH --}}

                            {{-- Hari --}}
                            <div>
                                <label for="hari" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Hari</label>
                                <select id="hari" name="hari" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Pilih Hari</option>
                                    @foreach($hariOptions as $hariOption)
                                        <option value="{{ $hariOption }}" {{ old('hari', $jadwal->hari) == $hariOption ? 'selected' : '' }}>{{ $hariOption }}</option>
                                    @endforeach
                                </select>
                                @error('hari')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jam Mulai --}}
                            @php
                                $jamMulaiParts = explode(':', old('jam_mulai', $jadwal->jam_mulai ?? '00:00'));
                                $selectedJamMulaiJam = $jamMulaiParts[0] ?? '00';
                                $selectedJamMulaiMenit = $jamMulaiParts[1] ?? '00';
                            @endphp
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Jam Mulai</label>
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label for="jam_mulai_jam" class="sr-only">Jam Mulai (Jam)</label>
                                        <select id="jam_mulai_jam" name="jam_mulai_jam" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Jam</option>
                                            @foreach($timeOptions['hours'] as $hour)
                                                <option value="{{ $hour }}" {{ $selectedJamMulaiJam == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center font-semibold dark:text-gray-100">:</div>
                                    <div class="flex-1">
                                        <label for="jam_mulai_menit" class="sr-only">Jam Mulai (Menit)</label>
                                        <select id="jam_mulai_menit" name="jam_mulai_menit" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Menit</option>
                                            @foreach($timeOptions['minutes'] as $minute)
                                                <option value="{{ $minute }}" {{ $selectedJamMulaiMenit == $minute ? 'selected' : '' }}>{{ $minute }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('jam_mulai_jam') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                @error('jam_mulai_menit') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Jam Selesai --}}
                             @php
                                $jamSelesaiParts = explode(':', old('jam_selesai', $jadwal->jam_selesai ?? '00:00'));
                                $selectedJamSelesaiJam = $jamSelesaiParts[0] ?? '00';
                                $selectedJamSelesaiMenit = $jamSelesaiParts[1] ?? '00';
                            @endphp
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Jam Selesai</label>
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label for="jam_selesai_jam" class="sr-only">Jam Selesai (Jam)</label>
                                        <select id="jam_selesai_jam" name="jam_selesai_jam" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Jam</option>
                                            @foreach($timeOptions['hours'] as $hour)
                                                <option value="{{ $hour }}" {{ $selectedJamSelesaiJam == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center font-semibold dark:text-gray-100">:</div>
                                    <div class="flex-1">
                                        <label for="jam_selesai_menit" class="sr-only">Jam Selesai (Menit)</label>
                                        <select id="jam_selesai_menit" name="jam_selesai_menit" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="">Menit</option>
                                            @foreach($timeOptions['minutes'] as $minute)
                                                <option value="{{ $minute }}" {{ $selectedJamSelesaiMenit == $minute ? 'selected' : '' }}>{{ $minute }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('jam_selesai_jam') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                @error('jam_selesai_menit') <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                @error('jam_selesai')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Status</label>
                                <select id="status" name="status" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="1" {{ old('status', $jadwal->status ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status', $jadwal->status ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
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
                                    Update Jadwal
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
