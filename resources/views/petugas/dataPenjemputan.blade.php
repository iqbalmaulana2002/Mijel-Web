@extends('../templates/template-petugas')

@section('title', 'Riwayat Penjemputan Saya')

@section('data-penjemputan', 'active')

@section('content')
<div class="container mb-5 pb-5">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Riwayat Penjemputan Saya</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Penjemputan</th>
                            <th>Sedekah Dari</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjemputan as $p)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $p->sedekah->tanggal }}</td>
                                <td>{{ $p->tanggal }}</td>
                                <td>{{ $p->sedekah->user->nama }}</td>
                                <td>
                                    <span class="badge {{ $p->sedekah->status == 'Pending' ? 'badge-danger' : ($p->sedekah->status == 'Sedang Dijemput' ? 'badge-warning' : 'badge-success') }}">
                                        {{ $p->sedekah->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ url('/petugas/penjemputan/'.$p->id) }}" class="btn btn-primary btn-sm font-weight-bold">
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
@endsection