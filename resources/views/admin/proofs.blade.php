@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto max-w-6xl p-4 space-y-4">

  {{-- Header --}}
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold">Daftar Bukti SIKA</h1>
  </div>

  {{-- Filter --}}
  <form method="GET" class="flex flex-wrap gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode/nama/NPM"
           class="border px-3 py-2 rounded" />
    <input type="date" name="from" value="{{ request('from') }}"
           class="border px-3 py-2 rounded" />
    <input type="date" name="to" value="{{ request('to') }}"
           class="border px-3 py-2 rounded" />
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
  </form>

  {{-- Tabel --}}
  <div class="overflow-x-auto rounded border bg-white">
    <table class="w-full">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-2 border">Waktu Klaim</th>
          <th class="p-2 border">Kode</th>
          <th class="p-2 border">NPM</th>
          <th class="p-2 border">Bukti SIKA</th>
          <th class="p-2 border">Pemilik</th>
          <th class="p-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tickets as $t)
          @php
            $url = $t->npm_proof_path ? Storage::url($t->npm_proof_path) : null;
          @endphp
          <tr>
            <td class="p-2 border">{{ optional($t->claimed_at)->format('Y-m-d H:i') }}</td>
            <td class="p-2 border font-mono">{{ $t->code }}</td>
            <td class="p-2 border">{{ $t->npm ?? '-' }}</td>
            <td class="p-2 border">
              @if($url)
                <a href="{{ $url }}" target="_blank" class="inline-block">
                  <img src="{{ $url }}" alt="Bukti {{ $t->code }}"
                       class="h-16 w-24 object-cover rounded border" />
                </a>
              @else
                <span class="text-gray-400">-</span>
              @endif
            </td>
            <td class="p-2 border">{{ optional($t->user)->name ?? '-' }}</td>
            <td class="p-2 border">
              <div class="flex gap-2">
                @if($url)
                  <a href="{{ route('admin.proofs.download', $t) }}"
                     class="rounded bg-gray-800 text-white px-3 py-1">Download</a>
                  <a href="{{ $url }}" target="_blank"
                     class="rounded bg-blue-600 text-white px-3 py-1">Buka</a>
                @else
                  <span class="text-gray-400">Tidak ada berkas</span>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="p-2 border text-center text-gray-500" colspan="6">
              Belum ada data
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="mt-3">
    {{ $tickets->links() }}
  </div>

</div>
@endsection
