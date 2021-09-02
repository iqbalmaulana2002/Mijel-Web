@extends('../templates/template-admin')

@section('title', 'Detail User')

@section('data-users', 'active')

@section('content')
    <div class="container">

    <!-- DataTales Example -->
    <div class="card shadow">

        {{-- Card Header --}}
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Detail {{ Str::ucfirst($user->level) }}</h5>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
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
                                <td>Bergabung Pada</td>
                                <td>:</td>
                                <td><strong>{{ explode('-', explode(' ', $user->created_at)[0])[0] }}</strong></td>
                            </tr>

                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><strong>{{ $user->jenkel }}</strong></td>
                            </tr>

                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td><strong>{{ $user->username }}</strong></td>
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

                            @if ($user->qr_code)
                                <tr>
                                    <td>QR Code</td>
                                    <td>:</td>
                                    <td>
                                        <img src="{{ asset('assets/qr_code/'.$user->qr_code) }}" alt="QR Code" style="width: 140px; height: 140px;" class="img-fluid">
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>Level</td>
                                <td>:</td>
                                <td><strong>{{ $user->level }}</strong></td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    {!! $user->is_active ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Tidak Aktif</span>" !!}
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
        </div>
	</div>

	<div class="text-center mt-3 mb-5 pb-5" >
        @php $level = $user->level == 'anggota' ? $user->level : 'petugas';  @endphp
		<a href="{{ url('/admin/data/'.$level) }}" class="btn btn-primary">Kembali</a>

        @if ($level == 'anggota')
            <a href="{{ url('/admin/download/qr-code/'.$user->qr_code) }}" class="btn btn-info font-weight-bold ml-1">
                <i class="fas fa-download"></i> <span class="d-none d-md-inline">Download QR Code</span>
            </a>
        @endif

        <form action="{{ url('/admin/data/user/'.$user->id) }}" method="post" class="d-inline">
            @csrf
            @method('patch')
            
            @if ($user->is_active === 1)
                <button type="submit" class="btn btn-danger font-weight-bold ml-1" onclick="return confirm('Yakin ingin menonaktifkan user ini?');">
                    <i class="fas fa-user-alt-slash"></i> <span class="d-none d-md-inline">Nonaktifkan</span>
                </button>
            @else
                <button type="submit" class="btn btn-success font-weight-bold ml-1" onclick="return confirm('Yakin ingin mengaktifkan user ini lagi?');">
                    <i class="fas fa-user-check"></i> <span class="d-none d-md-inline">Aktifkan</span>
                </button>
            @endif
        </form>
	</div>
    
</div>
@endsection