<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('landingPage');
    }

    public function viewRegister()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|unique:users',
            'nama' => 'required|min:2|max:50',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required|numeric|unique:users,telp',
            'username' => 'required|min:4|max:50|unique:users',
            'password' => 'required|min:5|max:255|same:konfirmasi_password',
            'konfirmasi_password' => 'required|max:255|same:password',
            'alamat' => 'required|max:255',
        ]);

        $foto = ($request->jenis_kelamin == 'Perempuan') ? 'perempuan.svg' : 'laki-laki.svg';
        $qr_code = 'qrCode-'.time().'.svg';

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
            'level' => 'anggota',
            'is_active' => 1
        ])->id;

        \App\Tabungan::create([ 'user_id' => $user_id ]);

        // Generate QR Code
        QrCode::size(400)->generate('http://127.0.0.1:8000/petugas/sedekah/'.$request->nik, public_path('assets/qr_code/'.$qr_code));

        return redirect('/login')->with('pesan', 'Anda Berhasil Membuat Akun, Silahkan Login Disini');
    }

    public function viewLogin()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        // Cek username dan password
        if (Auth::attempt($request->only('username', 'password'))) {

            if (auth()->user()->is_active === 0) {
                Auth::logout();
                return redirect('/login')->with('pesanError', 'Akun anda sudah di nonaktiifkan');
            }

            $request->session()->regenerate();
            // Cek Level User nya
            if (auth()->user()->level == 'admin') {
                return redirect()->intended('/admin');
            } elseif (auth()->user()->level == 'petugas') {
                return redirect()->intended('/petugas');
            } else {
                return redirect()->intended('/anggota');
            }
            
        } else {
            return redirect('/login')->with('pesanError', 'Username atau Password yang anda masukkan salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('pesan', 'Anda berhasil Logout');
    }
}
