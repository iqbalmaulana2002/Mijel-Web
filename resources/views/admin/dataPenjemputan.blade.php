@extends('../templates/template-admin')

@section('title', 'Data Penjemputan')

@section('data-penjemputan', 'active')

@section('content')
<div class="container mb-5 pb-5">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Data Penjemputan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Penjemputan</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjemputan as $p)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $p->sedekah->tanggal }}</td>
                                <td>{{ $p->tanggal }}</td>
                                <td>{{ $p->petugas->nik }}</td>
                                <td>{{ $p->petugas->nama }}</td>
                                <td>
                                    <a href="{{ url('/admin/penjemputan/'.$p->id) }}" class="btn btn-primary btn-sm font-weight-bold">
                                        <i class="fas fa-search-plus"></i> <span class="d-none d-md-inline">Detail</span>
                                    </a>
                                    {{-- <form action="{{ url('/admin/data/petugas/'.$p->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm font-weight-bold" onclick="return confirm('Yakin ingin menghapus? Tindakan ini akan menghapus data');">
                                            <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Delete</span>
                                        </button>
                                    </form> --}}
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