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
    public function indexAdmin()
    {
        return view('admin.data-absensi');
    }

    // AbsensiController.php

    public function data()
    {
        $absensi = Absensi::with('user')->select(['id', 'user_id', 'waktu_masuk', 'status', 'foto_pagar_depan', 'foto_ruang_tengah', 'foto_lorong_lab', 'foto_pagar_belakang']);

        return DataTables::of($absensi)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->user ? $row->user->name : 'Tidak Diketahui';
            })
            ->addColumn('aksi', function ($row) {
                return "<form action=\"{{ route('absensi.destroy', $row->id) }}\" method=\"POST\" class=\"inline\">" .
                    "@csrf" .
                    "@method('DELETE')" . // Menggunakan tanda kutip tunggal
                    "<button type=\"submit\" class=\"px-3 py-1 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg\">Hapus</button>" .
                    "</form>";
            })
            ->rawColumns(['aksi'])
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
