
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Persediaan ATK</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            min-height: 100%;
            font-family: Arial, Helvetica, sans-serif;
            color: #17233d;
        }

        body {
            min-height: 100vh;
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */

        .header {
            min-height: 76px;
            padding: 10px 3%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: #fff;
            position: relative;
            z-index: 2;
        }

        .logos {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .logos img {
            display: block;
            width: 105px;
            height: 40px;
            object-fit: contain;
        }

        .separator {
            height: 32px;
            border-left: 1px solid #e5eaf0;
        }

        .header-title {
            flex: 1;
            text-align: center;
            min-width: 200px;
        }

        .header-title h2 {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .header-title p {
            font-size: 10px;
            color: #64748b;
        }

        /* AREA UTAMA */

        .main {
            flex: 1;
            min-height: 580px;
            padding: 40px 5.5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 35px;

            background-image:
                linear-gradient(
                    90deg,
                    rgba(5, 25, 40, 0.30),
                    rgba(5, 25, 40, 0.04)
                ),
                url("{{ asset('images/pusri-background.png') }}");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* KONTEN KIRI */

        .intro {
            flex: 1;
            min-width: 0;
            color: #fff;
        }

        .department {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            margin-bottom: 20px;
            border-radius: 30px;
            background: rgba(12, 57, 75, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 10px;
            white-space: nowrap;
        }

        .dot {
            color: #22d3a0;
        }

        .intro h1 {
            font-size: clamp(28px, 3vw, 39px);
            line-height: 1.17;
            letter-spacing: -0.7px;
            margin-bottom: 20px;
        }

        .intro h1 span {
            color: #66caff;
        }

        .yellow-line {
            width: 55px;
            height: 5px;
            border-radius: 5px;
            background: #f6cf55;
            margin-bottom: 25px;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .feature {
            display: flex;
            align-items: center;
            background: #fff;
            color: #17233d;
            border-radius: 30px;
            padding: 12px 15px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .feature-icon {
            color: #0ea5e9;
            margin-right: 8px;
            font-size: 13px;
        }

        /* KARTU LOGIN */

        .login-card {
            width: 430px;
            max-width: 100%;
            flex-shrink: 0;
            position: relative;
            padding: 28px 26px 26px;
            border-top: 4px solid #18b9e8;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
        }

        .login-logo {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        /* LOGO KHUSUS KARTU LOGIN */

        .login-logo img {
            width: 54px;
            height: 54px;
            object-fit: contain;
            display: block;
        }

        .login-heading {
            text-align: center;
            margin: 25px 0 22px;
        }

        .login-heading h2 {
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-heading p {
            font-size: 12px;
            line-height: 1.5;
            color: #73839c;
        }

        /* PESAN ERROR */

        .error-box {
            padding: 10px 12px;
            margin-bottom: 17px;
            border: 1px solid #fecdd3;
            border-radius: 12px;
            background: #fff1f2;
            color: #dc2626;
            font-size: 11px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field > label {
            display: block;
            margin-bottom: 9px;
            font-size: 11px;
            font-weight: 700;
        }

        .input-box {
            height: 48px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 14px;
            border: 1px solid #dfe7f0;
            border-radius: 28px;
            background: #f7f9fc;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-box:focus-within {
            border-color: #16b8ee;
            box-shadow: 0 0 0 3px rgba(22, 184, 238, 0.10);
        }

        .input-box input {
            width: 100%;
            min-width: 0;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: #17233d;
            font-size: 12px;
        }

        .input-box input::placeholder {
            color: #94a3b8;
        }

        .input-icon {
            color: #8ca0ba;
            font-size: 15px;
            flex-shrink: 0;
        }

        .password-toggle {
            flex-shrink: 0;
            cursor: pointer;
            border: none;
            background: transparent;
            color: #8ca0ba;
            font-size: 16px;
        }

        .field-error {
            color: #dc2626;
            font-size: 11px;
            margin-top: 6px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 5px 0 20px;
            font-size: 11px;
            color: #52617a;
            cursor: pointer;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: #0ea5e9;
        }

        .submit-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 28px;
            color: #fff;
            background: linear-gradient(90deg, #32b9ed, #079fe0);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 13px rgba(14, 165, 233, 0.25);
            transition: filter 0.2s;
        }

        .submit-btn:hover {
            filter: brightness(0.95);
        }

        /* FOOTER */

        .footer {
            min-height: 36px;
            padding: 9px 3%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background: #fff;
            color: #34445c;
            font-size: 9px;
        }

        .footer span {
            color: #0ea5e9;
        }

        /* RESPONSIVE TABLET */

        @media (max-width: 1000px) {
            .header {
                gap: 10px;
                padding-left: 2%;
                padding-right: 2%;
            }

            .logos {
                gap: 6px;
            }

            .logos img {
                width: 75px;
            }

            .main {
                padding: 35px 4%;
                gap: 25px;
            }

            .login-card {
                width: 370px;
            }

            .intro h1 {
                font-size: 30px;
            }
        }

        /* RESPONSIVE HP */

        @media (max-width: 760px) {
            .header {
                flex-wrap: wrap;
                justify-content: center;
            }

            .header-title {
                order: 3;
                flex-basis: 100%;
                padding: 5px 0;
            }

            .main {
                flex-direction: column;
                align-items: stretch;
                gap: 55px;
                padding: 55px 6%;
            }

            .intro h1 {
                font-size: 32px;
            }

            .department {
                white-space: normal;
                line-height: 1.5;
            }

            .login-card {
                width: min(100%, 430px);
                margin: 0 auto;
            }

            .footer {
                flex-direction: column;
                align-items: flex-start;
                line-height: 1.6;
            }
        }

        @media (max-width: 480px) {
            .logos img {
                width: 65px;
                height: 30px;
            }

            .intro h1 {
                font-size: 27px;
            }

            .feature {
                font-size: 10px;
                padding: 10px 12px;
            }

            .login-card {
                padding: 28px 20px 24px;
            }
        }
    </style>
</head>

<body>
<div class="page">

    <!-- HEADER -->
    <header class="header">
        <div class="logos">
            <img
                src="{{ asset('images/logo-danantara.png') }}"
                alt="Danantara Indonesia"
            >

            <span class="separator"></span>

            <!-- LOGO PUSRI HEADER TETAP -->
            <img
                src="{{ asset('images/logo-pusri.png') }}"
                alt="Pupuk Sriwidjaja Palembang"
            >
        </div>

        <div class="header-title">
            <h2>SISTEM INFORMASI PENGELOLAAN PERSEDIAAN ATK</h2>
            <p>LEARNING CENTER PT PUPUK SRIWIDJAJA PALEMBANG</p>
        </div>

        <div class="logos">
            <img
                src="{{ asset('images/logo-bumn.png') }}"
                alt="Kementerian BUMN"
            >

            <span class="separator"></span>

            <img
                src="{{ asset('images/logo-pupuk-indonesia.png') }}"
                alt="Pupuk Indonesia"
            >
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="main">

        <!-- SISI KIRI -->
        <section class="intro">
            <div class="department">
                <span class="dot">●</span>
                LEARNING AND DEVELOPMENT
                &nbsp;•&nbsp; PT. PUPUK SRIWIDJAJA PALEMBANG
                <span class="dot">●</span>
            </div>

            <h1>
                Sistem Informasi Pengelolaan
                <br>
                <span>Persediaan ATK</span>
            </h1>

            <div class="yellow-line"></div>

            <div class="features">
                <div class="feature">
                    <span class="feature-icon">▤</span>
                    Stok Real-time
                </div>

                <div class="feature">
                    <span class="feature-icon">◷</span>
                    Riwayat Terlacak
                </div>

                <div class="feature">
                    <span class="feature-icon">▥</span>
                    Laporan Otomatis
                </div>
            </div>
        </section>

        <!-- KARTU LOGIN -->
        <section class="login-card">

            <!-- LOGO LOGIN BERBEDA DARI HEADER -->
            <div class="login-logo">
                <img
                    src="{{ asset('images/logo-login.png') }}"
                    alt="Logo Login"
                >
            </div>

            <div class="login-heading">
                <h2>Selamat Datang</h2>
                <p>Masuk untuk mengelola persediaan barang dan ATK</p>
            </div>

            @if ($errors->any() && !$errors->has('email'))
                <div class="error-box" role="alert">
                    ⚠ {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="field">
                    <label for="email">EMAIL</label>

                    <div class="input-box">
                        <span class="input-icon">✉</span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="field">
                    <label for="password">KATA SANDI</label>

                    <div class="input-box">
                        <span class="input-icon">♙</span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Tampilkan kata sandi"
                        >◎</button>
                    </div>

                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- INGAT SAYA -->
                <label class="remember" for="remember">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    Ingat saya di perangkat ini
                </label>

                <!-- TOMBOL LOGIN -->
                <button type="submit" class="submit-btn">
                    Masuk &nbsp; →
                </button>
            </form>

        </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div>
            <span>♧</span>
            PT Pupuk Sriwidjaja Palembang
        </div>

        <div>
            <span>⌖</span>
            Jl. Mayor Zen, Sei Selayur, Kec. Kalidoni, Palembang
        </div>

        <div>
            <span>▦</span>
            LEARNING &amp; DEVELOPMENT
        </div>
    </footer>

</div>

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function () {
        const show = password.type === 'password';

        password.type = show ? 'text' : 'password';
        toggle.textContent = show ? '◉' : '◎';

        toggle.setAttribute(
            'aria-label',
            show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'
        );
    });
</script>

</body>
</html>
