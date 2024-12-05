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
        <div class="overflow-x-auto">
            <table id="data-absensi" class="table table-striped nowrap w-full">
                <thead>
                    <tr class="text-white bg-gray-800">
                        <th class="text-center">No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Status Kehadiran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>

    <!-- Script DataTables -->
    <script>
       $('#data-absensi').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("admin.data-absensi.data") }}',
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'user_id', name: 'user_id' },
        { data: 'waktu_masuk', name: 'waktu_masuk' },
        { data: 'waktu_keluar', name: 'waktu_keluar' },
        { data: 'status', name: 'status' },
        { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
    ]
});

       
    </script>
</x-app-layout>