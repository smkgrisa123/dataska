<?php
// --- TARUH HELPER INI DI BARIS PALING ATAS FILE detail.php ---
if (!function_exists('tanggal_indo')) {
    function tanggal_indo($tanggal)
    {
        if (empty($tanggal) || $tanggal == '0000-00-00') return '-';
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);
        $tgl   = substr($tanggal, 8, 2);
        return (int)$tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
    }
}
?>

<!-- 2. Tambahkan CSS ini persis di atas kode HTML/tampilan -->
<style>
    /* Mengubah semua teks hasil isian data otomatis jadi Tahoma */
    span.col-span-2 {
        font-family: 'Tahoma', Geneva, Verdana, sans-serif !important;
    }
</style>

<!-- Di bawah sinilah kode HTML / Tampilan halaman Anda dimulai -->
<div class="...">
    <!-- Konten Detail Siswa -->
</div>



<div class="flex-1 overflow-y-auto p-6 space-y-6" x-data="{ activeTab: 'pribadi' }">

    <!-- HEADER UTAMA: Bergaya Lembar Dokumen Resmi / Dapodik -->
    <div class="bg-gradient-to-r from-red-600 to-rose-800 text-white p-6 rounded-2xl shadow-md flex items-center justify-between">
        <div>
            <div class="inline-block bg-red-900 text-white text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider mb-2">Siswa Keluar / Non-Aktif</div>
            <h1 class="text-2xl font-extrabold tracking-wide">DATA SISWA: <?= htmlspecialchars($siswa->nama ?? '-'); ?></h1>
            <p class="text-xs text-red-100 mt-1">Informasi lengkap seluruh data peserta didik berdasarkan database sekolah.</p>
        </div>
        <a href="<?= site_url('siswa/keluar'); ?>" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl transition flex items-center space-x-2 border border-white/20 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i><span>Kembali</span>
        </a>
    </div>

    <!-- NAVIGASI TAB MENU -->
    <div class="bg-white dark:bg-gray-800 p-2 rounded-2xl shadow-sm border border-red-200 dark:border-red-900 overflow-x-auto">
        <div class="flex space-x-2 min-w-max">
            <button @click="activeTab = 'pribadi'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'pribadi', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'pribadi' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-id-card"></i><span>Data Pribadi</span>
            </button>
            <button @click="activeTab = 'alamat'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'alamat', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'alamat' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-map-location-dot"></i><span>Alamat & Kontak</span>
            </button>
            <button @click="activeTab = 'ortu'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'ortu', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'ortu' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-users"></i><span>Orang Tua / Wali</span>
            </button>
            <button @click="activeTab = 'periodik'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'periodik', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'periodik' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-ruler-combined"></i><span>Periodik</span>
            </button>
            <button @click="activeTab = 'prestasi'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'prestasi', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'prestasi' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-trophy"></i><span>Prestasi</span>
            </button>
            <button @click="activeTab = 'beasiswa'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'beasiswa', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'beasiswa' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-graduation-cap"></i><span>Beasiswa</span>
            </button>
            <button @click="activeTab = 'kesejahteraan'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'kesejahteraan', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'kesejahteraan' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-hand-holding-heart"></i><span>Kesejahteraan</span>
            </button>
            <button @click="activeTab = 'dokumen'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'dokumen', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'dokumen' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-folder-open"></i><span>Dokumen</span>
            </button>
            <button @click="activeTab = 'lulus'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'lulus', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'lulus' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-award"></i><span>Tamat Belajar / Lulus</span>
            </button>
            <button @click="activeTab = 'registrasi'" :class="{ 'bg-red-600 text-white shadow-md': activeTab === 'registrasi', 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-100': activeTab !== 'registrasi' }" class="px-4 py-2.5 rounded-xl text-xs font-semibold transition flex items-center space-x-2">
                <i class="fa-solid fa-file-pen"></i><span>Registrasi</span>
            </button>
        </div>
    </div>

    <!-- KONTEN UTAMA DENGAN FORMAT FORMULIR BERSIH -->
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 space-y-6">

        <!-- 1. DATA PRIBADI -->
        <div x-show="activeTab === 'pribadi'" class="space-y-4">
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <h3 class="font-semibold text-blue-600 dark:text-blue-400 mb-4">Data Pribadi Siswa</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-xs sm:text-sm">
                    <!-- Kolom Kiri -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Nama Lengkap</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->nama ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Nama Panggilan</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->nama_panggilan ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">NISN</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2 font-mono">: <?= htmlspecialchars($siswa->nisn ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Nomor Induk / NIS</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2 font-mono">: <?= htmlspecialchars($siswa->no_induk ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">NIK</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2 font-mono">: <?= htmlspecialchars($siswa->nik ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Jenis Kelamin</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= ($siswa->jk == 'L') ? 'Laki-laki' : (($siswa->jk == 'P') ? 'Perempuan' : '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Tempat, Tgl Lahir</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->tempat_lahir ?? '-'); ?>, <?= tanggal_indo($siswa->tanggal_lahir); ?></span>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">No. Kartu Keluarga</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2 font-mono">: <?= htmlspecialchars($siswa->no_kk ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">No. Akta Lahir</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->no_akte_lahir ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Agama</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->agama ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Kewarganegaraan</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->kewarganegaraan_siswa ?? 'Indonesia'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Status Orang Tua</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->status_orang_tua ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Bahasa Sehari-hari</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->bahasa_sehari_hari ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Berkebutuhan Khusus</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= htmlspecialchars($siswa->berkebutuhan_khusus ?? 'Tidak Ada / Normal'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. ALAMAT & KONTAK -->
        <div x-show="activeTab === 'alamat'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">II. Alamat & Kontak Siswa</h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-xs sm:text-sm">

                    <!-- Kolom Kiri -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Nama Jalan / Perumahan</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->jalan ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Dusun / Kampung</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->dusun ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">RT / RW</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: RT <?= htmlspecialchars($siswa->rt ?? '-'); ?> / RW <?= htmlspecialchars($siswa->rw ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Desa / Kelurahan</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->desa ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Kecamatan</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->kecamatan ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Kabupaten / Kota</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->kabupaten ?? '-'); ?></span>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Provinsi</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->provinsi ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Titik Koordinat</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= (!empty($siswa->lintang) && !empty($siswa->bujur)) ? $siswa->lintang . ', ' . $siswa->bujur : '-'; ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Jenis Tempat Tinggal</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->tempat_tinggal ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Moda Transportasi</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->moda_transportasi ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Nomor HP / WhatsApp</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->no_hp ?? '-'); ?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 3. ORANG TUA / WALI -->
        <div x-show="activeTab === 'ortu'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">III. Data Orang Tua / Wali</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs sm:text-sm">

                <!-- --- DATA AYAH KANDUNG --- -->
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <h3 class="font-semibold text-blue-600 dark:text-blue-400 mb-3">Data Ayah Kandung</h3>
                    <table class="w-full text-sm space-y-2">
                        <tr>
                            <td class="font-medium text-slate-500 w-36 py-1">Nama</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_nama) ? $siswa->ayah_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Status</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_status) ? $siswa->ayah_status : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">NIK</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_nik) ? $siswa->ayah_nik : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Tahun Lahir</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_tahun_lahir) ? $siswa->ayah_tahun_lahir : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Pendidikan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_pendidikan) ? $siswa->ayah_pendidikan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Pekerjaan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_pekerjaan) ? $siswa->ayah_pekerjaan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Penghasilan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_penghasilan) ? $siswa->ayah_penghasilan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Provinsi</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_provinsi_nama) ? $siswa->ayah_provinsi_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Kabupaten/Kota</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_kabupaten_nama) ? $siswa->ayah_kabupaten_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Kecamatan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_kecamatan_nama) ? $siswa->ayah_kecamatan_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Desa/Kelurahan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_desa_nama) ? $siswa->ayah_desa_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Nama Jalan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_jalan) ? $siswa->ayah_jalan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Dusun/Kampung</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_dusun) ? $siswa->ayah_dusun : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">RT / RW</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= (!empty($siswa->ayah_rt) || !empty($siswa->ayah_rw)) ? 'RT ' . ($siswa->ayah_rt ?? '-') . ' / RW ' . ($siswa->ayah_rw ?? '-') : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">No. HP</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ayah_no_hp) ? $siswa->ayah_no_hp : '-'; ?></td>
                        </tr>
                    </table>
                </div>

                <!-- --- DATA IBU KANDUNG --- -->
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <h3 class="font-semibold text-pink-600 dark:text-pink-400 mb-3">Data Ibu Kandung</h3>
                    <table class="w-full text-sm space-y-2">
                        <tr>
                            <td class="font-medium text-slate-500 w-36 py-1">Nama</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_nama) ? $siswa->ibu_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Status</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_status) ? $siswa->ibu_status : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">NIK</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_nik) ? $siswa->ibu_nik : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Tahun Lahir</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_tahun_lahir) ? $siswa->ibu_tahun_lahir : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Pendidikan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_pendidikan) ? $siswa->ibu_pendidikan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Pekerjaan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_pekerjaan) ? $siswa->ibu_pekerjaan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Penghasilan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_penghasilan) ? $siswa->ibu_penghasilan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Provinsi</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_provinsi_nama) ? $siswa->ibu_provinsi_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Kabupaten/Kota</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_kabupaten_nama) ? $siswa->ibu_kabupaten_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Kecamatan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_kecamatan_nama) ? $siswa->ibu_kecamatan_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Desa/Kelurahan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_desa_nama) ? $siswa->ibu_desa_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Nama Jalan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_jalan) ? $siswa->ibu_jalan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Dusun/Kampung</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_dusun) ? $siswa->ibu_dusun : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">RT / RW</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= (!empty($siswa->ibu_rt) || !empty($siswa->ibu_rw)) ? 'RT ' . ($siswa->ibu_rt ?? '-') . ' / RW ' . ($siswa->ibu_rw ?? '-') : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">No. HP</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->ibu_no_hp) ? $siswa->ibu_no_hp : '-'; ?></td>
                        </tr>
                    </table>
                </div>

                <!-- --- DATA WALI SISWA --- -->
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <h3 class="font-semibold text-emerald-600 dark:text-emerald-400 mb-3">Data Wali Siswa</h3>
                    <table class="w-full text-sm space-y-2">
                        <tr>
                            <td class="font-medium text-slate-500 w-36 py-1">Nama</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_nama) ? $siswa->wali_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Hubungan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_status_hubungan) ? $siswa->wali_status_hubungan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">NIK</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_nik) ? $siswa->wali_nik : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Tahun Lahir</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_tahun_lahir) ? $siswa->wali_tahun_lahir : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Pendidikan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_pendidikan) ? $siswa->wali_pendidikan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Pekerjaan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_pekerjaan) ? $siswa->wali_pekerjaan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Penghasilan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_penghasilan) ? $siswa->wali_penghasilan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Provinsi</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_provinsi_nama) ? $siswa->wali_provinsi_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Kabupaten/Kota</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_kabupaten_nama) ? $siswa->wali_kabupaten_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Kecamatan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_kecamatan_nama) ? $siswa->wali_kecamatan_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Desa/Kelurahan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_desa_nama) ? $siswa->wali_desa_nama : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Nama Jalan</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_jalan) ? $siswa->wali_jalan : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">Dusun/Kampung</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_dusun) ? $siswa->wali_dusun : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">RT / RW</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= (!empty($siswa->wali_rt) || !empty($siswa->wali_rw)) ? 'RT ' . ($siswa->wali_rt ?? '-') . ' / RW ' . ($siswa->wali_rw ?? '-') : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-500 py-1">No. HP</td>
                            <td class="px-2 text-slate-400">:</td>
                            <td class="text-slate-800 dark:text-slate-200"><?= !empty($siswa->wali_no_hp) ? $siswa->wali_no_hp : '-'; ?></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        <!-- 4. PERIODIK -->
        <div x-show="activeTab === 'periodik'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">IV. Data Periodik Siswa</h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-xs sm:text-sm">

                    <!-- Kolom Kiri -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Tinggi Badan</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->tinggi_badan ?? '-'); ?> cm</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Berat Badan</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->berat_badan ?? '-'); ?> kg</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Lingkar Kepala</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->lingkar_kepala ?? '-'); ?> cm</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Jarak Tempuh</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->jarak_tempuh_kategori ?? '-'); ?> (<?= htmlspecialchars($siswa->jarak_km ?? '-'); ?> km)</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Waktu Tempuh</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->waktu_tempuh ?? '-'); ?> menit</span>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Anak Ke / Saudara</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: Anak ke-<?= htmlspecialchars($siswa->anak_ke ?? '-'); ?> dari <?= htmlspecialchars($siswa->jml_saudara_kandung ?? '-'); ?> saudara</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Saudara Tiri/Angkat</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->jml_saudara_tiri ?? '0'); ?> tiri, <?= htmlspecialchars($siswa->jml_saudara_angkat ?? '0'); ?> angkat</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Riwayat Penyakit</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->riwayat_penyakit ?? '-'); ?></span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="text-gray-500 font-medium col-span-1">Golongan Darah</span>
                            <span class="font-semibold text-gray-800 dark:text-white col-span-2">: <?= htmlspecialchars($siswa->golongan_darah ?? '-'); ?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 5. PRESTASI -->
        <div x-show="activeTab === 'prestasi'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">V. Riwayat Prestasi</h3>
            </div>
            <div class="overflow-x-auto pt-2">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">No</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Jenis</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tingkat</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Nama Prestasi</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tahun</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Penyelenggara</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-300">
                        <?php if (!empty($prestasi_list)): ?>
                            <?php $no = 1;
                            foreach ($prestasi_list as $p): ?>
                                <tr>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700 text-center"><?= $no++; ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($p->jenis); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($p->tingkat); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700 font-medium"><?= htmlspecialchars($p->nama_prestasi); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($p->tahun); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($p->penyelenggara); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($p->peringkat); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-400 italic border border-gray-200 dark:border-gray-700">
                                    Belum ada data prestasi yang tercatat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 6. BEASISWA -->
        <div x-show="activeTab === 'beasiswa'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">VI. Riwayat Beasiswa</h3>
            </div>
            <div class="overflow-x-auto pt-2">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">No</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Jenis Beasiswa</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Keterangan</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tahun Mulai</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tahun Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-300">
                        <?php if (!empty($beasiswa_list)): ?>
                            <?php $no = 1;
                            foreach ($beasiswa_list as $b): ?>
                                <tr>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700 text-center"><?= $no++; ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700 font-medium"><?= htmlspecialchars($b->jenis); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($b->keterangan); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($b->tahun_mulai); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($b->tahun_selesai); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-400 italic border border-gray-200 dark:border-gray-700">
                                    Belum ada data beasiswa yang tercatat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 7. KESEJAHTERAAN -->
        <div x-show="activeTab === 'kesejahteraan'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">VII. Data Kesejahteraan / Bantuan Sosial</h3>
            </div>
            <div class="overflow-x-auto pt-2">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">No</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Jenis Kesejahteraan</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Nomor Kartu</th>
                            <th class="p-2.5 border border-gray-200 dark:border-gray-700">Nama di Kartu</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-300">
                        <?php if (!empty($kesejahteraan_list)): ?>
                            <?php $no = 1;
                            foreach ($kesejahteraan_list as $k): ?>
                                <tr>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700 text-center"><?= $no++; ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700 font-medium"><?= htmlspecialchars($k->jenis); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($k->no_kartu); ?></td>
                                    <td class="p-2.5 border border-gray-200 dark:border-gray-700"><?= htmlspecialchars($k->nama_kartu); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-400 italic border border-gray-200 dark:border-gray-700">
                                    Belum ada data kesejahteraan yang tercatat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 8. DOKUMEN -->
        <div x-show="activeTab === 'dokumen'" class="space-y-4" style="display: none;">
            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">VIII. Dokumen Pendukung Siswa</h3>
            </div>
            <div class="space-y-2 pt-2">
                <?php if (!empty($dokumen_list)): ?>
                    <?php foreach ($dokumen_list as $doc): ?>
                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs sm:text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300"><?= htmlspecialchars($doc->nama_dokumen ?? $doc->jenis_dokumen); ?> (<?= htmlspecialchars($doc->nama_file); ?>)</span>
                            <a href="<?= base_url('uploads/dokumen/' . $doc->nama_file); ?>" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium flex items-center gap-1.5 transition shadow-sm">
                                <i class="fa-solid fa-eye"></i><span>Lihat File</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-xs text-gray-400 italic py-4">Tidak ada dokumen terlampir.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 9. TAMAT BELAJAR / LULUS -->
        <div x-show="activeTab === 'lulus'" class="space-y-4" style="display: none;">
            <?php
            // Helper fungsi format tanggal Indonesia
            if (!function_exists('tanggal_indo')) {
                function tanggal_indo($tanggal)
                {
                    if (empty($tanggal) || $tanggal == '0000-00-00') return '-';
                    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                    $tahun = substr($tanggal, 0, 4);
                    $bulan = substr($tanggal, 5, 2);
                    $tgl   = substr($tanggal, 8, 2);
                    return (int)$tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
                }
            }
            ?>

            <div class="border-l-4 border-blue-600 pl-3">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">IX. Informasi Tamat Belajar / Kelulusan & Tracer Study</h3>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-gray-700 text-xs sm:text-sm bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">

                <!-- Nomor Ijazah SMK -->
                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <span class="text-gray-500 font-medium">Nomor Ijazah SMK</span>
                    <span class="sm:col-span-2 font-semibold text-gray-800 dark:text-white">: <?= !empty($tamat_belajar->nomor_ijazah) ? htmlspecialchars($tamat_belajar->nomor_ijazah) : (!empty($siswa->nomor_ijazah) ? htmlspecialchars($siswa->nomor_ijazah) : '-'); ?></span>
                </div>

                <!-- Tanggal Ijazah SMK -->
                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <span class="text-gray-500 font-medium">Tanggal Ijazah SMK</span>
                    <span class="sm:col-span-2 font-semibold text-gray-800 dark:text-white">: <?= !empty($tamat_belajar->tanggal_ijazah) ? tanggal_indo($tamat_belajar->tanggal_ijazah) : (!empty($siswa->tanggal_ijazah) ? tanggal_indo($siswa->tanggal_ijazah) : '-'); ?></span>
                </div>

                <!-- Melanjutkan ke Kuliah -->
                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <span class="text-gray-500 font-medium">Melanjutkan ke (Kuliah)</span>
                    <span class="sm:col-span-2 font-semibold text-gray-800 dark:text-white">: <?= !empty($tamat_belajar->melanjutkan_ke) ? htmlspecialchars($tamat_belajar->melanjutkan_ke) : (!empty($siswa->melanjutkan_ke) ? htmlspecialchars($siswa->melanjutkan_ke) : '-'); ?></span>
                </div>

                <!-- Bekerja di Perusahaan -->
                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <span class="text-gray-500 font-medium">Bekerja di / Perusahaan</span>
                    <span class="sm:col-span-2 font-semibold text-gray-800 dark:text-white">: <?= !empty($tamat_belajar->nama_perusahaan) ? htmlspecialchars($tamat_belajar->nama_perusahaan) : (!empty($siswa->nama_perusahaan) ? htmlspecialchars($siswa->nama_perusahaan) : '-'); ?></span>
                </div>

                <!-- Tanggal Mulai Bekerja -->
                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <span class="text-gray-500 font-medium">Tanggal Mulai Bekerja</span>
                    <span class="sm:col-span-2 font-semibold text-gray-800 dark:text-white">: <?= !empty($tamat_belajar->tanggal_mulai_bekerja) ? tanggal_indo($tamat_belajar->tanggal_mulai_bekerja) : (!empty($siswa->tanggal_mulai_bekerja) ? tanggal_indo($siswa->tanggal_mulai_bekerja) : '-'); ?></span>
                </div>

                <!-- Penghasilan / Gaji -->
                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <span class="text-gray-500 font-medium">Penghasilan / Gaji</span>
                    <span class="sm:col-span-2 font-semibold text-gray-800 dark:text-white">: <?= !empty($tamat_belajar->penghasilan_lulus) ? htmlspecialchars($tamat_belajar->penghasilan_lulus) : (!empty($siswa->penghasilan_lulus) ? htmlspecialchars($siswa->penghasilan_lulus) : '-'); ?></span>
                </div>

                <!-- Preview Dokumen / File Ijazah -->
                <!-- Preview Dokumen / File Ijazah dari tabel dokumen_siswa -->
                <div class="py-3 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                    <span class="text-gray-500 font-medium">File Ijazah</span>
                    <span class="sm:col-span-2">
                        <?php
                        // Cari dokumen yang jenisnya 'ijazah' dari list dokumen siswa
                        $file_ijazah_item = null;
                        if (!empty($dokumen_list)) {
                            foreach ($dokumen_list as $doc) {
                                if ($doc->jenis_dokumen === 'ijazah' || $doc->jenis_dokumen === 'file_ijazah') {
                                    $file_ijazah_item = $doc->nama_file;
                                    break;
                                }
                            }
                        }
                        ?>

                        <?php if (!empty($file_ijazah_item)) : ?>
                            <a href="<?= base_url('uploads/dokumen/' . $file_ijazah_item); ?>" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview / Lihat Ijazah
                            </a>
                        <?php else : ?>
                            <span class="text-gray-400 italic">Belum ada file ijazah yang di-upload.</span>
                        <?php endif; ?>
                    </span>
                </div>

            </div>
        </div>

        <!-- 10. REGISTRASI -->
        <div x-show="activeTab === 'registrasi'" class="space-y-4" style="display: none;" x-data="{ subReg: 'masuk' }">
            <div class="border-l-4 border-blue-600 pl-3 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase">X. Riwayat Registrasi Siswa</h3>
                <div class="inline-flex bg-gray-100 dark:bg-gray-700 p-1 rounded-lg text-xs">
                    <button type="button" @click="subReg = 'masuk'" :class="subReg === 'masuk' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-500'" class="px-3 py-1.5 rounded-md transition font-medium">Registrasi Masuk</button>
                    <button type="button" @click="subReg = 'keluar'" :class="subReg === 'keluar' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-500'" class="px-3 py-1.5 rounded-md transition font-medium">Registrasi Keluar</button>
                </div>
            </div>

            <!-- Sub Tab Masuk -->
            <div x-show="subReg === 'masuk'" class="divide-y divide-gray-100 dark:divide-gray-700 text-xs sm:text-sm pt-2">
                <?php if (!empty($registrasi_masuk)): ?>
                    <?php
                    // Helper fungsi format tanggal Indonesia
                    if (!function_exists('tanggal_indo')) {
                        function tanggal_indo($tanggal)
                        {
                            if (empty($tanggal) || $tanggal == '0000-00-00') return '-';
                            $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                            $tahun = substr($tanggal, 0, 4);
                            $bulan = substr($tanggal, 5, 2);
                            $tgl   = substr($tanggal, 8, 2);
                            return (int)$tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
                        }
                    }
                    ?>
                    <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <h3 class="font-semibold text-blue-600 dark:text-blue-400 mb-4">Form & Detail Registrasi Masuk</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-sm">
                            <!-- Kolom Kiri -->
                            <div class="space-y-3">
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Jenis Pendaftaran</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->jenis_pendaftaran) ? $registrasi_masuk->jenis_pendaftaran : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Bidang Keahlian</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->bidang_keahlian) ? $registrasi_masuk->bidang_keahlian : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Konsentrasi Keahlian</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->konsentrasi_keahlian) ? $registrasi_masuk->konsentrasi_keahlian : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Asal Sekolah</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->asal_sekolah) ? $registrasi_masuk->asal_sekolah : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">No. Ijazah</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->no_ijazah_smp) ? $registrasi_masuk->no_ijazah_smp : '-'; ?></span>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="space-y-3">
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Diterima di Kelas</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->diterima_di_kelas) ? $registrasi_masuk->diterima_di_kelas : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Program Keahlian</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->program_keahlian) ? $registrasi_masuk->program_keahlian : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Nomor Induk</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= !empty($registrasi_masuk->no_induk) ? $registrasi_masuk->no_induk : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Tanggal Masuk</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= tanggal_indo($registrasi_masuk->tanggal_masuk); ?></span>
                                </div>
                                <div class="grid grid-cols-3">
                                    <span class="text-gray-500 font-medium col-span-1">Tanggal Ijazah</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 col-span-2">: <?= tanggal_indo($registrasi_masuk->tanggal_ijazah_smp); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-gray-400 italic py-4">Belum ada data registrasi masuk.</p>
                <?php endif; ?>
            </div>

            <!-- Sub Tab Keluar -->
            <div x-show="subReg === 'keluar'" class="divide-y divide-gray-100 dark:divide-gray-700 text-xs sm:text-sm pt-2" style="display: none;">
                <?php if (!empty($registrasi_keluar)): ?>
                    <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <h3 class="font-semibold text-blue-600 dark:text-blue-400 mb-4">Form & Detail Registrasi Keluar</h3>

                        <div class="space-y-3 text-sm">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <span class="text-gray-500 font-medium">Keluar Karena</span>
                                <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->jenis_keluar) ? $registrasi_keluar->jenis_keluar : '-'; ?></span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <span class="text-gray-500 font-medium">Kelas Yang Ditinggalkan</span>
                                <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->kelas_ditinggalkan) ? $registrasi_keluar->kelas_ditinggalkan : '-'; ?></span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <span class="text-gray-500 font-medium">Tahun Ajaran Keluar</span>
                                <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->nama_tahun_ajaran) ? $registrasi_keluar->nama_tahun_ajaran : '-'; ?></span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <span class="text-gray-500 font-medium">Tanggal Keluar</span>
                                <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->tanggal_keluar) ? tanggal_indo($registrasi_keluar->tanggal_keluar) : '-'; ?></span>
                            </div>

                            <?php if (!empty($registrasi_keluar->jenis_keluar) && $registrasi_keluar->jenis_keluar === 'Mutasi'): ?>
                                <!-- Tambahan Field Khusus Jika Mutasi -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <span class="text-gray-500 font-medium">Nomor Surat</span>
                                    <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->no_surat) ? $registrasi_keluar->no_surat : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <span class="text-gray-500 font-medium">Tanggal Surat</span>
                                    <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->tanggal_surat) ? tanggal_indo($registrasi_keluar->tanggal_surat) : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <span class="text-gray-500 font-medium">Nama Sekolah Tujuan</span>
                                    <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->nama_sekolah_tujuan) ? $registrasi_keluar->nama_sekolah_tujuan : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <span class="text-gray-500 font-medium">NPSN Sekolah Tujuan</span>
                                    <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->npsn_sekolah_tujuan) ? $registrasi_keluar->npsn_sekolah_tujuan : '-'; ?></span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <span class="text-gray-500 font-medium">Alamat Sekolah</span>
                                    <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->alamat_sekolah) ? $registrasi_keluar->alamat_sekolah : '-'; ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <span class="text-gray-500 font-medium">Alasan / Keterangan</span>
                                <span class="sm:col-span-2 font-semibold text-slate-800 dark:text-slate-200">: <?= !empty($registrasi_keluar->alasan) ? $registrasi_keluar->alasan : '-'; ?></span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-gray-400 italic py-4">Belum ada data registrasi keluar.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>