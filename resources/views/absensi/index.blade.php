<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Absensi</h2>
    </x-slot>

    <main class="px-10 mt-10">
        <!-- Tombol Tambah Absensi -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('absensi.add-absensi') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                Tambah Absensi
            </a>
        </div>

        <!-- Tabel Data Absensi -->
        <div class="table-container">
            <div class="overflow-x-auto w-full">
                <table id="data-absensi" class="table table-striped nowrap w-full">
                    <thead>
                        <tr class="text-white bg-gray-800">
                            <th class="text-center">No</th>
                            <th>Nama Petugas</th>
                            <th>Tanggal Masuk</th>
                            <th>Foto Pagar Depan</th>
                            <th>Foto Ruang Tengah</th>
                            <th>Foto Lorong Lab</th>
                            <th>Foto Pagar Belakang</th>
                            <th>Status Kehadiran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Script DataTables -->
    <script>
        $(document).ready(function () {
            $('#data-absensi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('absensi.data') }}', // Ganti dengan route yang sesuai untuk mengambil data absensi
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'waktu_masuk',
                        name: 'waktu_masuk'
                    },
                    {
                        data: 'foto_pagar_depan',
                        name: 'foto_pagar_depan',
                        render: function (data) {
                            return data ? '<img src="' + data + '" alt="Foto Pagar Depan" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal(\'' + data + '\')">' : '-';
                        }
                    },
                    {
                        data: 'foto_ruang_tengah',
                        name: 'foto_ruang_tengah',
                        render: function (data) {
                            return data ? '<img src="' + data + '" alt="Foto Ruang Tengah" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal(\'' + data + '\')">' : '-';
                        }
                    },
                    {
                        data: 'foto_lorong_lab',
                        name: 'foto_lorong_lab',
                        render: function (data) {
                            return data ? '<img src="' + data + '" alt="Foto Lorong Lab" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal(\'' + data + '\')">' : '-';
                        }
                    },
                    {
                        data: 'foto_pagar_belakang',
                        name: 'foto_pagar_belakang',
                        render: function (data) {
                            return data ? '<img src="' + data + '" alt="Foto Pagar Belakang" class="w-20 h-20 object-cover cursor-pointer" onclick="openImageModal(\'' + data + '\')">' : '-';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data) {
                            return '<span class="px-2 py-1 rounded-lg text-white ' + (data === 'Diverifikasi' ? 'bg-green-500' : 'bg-red-500') + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return '<form action="{{ route('absensi.destroy', '') }}/' + row.id + '" method="POST" class="inline">' +
                                '@csrf' +
                                '@method('DELETE')' +
                                '<button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">Hapus</button>' +
                                '</form>';
                        }
                    }
                ]
            });
        });

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

    <!-- Modal Gambar Besar -->
    <div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="relative bg-white p-4 rounded-lg shadow-lg">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-2xl">&times;</button>
            <img id="modalImage" src="" alt="Foto" class="max-w-2xl max-h-96 mx-auto">
        </div>
    </div>
</x-app-layout>