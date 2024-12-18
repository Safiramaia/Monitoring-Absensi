<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        // Ambil absensi berdasarkan user yang sedang login
        $absensis = Absensi::where('user_id', Auth::id())->get();

        return view('absensi.index', compact('absensis'));
    }

    public function create()
    {
        return view('absensi.add-absensi');
    }



    // Fungsi untuk menyimpan gambar dari data URL base64 dan membuat direktori jika belum ada

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [

            'foto_pagar_depan' => 'required|string',
            'foto_lorong_lab' => 'required|string',
            'foto_ruang_tengah' => 'required|string',
            'foto_pagar_belakang' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fungsi untuk menyimpan gambar dari data URL base64
        function simpanGambarBase64($dataUrl, $path)
        {
            $fullPath = public_path($path);
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
            'foto_pagar_depan' => $fotoPagarDepanPath,
            'foto_lorong_lab' => $fotoLorongLabPath,
            'foto_ruang_tengah' => $fotoRuangTengahPath,
            'foto_pagar_belakang' => $fotoPagarBelakangPath,
            'status' => 'belum diverifikasi',
            'tanggal' => now(),
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil disimpan!');
    }
    public function indexAdmin()
    {
        return view('admin.data-absensi');
    }

    // AbsensiController.php

    public function data()
    {
        $absensi = Absensi::with('user')->select([
            'id',
            'user_id',
            'tanggal',
            'status',
            'foto_pagar_depan',
            'foto_ruang_tengah',
            'foto_lorong_lab',
            'foto_pagar_belakang'
        ]);

        return DataTables::of($absensi)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->user ? $row->user->name : 'Tidak Diketahui';
            })
            ->addColumn('tanggal', function ($row) {
                return $row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '-';
            })
            ->addColumn('foto_pagar_depan', function ($row) {
                return $row->foto_pagar_depan
                    ? "<img src='" . asset($row->foto_pagar_depan) . "' alt='Foto Pagar Depan' class='img-fluid' width='100'>"
                    : '-';
            })
            ->addColumn('foto_lorong_lab', function ($row) {
                return $row->foto_lorong_lab
                    ? "<img src='" . asset($row->foto_lorong_lab) . "' alt='Foto Lorong Lab' class='img-fluid' width='100'>"
                    : '-';
            })
            ->addColumn('foto_ruang_tengah', function ($row) {
                return $row->foto_ruang_tengah
                    ? "<img src='" . asset($row->foto_ruang_tengah) . "' alt='Foto Ruang Tengah' class='img-fluid' width='100'>"
                    : '-';
            })
            ->addColumn('foto_pagar_belakang', function ($row) {
                return $row->foto_pagar_belakang
                    ? "<img src='" . asset($row->foto_pagar_belakang) . "' alt='Foto Pagar Belakang' class='img-fluid' width='100'>"
                    : '-';
            })
            ->addColumn('aksi', function ($row) {
                return "<form action='" . route('absensi.destroy', $row->id) . "' method='POST' class='inline'>" .
                    "<input type='hidden' name='_token' value='" . csrf_token() . "'>" .
                    "<input type='hidden' name='_method' value='DELETE'>" .
                    "<button type='submit' class='px-3 py-1 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg'>Hapus</button>" .
                    "</form>";
            })
            ->rawColumns([
                'foto_pagar_depan',
                'foto_lorong_lab',
                'foto_ruang_tengah',
                'foto_pagar_belakang',
                'aksi'
            ])
            ->make(true);
    }


    public function updateStatus(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'id' => 'required',
        //     'status' => 'required',
        // ]);

        // Cari data absensi berdasarkan ID
        $absensi = Absensi::find($request->id);

        if ($absensi) {
            // Perbarui status absensi
            if ($request->status == 'verifikasi') {
                $absensi->status = 'diverifikasi';
            } else {
                $absensi->status = 'tidak valid';
            }
            $absensi->save();  // Simpan perubahan

            // Respons sukses
            return response()->json(['success' => true]);
        }

        // // Jika absensi tidak ditemukan
        return response()->json([
            'success' => false,
        ]);
    }
}
