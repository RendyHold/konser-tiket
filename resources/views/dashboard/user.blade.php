@extends('layouts.app')
@section('content')
<div class="container p-4">
  <h1 class="text-2xl font-bold mb-4">Dashboard User</h1>
  <a href="{{ route('ticket.show') }}" class="text-blue-600 underline">Lihat Tiket Saya</a>
</div>
@endsection
