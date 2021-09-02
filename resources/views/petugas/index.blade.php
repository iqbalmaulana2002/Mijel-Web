@extends('../templates/template-petugas')

@section('title', 'Halaman Dashboard')

@section('dashboard', 'active')

@section('content')
<div class="container mb-5 pb-5">

    @if (session('pesan'))
        {!! session('pesan') !!}
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Data Sedekah Mijel</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sedekah as $s)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $s->tanggal }}</td>
                                <td>{{ $s->user ? $s->user->nama : $s->user_id }}</td>
                                <td>
                                    <span class="badge {{ $s->status == 'Pending' ? 'badge-danger' : ($s->status == 'Sedang Dijemput' ? 'badge-warning' : 'badge-success') }}">{{ $s->status }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ url('/petugas/sedekah/'.$s->id) }}" class="btn btn-primary btn-sm font-weight-bold">
                                            <i class="fas fa-search-plus"></i> <span class="d-none d-md-inline">Detail</span>
                                        </a>
                                        @if ($s->status === 'Pending' && (!isset($is_jemput->sedekah) || (isset($is_jemput->sedekah) && $is_jemput->sedekah->status !== 'Sedang Dijemput')))
                                            <form action="{{ url('/petugas/sedekah/'.$s->id) }}" method="post" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm font-weight-bold ml-1">Jemput</button>
                                            </form>
                                        @elseif (isset($is_jemput) && $is_jemput->sedekah_id == $s->id && $is_jemput->sedekah->status === 'Sedang Dijemput')
                                            <a href="#" data-toggle="modal" data-target="#konfirmasiMijelModal-{{ $s->id }}" class="btn btn-success btn-sm font-weight-bold ml-1">Selesai</a>
                                            
                                            <!-- Konfirmasi Mijel Modal-->
                                            <div class="modal fade" id="konfirmasiMijelModal-{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Form Konfirmasi Mijel</strong></h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ url('/petugas/sedekah/'.$s->id) }}" method="POST">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

@endsection