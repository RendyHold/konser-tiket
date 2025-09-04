{{-- resources/views/auth/register.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Tailwind CDN untuk styling cepat -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 antialiased">
<main class="min-h-screen flex items-center justify-center p-4">
    <section class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 md:p-10">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8 object-contain rounded">
            <h1 class="text-xl font-semibold text-gray-900">Create your account</h1>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- NPM -->
            <div>
                <label for="npm" class="block text-sm font-medium text-gray-700 mb-1">NPM</label>
                <input id="npm" name="npm" type="text" value="{{ old('npm') }}" required
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('npm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('password_confirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Footer actions -->
            <div class="flex flex-col-reverse items-start gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                    Already registered?
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold
                               text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                    REGISTER
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
