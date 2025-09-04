{{-- resources/views/auth/register.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Tailwind CDN (solusi instan tampilan rapi) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 antialiased">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8">
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-2">
                <img src="{{ asset('logo.png') }}" alt="My Logo" class="h-8 w-8 object-contain">
                <span class="text-lg font-semibold text-gray-800">My Logo</span>
            </a>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="npm" class="block text-sm font-medium text-gray-700">NPM</label>
                <input id="npm" name="npm" type="text" value="{{ old('npm') }}" required
                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('npm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('password_confirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-600 hover:text-gray-900 underline">
                    Already registered?
                </a>

                <button type="submit"
                        class="inline-flex items-center rounded-xl bg-gray-900 px-5 py-2.5 text-white font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                    REGISTER
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
