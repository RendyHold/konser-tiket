<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    {{-- Navbar --}}
    <nav class="bg-white shadow mb-6">
        <div class="container mx-auto flex justify-between items-center px-4 py-3">
            <div class="text-xl font-bold">KonserScan</div>
            <div class="space-x-4">
                @auth
                    {{-- Menu untuk semua user --}}
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>

                    {{-- Menu untuk User biasa --}}
                    @if(Auth::user()->role === 'user')
                        <a href="{{ route('ticket.show') }}" class="hover:underline">Tiket Saya</a>
                    @endif

                    {{-- Menu untuk User biasa --}}
                    @if(Auth::user()->role === 'user')
                        <a href="{{ route('__('Profile') }}" class="hover:underline">Profile</a>
                    @endif


                    {{-- Menu untuk Petugas --}}
                    @if(Auth::user()->role === 'petugas')
                        <a href="{{ route('ticket.scan') }}" class="hover:underline">Scan Tiket</a>
                    @endif

                    {{-- Menu untuk Admin --}}
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('ticket.scan') }}" class="hover:underline">Scan Tiket</a>
                        <a href="{{ route('admin.scans') }}" class="hover:underline">Daftar Scan</a>
                        <a href="{{ route('admin.users') }}" class="hover:underline">Manajemen User</a>
                    @endif

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline text-red-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten utama --}}
    <div class="container mx-auto">
        @yield('content')
    </div>
</body>
</html>
