@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl p-4">
  <h1 class="text-2xl font-bold mb-4">Tiket Saya</h1>

  @if($tickets->isEmpty())
    <p class="text-gray-600">Belum ada tiket.</p>
  @else
    <table class="w-full border">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 border">Kode</th>
          <th class="p-2 border">Barcode</th> <!-- Hanya kolom Barcode -->
          <th class="p-2 border">Status</th>
          <th class="p-2 border">Waktu Scan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tickets as $t)
        <tr>
          <td class="p-2 border align-top">
            <div class="font-mono">{{ $t->code }}</div>
            @isset($t->npm)
              <div class="text-xs text-gray-500">NPM: {{ $t->npm }}</div>
            @endisset
          </td>
          <td class="p-2 border">
            {{-- Menampilkan barcode (yang sudah mencakup QR code) --}}
            <div class="barcode-container" style="width: 150px; height: 80px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                <img src="{{ asset('img/tiket.png') }}" alt="Barcode" style="width: 100%; height: auto;" />
            </div>
          </td>
          <td class="p-2 border align-top">{{ $t->status ?? '-' }}</td>
          <td class="p-2 border align-top">
            {{ $t->scanned_at ? $t->scanned_at->format('d M Y H:i') : '-' }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection
