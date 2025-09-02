@extends('layouts.base')
@section('title','Edit Acara')
@section('content')
<div class="card">
  @if ($errors->any())
    <div class="err">
      <ul style="margin:0;padding-left:18px;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('acara.update',$acara) }}">
    @csrf @method('PUT')
    <p><label>Nama</label><br>
      <input name="nama" value="{{ old('nama',$acara->nama) }}" required>
    </p>
    <p><label>Tanggal</label><br>
      <input type="datetime-local" name="tanggal"
             value="{{ old('tanggal',$acara->tanggal->format('Y-m-d\TH:i')) }}" required>
    </p>
    <p><label>Lokasi</label><br>
      <input name="lokasi" value="{{ old('lokasi',$acara->lokasi) }}">
    </p>
    <p><label>Kuota (0 = tak terbatas)</label><br>
      <input type="number" name="kuota" min="0" value="{{ old('kuota',$acara->kuota) }}">
    </p>
    <button>Update</button>
    <a href="{{ route('acara.index') }}">Kembali</a>
  </form>
</div>
@endsection
