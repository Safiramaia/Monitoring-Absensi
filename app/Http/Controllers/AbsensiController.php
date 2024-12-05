<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('admin.data-absensi');
    }
    public function data()
{
    $absensi = Absensi::select(['id', 'user_id', 'waktu_masuk', 'waktu_keluar', 'status']); // Ambil kolom yang diperlukan

    return DataTables::of($absensi)
        ->addIndexColumn() // Tambahkan nomor baris secara otomatis
        ->addColumn('aksi', function ($row) {
            return '
                <button class="btn btn-sm btn-primary">Edit</button>
                <button class="btn btn-sm btn-danger">Hapus</button>
            '; // Kolom untuk aksi
        })
        ->rawColumns(['aksi']) // Pastikan kolom "aksi" dirender sebagai HTML
        ->make(true);
}



}
