@extends('../templates/template-admin')

@section('title', 'Halaman Dashboard')

@section('dashboard', 'active')

@section('content')
<div class="container mb-5 pb-5">

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
@endsection