<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sedekah;
use App\Tabungan;
use App\Penarikan;
use App\Mail\PenjemputanMail;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class AnggotaController extends Controller
{

    public function index()
    {
        $sedekah = Sedekah::with('penjemputan:sedekah_id,tanggal')->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('anggota/index', compact('sedekah'));
    }

    // public function tabungan()
    // {
    //     $user_id = auth()->user()->id;
    //     $sedekah = Sedekah::with('penjemputan:sedekah_id,tanggal') 
    //                     ->where('user_id', $user_id)
    //                     ->where('status', 'Selesai')
    //                     ->where('keterangan', 'Tabung')
    //                     ->orderBy('id', 'desc')
    //                     ->get();

    //     $tabungan = Tabungan::where('user_id', $user_id)->first();

    //     return view('anggota/tabungan', compact('sedekah', 'tabungan'));
    // }

    public function penarikan()
    {
        $tabungan = Tabungan::where('user_id', auth()->user()->id)->first();
        $penarikan = Penarikan::where('tabungan_id', $tabungan->id)->orderBy('id', 'desc')->get();
        return view('anggota/riwayatPenarikan', compact('penarikan', 'tabungan'));
    }

    public function store()
    {
        $is_req = Sedekah::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();

        if($is_req && $is_req->status !== 'Selesai') {
            return redirect('/anggota')->with('pesan', '<div class="alert alert-danger">Mohon maaf anda hanya bisa mengajukan penjemputan satu kali, mohon tunggu sampai petugas kami menerima mijel anda</div>');
        }

        Sedekah::create([
            'user_id' => auth()->user()->id,
            'tanggal' => date('Y-m-d'),
            'status' => 'Pending'
        ]);

        // Notifikasi Sms
        // Nexmo::message()->send([
        //     'to' => '6285892399827',
        //     'from' => '6281219451912',
        //     'text' => 'OK'
        // ]);

        // Notifikasi Email
        // $petugasEmail = User::where('level', '!=', 'anggota')->get();
        // $data = [
        //     'namaUser' => auth()->user()->nama,
        //     'alamatUser' => auth()->user()->alamat,
        // ];
        // foreach ($petugasEmail as $petugas) {
        //     if ($petugas->email) {
        //         array_push($data, $petugas->nama, $petugas->level);
        //         Mail::to($petugas->email)->send(new PenjemputanMail($data));
        //         array_pop($data);
        //         array_pop($data);
        //     }
        // }
        return redirect('/anggota')->with('pesan', '<div class="alert alert-success">Permintaan berhasil dikirim, mijel anda akan dijemput oleh petugas kami segera</div>');
    }

    public function show(Sedekah $sedekah)
    {
        return view('anggota/detail', compact('sedekah'));
    }

    public function tarikTabungan(Request $request)
    {
        $user_id = auth()->user()->id;
        $tabungan = Tabungan::where('user_id', $user_id)->first();
        $penarikan = Penarikan::where('tabungan_id', $tabungan->id)->get()->last();

        if ($penarikan && $penarikan->is_transfer === 0) {
            return redirect('/anggota/penarikan')->with('pesan', '<div class="alert alert-danger">Gagal, anda tidak dapat melakukan lebih dari satu penarikan secara bersamaan</div>');
        } elseif ($request->jumlah < 60000) {
            return redirect('/anggota/penarikan')->with('pesan', '<div class="alert alert-danger">Gagal, penarikan tabungan minimal Rp. 60.000,00</div>');
        } elseif ($tabungan->saldo < $request->jumlah) {
            return redirect('/anggota/penarikan')->with('pesan', '<div class="alert alert-danger">Gagal, saldo anda tidak cukup</div>');
        }

        Penarikan::create([
            'tabungan_id' => $tabungan->id,
            'jumlah' => $request->jumlah,
            'is_transfer' => 0
        ]);

        return redirect('/anggota/penarikan')->with('pesan', '<div class="alert alert-success">Berhasil, permintaan anda sedang kami proses</div>');
    }

}
