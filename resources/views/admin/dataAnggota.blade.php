@extends('../templates/template-admin')

@section('title', 'Data Anggota')

@section('data-users', 'active')

@section('content')
<div class="container mb-5 pb-5">
    @if (session('pesan'))
        {!! session('pesan') !!}
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Data Anggota</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Terakhir Sedekah</th>
                            <th>Tabungan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $a)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->sedekah->last() ? $a->sedekah->last()->tanggal : 'Belum Pernah' }}</td>
                                <td>{{ 'Rp. '.number_format($a->tabungan->saldo, 2, ",", ".") }}</td>
                                <td>
                                    {!! $a->is_active ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Tidak Aktif</span>" !!}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ url('/admin/data/user/'.$a->id) }}" class="btn btn-primary btn-sm font-weight-bold">
                                            <i class="fas fa-search-plus"></i> <span class="d-none d-md-inline">Detail</span>
                                        </a>
                                        <a href="{{ url('/admin/download/qr-code/'.$a->qr_code) }}" class="btn btn-info btn-sm font-weight-bold ml-1">
                                            <i class="fas fa-download"></i> <span class="d-none d-md-inline">QR Code</span>
                                        </a>
                                        <form action="{{ url('/admin/data/user/'.$a->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('patch')

                                            @if ($a->is_active === 1)
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