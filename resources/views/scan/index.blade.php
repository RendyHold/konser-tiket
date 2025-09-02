@extends('layouts.base')
@section('title','Scan Tiket')

@section('content')
<div class="card">
  <form method="POST" action="{{ route('scan.validate') }}">
    @csrf
    <input name="kode" autofocus placeholder="Arahkan scanner ke sini">
    <button>Validasi</button>
  </form>
</div>

@if(session('msg'))
  <div class="card"><strong>{{ session('msg') }}</strong></div>
@endif
@endsection
