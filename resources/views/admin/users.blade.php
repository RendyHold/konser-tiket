{{-- resources/views/admin/users.blade.php --}}
@extends('layouts.app')

@section('content')
<<<<<<< HEAD
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold">Manajemen User</h1>
    <p class="text-gray-500 mb-4">Kelola role & akun pengguna</p>

    {{-- Filter --}}
    <form id="filterForm" method="GET" action="{{ route('admin.users') }}" class="mb-4 flex flex-wrap items-center gap-3">
      <div class="relative">
        <input type="text" name="q" value="{{ old('q', $q ?? request('q')) }}" placeholder="Cari nama / email…" autocomplete="off" class="border rounded-lg px-3 py-2 min-w-[260px]">
      </div>

      <select name="role" class="border rounded-lg px-3 py-2">
        <option value="">Semua role</option>
        @foreach(($roles ?? ['admin', 'petugas', 'user']) as $r)
          <option value="{{ $r }}" @selected(($role ?? request('role')) === $r)>{{ $r }}</option>
        @endforeach
      </select>

      <select name="perPage" class="border rounded-lg px-3 py-2">
        @foreach([10, 25, 50, 100] as $n)
          <option value="{{ $n }}" @selected(($perPage ?? request('perPage', 10)) == $n)>{{ $n }}/hal</option>
        @endforeach
      </select>

      <button type="submit" class="bg-indigo-600 text-white rounded-lg px-4 py-2">Filter</button>

      @if(request()->hasAny(['q', 'role', 'perPage']))
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 underline">Reset</a>
      @endif
    </form>

    {{-- Info ringkas --}}
    <div class="text-sm text-gray-500 mb-2">
      Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
    </div>

    {{-- Tabel users --}}
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
                <span class="px-2 py-1 text-xs rounded bg-gray-100">{{ $user->role }}</span>
              </td>
              <td class="p-4">
                {{-- Tombol aksi (edit, hapus, dll.) --}}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="p-6 text-center text-gray-500">Tidak ada data</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
      {{ $users->onEachSide(1)->links() }}
    </div>
  </div>
=======
<div class="max-w-6xl mx-auto space-y-6">
  <div>
    <h1 class="text-xl font-semibold">Manajemen User</h1>
    <p class="text-sm text-gray-500">Kelola role & akun pengguna</p>
  </div>

  @if(session('ok'))
    <div class="rounded-md border border-green-200 bg-green-50 p-3 text-green-800">
      {{ session('ok') }}
    </div>
  @endif
  @if(session('err'))
    <div class="rounded-md border border-red-200 bg-red-50 p-3 text-red-700">
      {{ session('err') }}
    </div>
  @endif

  <div class="rounded-xl border bg-white shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50 text-left">
        <tr>
          <th class="px-4 py-3">Nama</th>
          <th class="px-4 py-3">Email</th>
          <th class="px-4 py-3">Role</th>
          <th class="px-4 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @foreach($users as $u)
          <tr>
            <td class="px-4 py-3">{{ $u->name }}</td>
            <td class="px-4 py-3">{{ $u->email }}</td>
            <td class="px-4 py-3">
              <span class="rounded px-2 py-0.5 text-xs ring-1
                @if($u->role==='admin') bg-purple-50 text-purple-700 ring-purple-200
                @elseif($u->role==='petugas') bg-blue-50 text-blue-700 ring-blue-200
                @else bg-gray-50 text-gray-700 ring-gray-200
                @endif">
                {{ $u->role ?? 'user' }}
              </span>
            </td>

            <td class="px-4 py-3">
              {{-- Jangan izinkan aksi ke akun diri sendiri --}}
              @if($u->id !== auth()->id())

                {{-- Khusus ADMIN: ubah role user/petugas --}}
                @if(auth()->user()->role === 'admin')
                  @if($u->role === 'user')
                    <form method="POST" action="{{ route('admin.users.make-petugas', $u) }}" class="inline">
                      @csrf
                      <button class="px-3 py-1 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                        Jadikan Petugas
                      </button>
                    </form>
                  @elseif($u->role === 'petugas')
                    <form method="POST" action="{{ route('admin.users.revoke-petugas', $u) }}" class="inline">
                      @csrf
                      <button class="px-3 py-1 rounded bg-gray-800 text-white hover:bg-black">
                        Cabut Petugas
                      </button>
                    </form>
                  @endif
                @endif

                {{-- ADMIN & PETUGAS: hapus user --}}
                <form action="{{ route('admin.users.destroy', $u) }}" method="POST"
                      class="inline"
                      onsubmit="return confirm('Hapus akun {{ $u->name }}? Semua tiketnya juga akan dihapus.');">
                  @csrf
                  @method('DELETE')
                  <button class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                    Hapus
                  </button>
                </form>

              @else
                <span class="text-gray-400 text-xs">—</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div>{{ $users->links() }}</div>
</div>
>>>>>>> parent of a88218e (aa)
@endsection
