<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/ticket/form', [TicketController::class, 'showForm'])->name('ticket.form');
    Route::post('/ticket/claim', [TicketController::class, 'claimTicket'])->name('ticket.claim');
    Route::get('/ticket/show', [TicketController::class, 'showTicket'])->name('ticket.show');
});

Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    // Scanner
    Route::get('/ticket/scan', [ScanController::class, 'scanPage'])->name('ticket.scan');
    Route::post('/ticket/verify-scan', [ScanController::class, 'verifyScan'])->name('ticket.verifyScan');

    // Daftar scan (admin & petugas)
    Route::get('/admin/scans', [AdminController::class, 'scans'])->name('admin.scans');

    // Bukti SIAK (admin & petugas)
    Route::get('/admin/proofs', [AdminController::class, 'proofs'])->name('admin.proofs');
    Route::get('/admin/proofs/{ticket}/download', [AdminController::class, 'downloadProof'])->name('admin.proofs.download');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');

    // hapus user
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])
        ->name('admin.users.destroy');

    // form tambah manual + simpan
    Route::get('/admin/scans/manual',  [AdminController::class, 'manualScanForm'])
         ->name('admin.scans.manual');
    Route::post('/admin/scans/manual', [AdminController::class, 'manualScanStore'])
         ->name('admin.scans.manual.store');
    Route::post('/scans', [ScanController::class,'store'])
         ->name('scans.store');
});

// ADMIN ONLY: ubah role
Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::post('/users/{user}/make-petugas',   [AdminController::class, 'makePetugas'])
        ->name('users.make-petugas');
    Route::post('/users/{user}/revoke-petugas', [AdminController::class, 'revokePetugas'])
        ->name('users.revoke-petugas');
});

