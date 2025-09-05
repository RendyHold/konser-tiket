@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
  <div>
    <h1 class="text-xl font-semibold">Manajemen User</h1>
    <p class="text-sm text-gray-500">Kelola role & akun pengguna</p>
  </div>

  <!-- Filter Form -->
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
      <a href="{{ route('admin.users') }}" class="text-gray-600 underline">Reset</a>
    @endif
  </form>

  <!-- Informasi Hasil Pencarian -->
  <div class="text-sm text-gray-500 mb-2">
    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
  </div>

  <!-- Tabel User -->
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

<script>
  // Konfirmasi penghapusan
  document.querySelectorAll('form[onsubmit]').forEach(function(form) {
    form.addEventListener('submit', function(event) {
      var message = event.target.querySelector('button').innerText;
      if (!confirm('Apakah Anda yakin ingin ' + message.toLowerCase() + '?')) {
        event.preventDefault();
      }
    });
  });
</script>

@endsection
