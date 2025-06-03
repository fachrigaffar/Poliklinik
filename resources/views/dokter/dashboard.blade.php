<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in! Welcome Dokter") }} {{ Auth::user()->nama }}
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">Statistik Cepat</h3>
                        <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-3">
                            <div class="p-4 bg-gray-100 rounded-lg dark:bg-gray-700">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Pasien Hari Ini</p>
                                <p class="text-2xl font-semibold">15</p>
                            </div>
                            <div class="p-4 bg-gray-100 rounded-lg dark:bg-gray-700">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jadwal Berikutnya</p>
                                <p class="text-2xl font-semibold">10:00 AM</p>
                            </div>
                            <div class="p-4 bg-gray-100 rounded-lg dark:bg-gray-700">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesan Baru</p>
                                <p class="text-2xl font-semibold">3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
