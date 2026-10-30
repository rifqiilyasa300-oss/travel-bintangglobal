<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- FITUR: REDIRECT SETELAH LOGIN ---
        // Jika agen klik 'Booking Sekarang' saat belum login,
        // setelah login sukses akan langsung dilempar ke form booking tersebut.
        if ($request->has('redirect_to')) {
            return redirect($request->query('redirect_to'));
        }

        // Jika login biasa, masuk ke dashboard utama
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // --- REVISI DISINI ---
        // Kita ubah dari '/login' menjadi '/'
        // Agar saat logout, agen balik ke halaman welcome (daftar paket)
        return redirect('/');
    }
}
