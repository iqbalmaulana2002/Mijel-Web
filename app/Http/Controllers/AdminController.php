<?php

namespace App\Http\Controllers;

use App\User;
use App\Sedekah;
use App\Tabungan;
use App\Penarikan;
use App\Penjemputan;
use Illuminate\Http\Request;
use App\Exports\SedekahExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{

    public function index()
    {
        // Tampilkan semua data sedekah dan urutkan id nya dari yang terbesar ke yang terkecil
        $sedekah = Sedekah::with('user:id,nik,nama')->orderBy('id', 'desc')->get();
        return view('admin/index', compact('sedekah'));
    }

    public function dataPetugas()
    {
        // Tampilkan semua data user yang levelnya bukan anggota
        $petugas = User::where('level', '!=', 'anggota')->get();
        return view('admin/dataPetugas', compact('petugas'));
    }

    public function dataAnggota()
    {
        // Tampilkan semua data user yang levelnya anggota
        $anggota = User::with('sedekah:user_id,tanggal')->where('level', 'anggota')->get();
        return view('admin/dataAnggota', compact('anggota'));
    }

    public function listPenarikan()
    {
        // Tampilkan semua data penarikan dan urutkan id nya dari yang terbesar ke yang terkecil
        $list_penarikan = Penarikan::orderBy('id', 'desc')->get();
        return view('admin/listPenarikan', compact('list_penarikan'));
    }

    public function dataPenjemputan()
    {
        // Mengambil id semua sedekah yang statusnya selesai
        $sedekah_selesai = Sedekah::select('id')->where('status', 'Selesai')->get();
        $sedekah_id = [];
        foreach ($sedekah_selesai as $ss) {
            array_push($sedekah_id, $ss->id);
        }

        // Mengambil semua data penjemputan yang sedekah_id nya sama dengan $sedekah_id
        $penjemputan = Penjemputan::with(['sedekah:id,tanggal', 'petugas:id,nik,nama'])->whereIn('sedekah_id', $sedekah_id)->orderBy('id', 'desc')->get();
        return view('admin/dataPenjemputan', compact('penjemputan'));
    }

    public function viewRegister()
    {
        // Tampilkan form tambah user baru
        return view('admin/register');
    }

    public function register(Request $request)
    {
        // Validasi Inputan
        $request->validate([
            'nik' => 'required|numeric|unique:users',
            'nama' => 'required|min:2|max:50',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required|numeric|unique:users,telp',
            'username' => 'required|min:4|max:50|unique:users',
            'password' => 'required|min:5|max:255|same:konfirmasi_password',
            'konfirmasi_password' => 'required|max:255|same:password',
            'level' => 'required|min:5|max:7',
            'alamat' => 'required|max:255'
        ]);

        $foto = $request->jenis_kelamin == 'Perempuan' ? 'perempuan.svg' : 'laki-laki.svg';
        $qr_code = $request->level == 'anggota' ? 'qrCode-'.time().'.svg' : null;

        // Create User Baru
        $user_id = User::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->no_telepon,
            'jenkel' => $request->jenis_kelamin,
            'foto' => $foto,
            'qr_code' => $qr_code,
            'alamat' => $request->alamat,
            'level' => $request->level,
            'is_active' => 1
        ])->id;

        // Create tabungan untuk user baru yang levelnya anggota
        if ($request->level === 'anggota') {
            Tabungan::create([ 'user_id' => $user_id ]);

            // Generate QR Code
            QrCode::size(400)->generate('http://127.0.0.1:8000/petugas/sedekah/'.$request->nik, public_path('assets/qr_code/'.$qr_code));
        }


        $level = $request->level == 'anggota' ? $request->level : 'petugas';
        return redirect('/admin/data/'.$level)->with('pesan', '<div class="alert alert-success">User baru berhasil ditambahkan</div>');
    }

    public function show(Sedekah $sedekah)
    {
        // Tampilkan halaman detail sedekah
        return view('admin/detail', compact('sedekah'));
    }

    public function detailUser(User $user)
    {
        // Tampilkan halaman detail admin/petugas/anggota
        return view('admin/detailUser', compact('user'));
    }

    public function detailPenjemputan(Penjemputan $penjemputan)
    {
        // Tampilkan halaman detail penjemputan petugas
        return view('admin/detailPenjemputan', compact('penjemputan'));
    }

    public function downloadQrCode($qr_code)
    {
        // Download qr_code
        return response()->download(public_path('assets/qr_code/'.$qr_code));
    }

    public function konfirmasiPenarikanTabungan(Penarikan $penarikan)
    {
        // Mengurangi total tabungan user dengan jumlah penarikannya
        $total_tabungan = Tabungan::where('id', $penarikan->tabungan_id)->first()->total;
        $sisa_tabungan = $total_tabungan - $penarikan->jumlah;
        
        // Update total tabungan
        Tabungan::where('id', $penarikan->tabungan_id)->update(['total' => $sisa_tabungan]);

        // Update status penarikan menjadi selesai
        Penarikan::where('id', $penarikan->id)->update(['is_transfer' => 1]);

        return redirect('/admin/list-penarikan')->with('pesan', '<div class="alert alert-success">Konfirmasi Berhasil</div>');
    }

    public function aktifkanAtauNonaktifkanUser(User $user)
    {
        $level = $user->level == 'anggota' ? 'anggota' : 'petugas';

        $pesan = '<div class="alert alert-success">Berhasil, '.$level.' ini telah di ';

        // Cek apakah usernya Aktif jika aktif akan dinonaktifkan dan sebaliknya
        if ($user->is_active === 1) {
            User::where('id', $user->id)->update(['is_active' => 0]);
            $pesan .= 'nonaktifkan</div>';
        } else {
            User::where('id', $user->id)->update(['is_active' => 1]);
            $pesan .= 'aktifkan</div>';
        }

        return redirect('/admin/data/'.$level)->with('pesan', $pesan);
    }

    public function sedekahExport(Request $request)
    {
        $nik = $request->nik;
        $awal = $request->tgl_awal;
        $akhir = $request->tgl_akhir;

        // Jika kosong semua
        if (!$nik && !$awal && !$akhir) {
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->get();

        // Jika niknya ada dan yang lainnya kosong
        } elseif ($nik && !$awal && !$akhir) {
            $user = User::where('nik', $nik)->first();
            if (!$user) {
                return redirect('/admin')->with('pesan', '<div class="alert alert-danger">User dengan NIK: '.$nik.' tidak ditemukan</div>');
            }
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->where('user_id', $user->id)
                            ->get();

        // Jika tanggal awalnya ada dan yang lainnya kosong
        } elseif (!$nik && $awal && !$akhir) {
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->whereDate('tanggal', '>=', $awal)
                            ->get();

        // Jika tanggal akhirnya ada dan yang lainnya kosong
        } elseif (!$nik && !$awal && $akhir) {
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->whereDate('tanggal', '<=', $akhir)
                            ->get();

        // Jika nik dan tanggal awalnya ada dan tanggal akhirnya tidak ada
        } elseif ($nik && $awal && !$akhir) {
            $user = User::where('nik', $nik)->first();
            if (!$user) {
                return redirect('/admin')->with('pesan', '<div class="alert alert-danger">User dengan NIK: '.$nik.' tidak ditemukan</div>');
            }
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->where('user_id', $user->id)
                            ->whereDate('tanggal', '>=', $awal)
                            ->get();

        // Jika nik dan tanggal akhirnya ada dan tanggal awalnya tidak ada
        } elseif ($nik && !$awal && $akhir) {
            $user = User::where('nik', $nik)->first();
            if (!$user) {
                return redirect('/admin')->with('pesan', '<div class="alert alert-danger">User dengan NIK: '.$nik.' tidak ditemukan</div>');
            }
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->where('user_id', $user->id)
                            ->whereDate('tanggal', '<=', $akhir)
                            ->get();

        // Jika tanggal awal dan tanggal akhirnya ada dan niknya tidak ada
        } elseif (!$nik && $awal && $akhir) {
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->whereBetween('tanggal', [$awal, $akhir])
                            ->get();
            dd($sedekah);

        // Jika semuanya ada
        } else {
            $user = User::where('nik', $nik)->first();
            if (!$user) {
                return redirect('/admin')->with('pesan', '<div class="alert alert-danger">User dengan NIK: '.$nik.' tidak ditemukan</div>');
            }
            $sedekah = Sedekah::with([
                                'user:id,nik,nama,jenkel,telp,alamat',
                                'penjemputan:sedekah_id,petugas_id,tanggal,berangkat,sampai',
                                'penjemputan.petugas:id,nama,telp'
                            ])
                            ->where('status', 'Selesai')
                            ->where('user_id', $user->id)
                            ->whereBetween('tanggal', [$awal, $akhir])
                            ->get();
        }

        if ($sedekah->isEmpty()) {
            return redirect('/admin/cetak/data/sedekah')->with('pesan', 'Data tidak ada, pastikan data yang anda masukan benar');
        }

        return new SedekahExport($sedekah);
    }

}
