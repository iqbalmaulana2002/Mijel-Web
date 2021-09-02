@extends('../templates/template-anggota')

@section('title', 'Riwayat Penarikan')

@section('content')
<div class="container mb-5 pb-5">
	@if (session('pesan'))
        {!! session('pesan') !!}
    @endif

    <a class="btn btn-outline-primary font-weight-bold mb-3" href="{{ url('/anggota') }}">Home <i class="fas fa-home"></i></a>

    @if ($tabungan->saldo > 0 && ($penarikan->isEmpty() || $penarikan[0]->is_transfer === 1))
        <a class="btn btn-success font-weight-bold mb-3" href="#" data-toggle="modal" data-target="#tarikTabunganModal">Tarik Tabungan <i class="fas fa-hand-holding-usd"></i></a>
    @else
        <button type="button" class="btn btn-success disabled font-weight-bold mb-3">Tarik Tabungan <i class="fas fa-hand-holding-usd"></i></button>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="m-0 font-weight-bold text-primary h4 mb-2">
                Riwayat Penarikan
                <div class="float-right h6 bg-gray-200 p-2 text-gray-700 font-weight-bold mt-3 mt-sm-0">Saldo Anda Sekarang: 
                    <span class="text-{{ $tabungan->saldo < 60000 ? 'danger' : 'success' }}">
                        Rp.&nbsp;{{ number_format($tabungan->saldo, 2, ",", ".") }}
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah Penarikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penarikan as $p)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ explode(' ', $p->created_at)[0] }}</td>
                                <td>{{ 'Rp. '.number_format($p->jumlah, 2, ",", ".") }}</td>
                                <td>{!! $p->is_transfer ? "<span class='badge badge-success'>Selesai</span>" : "<span class='badge badge-danger'>Pending</span>" !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@if ($penarikan->isEmpty() || $penarikan[0]->is_transfer === 1)
    @if ($tabungan->saldo)
        <!-- Tarik Tabungan Modal-->
        <div class="modal fade" id="tarikTabunganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Konfirmasi</strong></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('/anggota/penarikan') }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="jumlah" class="text-dark">Jumlah Penarikan</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" min="60000" value="{{ old('jumlah') }}" placeholder="contoh: 60000">
                                @error('jumlah')<div class="text text-danger">{{ $message }}</div>@enderror
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
@endif

@endsection