@extends('layouts.base')
@section('title','Daftar Acara')
@section('content')
<div class="card">
  <a href="{{ route('acara.create') }}">+ Tambah Acara</a>
</div>

@if(session('ok')) <div class="card ok">{{ session('ok') }}</div> @endif

@foreach($list as $a)
  <div class="card">
    <strong>{{ $a->nama }}</strong><br>
    {{ $a->tanggal->format('d M Y H:i') }} @if($a->lokasi) — {{ $a->lokasi }} @endif
    <div style="margin-top:8px">
      <a href="{{ route('acara.edit',$a) }}">Edit</a>
      <form method="POST" action="{{ route('acara.destroy',$a) }}" style="display:inline">
        @csrf @method('DELETE')
        <button onclick="return confirm('Hapus acara ini?')">Hapus</button>
      </form>
    </div>
  </div>
@endforeach

@if(method_exists($list,'links'))
  {{ $list->links() }}
@endif
@endsection
