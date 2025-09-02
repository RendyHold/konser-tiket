@extends('layouts.app')

@section('content')
<div class="container p-4">
  <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
  <div class="space-y-2">
    <a href="{{ route('ticket.scan') }}" class="block px-4 py-2 bg-green-600 text-white rounded">🔍 Buka Scanner</a>
    <a href="{{ route('admin.scans') }}" class="block px-4 py-2 bg-blue-600 text-white rounded">📋 Daftar Scan</a>
    <a href="{{ route('admin.users') }}" class="block px-4 py-2 bg-indigo-600 text-white rounded">👥 Manajemen User</a>
  </div>
</div>
@endsection
