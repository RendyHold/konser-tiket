<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // Menampilkan form reset password berdasarkan token
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Proses reset password
    public function reset(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
        'token' => 'required',
    ]);

    // Mencari user berdasarkan token
    $user = User::where('email', $request->email)
                ->where('reset_token', $request->token)
                ->first();

    if (!$user) {
        return redirect()->route('password.reset', ['token' => $request->token])
                         ->withErrors(['email' => 'Token atau email tidak valid.']);
    }

    // Reset password
    $user->password = Hash::make($request->password);
    $user->reset_token = null;  // Hapus token setelah reset
    $user->save();

    return redirect()->route('login')->with('success', 'Password berhasil direset.');
}

}
