@extends('../templates/template-petugas')

@section('title', 'Detail Sedekah')

@section('dashboard', 'active')

@section('content')
<div class="container">

    <!-- DataTales Example -->
    <div class="card shadow">

        {{-- Card Header --}}
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary"><b>Detail Sedekah</b></h4>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-5 text-center">
                    <img src="{{ asset('assets/img/'.$sedekah->user->foto) }}" class="card-img-bottom rounded img-fluid shadow" style="width:400px; height:280px;" alt="Foto">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" cellspacing="0">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><strong>{{ $sedekah->user->nama }}</strong></td>
                    </tr>

                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><strong>{{ $sedekah->user->jenkel }}</strong></td>
                    </tr>

                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td><strong>{{ $sedekah->user->telp }}</strong></td>
                    </tr>

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

                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td><strong>{{ $sedekah->keterangan ? $sedekah->keterangan : '-' }}</strong></td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td>
                            <span class="badge {{ $sedekah->status == 'Pending' ? 'badge-danger' : ($sedekah->status == 'Sedang Dijemput' ? 'badge-warning' : 'badge-success') }}">
                                <strong>{{ $sedekah->status }}</strong>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><strong>{{ $sedekah->user->alamat }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
	</div>

    @isset($sedekah->penjemputan)
        <div class="card shadow mt-4 mb-4">

            {{-- Card Header --}}
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Petugas Yang Menjemput</h4>
            </div>

            {{-- Card Body --}}
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 mb-5 text-center">
                        <img src="{{ asset('assets/img/'.$sedekah->penjemputan->petugas->foto) }}" class="card-img-bottom rounded img-fluid shadow" style="width:400px; height:280px;"  alt="Foto">
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
                            <td><strong>{{ $sedekah->penjemputan->berangkat ? $sedekah->penjemputan->berangkat.' WIB' : '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Sampai</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->sampai ? $sedekah->penjemputan->sampai.' WIB' : '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><strong>{{ $sedekah->penjemputan->petugas->nama == auth()->user()->nama ? 'Anda' : $sedekah->penjemputan->petugas->nama }}</strong></td>
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
                            <td><strong>{{ $sedekah->penjemputan->petugas->email ? $sedekah->penjemputan->petugas->email : ' - ' }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endisset

	<div class="text-center mt-3 mb-5 pb-5">
        <a href="{{ url('/petugas') }}" class="btn btn-primary">Kembali</a>

        @if ($sedekah->status == 'Pending' && (!isset($is_jemput->sedekah) || (isset($is_jemput->sedekah) && $is_jemput->sedekah->status != 'Sedang Dijemput')))
            <form action="{{ url('/petugas/sedekah/'.$sedekah->id) }}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success font-weight-bold">Jemput</button>
            </form>
        @elseif (isset($is_jemput) && $is_jemput->sedekah_id == $sedekah->id && $is_jemput->sedekah->status == 'Sedang Dijemput')
            <a href="#" data-toggle="modal" data-target="#konfirmasiMijelModal-{{ $sedekah->id }}" class="btn btn-success font-weight-bold ml-1">Selesai</a>

            <!-- Konfirmasi Mijel Modal-->
            <div class="modal fade text-left" id="konfirmasiMijelModal-{{ $sedekah->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong>Form Konfirmasi Mijel</strong></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{ url('/petugas/sedekah/'.$sedekah->id) }}" method="POST">
                            @csrf
                            @method('patch')

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="jumlah" class="text-dark">Jumlah <sup class="text-muted">dalam liter</sup></label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}" >
                                    @error('jumlah')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="harga" class="text-dark">Harga <sup class="text-muted">per liter</sup></label>
                                    <input type="text" class="form-control @error('harga') is-invalid @enderror" name="harga" id="harga" maxlength="11" value="{{ old('harga') }}" >
                                    @error('harga')<div class="text text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="text-dark">Keterangan</label>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="radio" class="form-check-input ml-2 @error('keterangan') is-invalid @enderror" id="tunai" name="keterangan" value="Tunai" {{ old('keterangan') == 'Tunai' ? 'checked' : '' }} >
                                            <label for="tunai" class="ml-4">Tunai</label>
                                        </div>

                                        <div class="col-md">
                                            <input type="radio" class="form-check-input ml-2 @error('keterangan') is-invalid @enderror" id="tabung" name="keterangan" value="Tabung" {{ old('keterangan') == 'Tabung' ? 'checked' : '' }} >
                                            <label for="tabung" class="ml-4">Tabung</label>
                                        </div>
                                    </div>

                                    @error('keterangan') <div class="text text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
	</div>
    
</div>
@endsection