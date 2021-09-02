@extends('../templates/template-admin')

@section('title', 'Data Petugas')

@section('data-users', 'active')

@section('content')
<div class="container mb-5 pb-5">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Data Petugas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($petugas as $p)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $p->nik }}</td>
                                <td>{!! $p->nama == auth()->user()->nama ? '<strong>Anda</strong>' : $p->nama !!}</td>
                                <td>{{ $p->jenkel }}</td>
                                <td>{{ $p->level }}</td>
                                <td>
                                    {!! $p->is_active ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Tidak Aktif</span>" !!}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ url('/admin/data/user/'.$p->id) }}" class="btn btn-primary btn-sm font-weight-bold">
                                            <i class="fas fa-search-plus"></i> <span class="d-none d-md-inline">Detail</span>
                                        </a>

                                        <form action="{{ url('/admin/data/user/'.$p->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('patch')
                                            
                                            @if ($p->is_active === 1)
                                                <button type="submit" class="btn btn-danger btn-sm font-weight-bold ml-1" onclick="return confirm('Yakin ingin menonaktifkan user ini?');">
                                                    <i class="fas fa-user-alt-slash"></i> <span class="d-none d-md-inline">Nonaktifkan</span>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm font-weight-bold ml-1" onclick="return confirm('Yakin ingin mengaktifkan user ini lagi?');">
                                                    <i class="fas fa-user-check"></i> <span class="d-none d-md-inline">Aktifkan</span>
                                                </button>
                                            @endif
                                        </form>
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