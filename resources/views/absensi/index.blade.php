<x-app-layout>
    <div class="flex justify-center items-center min-h-screen mt-2 w-full bg-gray-100 dark:bg-gray-900">
        <div class="w-full md:w-1/2 border border-gray-300 p-12 rounded-lg bg-white shadow-md dark:bg-gray-800 dark:border-gray-600">
            <h2 class="mb-8 text-2xl font-bold text-center text-gray-900 dark:text-white">Pilih Absensi</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                
                <!-- Tombol Absensi Masuk -->
                <div class="flex flex-col items-center justify-center">
                    <div class="p-4 bg-blue-500 text-white rounded-full shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-3l4-5 4 5h-3v4z" />
                        </svg>
                    </div>
                    <a href="{{ route('absensi.add-absensi') }}" class="mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                        Absensi Masuk
                    </a>
                </div>

                <!-- Tombol Absensi Keluar -->
                <div class="flex flex-col items-center justify-center">
                    <div class="p-4 bg-green-500 text-white rounded-full shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-3l4-5 4 5h-3v4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16h-1v-4h-3l4-5 4 5h-3v4z" />
                        </svg>
                    </div>
                    <a href="{{ route('absensi.add-absensi') }}" class="mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg">
                        Absensi Keluar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
