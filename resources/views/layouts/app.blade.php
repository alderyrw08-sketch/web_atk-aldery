
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
                        secondary: '#00668a',
                        tertiary: '#006e2f',
                        error: '#ba1a1a',
                        surface: '#faf8ff',
                        'surface-container': '#eaedff',
                        'surface-container-low': '#f2f3ff',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-high': '#e2e7ff',
                        'outline-variant': '#bec8d2',
                        'on-surface': '#131b2e',
                        'on-surface-variant': '#3e4850'
                    },
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif']
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

@stack('scripts')

</body>
</html>
