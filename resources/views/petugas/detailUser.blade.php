@extends('../templates/template-petugas')

@section('title', 'Detail Anggota')

@section('data-users', 'active')

@section('data-anggota', 'active')

@section('content')
    <div class="container">

    <!-- DataTales Example -->
    <div class="card shadow">

        {{-- Card Header --}}
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Detail Anggota</h5>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            @if ($user->level != 'anggota' || $user->status == 'Tidak Aktif')
                <div class="text-center">
                    <p class="lead text-gray-600 mb-3"><strong>Data tidak di temukan</strong></p>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-lg-6 mb-5 text-center">
                        <a href="{{ asset('assets/img/'.$user->foto) }}" target="_blank">
                            <img src="{{ asset('assets/img/'.$user->foto) }}" class="card-img-bottom rounded img-fluid shadow" style="width:400px; height:280px;">
                        </a>
                    </div>
                </div>

                <div class="row">                
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped" cellspacing="0">
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
                                    <td>No. Telepon</td>
                                    <td>:</td>
                                    <td><strong>{{ $user->telp }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td><strong>{{ $user->email ? $user->email : '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td>QR Code</td>
                                    <td>:</td>
                                    <td>
                                        <img src="{{ asset('assets/qr_code/'.$user->qr_code) }}" alt="QR Code" style="width: 140px; height: 140px;" class="img-fluid">
                                    </td>
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
            @endif
        </div>
	</div>

	<div class="text-center mt-3 mb-5 pb-5">
		<a href="{{ url('/petugas/data/anggota') }}" class="btn btn-primary">Kembali</a>
        @if ($user->status == 'Aktif')
            @if ($user->level == 'anggota')
                <a href="{{ url('/admin/download/qr-code/'.$user->qr_code) }}" class="btn btn-success font-weight-bold ml-1 mt-1 mt-sm-0">
                    <i class="fas fa-download"></i> <span class="d-none d-md-inline">Download </span>QR Code
                </a>
            @endif
        @endif
	</div>
    
</div>
@endsection