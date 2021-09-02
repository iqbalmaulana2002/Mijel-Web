@extends('../templates/template-admin')

@section('title', 'Add User')

@section('tambah', 'active')

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 mx-auto" style="width: 90%">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="text-gray-800 mb-5">Form Tambah User Baru</h4>
                        </div>
                        <form class="user" method="POST" action="{{ url('/admin/register') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="nik" class="text-dark">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik" placeholder="Masukan NIK Anda" value="{{ old('nik') }}" >
                                    @error('nik')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nama" class="text-dark">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukan Nama Anda" value="{{ old('nama') }}" >
                                    @error('nama')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-dark d-block">Jenis Kelamin</label>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="radio" class="form-check-input ml-2 @error('jenis_kelamin') is-invalid @enderror" id="laki-laki" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} >
                                            <label for="laki-laki" class="ml-4">Laki-laki</label>
                                        </div>

                                        <div class="col-md">
                                            <input type="radio" class="form-check-input ml-2 @error('jenis_kelamin') is-invalid @enderror" id="perempuan" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} >
                                            <label for="perempuan" class="ml-4">Perempuan</label>
                                        </div>
                                    </div>

                                    @error('jenis_kelamin') <div class="text text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_telepon" class="text-dark">No. Telepon</label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" id="no_telepon" placeholder="Masukan No. Telepon Anda" value="{{ old('no_telepon') }}" >
                                    @error('no_telepon')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="text-dark">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Masukan Username Anda" value="{{ old('username') }}" >
                                @error('username')<div class="text text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="password" class="text-dark">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukan Password Anda" >
                                    @error('password')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="konfirmasi_password" class="text-dark">Konfirmasi Password</label>
                                    <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" name="konfirmasi_password" id="konfirmasi_password" placeholder="Masukan Konfirmasi Password Anda" >
                                    @error('konfirmasi_password')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="level" class="text-dark">Level</label>
                                <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" >
                                    <option value="" disabled selected>-- Pilih Level --</option>
                                    <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="petugas" {{ old('level') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="anggota" {{ old('level') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                </select>
                                @error('level')<div class="text text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat" class="text-dark">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" cols="20" rows="4" placeholder="Masukan Alamat Lengkap Anda">{{ old('alamat') }}</textarea>
                                @error('alamat')<div class="text text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-7">
                                    <button type="submit" class="btn btn-success btn-block font-weight-bold mt-3">Registrasikan Akun</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection