@extends('../templates/template-petugas')

@section('title', 'Data Anggota')

@section('data-anggota', 'active')

@section('content')
<div class="container mb-5 pb-5">

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
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $a)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ asset('assets/img/'.$a->foto) }}" target="_blank">
                                        <img src="{{ asset('assets/img/'.$a->foto) }}" class="card-img-bottom rounded img-fluid shadow" style="width:160px;">
                                    </a>
                                </td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->jenkel }}</td>
                                <td>{{ $a->telp }}</td>
                                <td class="text-justify">{{ $a->alamat }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        {{-- <a href="{{ url('/petugas/data/user/'.$a->id) }}" class="btn btn-primary btn-sm font-weight-bold">
                                            <i class="fas fa-search-plus"></i> <span class="d-none d-md-inline">Detail</span>
                                        </a> --}}
                                        <a href="{{ url('/petugas/download/qr-code/'.$a->qr_code) }}" class="btn btn-success btn-sm font-weight-bold ml-1">
                                            <i class="fas fa-download"></i> <span class="d-none d-md-inline">Download QR Code</span>
                                        </a>
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