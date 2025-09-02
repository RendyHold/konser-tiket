@extends('layouts.base')
@section('title','Tiket Kamu')

@section('content')
<div class="card">
  <p><strong>Kode:</strong> {{ $pd->kode_tiket }}</p>
  <p><strong>NPM:</strong> {{ $pd->mahasiswa->npm }} — {{ $pd->mahasiswa->nama }}</p>
  <p><strong>Acara:</strong> {{ $pd->acara->nama }} ({{ $pd->acara->tanggal->format('d M Y H:i') }})</p>
  <div style="margin-top:12px">{!! $qrSvg !!}</div>
  <small>Tunjukkan QR ini di pintu masuk. Satu NPM hanya satu tiket per acara.</small>
</div>
@endsection
