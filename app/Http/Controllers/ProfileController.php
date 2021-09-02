<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        return view('profile/index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::find(auth()->user()->id);
        return view('profile/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = auth()->user()->id;
        $is_email = ($request->email) ? 'email|max:100|unique:users,email,'.$id.',id' : '';
        $request->validate([
            'username' => 'required|min:4|max:50|unique:users,username,'.$id.',id',
            'nama' => 'required|min:2|max:50',
            'no_telepon' => 'required|numeric|unique:users,telp,'.$id.',id',
            'email' => $is_email,
            'foto' => 'mimes:jpg,png,jpeg|max:3072',
            'alamat' => 'required|max:255'
        ]);

        $foto = ($request->foto) ? time().'-img-profile.'.$request->foto->extension() : auth()->user()->foto;

        User::where('id', $id)->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'telp' => $request->no_telepon,
            'foto' => $foto,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        // Mengecek jika ada foto yang diupload, maka lakukan upload
        if ($request->foto) {
            $request->foto->move(public_path('assets/img'), $foto);
        }

        return redirect('/'.auth()->user()->level.'/profile')->with('pesan', 'Profile Anda Berhasil Di Edit');
    }
}
