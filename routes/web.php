<?php

use App\Models\Package;
use App\Models\Cabang;
use App\Models\Artikel;
use App\Models\Kontak;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManifestController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK (Akses Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $packages = Package::latest()->get();
    return view('welcome', compact('packages'));
})->name('home');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

// Halaman Daftar Artikel untuk User
Route::get('/artikel', function () {
    $artikels = Artikel::latest()->paginate(6);
    return view('artikel', compact('artikels'));
})->name('artikel');

// FIX: Tambahkan Route Detail Artikel untuk User agar tidak error 500
Route::get('/artikel/detail/{id}', function ($id) {
    $artikel = Artikel::findOrFail($id);
    return view('artikel_detail', compact('artikel'));
})->name('artikel.detail');

Route::get('/kantor-cabang', function () {
    $cabangs = Cabang::all();
    return view('kantor_cabang', compact('cabangs'));
})->name('kantor.cabang');

Route::get('/booking/detail/{id}', [BookingController::class, 'show'])->name('user.booking.show');


/*
|--------------------------------------------------------------------------
| 2. AREA LOGIN (Agen & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD & RIWAYAT USER (AGEN) ---
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('riwayat');
    Route::post('/pembayaran/pelunasan', [BookingController::class, 'pelunasan'])->name('pembayaran.pelunasan');

    /*
    |--------------------------------------------------------------------------
    | 3. PANEL ADMIN (Khusus Role Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard & Riwayat Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('riwayat');

        // Kelola Artikel (Index, Create, Edit, Delete)
        Route::get('/artikel/kelola', [AdminController::class, 'indexArtikel'])->name('artikel.index');
        Route::get('/artikel/tambah', [AdminController::class, 'createArtikel'])->name('artikel.create');
        Route::post('/artikel/store', [AdminController::class, 'storeArtikel'])->name('artikel.store');
        Route::get('/artikel/edit/{id}', [AdminController::class, 'editArtikel'])->name('artikel.edit');
        Route::put('/artikel/update/{id}', [AdminController::class, 'updateArtikel'])->name('artikel.update');
        Route::delete('/artikel/delete/{id}', [AdminController::class, 'destroyArtikel'])->name('artikel.destroy');

        // Kelola Cabang
        Route::get('/cabang/kelola', [AdminController::class, 'indexCabang'])->name('cabang.index');
        Route::post('/cabang/store', [AdminController::class, 'storeCabang'])->name('cabang.store');
        Route::put('/cabang/update/{id}', [AdminController::class, 'updateCabang'])->name('cabang.update');
        Route::delete('/cabang/delete/{id}', [AdminController::class, 'destroyCabang'])->name('cabang.destroy');

        // Kelola Kontak
        Route::get('/kontak/kelola', [AdminController::class, 'indexKontak'])->name('kontak.index');
        Route::delete('/kontak/delete/{id}', [AdminController::class, 'destroyKontak'])->name('kontak.destroy');

        // Verifikasi & Pembayaran
        Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/verify/{id}', [AdminController::class, 'verify'])->name('verify');
        Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('reject');
        Route::get('/booking/{id}', [AdminController::class, 'show'])->name('booking.show');
        Route::get('/kwitansi/{id}', [AdminController::class, 'cetakKwitansi'])->name('kwitansi');

        // Master Data Paket & Transport
        Route::get('/transport', [AdminController::class, 'indexTransport'])->name('transport.index');
        Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('packages.create');
        Route::post('/packages/store', [AdminController::class, 'storePackage'])->name('packages.store');
        Route::get('/packages/edit/{id}', [AdminController::class, 'editPackage'])->name('packages.edit');
        Route::put('/packages/update/{id}', [AdminController::class, 'updatePackage'])->name('packages.update');
        Route::delete('/packages/delete/{id}', [AdminController::class, 'destroyPackage'])->name('packages.destroy');

        // Update Kurs
        Route::post('/exchange-rates/update', [AdminController::class, 'updateExchangeRate'])->name('rates.update');
        Route::post('/validate-jamaah', [BookingController::class, 'validateJamaah'])->name('validate.jamaah');
    });

    /*
    |--------------------------------------------------------------------------
    | 4. MANIFEST / DATA JAMAAH
    |--------------------------------------------------------------------------
    */
    Route::prefix('manifest')->name('manifest.')->group(function () {
        Route::get('/create/{booking_id}', [ManifestController::class, 'create'])->name('create');
        Route::post('/store/{booking_id}', [ManifestController::class, 'store'])->name('store');
        Route::get('/show/{booking_id}', [ManifestController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [ManifestController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ManifestController::class, 'update'])->name('update');
    });

    /*
    |--------------------------------------------------------------------------
    | 5. ALUR BOOKING AGEN
    |--------------------------------------------------------------------------
    */
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/pendaftaran/{id}', [BookingController::class, 'create'])->name('pendaftaran');
        Route::post('/store/{id}', [BookingController::class, 'store'])->name('store');
        Route::get('/payment/{id}', [BookingController::class, 'payment'])->name('payment');
        Route::post('/pay-process/{id}', [BookingController::class, 'storePayment'])->name('pay.process');
        Route::get('/invoice/{id}', [BookingController::class, 'invoice'])->name('invoice');
        Route::post('/add-service/{id}', [BookingController::class, 'addService'])->name('add-service');
    });

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
