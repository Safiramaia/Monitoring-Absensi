<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Absensi</h2>
    </x-slot>

    <main class="px-10 mt-10">

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

        function updateStatus(id, status) {
            fetch("{{ route('admin.absensi.update-status') }}", {
                method: 'POST',
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
                if (data.success) {
                    alert('Status berhasil diperbarui');
                    $('#data-absensi').DataTable().ajax.reload(); // Refresh DataTable
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
                alert('Terjadi kesalahan saat memperbarui status.');
            });
        }
    </script>
</x-app-layout>