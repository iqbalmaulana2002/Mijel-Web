@extends('../templates/template-anggota')

@section('title', 'Halaman Dashboard')

@section('content')
<div class="container mb-5 pb-5">
	@if (session('pesan'))
        {!! session('pesan') !!}
    @endif
    
    @if ($sedekah->isEmpty() || $sedekah[0]->status == 'Selesai')
        <a class="btn btn-primary font-weight-bold mb-3" href="#" data-toggle="modal" data-target="#reqPenjemputanModal">Request Penjemputan <i class="fas fa-taxi"></i></a>
    @else
        <a class="btn btn-primary font-weight-bold mb-3 disabled" href="#">Request Penjemputan <i class="fas fa-taxi"></i></a>
    @endif

    <a class="btn btn-outline-success font-weight-bold mb-3" href="{{ url('/anggota/penarikan') }}">Riwayat Penarikan <i class="fas fa-money-check"></i></a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="m-0 font-weight-bold text-primary h4">Data Sedekah Mijel Saya</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Penjemputan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sedekah as $s)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $s->tanggal }}</td>
                                <td>{{ $s->penjemputan ? $s->penjemputan->tanggal : 'Belum dijemput' }}</td>
                                <td>
                                    <span class="badge {{ $s->status == 'Pending' ? 'badge-danger' : ($s->status == 'Sedang Dijemput' ? 'badge-warning' : 'badge-success') }}">{{ $s->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ url('/anggota/'.$s->id) }}" class="btn btn-primary btn-sm font-weight-bold">
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

@if ($sedekah->isEmpty() || $sedekah[0]->status == 'Selesai')
    <!-- Req Penjempuatan Modal-->
    <div class="modal fade" id="reqPenjemputanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Konfirmasi</strong></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Yakin ingin meminta penjemputan mijel?</div>
                <div class="modal-footer">
                    <form action="{{ url('/anggota') }}" method="POST">
                        @csrf
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection