{{-- resources/views/auth/reset-password.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 antialiased">
<main class="min-h-screen flex items-center justify-center p-4">
    <section class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 md:p-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Reset your password</h1>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('password_confirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end pt-2">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold
                               text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                    Reset Password
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
