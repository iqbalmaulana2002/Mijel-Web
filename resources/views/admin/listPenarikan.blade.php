@extends('../templates/template-admin')

@section('title', 'List Penarikan Tabungan')

@section('list-penarikan', 'active')

@section('content')
<div class="container mb-5 pb-5">
    @if (session('pesan'))
        {!! session('pesan') !!}
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">List Penarikan Tabungan</h4>
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
                            {{-- <th>Total Tabungan</th> --}}
                            <th>Jumlah Penarikan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_penarikan as $list)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ explode(' ', $list->created_at)[0] }}</td>
                                <td>{{ $list->tabungan->user->nik }}</td>
                                <td>{{ $list->tabungan->user->nama }}</td>
                                {{-- <td>{{ 'Rp. '.number_format($list->tabungan->total, 2, ",", ".") }}</td> --}}
                                <td>{{ 'Rp. '.number_format($list->jumlah, 2, ",", ".") }}</td>
                                <td>{!! $list->is_transfer ? "<span class='badge badge-success'>Selesai</span>" : "<span class='badge badge-danger'>Pending</span>" !!}</td>
                                <td>
                                    @if ($list->is_transfer === 0)
                                        <form action="{{ url('/admin/konfirmasi/'.$list->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('patch')
                                            
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin sudah mentransfer tabungan {{ $list->tabungan->user->jenkel === 'Perempuan' ? 'Bu' : 'Pak' }} {{ $list->tabungan->user->nama }}');">
                                                <i class="fas fa-check"></i> <span class="d-none d-md-inline">Konfirmasi</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Selesai</span>
                                    @endif
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