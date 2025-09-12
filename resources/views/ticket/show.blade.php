@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl p-4">
  <h1 class="text-3xl font-semibold mb-6 text-center">Tiket Saya</h1>

  @if($tickets->isEmpty())
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded-md">
      <p class="text-center">Belum ada tiket. Silakan klaim tiket untuk mendapatkan akses.</p>
    </div>
  @else
    <div class="overflow-x-auto shadow-md rounded-lg mb-6">
      <table class="w-full table-auto border-collapse border border-gray-300">
        <thead class="bg-indigo-600 text-white">
          <tr>
            <th class="py-3 px-4 text-left">Kode</th>
            <th class="py-3 px-4 text-left">Tiket</th>
            <th class="py-3 px-4 text-left">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-800">
          @foreach($tickets as $t)
          <tr class="border-b hover:bg-gray-50">
            <td class="py-3 px-4">
              <div class="font-mono text-lg font-semibold">{{ $t->code }}</div>
              @isset($t->npm)
                <div class="text-xs text-gray-500">NPM: {{ $t->npm }}</div>
              @endisset
            </td>
            <td class="py-3 px-4">
              <img src="{{ asset($t->barcode_path) }}" alt="Barcode" class="w-16 h-auto mx-auto">
            </td>
            <td class="py-3 px-4">
              <span class="font-medium {{ $t->status == 'new' ? 'text-green-500' : 'text-gray-500' }}">
                {{ $t->status ?? '-' }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Download Button -->
    <div class="text-center">
      <a href="{{ route('ticket.downloadTicket') }}" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Download Tiket Disini!
      </a>
    </div>
  @endif
</div>
@endsection
