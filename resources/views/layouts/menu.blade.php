
@php
    $isActive = fn ($patterns) => request()->routeIs(...(array) $patterns);
@endphp

<style>
    .atk-nav {
        display: flex;
        flex-direction: column;
        min-height: 100%;
        flex: 1;
        padding: 24px 16px 16px;
        color: #0F172A;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .atk-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0 8px 24px;
        border-bottom: 1px solid #E2E8F0;
        margin-bottom: 22px;
        position: relative;
    }

    .atk-brand::after {
        content: "";
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #E5B93C;
    }

    .atk-brand-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #F0F9FF;
        border: 1px solid #BAE6FD;
        overflow: hidden;
    }

    .atk-brand-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 5px;
    }

    .atk-brand-title {
        font-size: 15px;
        font-weight: 800;
        line-height: 1.4;
        letter-spacing: -.3px;
        color: #0F172A;
    }

    .atk-brand-subtitle {
        margin-top: 3px;
        color: #64748B;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.5;
    }

    .atk-nav-section {
        margin: 0 0 8px;
        padding: 0 12px;
        color: #94A3B8;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .atk-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 42px;
        margin-bottom: 4px;
        padding: 10px 14px;
        color: #475569;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border-radius: 999px;
        transition: background .18s ease, color .18s ease;
    }

    .atk-nav-link .material-symbols-outlined {
        font-size: 21px;
        color: #94A3B8;
        flex-shrink: 0;
    }

    .atk-nav-link:hover {
        background: #F0F9FF;
        color: #0284C7;
    }

    .atk-nav-link:hover .material-symbols-outlined {
        color: #0284C7;
    }

    .atk-nav-link.active {
        color: #FFFFFF;
        background: #38BDF8;
        font-weight: 700;
    }

    .atk-nav-link.active .material-symbols-outlined {
        color: #FFFFFF;
        font-variation-settings: 'FILL' 1;
    }

    .atk-nav-divider {
        height: 1px;
        margin: 16px 0;
        background: #E2E8F0;
    }

    .atk-nav-spacer {
        flex: 1;
        min-height: 24px;
    }

    .atk-nav-account {
        padding: 14px 12px 0;
        border-top: 1px solid #E2E8F0;
        margin-top: 18px;
    }

    .atk-nav-account-name {
        overflow: hidden;
        color: #0F172A;
        font-size: 12px;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .atk-nav-account-role {
        margin-top: 4px;
        color: #94A3B8;
        font-size: 10px;
    }

    .atk-nav-logout {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        margin-top: 13px;
        padding: 10px 12px;
        color: #DC2626;
        background: transparent;
        border: 0;
        border-radius: 10px;
        text-align: left;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .atk-nav-logout:hover {
        background: #FEF2F2;
    }

    .atk-nav-logout .material-symbols-outlined {
        font-size: 20px;
    }

    .atk-nav-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        margin-left: auto;
        padding: 0 6px;
        border-radius: 999px;
        background: #FEE2E2;
        color: #DC2626;
        font-size: 10px;
        font-weight: 800;
    }

    @media (max-width: 767.98px) {
        .atk-nav {
            min-height: calc(100vh - 70px);
        }
    }
</style>

<nav class="atk-nav">

    {{-- BRAND --}}
    <div class="atk-brand">
        <div class="atk-brand-icon">
            <img
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpEnqdqKydWiQ6NmXAOd8jpMBdR1BgPoMuXZitKvVOM-9kC6gNYfpGdTv_Czl0zGhGIRPjTxdFsd--R_6At1-k_m6IQfg-Q4cLbByrq43KXW64wJ1lLu1_AQ9ETv9R3H3UH-PxhHR9cRoLeoIBvNcrO1hBauk60gLZ0UrOA7HlR9cAclE6E5DQRY4EIKKC6mcVY3j6a2KULs9CImD7CgZxGyXWph2_nwRTb3Fl7vnF6FJQt7R1Dsnph4ucTvHVRvFFAA"
                alt="Logo Pusri"
            >
        </div>

        <div>
            <div class="atk-brand-title">Learning Center</div>
            <div class="atk-brand-subtitle">PT. Pupuk Sriwidjaja</div>
        </div>
    </div>

    {{-- DASHBOARD --}}
    <a href="{{ route('home') }}"
       class="atk-nav-link {{ $isActive('home') ? 'active' : '' }}">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
    </a>

    {{-- MASTER DATA --}}
    <div class="mt-4">
        <div class="atk-nav-section">Master Data</div>

        @can('barang.view')
            <a href="{{ route('barangs.index') }}"
               class="atk-nav-link {{ $isActive(['barangs.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span>Daftar Barang</span>
            </a>
        @endcan

        @can('kategori.view')
            <a href="{{ route('categories.index') }}"
               class="atk-nav-link {{ $isActive(['categories.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">category</span>
                <span>Kategori Barang</span>
            </a>
        @endcan

        @can('satuan.view')
            <a href="{{ route('units.index') }}"
               class="atk-nav-link {{ $isActive(['units.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">straighten</span>
                <span>Satuan</span>
            </a>
        @endcan

        @can('supplier.view')
            <a href="{{ route('suppliers.index') }}"
               class="atk-nav-link {{ $isActive(['suppliers.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">local_shipping</span>
                <span>Supplier</span>
            </a>
        @endcan
    </div>

    {{-- TRANSAKSI --}}
    <div class="mt-4">
        <div class="atk-nav-section">Transaksi</div>

        @can('barang-masuk.view')
            <a href="{{ route('stock-in.index') }}"
               class="atk-nav-link {{ $isActive(['stock-in.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">move_to_inbox</span>
                <span>Barang Masuk</span>
            </a>
        @endcan

        @can('barang-keluar.view')
            <a href="{{ route('stock-out.index') }}"
               class="atk-nav-link {{ $isActive(['stock-out.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">outbox</span>
                <span>Barang Keluar</span>
            </a>

            <a href="{{ route('usage.index') }}"
               class="atk-nav-link {{ $isActive(['usage.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Penggunaan ATK</span>
            </a>
        @endcan
    </div>

    {{-- PERSEDIAAN --}}
    <div class="mt-4">
        <div class="atk-nav-section">Persediaan</div>

        @can('barang.view')
            <a href="{{ route('monitoring.index') }}"
               class="atk-nav-link {{ $isActive(['monitoring.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">monitoring</span>
                <span>Monitoring Stok</span>
            </a>

            <a href="{{ route('stock-history.index') }}"
               class="atk-nav-link {{ $isActive(['stock-history.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">history</span>
                <span>Riwayat Stok</span>
            </a>
        @endcan

        @can('stock-opname.view')
            <a href="{{ route('stock-opname.index') }}"
               class="atk-nav-link {{ $isActive(['stock-opname.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">fact_check</span>
                <span>Stock Opname</span>
            </a>
        @endcan
    </div>

    {{-- LAPORAN --}}
    @can('laporan.view')
        <div class="mt-4">
            <div class="atk-nav-section">Laporan</div>

            <a href="{{ route('reports.index') }}"
               class="atk-nav-link {{ $isActive(['reports.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">summarize</span>
                <span>Laporan</span>
            </a>
        </div>
    @endcan

    {{-- MANAGEMENT --}}
    <div class="mt-4">
        <div class="atk-nav-section">Management</div>

        @can('user.view')
            <a href="{{ route('users.index') }}"
               class="atk-nav-link {{ $isActive(['users.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">group</span>
                <span>Pengguna</span>
            </a>
        @endcan

        @can('role.view')
            <a href="{{ route('roles.index') }}"
               class="atk-nav-link {{ $isActive(['roles.*']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">badge</span>
                <span>Role</span>
            </a>
        @endcan

        <a href="{{ url('/permissions') }}"
           class="atk-nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">lock_person</span>
            <span>Permission</span>
        </a>
    </div>

    {{-- RUANG KOSONG --}}
    <div class="atk-nav-spacer"></div>

    {{-- AKUN DAN LOGOUT --}}
    <div class="atk-nav-account">
        <div class="atk-nav-account-name">
            {{ auth()->user()?->name ?? 'Pengguna' }}
        </div>

        <div class="atk-nav-account-role">
            {{ auth()->user()?->getRoleNames()->first() ?? 'Pengguna' }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="atk-nav-logout">
                <span class="material-symbols-outlined">logout</span>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</nav>
