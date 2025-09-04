{{-- resources/views/auth/login.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Tailwind CDN (agar tampil rapi tanpa build) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 antialiased">
<main class="min-h-screen flex items-center justify-center p-4">
    <section class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 md:p-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign in to your account</h1>

        {{-- Session status --}}
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember" class="inline-flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-indigo-600 hover:text-indigo-800">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Create an account
                    </a>
                @endif

                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold
                               text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                    LOG IN
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
