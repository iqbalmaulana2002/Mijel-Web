@extends('../templates/template-'.$user->level)

@section('title', 'Halaman Edit Profile')

@section('content')
<div class="container">

	<div class="row justify-content-center">
		<div class="col-md">
			<h3 class="mb-4"><i class="fas fa-edit"></i> Form Edit Profile</h3>
			<form method="POST" action="{{url('/'.auth()->user()->level.'/edit-profile')}}" enctype="multipart/form-data">
				@csrf
                @method('PATCH')

				<div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ $user->username }}">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ $user->nama }}">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="no_telepon">No. Telepon</label>
                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" id="no_telepon" value="{{ $user->telp }}">
                    @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <small class="text-gray-600">( optional )</small></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $user->email }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="foto">Foto <small class="text-gray-600">( optional )</small></label>
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <img src="{{ asset('assets/img/'.$user->foto) }}" class="img-thumbnail" width="260px">
                        </div>
                        <div class="col-md-8">
                            <input type="file" class="form-control mt-2 @error('foto')is-invalid @enderror" id="foto" name="foto">
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="text-dark">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" cols="20" rows="4" placeholder="Masukan Alamat Lengkap Anda">{{ $user->alamat }}</textarea>
                    @error('alamat')<div class="text text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group row float-right">
                    <div class="col-md mt-4 mb-5">
                        <a href="{{url('/'.$user->level.'/profile')}}" class="btn btn-outline-success btn-light">Kembali</a>
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </div>

			</form>
		</div>
	</div>

</div>
@endsection