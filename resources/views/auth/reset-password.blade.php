@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto space-y-6">
    <div class="text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Reset Password untuk {{ $u->name }}</h1>
        <p class="text-sm text-gray-500">Silakan masukkan password baru Anda.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
        <form method="POST" action="{{ route('admin.users.resetPassword', $u) }}">
            @csrf
            @method('POST')

            <!-- Password Baru -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password Baru</label>
                <input type="password" name="password" id="password" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
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
