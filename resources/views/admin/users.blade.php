{{-- resources/views/admin/users.blade.php --}}
@extends('layouts.app')

@section('content')
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

  {{-- ===== Filter bar ===== --}}
  <form id="filterForm" method="GET" action="{{ url()->current() }}"
        class="flex flex-wrap items-center gap-3 bg-white border rounded-xl px-4 py-3">
    <div class="relative">
      <input
        type="text"
        name="q"
        value="{{ old('q', $q ?? request('q')) }}"
        placeholder="Cari nama / email…"
        autocomplete="off"
        class="border rounded-lg px-3 py-2 min-w-[260px]"
        aria-label="Cari nama atau email"
      >
    </div>

    <select name="role" class="border rounded-lg px-3 py-2" aria-label="Filter role">
      <option value="">Semua role</option>
      @foreach(($roles ?? ['admin','petugas','user']) as $r)
        <option value="{{ $r }}" @selected(($role ?? request('role')) === $r)>{{ $r }}</option>
      @endforeach
    </select>

    <select name="perPage" class="border rounded-lg px-3 py-2" aria-label="Jumlah per halaman">
      @foreach([10,25,50,100] as $n)
        <option value="{{ $n }}" @selected(($perPage ?? request('perPage',10)) == $n)>{{ $n }}/hal</option>
      @endforeach
    </select>

    <button type="submit" class="bg-indigo-600 text-white rounded-lg px-4 py-2">
      Filter
    </button>

    @if(request()->hasAny(['q','role','perPage']))
      <a href="{{ url()->current() }}" class="text-gray-600 underline">Reset</a>
    @endif
  </form>

  {{-- Info ringkas --}}
  <div class="text-sm text-gray-500">
    @if($users->total() > 0)
      Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
    @else
      Tidak ada data
    @endif
  </div>

  {{-- ===== Tabel ===== --}}
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
        @forelse($users as $u)
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
        @empty
          <tr>
            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{-- pagination menyimpan query berkat withQueryString() di controller --}}
    {{ $users->onEachSide(1)->links() }}
  </div>
</div>
@endsection

{{-- JS kecil untuk auto-submit filter --}}
@push('scripts')
<script>
(function(){
  const form = document.getElementById('filterForm');
  if(!form) return;

  const q = form.querySelector('input[name="q"]');
  const selects = form.querySelectorAll('select[name="role"], select[name="perPage"]');

  // submit saat dropdown berubah
  selects.forEach(s => s.addEventListener('change', () => form.submit()));

  // debounce pencarian
  let t;
  q && q.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(() => form.submit(), 400);
  });
})();
</script>
@endpush
