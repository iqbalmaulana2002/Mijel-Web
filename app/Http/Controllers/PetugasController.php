<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sedekah;
use App\Tabungan;
use App\Penjemputan;
use App\User;

class PetugasController extends Controller
{

    public function index()
    {
        $sedekah = Sedekah::with('user')->orderBy('id', 'desc')->get();
        $is_jemput = Penjemputan::with('sedekah')->where('petugas_id', auth()->user()->id)->orderBy('id', 'desc')->first();
        return view('petugas/index', compact('sedekah', 'is_jemput'));
    }

    public function dataAnggota()
    {
        $anggota = User::where('level', 'anggota')->where('is_active', 1)->get();
        return view('petugas/dataAnggota', compact('anggota'));
    }

    public function dataPenjemputanSaya()
    {
        $sedekah_selesai = Sedekah::select('id')->where('status', 'Selesai')->get();
        $sedekah_id = [];
        foreach ($sedekah_selesai as $ss) {
            array_push($sedekah_id, $ss->id);
        }

        $penjemputan = Penjemputan::with(['sedekah', 'sedekah.user:id,nama'])
                                ->whereIn('sedekah_id', $sedekah_id)
                                ->where('petugas_id', auth()->user()->id)
                                ->orderBy('id', 'desc')
                                ->get();

        return view('petugas/dataPenjemputan', compact('penjemputan'));
    }

    public function store($id)
    {
        $is_jemput = Sedekah::find($id);
        if ($is_jemput->status === 'Sedang Dijemput') {
            return redirect('/petugas')->with('pesan', '<div class="alert alert-danger">Maaf, Mijel ini telah dijemput oleh petugas lain, silahkan anda cari mijel lain yang belum dijemput</div>');
        } elseif ($is_jemput->status === 'Selesai') {
            return redirect('/petugas')->with('pesan', '<div class="alert alert-danger">Maaf, Mijel ini telah diterima, silahkan anda cari mijel lain yang belum dijemput</div>');
        }

        Penjemputan::create([
            'petugas_id' => auth()->user()->id,
            'sedekah_id' => $id,
            'tanggal' => date('Y-m-d'),
            'berangkat' => date('H:i:s')
        ]);

        Sedekah::where('id', $id)->update([ 'status' => 'Sedang Dijemput' ]);
        
        return redirect('/petugas')->with('pesan', '<div class="alert alert-success">Berhasil, silahkan jemput mijel yang anda pilih</div>');
    }

    public function show(Sedekah $sedekah)
    {
        $is_jemput = Penjemputan::with('sedekah')->where('petugas_id', auth()->user()->id)->orderBy('id', 'desc')->first();
        return view('petugas/detail', compact('sedekah', 'is_jemput'));
    }

    public function detailPenjemputan(Penjemputan $penjemputan)
    {
        return view('petugas/detailPenjemputan', compact('penjemputan'));
    }

    public function downloadQrCode($qr_code)
    {
        return response()->download(public_path('assets/qr_code/'.$qr_code));
    }

    public function update(Request $request, Sedekah $sedekah)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'keterangan' => 'required|min:5|max:6',
        ]);

        Sedekah::where('id', $sedekah->id)->update([
            'status' => 'Selesai',
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->keterangan === 'Tabung') {
            $total_tabungan = Tabungan::where('user_id', $sedekah->user_id)->first()->total;
            $total_tabungan += (intval($request->jumlah * $request->harga));
            Tabungan::where('user_id', $sedekah->user_id)->update(['saldo' => $total_tabungan]);
        }

        Penjemputan::where('sedekah_id', $sedekah->id)->update([ 'sampai' => date('H:i:s') ]);

        return redirect('/petugas')->with('pesan', '<div class="alert alert-success">Selamat, mijel berhasil diterima</div>');
    }

}
