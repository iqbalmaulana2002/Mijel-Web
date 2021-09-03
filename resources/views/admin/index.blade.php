@extends('../templates/template-admin')

@section('title', 'Halaman Dashboard')

@section('dashboard', 'active')

@section('content')
<div class="container mb-5 pb-5">

    @if (session('pesan'))
        {!! session('pesan') !!}
    @endif

    <ul class="nav mb-3">
            
        {{-- Export Excel --}}
        <li class="nav-item">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ExportExcelModal">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </li>

    </ul>

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
                            <th>NIK</th>
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
                                <td>{{ $s->user->nik }}</td>
                                <td>{{ $s->user ? $s->user->nama : $s->user_id }}</td>
                                <td>
                                    <span class="badge {{ $s->status == 'Pending' ? 'badge-danger' : ($s->status == 'Sedang Dijemput' ? 'badge-warning' : 'badge-success') }}">{{ $s->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ url('/admin/sedekah/'.$s->id) }}" class="btn btn-primary btn-sm font-weight-bold">
                                        <i class="fas fa-search-plus"></i> <span class="d-none d-md-inline">Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

{{-- Modal Export Excel --}}
<div class="modal fade" id="ExportExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Data Export</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ url('/admin') }}" method="post">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <input type="number" class="form-control" name="nik" placeholder="NIK" min="0" minlength="1" value="{{ old('nik') }}" >
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="date" name="tgl_awal" class="form-control" value="{{ old('tgl_awal') }}">
                        </div>
                        <div class="col-sm-6">
                            <input type="date" name="tgl_akhir" class="form-control" value="{{ old('tgl_akhir') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Export</button>
                </div>
                    <small class="text-muted text-left ml-1 ml-sm-3">Catatan : Kosongkan semua inputan jika ingin mengexport semua data</small>

            </form>
        </div>
    </div>
</div>
@endsection