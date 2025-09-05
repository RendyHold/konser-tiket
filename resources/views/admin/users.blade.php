@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold">Manajemen User</h1>
  <p class="text-gray-500 mb-4">Kelola role & akun pengguna</p>

  {{-- Filter --}}
  <form id="filterForm" method="GET" action="{{ route('admin.users') }}"
        class="mb-4 flex flex-wrap items-center gap-3">
    <div class="relative">
      <input type="text" name="q" value="{{ old('q', $q ?? request('q')) }}"
             placeholder="Cari nama / email…" autocomplete="off"
             class="border rounded-lg px-3 py-2 min-w-[260px]">
    </div>

    <select name="role" class="border rounded-lg px-3 py-2">
      <option value="">Semua role</option>
      @foreach(($roles ?? ['admin','petugas','user']) as $r)
        <option value="{{ $r }}" @selected(($role ?? request('role')) === $r)>{{ $r }}</option>
      @endforeach
    </select>

    <select name="perPage" class="border rounded-lg px-3 py-2">
      @foreach([10,25,50,100] as $n)
        <option value="{{ $n }}" @selected(($perPage ?? request('perPage',10)) == $n)>{{ $n }}/hal</option>
      @endforeach
    </select>

    <button type="submit" class="bg-indigo-600 text-white rounded-lg px-4 py-2">Filter</button>

    @if(request()->hasAny(['q','role','perPage']))
      <a href="{{ route('admin.users.index') }}" class="text-gray-600 underline">Reset</a>
    @endif
  </form>

  {{-- Info ringkas --}}
  <div class="text-sm text-gray-500 mb-2">
    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
  </div>

  {{-- Tabel users (contoh, sesuaikan punyamu) --}}
  <div class="bg-white rounded-xl border">
    <table class="w-full">
      <thead>
        <tr class="border-b">
          <th class="text-left p-4">Nama</th>
          <th class="text-left p-4">Email</th>
          <th class="text-left p-4">Role</th>
          <th class="text-left p-4">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          <tr class="border-b">
            <td class="p-4">{{ $user->name }}</td>
            <td class="p-4">{{ $user->email }}</td>
            <td class="p-4">
              {{-- jika kolom role --}}
              <span class="px-2 py-1 text-xs rounded bg-gray-100">{{ $user->role }}</span>
              {{-- jika Spatie:
              <span class="px-2 py-1 text-xs rounded bg-gray-100">{{ $user->roles->pluck('name')->join(', ') }}</span>
              --}}
            </td>
            <td class="p-4">
              {{-- tombol aksi kamu di sini --}}
              {{-- … --}}
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="p-6 text-center text-gray-500">Tidak ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $users->onEachSide(1)->links() }}
  </div>
</div>
@endsection
