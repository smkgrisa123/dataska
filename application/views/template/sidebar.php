<?php
$role          = $this->session->userdata('role');
$is_wali_kelas = $this->session->userdata('is_wali_kelas');

// Tentukan arah URL Dashboard langsung ke dashboard utama
$dashboard_url = base_url('dashboard');
?>
<!-- Tambahkan style x-cloak di bagian atas halaman (biasanya di dalam tag <head> atau sebelum tag <aside>) -->
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="relative bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col transition-all duration-300 ease-in-out">

    <!-- Tombol Toggle Sidebar -->
    <button @click="sidebarOpen = !sidebarOpen" class="absolute -right-3.5 top-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-200 w-7 h-7 rounded-full flex items-center justify-center shadow-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none z-50 transition-transform">
        <i class="fa-solid fa-chevron-left text-xs transition-transform duration-300" :class="{ 'rotate-180': !sidebarOpen }"></i>
    </button>

    <!-- Logo / Brand -->
    <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-600 text-white p-2 rounded-lg shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div x-show="sidebarOpen" x-cloak x-transition.opacity class="whitespace-nowrap">
                <h1 class="font-bold text-sm leading-tight">Aplikasi Pengawasan</h1>
                <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">TKA</span>
            </div>
        </div>
    </div>

    <!-- Menu Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overflow-x-hidden text-sm font-medium">

        <!-- Dashboard -->
        <a href="<?= $dashboard_url ?>" class="flex items-center px-3 py-2.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400" title="Dashboard">
            <i class="fa-solid fa-chart-pie w-6 text-center text-base shrink-0"></i>
            <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Dashboard</span>
        </a>

        <!-- sekolah -->
        <!-- DATA SEKOLAH (Dropdown) -->
        <!-- DATA SEKOLAH (Dropdown -> Sekolah & Dropdown Data Rinci) -->
        <div x-data="{ openSekolah: false, openRinci: false }">
            <button type="button" @click="openSekolah = !openSekolah" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors cursor-pointer">
                <div class="flex items-center">
                    <i class="fa-solid fa-school w-6 text-center text-base shrink-0"></i>
                    <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Data Sekolah</span>
                </div>
                <i x-show="sidebarOpen" x-cloak class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openSekolah }"></i>
            </button>

            <div x-show="openSekolah && sidebarOpen" x-cloak x-transition class="pl-9 pr-2 py-1 space-y-1">
                <!-- Menu Sekolah -->
                <a href="<?= base_url('sekolah'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == '') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                    <i class="fa-solid fa-id-card w-5 text-center mr-2"></i>
                    <span>Sekolah</span>
                </a>

                <!-- Dropdown Data Rinci di dalam Data Sekolah -->
                <button type="button" @click="openRinci = !openRinci" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-medium rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors cursor-pointer">
                    <div class="flex items-center">
                        <i class="fa-solid fa-table-cells-large w-5 text-center mr-2"></i>
                        <span>Data Rinci</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[11px] transition-transform duration-200" :class="{ 'rotate-180': openRinci }"></i>
                </button>

                <div x-show="openRinci && sidebarOpen" x-cloak x-transition class="pl-5 pr-1 py-1 space-y-1">
                    <a href="<?= base_url('sekolah/rinci/periodik'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'periodik') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-rotate w-5 text-center mr-2"></i>
                        <span>Data Periodik</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/listrik'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'listrik') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-bolt w-5 text-center mr-2"></i>
                        <span>Listrik</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/internet'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'internet') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-wifi w-5 text-center mr-2"></i>
                        <span>Internet</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/sanitasi'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'sanitasi') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-faucet-drip w-5 text-center mr-2"></i>
                        <span>Sanitasi</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/dinamis'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'dinamis') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-pen-ruler w-5 text-center mr-2"></i>
                        <span>Data Dinamis</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/kepanitiaan'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'kepanitiaan') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-users-gear w-5 text-center mr-2"></i>
                        <span>Kepanitiaan Sekolah</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/blockgrant'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'blockgrant') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-hand-holding-dollar w-5 text-center mr-2"></i>
                        <span>Blockgrant</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/layanan-khusus'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'layanan-khusus') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-universal-access w-5 text-center mr-2"></i>
                        <span>Layanan Khusus</span>
                    </a>
                    <a href="<?= base_url('sekolah/rinci/program'); ?>" class="flex items-center px-3.5 py-2 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'sekolah' && $this->uri->segment(2) == 'rinci' && $this->uri->segment(3) == 'program') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-layer-group w-5 text-center mr-2"></i>
                        <span>Program</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MENU KHUSUS ADMINISTRATOR                  -->
        <!-- ========================================== -->
        <?php if ($role === 'administrator') : ?>



            <!-- 1. DATA MASTER (Dropdown) -->
            <div x-data="{ openMaster: false }">
                <button @click="openMaster = !openMaster" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center">
                        <i class="fa-solid fa-database w-6 text-center text-base shrink-0"></i>
                        <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Data Master</span>
                    </div>
                    <i x-show="sidebarOpen" x-cloak class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openMaster }"></i>
                </button>
                <div x-show="openMaster && sidebarOpen" x-cloak x-transition class="pl-9 pr-2 py-1 space-y-1">
                    <a href="<?= base_url('kompetensi') ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'kompetensi') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-graduation-cap w-5 text-center mr-2"></i>
                        <span>Kompetensi</span>
                    </a>
                    <a href="<?= base_url('tahunajaran'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'tahunajaran') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-graduation-cap w-5 text-center mr-2"></i>
                        <span>Tahun Ajaran</span>
                    </a>
                    <a href="<?= base_url('tingkat') ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'tingkat') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-layer-group w-5 text-center mr-2"></i>
                        <span>Tingkat</span>
                    </a>
                    <a href="<?= base_url('tugas_tambahan') ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'tugas_tambahan') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-clipboard-user w-5 text-center mr-2"></i>
                        <span>Tugas Tambahan</span>
                    </a>
                    <a href="<?= base_url('pekerjaan') ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'pekerjaan') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-briefcase w-5 text-center mr-2"></i>
                        <span>Pekerjaan</span>
                    </a>
                    <a href="<?= base_url('berkebutuhan_khusus'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'berkebutuhan_khusus') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-wheelchair w-5 text-center mr-2"></i>
                        <span>Berkebutuhan Khusus</span>
                    </a>
                    <a href="<?= base_url('tempat_tinggal'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'tempat_tinggal') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-house-chimney w-5 text-center mr-2"></i>
                        <span>Tempat Tinggal</span>
                    </a>
                    <a href="<?= base_url('moda_transportasi'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'moda_transportasi') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-bus w-5 text-center mr-2"></i>
                        <span>Moda Transportasi</span>
                    </a>
                    <a href="<?= base_url('pendidikan'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'pendidikan') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-graduation-cap w-5 text-center mr-2"></i>
                        <span>Pendidikan</span>
                    </a>
                    <a href="<?= base_url('penghasilan'); ?>" class="flex items-center px-4 py-2.5 text-xs font-medium rounded-xl transition-colors <?= ($this->uri->segment(1) == 'penghasilan') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-wallet w-5 text-center mr-2"></i>
                        <span>Penghasilan Bulanan</span>
                    </a>
                    <a href="<?= base_url('master_kelas'); ?>" class="flex items-center px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                        <i class="fa-solid fa-layer-group w-5 mr-2 text-emerald-500"></i>
                        <span>Master Kelas</span>
                    </a>
                </div>
            </div>

            <!-- 1. DATA MASTER mapel  (Dropdown) -->
            <?php
            $seg1 = $this->uri->segment(1);
            $is_master_mapel = in_array($seg1, ['kelompok_mapel', 'mapel']);
            ?>

            <div x-data="{ openMasterMapel: <?= $is_master_mapel ? 'true' : 'false'; ?> }">
                <button @click="openMasterMapel = !openMasterMapel" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center">
                        <i class="fa-solid fa-book-open w-6 text-center text-base shrink-0"></i>
                        <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Master Mapel</span>
                    </div>
                    <i x-show="sidebarOpen" x-cloak class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openMasterMapel }"></i>
                </button>
                <div x-show="openMasterMapel && sidebarOpen" x-cloak x-transition class="pl-9 pr-2 py-1 space-y-1">
                    <a href="<?= site_url('kelompok_mapel'); ?>" class="block px-3 py-2 text-xs rounded-lg transition-colors <?= $seg1 == 'kelompok_mapel' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/40'; ?>">Kelompok Mapel</a>
                    <a href="<?= site_url('mapel'); ?>" class="block px-3 py-2 text-xs rounded-lg transition-colors <?= $seg1 == 'mapel' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/40'; ?>">Mapel</a>
                </div>
            </div>


            <!-- 2. GURU (Dropdown) -->
            <div x-data="{ openGuru: false }">
                <button @click="openGuru = !openGuru" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center">
                        <i class="fa-solid fa-chalkboard-user w-6 text-center text-base shrink-0"></i>
                        <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Guru</span>
                    </div>
                    <i x-show="sidebarOpen" x-cloak class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openGuru }"></i>
                </button>
                <div x-show="openGuru && sidebarOpen" x-cloak x-transition class="pl-9 pr-2 py-1 space-y-1">
                    <a href="<?= site_url('guru'); ?>" class="block px-3 py-2 text-xs rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/40">PTK</a>
                    <a href="#" class="block px-3 py-2 text-xs rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/40">Tendik</a>
                </div>
            </div>

        <?php endif; ?>

        <!-- ========================================== -->
        <!-- MENU SISWA (Tampil untuk Admin & Wali Kelas)-->
        <!-- ========================================== -->
        <?php if ($role === 'administrator' || $is_wali_kelas || $role === 'wali_kelas') : ?>
            <div x-data="{ openSiswa: false }">
                <!-- Tombol Utama Siswa -->
                <button @click="openSiswa = !openSiswa" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center">
                        <i class="fa-solid fa-user-graduate w-6 text-center text-base shrink-0"></i>
                        <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Siswa</span>
                    </div>
                    <i x-show="sidebarOpen" x-cloak class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openSiswa }"></i>
                </button>

                <!-- Submenu -->
                <div x-show="openSiswa && sidebarOpen" x-cloak x-transition class="space-y-1 mt-1">
                    <a href="<?= base_url('siswa') ?>" class="flex items-center px-3 py-2.5 pl-11 rounded-lg text-xs font-medium no-underline hover:no-underline transition-colors <?= ($this->uri->segment(1) == 'siswa' && $this->uri->segment(2) == '') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                        <i class="fa-solid fa-circle text-[6px] w-6 text-center shrink-0"></i>
                        <span class="ml-1 whitespace-nowrap">Peserta Didik</span>
                    </a>

                    <!-- Submenu khusus admin -->
                    <?php if ($role === 'administrator') : ?>
                        <a href="<?= base_url('siswa/keluar') ?>" class="flex items-center px-3 py-2.5 pl-11 rounded-lg text-xs font-medium no-underline hover:no-underline transition-colors text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                            <i class="fa-solid fa-circle text-[6px] w-6 text-center shrink-0"></i>
                            <span class="ml-1 whitespace-nowrap">PD Keluar</span>
                        </a>
                        <a href="<?= base_url('siswa/pd_lulus') ?>" class="flex items-center px-3 py-2.5 pl-11 rounded-lg text-xs font-medium no-underline hover:no-underline transition-colors text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                            <i class="fa-solid fa-circle text-[6px] w-6 text-center shrink-0"></i>
                            <span class="ml-1 whitespace-nowrap">PD Lulus</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ========================================== -->
        <!-- LANJUTAN MENU KHUSUS ADMINISTRATOR         -->
        <!-- ========================================== -->
        <?php if ($role === 'administrator') : ?>
            <div>
                <a href="<?= base_url('rombel'); ?>" class="flex items-center px-3 py-2.5 rounded-lg transition-colors <?= $this->uri->segment(1) == 'rombel' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>">
                    <div class="flex items-center">
                        <i class="fa-solid fa-chalkboard w-6 text-center text-base shrink-0"></i>
                        <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Rombel</span>
                    </div>
                </a>
            </div>

            <a href="<?= site_url('kenaikanKelas'); ?>"
                class="flex items-center px-3 py-2.5 rounded-lg transition-colors <?= ($this->uri->segment(1) == 'kenaikanKelas') ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-semibold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300'; ?>"
                title="Kenaikan Kelas">
                <i class="fa-solid fa-arrow-trend-up w-6 text-center text-base shrink-0 text-blue-600 dark:text-blue-400"></i>
                <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Kenaikan Kelas</span>
            </a>

            <a href="<?= site_url('users'); ?>" class="flex items-center px-3 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition-colors" title="Manajemen Hak Akses">
                <i class="fa-solid fa-users-gear w-6 text-center text-base shrink-0 text-blue-600 dark:text-blue-400"></i>
                <span x-show="sidebarOpen" x-cloak x-transition.opacity class="ml-3 whitespace-nowrap">Hak Akses</span>
            </a>
        <?php endif; ?>

    </nav>
</aside>