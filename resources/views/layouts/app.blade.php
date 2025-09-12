<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Festival Mahasiswa' }}</title>

  {{-- Opsi A: Tailwind CDN (paling cepat). Pastikan koneksi internet aktif. --}}
  <script src="https://cdn.tailwindcss.com"></script>

  @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

  {{-- ===== NAVBAR ===== --}}
  <nav class="bg-white shadow-sm sticky top-0 z-40">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-14 items-center justify-between">

        {{-- Kiri: brand --}}
        <div class="flex items-center">
          <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}"
             class="text-lg font-bold text-gray-900">

          </a>
        </div>

        {{-- Tombol hamburger (mobile) --}}
        <button id="navToggle"
                class="md:hidden inline-flex items-center justify-center rounded p-2 hover:bg-gray-100"
                aria-label="Toggle navigation">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        @php
          $user = Auth::user();
          $role = $user->role ?? 'guest';
          $hasTicket = $user ? \App\Models\Ticket::where('user_id', $user->id)->exists() : false;
        @endphp

        {{-- Tengah: menu utama --}}
        <ul id="navMenu"
            class="hidden md:flex list-none items-center gap-6 text-sm font-medium text-gray-700">
          @auth
            {{-- Dashboard (umum) --}}
            @if(Route::has('dashboard'))
              <li>
                <a href="{{ route('dashboard') }}"
                   class="hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'underline font-semibold' : '' }}">
                  Dashboard
                </a>
              </li>
            @endif

            {{-- USER --}}
            @if($role === 'user')
              @if(Route::has('ticket.show'))
                <li>
                  <a href="{{ route('ticket.show') }}"
                     class="hover:text-gray-900 {{ request()->routeIs('ticket.show') ? 'underline font-semibold' : '' }}">
                    Tiket Saya
                  </a>
                </li>
              @endif
              @if(!$hasTicket && Route::has('ticket.form'))
                <li>
                  <a href="{{ route('ticket.form') }}"
                     class="hover:text-gray-900 {{ request()->routeIs('ticket.form') ? 'underline font-semibold' : '' }}">
                    Klaim Tiket
                  </a>
                </li>
              @endif
            @endif

            {{-- PETUGAS / ADMIN --}}
            @if(in_array($role, ['petugas','admin']))
              @if(Route::has('ticket.scan'))
                <li>
                  <a href="{{ route('ticket.scan') }}"
                     class="hover:text-gray-900 {{ request()->routeIs('ticket.scan') ? 'underline font-semibold' : '' }}">
                    Scan
                  </a>
                </li>
              @endif
              @if(Route::has('admin.scans'))
                <li>
                  <a href="{{ route('admin.scans') }}"
                     class="hover:text-gray-900 {{ request()->routeIs('admin.scans') ? 'underline font-semibold' : '' }}">
                    Daftar Scan
                  </a>
                </li>
              @endif
              @if(Route::has('admin.proofs'))
                <li>
                  <a href="{{ route('admin.proofs') }}"
                     class="hover:text-gray-900 {{ request()->routeIs('admin.proofs') ? 'underline font-semibold' : '' }}">
                    Bukti SIKA
                  </a>
                </li>
              @endif
              @if($role === 'admin' && Route::has('admin.users'))
                <li>
                  <a href="{{ route('admin.users') }}"
                     class="hover:text-gray-900 {{ request()->routeIs('admin.users') ? 'underline font-semibold' : '' }}">
                    Manajemen User
                  </a>
                </li>
              @endif
            @endif
          @endauth

          @guest
            @if(Route::has('login'))
              <li><a href="{{ route('login') }}" class="hover:text-gray-900">Login</a></li>
            @endif
            @if(Route::has('register'))
              <li><a href="{{ route('register') }}" class="hover:text-gray-900">Register</a></li>
            @endif
          @endguest
        </ul>

        {{-- Kanan: Logout --}}
        <div class="hidden md:flex items-center">
          @auth
            @if(Route::has('logout'))
              <a href="#"
                 class="text-sm font-medium text-red-600 hover:text-red-700"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
            @endif
          @endauth
        </div>
      </div>

      {{-- Mobile menu (dropdown) --}}
      <div id="mobileMenu" class="md:hidden hidden border-t">
        <ul class="list-none py-3 space-y-2 text-sm font-medium text-gray-700">
          @auth
            @if(Route::has('dashboard'))
              <li><a href="{{ route('dashboard') }}" class="block px-2 py-1 {{ request()->routeIs('dashboard') ? 'underline font-semibold' : '' }}">Dashboard</a></li>
            @endif

            @if($role === 'user')
              @if(Route::has('ticket.show'))
                <li><a href="{{ route('ticket.show') }}" class="block px-2 py-1 {{ request()->routeIs('ticket.show') ? 'underline font-semibold' : '' }}">Tiket Saya</a></li>
              @endif
              @if(!$hasTicket && Route::has('ticket.form'))
                <li><a href="{{ route('ticket.form') }}" class="block px-2 py-1 {{ request()->routeIs('ticket.form') ? 'underline font-semibold' : '' }}">Klaim Tiket</a></li>
              @endif
            @endif

            @if(in_array($role, ['petugas','admin']))
              @if(Route::has('ticket.scan'))
                <li><a href="{{ route('ticket.scan') }}" class="block px-2 py-1 {{ request()->routeIs('ticket.scan') ? 'underline font-semibold' : '' }}">Scan</a></li>
              @endif
              @if(Route::has('admin.scans'))
                <li><a href="{{ route('admin.scans') }}" class="block px-2 py-1 {{ request()->routeIs('admin.scans') ? 'underline font-semibold' : '' }}">Daftar Scan</a></li>
              @endif
              @if(Route::has('admin.proofs'))
                <li><a href="{{ route('admin.proofs') }}" class="block px-2 py-1 {{ request()->routeIs('admin.proofs') ? 'underline font-semibold' : '' }}">Bukti SIAK</a></li>
              @endif
              @if($role === 'admin' && Route::has('admin.users'))
                <li><a href="{{ route('admin.users') }}" class="block px-2 py-1 {{ request()->routeIs('admin.users') ? 'underline font-semibold' : '' }}">Manajemen User</a></li>
              @endif
            @endif

            @if(Route::has('logout'))
              <li>
                <a href="#" class="block px-2 py-1 text-red-600"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
                </a>
              </li>
            @endif
          @else
            @if(Route::has('login'))
              <li><a href="{{ route('login') }}" class="block px-2 py-1">Login</a></li>
            @endif
            @if(Route::has('register'))
              <li><a href="{{ route('register') }}" class="block px-2 py-1">Register</a></li>
            @endif
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  @if(Route::has('logout'))
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
  </form>
  @endif

  {{-- Konten halaman --}}
  <main class="flex-1 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
  </main>

  {{-- ===== FOOTER ===== --}}
  @php $isAdmin = isset($role) && $role === 'admin'; @endphp
  <footer class="mt-10 border-t bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4
                text-sm text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-2">

      <p class="order-2 sm:order-1">
        © {{ date('Y') }} RuangTeknologi. All rights reserved.
      </p>
    </div>
  </footer>

  {{-- Toggle mobile menu --}}
  <script>
    const btn = document.getElementById('navToggle');
    const dropdown = document.getElementById('mobileMenu');
    if (btn) {
      btn.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
      });
    }
  </script>

  @stack('scripts')
</body>
</html>
