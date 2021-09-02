@extends('../templates/template-admin')

@section('title', 'Detail Penjemputan')

@section('data-penjemputan', 'active')

@section('content')
<div class="container">

    <!-- DataTales Example -->
    <div class="card shadow">

        {{-- Card Header --}}
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary mb-2"><b>Detail Penjemputan</b></h4>
            @if ($penjemputan->sampai)
                <p>
                    Pada tanggal {{ $penjemputan->tanggal }} <a href="{{ url('/admin/data/user/'.$penjemputan->petugas->id) }}" class="h5 text-dark font-weight-bold">{{ $penjemputan->petugas->jenkel == 'Laki-laki' ? 'Pak' : 'Bu' }} {{ $penjemputan->petugas->nama }}</a> melakukan penjemputan mijel dari <span class="h5 font-weight-bold">{{ $penjemputan->sedekah->user->jenkel == 'Laki-laki' ? 'Pak' : 'Bu' }} {{ $penjemputan->sedekah->user->nama }}</span> pada pukul {{ $penjemputan->berangkat }} - {{ $penjemputan->sampai }} WIB.
                </p>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            @if (!$penjemputan->sampai)
                <div class="text-center">
                    <p class="lead text-gray-600 mb-3"><strong>Data tidak di temukan</strong></p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped" cellspacing="0">
                        <tr>
                            <td>Tanggal Pengajuan</td>
                            <td>:</td>
                            <td><strong>{{ $penjemputan->sedekah->tanggal }}</strong></td>
                        </tr>

                        <tr>
                            <td>Jumlah Sedekah</td>
                            <td>:</td>
                            <td><strong>{{ $penjemputan->sedekah->jumlah ? $penjemputan->sedekah->jumlah.' Liter' : '-' }}</strong></td>
                        </tr>

                        <tr>
                            <td>Harga per liter</td>
                            <td>:</td>
                            <td><strong>{{ $penjemputan->sedekah->harga ? 'Rp. '.number_format($penjemputan->sedekah->harga, 2, ",", ".") : '-' }}</strong></td>
                        </tr>

                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><strong>{{ $penjemputan->sedekah->keterangan ? $penjemputan->sedekah->keterangan : '-' }}</strong></td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><span class="badge {{ $penjemputan->sedekah->status == 'Pending' ? 'badge-danger' : ($penjemputan->sedekah->status == 'Sedang Dijemput' ? 'badge-warning' : 'badge-success') }}"><strong>{{ $penjemputan->sedekah->status }}</strong></span></td>
                        </tr>

                        <tr>
                            <td>No. Telepon</td>
                            <td>:</td>
                            <td><strong>{{ $penjemputan->sedekah->user->telp }}</strong></td>
                        </tr>

                        @if ($penjemputan->sedekah->user->email)
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><strong>{{ $penjemputan->sedekah->user->email }}</strong></td>
                            </tr>
                        @endif

                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><strong>{{ $penjemputan->sedekah->user->alamat }}</strong></td>
                        </tr>
                    </table>
                </div>
            @endif
        </div>
	</div>

	<div class="text-center mt-3 mb-5 pb-5">
		<a href="{{ url('/admin/data/penjemputan') }}" class="btn btn-primary">Kembali</a>
	</div>
    
</div>
@endsection