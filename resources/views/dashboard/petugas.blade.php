@extends('layouts.app')

@section('content')
<div class="container p-4">
  <h1 class="text-2xl font-bold mb-4">Dashboard Petugas</h1>
  <a href="{{ route('ticket.scan') }}" class="px-4 py-2 bg-green-600 text-white rounded">🔍 Buka Scanner</a>
</div>
@endsection
