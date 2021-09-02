@extends('../templates/template-anggota')

@section('title', 'Halaman Detail')

@section('content')
<div class="container">

    <!-- DataTales Example -->
    <div class="card shadow">

        {{-- Card Header --}}
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Detail Sedekah Anda</h4>
        </div>

        {{-- Card Body --}}
        <div class="card-body">

            @if($sedekah->user->id != auth()->user()->id)
                <div class="text-center">
                    <p class="lead text-gray-600 mb-5"><strong>Data tidak di temukan</strong></p>
                </div>
            @else
                <div class="row">                
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped" cellspacing="0">
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><strong>{{ $sedekah->tanggal }}</strong></td>
                                </tr>

                                <tr>
                                    <td>Jumlah Sedekah</td>
                                    <td>:</td>
                                    <td><strong>{{ $sedekah->jumlah ? $sedekah->jumlah.' Liter' : '-' }}</strong></td>
                                </tr>

                                <tr>
                                    <td>Harga per liter</td>
                                    <td>:</td>
                                    <td><strong>{{ $sedekah->harga ? 'Rp. '.number_format($sedekah->harga, 2, ",", ".") : '-' }}</strong></td>
                                </tr>

                                @if ($sedekah->keterangan === 'Tabung')
                                    <tr>
                                        <td>Jumlah menabung</td>
                                        <td>:</td>
                                        <td><strong>{{ 'Rp. '.number_format($sedekah->harga * $sedekah->jumlah, 2, ",", ".") }}</strong></td>
                                    </tr>
                                @endif

                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td><strong>{{ $sedekah->keterangan ? $sedekah->keterangan : '-' }}</strong></td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        @php $badge = '';
                                            if($sedekah->status == 'Pending'){
                                                $badge = 'badge-danger';
                                            }elseif($sedekah->status == 'Sedang Dijemput'){
                                                $badge = 'badge-warning';
                                            }else{
                                                $badge = 'badge-success';
                                            }
                                        @endphp
                                        <h5><strong class="badge {{ $badge }}">{{ $sedekah->status }}</strong></h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
	</div>

    @if($sedekah->user->id == auth()->user()->id && isset($sedekah->penjemputan))
        <div class="card shadow mt-4 mb-4">

            {{-- Card Header --}}
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Petugas Yang Menjemput</h4>
            </div>

            {{-- Card Body --}}
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 mb-5 text-center">
                        <img src="{{ asset('assets/img/'.$sedekah->penjemputan->petugas->foto) }}" class="card-img-bottom rounded img-fluid shadow" style="width:400px; height:280px;"  alt="Klik untuk lebih jelas">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" cellspacing="0">
                        <tr>
                            <td>Tanggal Penjemputan</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->tanggal }}</strong></td>
                        </tr>
                        <tr>
                            <td>Berangkat</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->berangkat.' WIB' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Sampai</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->sampai ? $sedekah->penjemputan->sampai.' WIB' : '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama Petugas</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->petugas->nama }}</strong></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->petugas->jenkel }}</strong></td>
                        </tr>
                        <tr>
                            <td>No. Telepon</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->petugas->telp }}</strong></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->petugas->email ? $sedekah->penjemputan->petugas->email : '-' }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

	<div class="text-center mt-3 mb-5 pb-5">
		<a href="{{ url('/anggota') }}" class="btn btn-primary">Kembali</a>
	</div>
    
</div>
@endsection