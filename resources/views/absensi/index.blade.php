<x-app-layout>
    <div class="flex flex-col items-center min-h-screen mt-2 w-full bg-gray-100 dark:bg-gray-900">
        <div class="w-full md:w-3/4 border border-gray-300 p-6 rounded-lg bg-white shadow-md dark:bg-gray-800 dark:border-gray-600">
            <h2 class="mb-4 text-2xl font-bold text-center text-gray-900 dark:text-white">Data Absensi</h2>
            
            <!-- Tombol Tambah Absensi -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('absensi.add-absensi') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                    Tambah Absensi
                </a>
            </div>

            <!-- Tabel Data Absensi -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300 text-gray-700 dark:text-gray-300 dark:border-gray-600">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Pengguna</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu Masuk</th>
                            <th class="border border-gray-300 px-4 py-2">Foto Pagar Depan</th>
                            <th class="border border-gray-300 px-4 py-2">Foto Ruang Tengah</th>
                            <th class="border border-gray-300 px-4 py-2">Foto Lorong Lab</th>
                            <th class="border border-gray-300 px-4 py-2">Foto Pagar Belakang</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($absensis as $absensi)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $absensi->user->name ?? 'Tidak Diketahui' }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $absensi->waktu_masuk ?? '-' }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if($absensi->foto_pagar_depan)
                                        <img src="{{ asset($absensi->foto_pagar_depan) }}" alt="Foto Pagar Depan" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal('{{ asset($absensi->foto_pagar_depan) }}')">
                                    @else
                                        - 
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if($absensi->foto_ruang_tengah)
                                        <img src="{{ asset($absensi->foto_ruang_tengah) }}" alt="Foto Ruang Tengah" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal('{{ asset($absensi->foto_ruang_tengah) }}')">
                                    @else
                                        - 
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if($absensi->foto_lorong_lab)
                                        <img src="{{ asset($absensi->foto_lorong_lab) }}" alt="Foto Lorong Lab" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal('{{ asset($absensi->foto_lorong_lab) }}')">
                                    @else
                                        - 
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if($absensi->foto_pagar_belakang)
                                        <img src="{{ asset($absensi->foto_pagar_belakang) }}" alt="Foto Pagar Belakang" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal('{{ asset($absensi->foto_pagar_belakang) }}')">
                                    @else
                                        - 
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <span class="px-2 py-1 rounded-lg text-white 
                                        {{ $absensi->status == 'Diverifikasi' ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ $absensi->status }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border border-gray-300 px-4 py-2 text-center">
                                    Tidak ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Gambar Besar -->
    <div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="relative bg-white p-4 rounded-lg shadow-lg">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-2xl">&times;</button>
            <img id="modalImage" src="" alt="Foto" class="max-w-2xl max-h-96 mx-auto">
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal dan menampilkan gambar besar
        function openImageModal(imageUrl) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl; // Set gambar besar
            modal.classList.remove('hidden'); // Tampilkan modal
        }

        // Fungsi untuk menutup modal
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden'); // Sembunyikan modal
        }
    </script>
</x-app-layout>
