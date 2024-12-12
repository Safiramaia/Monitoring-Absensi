<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Absensi</h2>
    </x-slot>

    <main class="px-10 mt-10">
        <!-- Tombol Tambah Absensi -->
        <div class="flex justify-end mb-4">
            <button class="flex items-center gap-1 px-4 py-2 bg-green-700 rounded-md text-white font-medium text-sm"
                x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-absensi')">
                Tambah Absensi
            </button>
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
        $(document).ready(function() {
            $('#data-absensi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.data-absensi.data') }}',
                columns: [{
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
                    },
                    {
                        data: 'foto_ruang_tengah',
                        name: 'foto_ruang_tengah',
                    },
                    {
                        data: 'foto_lorong_lab',
                        name: 'foto_lorong_lab',
                    },
                    {
                        data: 'foto_pagar_belakang',
                        name: 'foto_pagar_belakang',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        // Fungsi untuk mengubah status absensi
        function updateStatus(id, status) {
            fetch("{{ route('admin.absensi.update-status') }}", {
                    method: 'POST', // Correct the method to POST
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data) {
                        // Swal.fire({
                        //     title: 'Berhasil!',
                        //     text: 'Status berhasil diperbarui',
                        //     icon: 'success',
                        //     confirmButtonText: 'OK'
                        // }).then(() => {
                        $('#data-absensi').DataTable().ajax.reload(); // Muat ulang DataTable
                        // });
                    } else {
                        // Swal.fire({
                        //     title: 'Gagal!',
                        //     text: data.message,
                        //     icon: 'error',
                        //     confirmButtonText: 'OK'
                        // });
                    }
                })
                .catch(xhr => {
                    console.error('Terjadi kesalahan:', xhr);
                    alert('Terjadi kesalahan saat memperbarui status.');
                });
        }
    </script>
</x-app-layout>
