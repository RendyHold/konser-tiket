@extends('layouts.app')

@section('content')
  {{-- ADMIN / PETUGAS --}}
  @if(in_array($role, ['admin','petugas']))
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-xl font-semibold">Dashboard</h1>
          <p class="text-sm text-gray-500">Ringkasan singkat aktivitas tiket</p>
        </div>

        @if(Route::has('ticket.scan'))
          <a href="{{ route('ticket.scan') }}"
             class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 5a2 2 0 0 1 2-2h3v2H5v3H3V5Zm13-2h3a2 2 0 0 1 2 2v3h-2V5h-3V3ZM3 16h2v3h3v2H5a2 2 0 0 1-2-2v-3Zm18 0v3a2 2 0 0 1-2 2h-3v-2h3v-3h2ZM7 8h10a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2Z"/>
            </svg>
            Mulai Scan
          </a>
        @endif
      </div>

      {{-- KPI cards (hanya untuk admin/petugas) --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-kpi title="Tiket Discan"
               value="{{ number_format($stats['terscan']) }}"
               icon="qr"
               note="Total tiket yang sudah berhasil discan" />

        <x-kpi title="Peserta Klaim"
               value="{{ number_format($stats['peserta_klaim']) }}"
               icon="users"
               color="emerald"
               note="Jumlah Mahasiswa yang berhasil mengklaim tiket" />

        <x-kpi title="Total Tiket"
               value="{{ number_format($stats['tiket']) }}"
               icon="ticket"
               color="sky"
               note="Akumulasi tiket yang ter-generate" />

        <x-kpi title="Belum Discan"
               value="{{ number_format($stats['pending']) }}"
               icon="clock"
               color="amber"
               note="Tiket klaim yang belum tervalidasi" />
      </div>

      {{-- Scan terbaru --}}
      <div class="rounded-xl border bg-white shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b">
          <h3 class="font-semibold">Scan Terbaru</h3>
        </div>
        <div class="divide-y">
          @forelse($latestScans as $t)
            <div class="px-4 py-3 flex items-center justify-between">
              <div class="min-w-0">
                <div class="font-mono text-sm truncate">{{ $t->code }}</div>
                <div class="text-xs text-gray-500 truncate">
                  {{ $t->user->name ?? '-' }} • NPM: {{ $t->npm ?? '-' }}
                </div>
              </div>
              <div class="text-xs text-gray-500 ml-4 whitespace-nowrap">
                {{ optional($t->scanned_at)->format('Y-m-d H:i') }}
              </div>
            </div>
          @empty
            <div class="px-4 py-6 text-center text-gray-500">Belum ada data scan.</div>
          @endforelse
        </div>
      </div>
    </div>

  {{-- USER --}}
  @else
    <div class="space-y-6">
      <div>
        <h1 class="text-xl font-semibold">Dashboard</h1>
        <p class="text-sm text-gray-500">Ringkasan akun & tiket kamu</p>
      </div>

      @if($myTicket)
        @php
          $status     = $myTicket->status ?? 'new';
          $isUsed     = ($status === 'used') || !is_null($myTicket->scanned_at);
          $badgeClass = $isUsed ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
                                : 'bg-amber-50 text-amber-700 ring-amber-200';
          $badgeText  = $isUsed ? 'Sudah Discan' : 'Belum Discan';

          // Siapkan URL & ekstensi bukti via route proxy (tanpa symlink)
          $proofPath = $myTicket->npm_proof_path ?? null;   // contoh: 'bukti_npm/xxxx.png'
          $proofUrl  = $proofPath ? route('files.proxy', ['path' => $proofPath]) : null;
          $ext       = $proofPath ? strtolower(pathinfo($proofPath, PATHINFO_EXTENSION)) : null;
        @endphp

        <div class="grid gap-6 lg:grid-cols-3">
          {{-- Ringkasan tiket --}}
          <div class="rounded-xl border bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-semibold">Tiket Saya</h3>
                <p class="text-xs text-gray-500">Detail tiket yang sudah kamu klaim</p>
              </div>
              <span class="inline-flex items-center rounded-md px-2 py-1 text-xs ring-1 {{ $badgeClass }}">
                {{ $badgeText }}
              </span>
            </div>

            <div class="mt-4 space-y-2 text-sm">
              <div><span class="text-gray-500">Kode:</span> <span class="font-mono">{{ $myTicket->code }}</span></div>
              <div><span class="text-gray-500">NPM:</span>  <span class="font-medium">{{ $myTicket->npm ?? '-' }}</span></div>
              <div><span class="text-gray-500">Diklaim:</span> <span>{{ optional($myTicket->claimed_at ?? $myTicket->created_at)->format('Y-m-d H:i') }}</span></div>
              <div><span class="text-gray-500">Discan:</span> <span>{{ $myTicket->scanned_at ? $myTicket->scanned_at->format('Y-m-d H:i') : '-' }}</span></div>
            </div>

            <div class="mt-4 flex gap-2">
              @if(Route::has('ticket.show'))
                <a href="{{ route('ticket.show') }}"
                   class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-white hover:bg-indigo-700">
                  Lihat Tiket
                </a>
              @endif
            </div>
          </div>

          {{-- Bukti SIAK --}}
          <div class="rounded-xl border bg-white p-4 shadow-sm">
            <h3 class="font-semibold">Bukti SIAK</h3>
            <p class="text-xs text-gray-500">FOTO/SS SIAK yang kamu unggah saat klaim tiket</p>

            <div class="mt-4">
              @if($proofUrl)
                @if(in_array($ext, ['jpg','jpeg','png','webp','gif']))
                  <a href="{{ $proofUrl }}" target="_blank" class="block">
                    <img src="{{ $proofUrl }}" alt="Bukti SIAK" class="rounded border max-h-56 w-auto">
                  </a>
                @elseif($ext === 'pdf')
                  <a href="{{ $proofUrl }}" target="_blank" class="text-indigo-600 underline">Lihat Dokumen (PDF)</a>
                @else
                  <a href="{{ $proofUrl }}" target="_blank" class="text-indigo-600 underline">Unduh Dokumen</a>
                @endif
              @else
                <div class="text-gray-500 text-sm">Belum ada bukti yang tersimpan.</div>
              @endif
            </div>
          </div>

          {{-- Panduan singkat --}}
          <div class="rounded-xl border bg-white p-4 shadow-sm">
            <h3 class="font-semibold">Panduan</h3>
            <ol class="mt-3 space-y-2 text-sm text-gray-700 list-decimal pl-5">
              <li>Klaim tiket menggunakan NPM yang valid.</li>
              <li>Unggah bukti/SS SIAK saat klaim.</li>
              <li>Tunjukkan QR/kode tiket ke petugas untuk validasi pada saat acara.</li>
              <li>Setelah discan, status tiket menjadi <span class="font-semibold text-emerald-700">Sudah Discan</span>.</li>
            </ol>
          </div>
        </div>
      @else
        {{-- Belum punya tiket --}}
        <div class="rounded-xl border bg-white p-6 shadow-sm text-center">
          <h3 class="text-lg font-semibold">Kamu belum memiliki tiket</h3>
          <p class="text-gray-500 text-sm mt-1">Silakan lakukan klaim tiket menggunakan NPM kamu.</p>

          @if(Route::has('ticket.form'))
            <a href="{{ route('ticket.form') }}"
               class="mt-4 inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
              Klaim Tiket
            </a>
          @endif
        </div>
      @endif
    </div>
  @endif
@endsection
