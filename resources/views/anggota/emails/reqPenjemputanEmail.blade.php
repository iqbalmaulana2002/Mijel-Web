@component('mail::message')
# Notifikasi Permintaan Penjemputan

Halo, {{ $data[0] }}<br>
Ada permintaan penjemputan sedekah dari {{ $data['namaUser'] }} yang beralamat di {{ $data['alamatUser'] }}

@component('mail::button', ['url' => 'http://localhost:8000/login', 'color' => 'success'])
{{ $data[1] == 'admin' ? 'Cek' : 'Jemput' }} Sekarang
@endcomponent

Selamat Bekerja,<br>
{{ config('app.name') }}
@endcomponent
