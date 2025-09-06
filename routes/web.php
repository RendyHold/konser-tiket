<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ScanController;        // <= yang punya index() paginate(5)
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

Route::get('/files/{path}', function (string $path) {
    abort_unless(Storage::disk('public')->exists($path), 404);
    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('files.proxy');

/* Halaman publik */
Route::view('/', 'welcome')->name('home');

/* Dashboard (jangan dua kali) */
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
/* Auth scaffolding */
require __DIR__ . '/auth.php';

/* User login */
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket klaim / lihat
    Route::prefix('ticket')->group(function () {
        Route::get('/form', [TicketController::class, 'showForm'])->name('ticket.form');
        Route::post('/claim', [TicketController::class, 'claimTicket'])->name('ticket.claim');
        Route::get('/show', [TicketController::class, 'showTicket'])->name('ticket.show');
    });
});

/* Admin & Petugas */
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    // Scanner
    Route::get('/ticket/scan', [ScanController::class, 'scanPage'])->name('ticket.scan');
    Route::post('/ticket/verify-scan', [ScanController::class, 'verifyScan'])->name('ticket.verifyScan');

    // Daftar scan (PAGINATE 5)
    Route::get('/admin/scans', [ScanController::class, 'index'])->name('admin.scans');

    // Bukti SIAK
    Route::get('/admin/proofs', [AdminController::class, 'proofs'])->name('admin.proofs');
    Route::get('/admin/proofs/{ticket}/download', [AdminController::class, 'downloadProof'])->name('admin.proofs.download');

    // User admin/petugas
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Tambah manual scan
    Route::get('/admin/scans/manual',  [AdminController::class, 'manualScanForm'])->name('admin.scans.manual');
    Route::post('/admin/scans/manual', [AdminController::class, 'manualScanStore'])->name('admin.scans.manual.store');

    // (kalau perlu)
    Route::post('/scans', [ScanController::class, 'store'])->name('scans.store');
});

/* Admin only: ubah role */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/users/{user}/make-petugas',   [AdminController::class, 'makePetugas'])->name('users.make-petugas');
    Route::post('/users/{user}/revoke-petugas', [AdminController::class, 'revokePetugas'])->name('users.revoke-petugas');
    Route::post('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});
