@extends('layouts.base')
@section('title','Riwayat Scan')

@section('content')
@foreach($list as $pd)
  <div class="card">
    <strong>{{ $pd->kode_tiket }}</strong><br>
    {{ $pd->mahasiswa->npm }} — {{ $pd->mahasiswa->nama }}<br>
    Acara: {{ $pd->acara->nama }}<br>
    Waktu scan: {{ $pd->scanned_at }}
  </div>
@endforeach

@if(method_exists($list,'links'))
  {{ $list->links() }}
@endif
@endsection
