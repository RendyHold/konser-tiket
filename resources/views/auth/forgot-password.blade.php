{{-- resources/views/auth/forgot-password.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 antialiased">
<main class="min-h-screen flex items-center justify-center p-4">
    <section class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 md:p-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-4 text-center">Forgot your password?</h1>
        <p class="mb-6 text-sm text-gray-600 text-center">
            No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </p>

        {{-- Session status --}}
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold
                               text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
