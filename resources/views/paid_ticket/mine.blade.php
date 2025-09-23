{{-- resources/views/paid_ticket/mine.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto">
  <h2 class="text-xl font-semibold mb-4">Klaim Berbayar Saya</h2>
  <table class="w-full border bg-white rounded">
    <thead><tr class="bg-gray-50">
      <th class="p-2 border">NPM</th>
      <th class="p-2 border">Nominal</th>
      <th class="p-2 border">Status</th>
      <th class="p-2 border">Aksi</th>
    </tr></thead>
    <tbody>
    @forelse($claims as $c)
      <tr>
        <td class="p-2 border">{{ $c->npm }}</td>
        <td class="p-2 border">Rp {{ number_format($c->amount,0,',','.') }}</td>
        <td class="p-2 border">{{ $c->status }}</td>
        <td class="p-2 border">
          @if($c->status==='issued' && $c->ticket_code)
            <a class="text-blue-600 underline" href="{{ route('paid.claim.download',$c->ticket_code) }}">Download Tiket</a>
          @else
            <span class="text-gray-500">-</span>
          @endif
        </td>
      </tr>
    @empty
      <tr><td colspan="4" class="p-3 text-center text-gray-500">Belum ada klaim.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
@endsection
