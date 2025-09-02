@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl p-4">
  <h1 class="text-2xl font-bold mb-4">Daftar Bukti SIAK</h1>

  <form class="flex gap-2 mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode/nama/NPM" class="border px-2 py-1 rounded">
    <input type="date" name="from" value="{{ request('from') }}" class="border px-2 py-1 rounded">
    <input type="date" name="to"   value="{{ request('to')   }}" class="border px-2 py-1 rounded">
    <button class="bg-blue-600 text-white px-3 py-1 rounded">Filter</button>
  </form>

  <table class="w-full border">
    <thead>
      <tr class="bg-gray-100">
        <th class="p-2 border">Waktu Klaim</th>
        <th class="p-2 border">Kode</th>
        <th class="p-2 border">NPM</th>
        <th class="p-2 border">Bukti SIAK</th>
        <th class="p-2 border">Pemilik</th>
        <th class="p-2 border">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tickets as $t)
        @php
          $proof = $t->npm_proof_path ? asset('storage/'.$t->npm_proof_path) : null;
          $ext   = $t->npm_proof_path ? strtolower(pathinfo($t->npm_proof_path, PATHINFO_EXTENSION)) : null;
          $isImg = in_array($ext, ['jpg','jpeg','png','webp']);
        @endphp
        <tr>
          <td class="p-2 border">{{ $t->claimed_at }}</td>
          <td class="p-2 border font-mono">{{ $t->code }}</td>
          <td class="p-2 border">{{ $t->npm }}</td>
          <td class="p-2 border">
            @if($proof)
              @if($isImg)
                <a href="{{ $proof }}" target="_blank" title="Lihat bukti">
                  <img src="{{ $proof }}" alt="bukti" class="h-12 w-auto inline-block rounded border">
                </a>
              @else
                <a href="{{ $proof }}" target="_blank" class="text-blue-600 underline">Lihat PDF</a>
              @endif
            @else
              <span class="text-gray-500">-</span>
            @endif
          </td>
          <td class="p-2 border">{{ $t->user->name ?? '-' }}</td>
          <td class="p-2 border">
            @if($t->npm_proof_path)
              <a href="{{ route('admin.proofs.download', $t) }}"
                 class="px-3 py-1 rounded bg-gray-800 text-white text-sm">Download</a>
              <a href="{{ $proof }}" target="_blank"
                 class="ml-2 px-3 py-1 rounded bg-blue-600 text-white text-sm">Buka</a>
            @else
              -
            @endif
          </td>
        </tr>
      @empty
        <tr><td class="p-2 border text-center" colspan="6">Belum ada bukti</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-3">{{ $tickets->links() }}</div>
</div>
@endsection
