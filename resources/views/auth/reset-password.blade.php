@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div>
        <h1 class="text-xl font-semibold">Reset Password</h1>
        <p class="text-sm text-gray-500">Silakan masukkan password baru Anda</p>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <form method="POST" action="{{ route('user.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Input (optional, already passed in the token) -->
            <div class="mb-4">
                <label for="email" class="text-sm font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full mt-2 p-2 border rounded" required />
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="text-sm font-semibold">Password Baru</label>
                <input type="password" name="password" id="password" class="w-full mt-2 p-2 border rounded" required />
            </div>

            <!-- Password Confirmation Input -->
            <div class="mb-4">
                <label for="password_confirmation" class="text-sm font-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full mt-2 p-2 border rounded" required />
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
