<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Portal DATASKA - Panel Hak Akses</h3>
                <hr>
                <p>Selamat datang, <strong><?= $nama; ?></strong></p>
                <p>Status Hak Akses Anda: <span class="badge bg-primary uppercase"><?= strtoupper($role); ?></span></p>

                <!-- PENGATURAN TAMPILAN BERDASARKAN HAK AKSES -->

                <?php if ($role == 'administrator'): ?>
                    <div class="alert alert-success">
                        <h5>Menu Administrator</h5>
                        <p>Anda memiliki akses penuh untuk mengelola seluruh sistem, menambah user, dan mengubah konfigurasi.</p>
                        <a href="<?= site_url('akses/data_siswa'); ?>" class="btn btn-dark">Kelola Data Siswa</a>
                    </div>

                <?php elseif ($role == 'kepala_sekolah'): ?>
                    <div class="alert alert-info">
                        <h5>Menu Kepala Sekolah (Mode Laporan & Monitoring)</h5>
                        <p>Anda dapat melihat rekapitulasi data dan laporan sekolah secara keseluruhan (Read-Only).</p>
                        <a href="<?= site_url('akses/data_siswa'); ?>" class="btn btn-outline-dark">Lihat Data Siswa</a>
                    </div>

                <?php elseif ($role == 'staf'): ?>
                    <div class="alert alert-warning">
                        <h5>Menu Staf Administrasi</h5>
                        <p>Anda dapat menginput dan mengedit beberapa data operasional sekolah.</p>
                        <a href="<?= site_url('akses/data_siswa'); ?>" class="btn btn-warning">Kelola & Edit Data Siswa</a>
                    </div>

                <?php elseif ($role == 'wali_kelas'): ?>
                    <div class="alert alert-primary">
                        <h5>Menu Wali Kelas</h5>
                        <p>Anda dapat mengakses data akademik dan absensi siswa khusus di kelas bimbingan Anda.</p>
                    </div>

                <?php elseif ($role == 'siswa'): ?>
                    <div class="alert alert-secondary">
                        <h5>Portal Siswa (Login via NISN)</h5>
                        <p>Anda dapat melihat profil biodata dan nilai akademik pribadi Anda.</p>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <a href="<?= site_url('auth/logout'); ?>" class="btn btn-danger btn-sm">Keluar Sistem</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>