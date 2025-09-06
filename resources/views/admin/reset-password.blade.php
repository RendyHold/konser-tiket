@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto space-y-6">
    <!-- Notifikasi Sukses -->
    @if (session('status'))
        <div class="bg-green-500 text-white p-4 rounded-lg text-center">
            {{ session('status') }}
        </div>
    @endif

    <!-- Judul dan Keterangan -->
    <div class="text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Reset Password untuk {{ $u->name }}</h1>
        <p class="text-sm text-gray-500">Silakan masukkan password baru Anda.</p>
    </div>

    <!-- Form Reset Password -->
    <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
        <form method="POST" action="{{ route('admin.resetPassword', ['user' => $u]) }}">
            @csrf
            @method('POST')

            <!-- Password Baru -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Password Baru')" class="text-sm font-semibold text-gray-700" />
                <x-text-input
                    id="password"
                    class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="password"
                    name="password"
                    required
                />
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input
                    id="password_confirmation"
                    class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="password"
                    name="password_confirmation"
                    required
                />
            </div>

            <!-- Tombol Reset Password -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none transition">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
