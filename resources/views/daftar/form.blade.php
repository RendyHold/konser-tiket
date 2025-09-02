@extends('layouts.base')
@section('title','Form Pendaftaran')

@section('content')
<div class="card">
  @if ($errors->any())
    <div class="err">
      <ul style="margin:0;padding-left:18px;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('daftar.store') }}">
    @csrf
    <p><label>NPM</label><br><input name="npm" value="{{ old('npm') }}" required></p>
    <p><label>Nama</label><br><input name="nama" value="{{ old('nama') }}" required></p>
    <p><label>Email</label><br><input type="email" name="email" value="{{ old('email') }}"></p>
    <p><label>No HP</label><br><input name="no_hp" value="{{ old('no_hp') }}"></p>

    <p>
      <label>Pilih Acara</label><br>
      <select name="acara_id" required>
        <option value="">-- pilih --</option>
        @foreach($acara as $a)
          <option value="{{ $a->id }}" @selected(old('acara_id')==$a->id)>
            {{ $a->nama }} — {{ $a->tanggal->format('d M Y H:i') }}
          </option>
        @endforeach
      </select>
    </p>

    <button type="submit">Daftar</button>
  </form>
</div>
@endsection
