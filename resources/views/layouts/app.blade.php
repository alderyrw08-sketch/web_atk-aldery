
<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem ATK | PT Pupuk Sriwidjaja')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#006591',
                        'primary-container': '#0ea5e9',
                        'primary-fixed': '#c9e6ff',
                        'primary-fixed-dim': '#89ceff',
                        'on-primary': '#ffffff',
                        'on-primary-container': '#003751',
                        'on-primary-fixed': '#001e2f',
                        'on-primary-fixed-variant': '#004c6e',
                        secondary: '#00668a',
                        'secondary-container': '#40c2fd',
                        'secondary-fixed': '#c4e7ff',
                        'secondary-fixed-dim': '#7bd0ff',
                        'on-secondary': '#ffffff',
                        'on-secondary-container': '#004d6a',
                        'on-secondary-fixed': '#001e2c',
                        'on-secondary-fixed-variant': '#004c69',
                        tertiary: '#006e2f',
                        'tertiary-container': '#00b351',
                        'tertiary-fixed': '#6bff8f',
                        'tertiary-fixed-dim': '#4ae176',
                        'on-tertiary': '#ffffff',
                        'on-tertiary-container': '#003c16',
                        'on-tertiary-fixed': '#002109',
                        'on-tertiary-fixed-variant': '#005321',
                        surface: '#faf8ff',
                        'surface-dim': '#d2d9f4',
                        'surface-bright': '#faf8ff',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-low': '#f2f3ff',
                        'surface-container': '#eaedff',
                        'surface-container-high': '#e2e7ff',
                        'surface-container-highest': '#dae2fd',
                        'on-surface': '#131b2e',
                        'on-surface-variant': '#3e4850',
                        outline: '#6e7881',
                        'outline-variant': '#bec8d2',
                        error: '#ba1a1a',
                        'error-container': '#ffdad6',
                        'on-error': '#ffffff',
                        'on-error-container': '#93000a',
                        gold: '#E5B93C',
                        'pusri-text': '#0F172A',
                        'pusri-gray': '#94A3B8'
                    },
                    borderRadius: {
                        DEFAULT: '1rem',
                        lg: '2rem',
                        xl: '3rem',
                        full: '9999px'
                    },
                    spacing: {
                        'space-xs': '0.25rem',
                        'space-sm': '0.5rem',
                        'space-md': '1rem',
                        'space-lg': '1.5rem',
                        'space-xl': '2.5rem',
                        margin: '2.5rem',
                        gutter: '1.5rem'
                    },
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif'],
                        'label-lg': ['Plus Jakarta Sans'],
                        'display-hero': ['Plus Jakarta Sans'],
                        'title-lg': ['Plus Jakarta Sans'],
                        'body-sm': ['Plus Jakarta Sans'],
                        'label-md': ['Plus Jakarta Sans'],
                        'headline-sm': ['Plus Jakarta Sans'],
                        'headline-md': ['Plus Jakarta Sans'],
                        'body-lg': ['Plus Jakarta Sans'],
                        'body-md': ['Plus Jakarta Sans'],
                        'headline-lg': ['Plus Jakarta Sans'],
                        'title-md': ['Plus Jakarta Sans'],
                        'label-sm': ['Plus Jakarta Sans']
                    },
                    fontSize: {
                        'label-lg': ['14px', { lineHeight: '20px', letterSpacing: '0.01em', fontWeight: '600' }],
                        'display-hero': ['48px', { lineHeight: '56px', letterSpacing: '-0.02em', fontWeight: '700' }],
                        'title-lg': ['18px', { lineHeight: '26px', letterSpacing: '0em', fontWeight: '600' }],
                        'body-sm': ['12px', { lineHeight: '18px', letterSpacing: '0.01em', fontWeight: '400' }],
                        'label-md': ['12px', { lineHeight: '16px', letterSpacing: '0.02em', fontWeight: '600' }],
                        'headline-sm': ['22px', { lineHeight: '30px', letterSpacing: '-0.01em', fontWeight: '600' }],
                        'headline-md': ['28px', { lineHeight: '36px', letterSpacing: '-0.015em', fontWeight: '600' }],
                        'body-lg': ['16px', { lineHeight: '26px', letterSpacing: '0em', fontWeight: '400' }],
                        'body-md': ['14px', { lineHeight: '22px', letterSpacing: '0em', fontWeight: '400' }],
                        'headline-lg': ['36px', { lineHeight: '44px', letterSpacing: '-0.02em', fontWeight: '700' }],
                        'title-md': ['16px', { lineHeight: '24px', letterSpacing: '0em', fontWeight: '600' }],
                        'label-sm': ['11px', { lineHeight: '14px', letterSpacing: '0.05em', fontWeight: '700' }]
                    }
                }
            }
        };
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            width: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #faf8ff;
            color: #131b2e;
        }

        body {
            overflow-x: hidden;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            display: inline-block;
            white-space: nowrap;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /* SIDEBAR */
        .app-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1050;
            width: 260px;
            height: 100vh;
            height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            background: linear-gradient(180deg, #ffffff 0%, #f2f3ff 100%);
            border-right: 1px solid rgba(190, 200, 210, .3);
            transition: transform .25s ease;
        }

        .app-sidebar nav {
            flex: 1;
            min-height: 100%;
        }

        /* MAIN */
        .app-main-wrapper {
            min-height: 100vh;
            margin-left: 260px;
        }

        /* HEADER */
        .app-topbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            z-index: 1040;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 0 24px;
            background: rgba(255, 255, 255, .97);
            border-bottom: 1px solid rgba(190, 200, 210, .3);
            box-shadow: 0 1px 8px rgba(0, 0, 0, .03);
            backdrop-filter: blur(12px);
        }

        .app-topbar-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .app-topbar-accent {
            width: 4px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 99px;
            background: #006591;
        }

        .app-topbar-title {
            font-size: 14px;
            font-weight: 600;
            color: #3e4850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .app-topbar-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
        }

        .app-date {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid rgba(190, 200, 210, .3);
            border-radius: 99px;
            background: #f2f3ff;
            color: #3e4850;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .app-icon-button {
            position: relative;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #3e4850;
            cursor: pointer;
        }

        .app-icon-button:hover {
            background: #eaedff;
        }

        .app-notification-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ba1a1a;
            box-shadow: 0 0 0 2px white;
        }

        .app-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 14px;
            border-left: 1px solid rgba(190, 200, 210, .4);
        }

        .app-profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .app-profile-name {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 600;
        }

        .app-profile-role {
            padding: 4px 9px;
            border-radius: 99px;
            background: #e2e7ff;
            color: #006591;
            font-size: 10px;
            font-weight: 700;
        }

        .app-profile-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(190, 200, 210, .4);
            border-radius: 50%;
            background: #e8edff;
            color: #006591;
        }

        /* AREA KONTEN */
        .app-content {
            width: 100%;
            min-height: 100vh;
            padding-top: 72px;
            background: #faf8ff;
        }

        .app-mobile-menu {
            display: none;
        }

        .app-sidebar-overlay {
            display: none;
        }

        @media (max-width: 900px) {
            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.is-open {
                transform: translateX(0);
            }

            .app-sidebar-overlay.is-visible {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1045;
                background: rgba(19, 27, 46, .35);
            }

            .app-main-wrapper {
                margin-left: 0;
            }

            .app-topbar {
                left: 0;
                padding: 0 16px;
            }

            .app-mobile-menu {
                display: flex;
            }

            .app-topbar-actions {
                gap: 8px;
            }

            .app-date {
                display: none;
            }
        }

        @media (max-width: 520px) {
            .app-topbar {
                height: 64px;
                padding: 0 12px;
            }

            .app-content {
                padding-top: 64px;
            }

            .app-topbar-title {
                font-size: 12px;
            }

            .app-profile {
                gap: 7px;
                padding-left: 8px;
            }

            .app-profile-info {
                display: none;
            }

            .app-profile-avatar {
                width: 32px;
                height: 32px;
            }
        }
    </style>

    @include('layouts.inventory-styles')
    @stack('styles')
</head>

<body class="bg-surface text-on-surface antialiased">

@auth

    <div class="app-sidebar-overlay" id="sidebar-overlay"></div>

    <!-- SIDEBAR: SEMUA ISINYA DIATUR MENU.BLADE.PHP -->
    <aside class="app-sidebar" id="app-sidebar">
        @include('layouts.menu')
    </aside>

    <!-- KONTEN UTAMA -->
    <div class="app-main-wrapper">

        <!-- HEADER: TIDAK MEMBUAT LOGO ATAU JUDUL SIDEBAR LAGI -->
        <header class="app-topbar">

            <div class="app-topbar-heading">

                <button
                    type="button"
                    class="app-icon-button app-mobile-menu"
                    id="sidebar-toggle"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false"
                >
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="app-topbar-accent hidden sm:block"></div>

                <span class="app-topbar-title">
                    @yield('page-title', 'Learning & Development')
                </span>
            </div>

            <div class="app-topbar-actions">

                <div class="app-date">
                    <span
                        class="material-symbols-outlined"
                        style="font-size:18px;color:#006591"
                    >calendar_today</span>

                    <span>
                        {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                    </span>
                </div>

                <button
                    class="app-icon-button"
                    type="button"
                    aria-label="Notifikasi"
                    title="Notifikasi"
                >
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="app-notification-dot"></span>
                </button>

                <div class="app-profile">

                    <div class="app-profile-info">
                        <span class="app-profile-name">
                            {{ Auth::user()->name }}
                        </span>

                        <span class="app-profile-role">
                            {{ Auth::user()->getRoleNames()->first() ?? 'Admin' }}
                        </span>
                    </div>

                    <div class="app-profile-avatar">
                        <span class="material-symbols-outlined">account_circle</span>
                    </div>

                </div>

            </div>
        </header>

        <main class="app-content">
            @yield('content')
        </main>

    </div>

@else

    <main>
        @yield('content')
    </main>

@endauth

<div class="modal fade inventory-confirm-modal" id="inventory-confirm-modal" tabindex="-1" aria-labelledby="inventory-confirm-title" aria-describedby="inventory-confirm-message" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <span class="inventory-confirm-icon"><span class="material-symbols-outlined" id="inventory-confirm-icon">warning</span></span>
                <h2 class="inventory-confirm-title" id="inventory-confirm-title">Konfirmasi tindakan</h2>
                <p class="inventory-confirm-message" id="inventory-confirm-message"></p>
            </div>
            <div class="inventory-confirm-actions">
                <button type="button" class="inv-button inv-button-outline" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="inv-button confirm-submit" id="inventory-confirm-submit">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('app-sidebar');
    const toggle = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');

    if (!sidebar || !toggle || !overlay) {
        return;
    }

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
        toggle.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function () {
        sidebar.classList.contains('is-open')
            ? closeSidebar()
            : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            closeSidebar();
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('inventory-confirm-modal');
    const confirmModal = new bootstrap.Modal(modalElement);
    let pendingForm = null;

    document.addEventListener('submit', function (event) {
        const form = event.target.closest('form[data-confirm-title]');
        if (!form) return;

        event.preventDefault();
        pendingForm = form;
        modalElement.classList.toggle('is-danger', form.dataset.confirmTone === 'danger');
        document.getElementById('inventory-confirm-title').textContent = form.dataset.confirmTitle;
        document.getElementById('inventory-confirm-message').textContent = form.dataset.confirmMessage;
        document.getElementById('inventory-confirm-submit').textContent = form.dataset.confirmAction || 'Lanjutkan';
        document.getElementById('inventory-confirm-icon').textContent = form.dataset.confirmIcon || 'warning';
        confirmModal.show();
    });

    document.getElementById('inventory-confirm-submit').addEventListener('click', function () {
        if (pendingForm) {
            HTMLFormElement.prototype.submit.call(pendingForm);
        }
    });

    modalElement.addEventListener('hidden.bs.modal', function () {
        pendingForm = null;
    });
});
</script>

@stack('scripts')

</body>
</html>
