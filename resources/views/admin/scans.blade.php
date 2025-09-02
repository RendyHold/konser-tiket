{{-- resources/views/admin/scans.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl p-4 space-y-4">

  {{-- Header: Judul + tombol Tambah Manual --}}
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold">Daftar Tiket Terscan</h1>

    {{-- arahkan ke route form manual --}}
    <a href="{{ route('admin.scans.manual') }}"
       class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
      + Tambah Manual
    </a>
  </div>

  {{-- Filter --}}
  <form method="GET" class="flex flex-wrap gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode/nama"
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
          <th class="p-2 border">Waktu</th>
          <th class="p-2 border">Kode</th>
          <th class="p-2 border">NPM</th>
          <th class="p-2 border">Pemilik</th>
          <th class="p-2 border">Discanned Oleh</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tickets as $t)
          <tr>
            <td class="p-2 border">{{ optional($t->scanned_at)->format('Y-m-d H:i') }}</td>
            <td class="p-2 border font-mono">{{ $t->code }}</td>
            <td class="p-2 border">{{ $t->npm ?? '-' }}</td>
            <td class="p-2 border">{{ optional($t->user)->name ?? '-' }}</td>
            <td class="p-2 border">{{ optional($t->scannedBy)->name ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            {{-- perbaiki colspan jadi 5 karena ada 5 kolom --}}
            <td class="p-2 border text-center text-gray-500" colspan="5">
              Belum ada data
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $tickets->links() }}</div>
</div>
@endsection
