<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Mencegah Browser Cache Halaman -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>LOGIN DATASKA | Data Sekolah Terintegrasi</title>
    <style>
        :root {
            --navy: #092b4c;
            --blue: #1768d4;
            --cyan: #12a6b5;
            --ink: #1c2d40;
            --muted: #7c8998;
            --line: #e8edf3;
            --panel: #f7f9fc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 15%, rgba(19, 166, 181, .17), transparent 28%),
                radial-gradient(circle at 88% 85%, rgba(23, 104, 212, .16), transparent 30%),
                linear-gradient(135deg, #edf3f8, #e5edf5);
        }

        .login-shell {
            width: min(1060px, 100%);
            min-height: 610px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 28px 80px rgba(14, 42, 72, .18);
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 38px 42px;
            color: white;
            overflow: hidden;
            background:
                radial-gradient(circle at 80% 28%, rgba(19, 178, 190, .36), transparent 28%),
                linear-gradient(145deg, #09284a 0%, #0c4665 58%, #087d8a 100%);
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 390px;
            height: 390px;
            right: -175px;
            top: 90px;
        }

        .brand-panel::after {
            width: 270px;
            height: 270px;
            right: -115px;
            top: 150px;
        }

        .brand,
        .hero,
        .brand-footer {
            position: relative;
            z-index: 1;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            color: #0b4260;
            background: #fff;
            box-shadow: 0 7px 18px rgba(0, 0, 0, .13);
            overflow: hidden;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 1.6px;
        }

        .brand-sub {
            margin-top: 4px;
            font-size: 10px;
            letter-spacing: 1.25px;
            opacity: .72;
        }

        .hero {
            text-align: center;
            padding: 15px 0 25px;
        }

        .illustration {
            width: 230px;
            height: 205px;
            margin: 0 auto 22px;
            display: grid;
            place-items: center;
            position: relative;
        }

        .hero h1 {
            margin: 0 0 11px;
            font-size: 27px;
            letter-spacing: .2px;
        }

        .hero p {
            max-width: 350px;
            margin: auto;
            color: rgba(255, 255, 255, .73);
            font-size: 13px;
            line-height: 1.7;
        }

        .feature-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 25px;
            justify-content: center;
        }

        .feature {
            padding: 8px 11px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 30px;
            background: rgba(255, 255, 255, .08);
            font-size: 10px;
            color: rgba(255, 255, 255, .88);
        }

        .brand-footer {
            font-size: 10px;
            line-height: 1.6;
            color: rgba(255, 255, 255, .62);
        }

        .brand-footer strong {
            color: white;
            font-weight: 600;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 58px;
            position: relative;
        }

        .form-wrap {
            width: 100%;
            max-width: 370px;
        }

        .mini-brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border-radius: 30px;
            background: #eef6ff;
            color: #2366b4;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .7px;
            margin-bottom: 23px;
        }

        .mini-brand span {
            font-size: 16px;
        }

        h2 {
            margin: 0 0 8px;
            font-size: 28px;
            color: #172c42;
        }

        .intro {
            margin: 0 0 24px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .field {
            margin-bottom: 17px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #34465a;
            font-size: 11px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        input,
        select {
            width: 100%;
            height: 47px;
            padding: 0 14px;
            border: 1px solid var(--line);
            border-radius: 10px;
            outline: none;
            color: #26394d;
            background: #fbfcfe;
            font: inherit;
            font-size: 12px;
            transition: .2s;
        }

        input:focus,
        select:focus {
            border-color: #5b9be8;
            box-shadow: 0 0 0 3px rgba(36, 119, 215, .10);
            background: #fff;
        }

        input::placeholder {
            color: #aab4c0;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b9aaa;
            font-size: 14px;
        }

        .with-icon {
            padding-left: 39px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #8493a3;
            cursor: pointer;
            font-size: 11px;
        }

        .password-input {
            padding-right: 54px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin: 2px 0 22px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #718092;
            font-size: 10px;
        }

        .remember input {
            width: 14px;
            height: 14px;
            margin: 0;
            accent-color: var(--blue);
        }

        a {
            color: #286bc1;
            text-decoration: none;
            font-size: 10px;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            height: 48px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2px;
            background: linear-gradient(100deg, #2169d6, #1454bd);
            box-shadow: 0 9px 18px rgba(25, 94, 198, .22);
            transition: transform .2s, box-shadow .2s;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(25, 94, 198, .28);
        }

        .submit-btn span {
            margin-left: 8px;
            font-size: 16px;
            vertical-align: -1px;
        }

        /* Styling Toast / Floating Notification Modern */
        .toast-container {
            position: absolute;
            top: 20px;
            right: 25px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 340px;
            width: 100%;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border-left: 5px solid #ccc;
            font-size: 12px;
            color: #26394d;
            animation: slideIn 0.3s ease-out forwards;
            transition: opacity 0.4s ease;
        }

        .toast.error {
            border-left-color: #e53e3e;
            background: #fff5f5;
            color: #9b2c2c;
        }

        .toast.success {
            border-left-color: #38a169;
            background: #f0fff4;
            color: #22543d;
        }

        .toast-icon {
            font-size: 16px;
            font-weight: bold;
        }

        .toast.error .toast-icon {
            color: #e53e3e;
        }

        .toast.success .toast-icon {
            color: #38a169;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .copyright {
            margin-top: 30px;
            text-align: center;
            color: #a1acb8;
            font-size: 9px;
            line-height: 1.7;
        }
    </style>
</head>

<body>
    <!-- Container Toast Mengapung di Pojok Kanan Atas Form -->
    <div class="toast-container" id="toastContainer">
        <?php if ($this->session->flashdata('error')): ?>
            <div class="toast error" id="toastAlert">
                <span class="toast-icon">⚠️</span>
                <div>
                    <strong>Peringatan!</strong><br>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="toast success" id="toastAlert">
                <span class="toast-icon">✅</span>
                <div>
                    <strong>Berhasil!</strong><br>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <main class="login-shell">
        <section class="brand-panel">
            <div class="brand">
                <div class="brand-mark">
                    <img src="<?= base_url('assets/img/logo.jpg'); ?>" alt="Logo Sekolah" style="width: 35px; height: 35px; object-fit: contain;">
                </div>
                <div>
                    <div class="brand-name">DATASKA</div>
                    <div class="brand-sub">DATA SEKOLAH TERINTEGRASI</div>
                </div>
            </div>

            <div class="hero">
                <div class="illustration flex items-center justify-center" aria-hidden="true">
                    <img src="<?= base_url('assets/img/dataska.jpg'); ?>" alt="Logo Sekolah" style="max-width: 140px; height: auto; object-fit: contain; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));">
                </div>
                <h1>Kelola Data Sekolah Lebih Mudah</h1>
                <p>Satu portal terintegrasi untuk mengelola informasi, administrasi, dan layanan sekolah secara efektif.</p>
                <div class="feature-list">
                    <span class="feature">▣ Data Siswa</span>
                    <span class="feature">▤ Data Guru</span>
                    <span class="feature">▦ Akademik</span>
                    <span class="feature">◷ Administrasi</span>
                </div>
            </div>

            <div class="brand-footer">
                <strong>“Satu data, banyak kemudahan.”</strong><br>
                DATASKA membantu pengelolaan data sekolah menjadi lebih teratur, cepat, dan terintegrasi.
            </div>
        </section>

        <section class="form-panel">
            <div class="form-wrap">
                <div class="mini-brand"><span>▦</span> PORTAL DATA SEKOLAH</div>
                <h2>Selamat Datang</h2>
                <p class="intro">Silakan masuk untuk mengakses sistem Data Sekolah Terintegrasi.</p>

                <!-- Form Login -->
                <form action="<?= site_url('auth/proses'); ?>" method="POST" autocomplete="off">

                    <!-- Input Username -->
                    <div class="field">
                        <label for="username">Username</label>
                        <div class="input-wrap">
                            <span class="input-icon">♙</span>
                            <input class="with-icon" type="text" id="username" name="username" placeholder="Masukkan username" autocomplete="nope" required>
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">♙</span>
                            <input class="with-icon password-input" type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" required>
                            <button class="password-toggle" type="button" id="togglePassword" aria-label="Tampilkan password">Lihat</button>
                        </div>
                    </div>

                    <!-- Pilih Role -->
                    <div class="field">
                        <label for="role">Masuk sebagai</label>
                        <select id="role" name="role" required>
                            <option value="">Pilih jenis akun</option>
                            <option value="administrator">Administrator</option>
                            <option value="kepala_sekolah">Kepala Sekolah</option>
                            <option value="staf">Staf</option>
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>

                    <div class="form-options">
                        <label class="remember"><input type="checkbox" id="remember"> Ingat saya</label>
                        <a href="#" id="helpLink">Butuh bantuan?</a>
                    </div>

                    <button class="submit-btn" type="submit">Masuk ke Dashboard <span>→</span></button>
                </form>

                <div class="copyright">
                    © <span id="year"></span> DATASKA · Data Sekolah Terintegrasi<br>
                    Sistem Informasi Manajemen Sekolah
                </div>
            </div>
        </section>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        document.getElementById('year').textContent = new Date().getFullYear();

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.textContent = isPassword ? 'Sembunyi' : 'Lihat';
        });

        // Otomatis menghilangkan Toast / Notifikasi setelah 4.5 detik
        setTimeout(() => {
            const toast = document.getElementById('toastAlert');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 400);
            }
        }, 4500);

        // Mencegah cache autofill muncul saat halaman dibuka
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.getElementById('username').setAttribute('autocomplete', 'off');
                document.getElementById('password').setAttribute('autocomplete', 'new-password');
            }, 300);
        });
    </script>
</body>

</html>