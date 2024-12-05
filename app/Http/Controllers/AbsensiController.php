<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Absensi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
=======
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
>>>>>>> 265ba4e75b1291db4c2d1b59534719822ae27df9

class AbsensiController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
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



=======
        // Ambil absensi berdasarkan user yang sedang login
        $absensis = Absensi::where('user_id', Auth::id())->get();

        return view('absensi.index', compact('absensis'));
    }

    public function create()
    {
        return view('absensi.add-absensi');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'waktu_masuk' => 'required|date',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_pagar_depan' => 'required|string',
            'foto_lorong_lab' => 'required|string',
            'foto_ruang_tengah' => 'required|string',
            'foto_pagar_belakang' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fungsi untuk menyimpan gambar dari data URL base64 dan membuat direktori jika belum ada
        function simpanGambarBase64($dataUrl, $path)
        {
            $fullPath = public_path($path);

            // Buat direktori jika belum ada
            $directory = dirname($fullPath);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            list($type, $data) = explode(';', $dataUrl);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents($fullPath, $data);

            return $path;
        }

        // Menyimpan file gambar dari data URL
        $fotoPagarDepanPath = 'uploads/absensi/pagar_depan/' . uniqid() . '.jpg';
        $fotoLorongLabPath = 'uploads/absensi/lorong_lab/' . uniqid() . '.jpg';
        $fotoRuangTengahPath = 'uploads/absensi/ruang_tengah/' . uniqid() . '.jpg';
        $fotoPagarBelakangPath = 'uploads/absensi/pagar_belakang/' . uniqid() . '.jpg';

        simpanGambarBase64($request->foto_pagar_depan, $fotoPagarDepanPath);
        simpanGambarBase64($request->foto_lorong_lab, $fotoLorongLabPath);
        simpanGambarBase64($request->foto_ruang_tengah, $fotoRuangTengahPath);
        simpanGambarBase64($request->foto_pagar_belakang, $fotoPagarBelakangPath);

        // Menyimpan data absensi ke database
        Absensi::create([
            'user_id' => Auth::id(),
            'waktu_masuk' => $request->waktu_masuk,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto_pagar_depan' => $fotoPagarDepanPath,
            'foto_lorong_lab' => $fotoLorongLabPath,
            'foto_ruang_tengah' => $fotoRuangTengahPath,
            'foto_pagar_belakang' => $fotoPagarBelakangPath,
            'status' => 'belum diverifikasi',
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil disimpan!');
    }
>>>>>>> 265ba4e75b1291db4c2d1b59534719822ae27df9
}

