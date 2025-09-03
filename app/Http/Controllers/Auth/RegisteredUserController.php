<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','lowercase','email','max:255', Rule::unique('users','email')],
            'password' => ['required','confirmed', Rules\Password::defaults()],
            'npm'      => ['required','string','max:50', Rule::unique('users','npm')], // <- wajib unik
        ], [
            'npm.unique'   => 'NPM ini sudah terdaftar. Silakan login atau gunakan NPM lain.',
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);

        try {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'npm'      => $validated['npm'],
            ]);
        } catch (QueryException $e) {
            // jaga-jaga kalau balapan request menabrak UNIQUE di DB
            if ($e->getCode() === '23000') {
                return back()
                    ->withErrors(['npm' => 'NPM atau Email ini sudah terdaftar.'])
                    ->withInput();
            }
            throw $e;
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard'); // lebih jelas
    }
}
