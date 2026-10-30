<style>
    :root {
        --teal-bintang: #2C4E58;
        --gold-bintang: #C5A367;
    }

    .navbar-custom {
        background-color: var(--teal-bintang);
        padding: 0 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 80px;
        width: 100%;
        box-sizing: border-box;
    }

    .nav-left {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .nav-brand {
        color: white;
        font-weight: 800;
        font-size: 1.25rem;
        text-transform: uppercase;
        text-decoration: none;
        letter-spacing: 0.05em;
        margin-right: 3rem;
        display: flex;
        align-items: center;
        height: 100%;
    }

    .nav-menu-list {
        display: flex;
        align-items: center;
        gap: 1.8rem;
        height: 100%;
    }

    .nav-link-custom {
        color: white !important;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: flex;
        align-items: center;
        height: 100%;
        padding: 0 5px;
        transition: all 0.3s ease;
        opacity: 0.8;
        border-bottom: 3px solid transparent;
        box-sizing: border-box;
    }

    .nav-link-custom:hover,
    .nav-link-custom.active {
        opacity: 1;
        border-bottom: 3px solid var(--gold-bintang);
    }

    .nav-right {
        display: flex;
        align-items: center;
    }

    .btn-keluar {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-keluar:hover {
        background-color: white;
        color: var(--teal-bintang);
    }
</style>

<nav class="navbar-custom">
    <div class="nav-left">
        <a href="{{ route('home') }}" class="nav-brand">BINTANG GLOBAL</a>

        <div class="nav-menu-list">
            <a href="{{ route('home') }}" class="nav-link-custom {{ request()->is('/') ? 'active' : '' }}">Home</a>

            <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard') }}"
               class="nav-link-custom {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Portal Booking
            </a>

            <a href="{{ Auth::user()->role == 'admin' ? route('admin.riwayat') : route('riwayat') }}"
               class="nav-link-custom {{ request()->routeIs('riwayat') || request()->routeIs('admin.riwayat') ? 'active' : '' }}">
                Riwayat Transaksi
            </a>

            <a href="{{ Auth::user()->role == 'admin' ? route('admin.kontak.index') : route('kontak') }}"
               class="nav-link-custom {{ request()->routeIs('kontak') || request()->routeIs('admin.kontak.index') ? 'active' : '' }}">
                Kontak
            </a>

            <a href="{{ Auth::user()->role == 'admin' ? route('admin.artikel.index') : route('artikel') }}"
               class="nav-link-custom {{ request()->routeIs('artikel') || request()->routeIs('admin.artikel.index') ? 'active' : '' }}">
                Artikel
            </a>

            <a href="{{ Auth::user()->role == 'admin' ? route('admin.cabang.index') : route('kantor.cabang') }}"
               class="nav-link-custom {{ request()->routeIs('kantor.cabang') || request()->routeIs('admin.cabang.index') ? 'active' : '' }}">
                Kantor Cab
            </a>
        </div>
    </div>

    <div class="nav-right">
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-keluar">Keluar</button>
        </form>
    </div>
</nav>
