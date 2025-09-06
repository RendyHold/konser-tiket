<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetRequest;

class PasswordResetController extends Controller
{
    // Menampilkan halaman reset password berdasarkan token
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Menangani proses reset password
    public function reset(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Jika validasi gagal, redirect kembali ke form dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cari pengguna berdasarkan token dan email
        $user = User::where('reset_token', $request->token)->first();

        // Cek apakah user ada dan token valid
        if (!$user || $user->email !== $request->email) {
            return redirect()->route('password.reset', ['token' => $request->token])
                             ->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // Reset password
        $user->password = Hash::make($request->password);
        $user->reset_token = null; // Hapus token setelah reset
        $user->save();

        // Arahkan pengguna ke halaman login setelah password berhasil direset
        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    public function sendResetPasswordLink(Request $request)
    {
        $user = user::where('email', $request->email)->first();

        if (!$user) {
            $token = Str::random(60);
            $user->reset_token = $token;
            $user->save();

        // kirim email dengan token reset password
        Mail::to($user->email)->send(new PasswordResetRequest($token));

        return redirect()->route('login')->with('status', 'Password reset link telah dikirim ke email Anda.');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan.']);
    }
}

