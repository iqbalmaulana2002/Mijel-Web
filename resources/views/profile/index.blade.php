@extends('../templates/template-'.$user->level)

@section('title', 'Halaman Profile')

@section('content')
<div class="container">

    @if (session('pesan'))
		<div class="alert alert-success">
			{{ session('pesan') }}
		</div>
	@endif

    <!-- DataTales Example -->
    <div class="card shadow">

        {{-- Card Header --}}
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Profile Anda</h5>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-5 text-center">
                    {{-- <a href="{{asset('img/'.$user->foto)}}" target="_blank"> --}}
                        <img src="{{asset('assets/img/'.$user->foto)}}" class="card-img-bottom rounded img-fluid shadow" style="width:400px; height:280px;">
                    {{-- </a> --}}
                </div>
            </div>

            <div class="row">                
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped" cellspacing="0">
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td><strong>{{ $user->username }}</strong></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td><strong>{{ $user->nik }}</strong></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><strong>{{ $user->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><strong>{{ $user->jenkel }}</strong></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>:</td>
                                <td><strong>{{ $user->telp }}</strong></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><strong>{{ $user->email ? $user->email : '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><strong>{{ $user->alamat }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<div class="text-center mt-3 mb-5 pb-5">
		<a href="{{ url('/'.$user->level) }}" class="btn btn-primary">Kembali</a>
		<a href="{{ url('/'.$user->level.'/edit-profile') }}" class="btn btn-warning mt-1 mt-sm-0">Edit Profile</a>
	</div>
    
</div>
@endsection