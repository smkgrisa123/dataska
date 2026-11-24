<?php
$is_wali_kelas = ($this->session->userdata('role') === 'wali_kelas');
?>

<div class="p-4 sm:p-6 space-y-6 pb-24 overflow-y-auto"
    x-data="{ 
         activeTab: 'pribadi',
         statusOrangTua: '<?= $siswa->status_orang_tua ?? ''; ?>',
         
         // Status Ayah
         ayahStatus: '<?= $siswa->ayah_status ?? 'Hidup'; ?>',
         ayahPekerjaan: '<?= $siswa->ayah_pekerjaan ?? ''; ?>',
         ayahPenghasilan: '<?= $siswa->ayah_penghasilan ?? ''; ?>',
         ayahNoHp: '<?= $siswa->ayah_no_hp ?? ''; ?>',

         // Status Ibu
         ibuStatus: '<?= $siswa->ibu_status ?? 'Hidup'; ?>',
         ibuPekerjaan: '<?= $siswa->ibu_pekerjaan ?? ''; ?>',
         ibuPenghasilan: '<?= $siswa->ibu_penghasilan ?? ''; ?>',
         ibuNoHp: '<?= $siswa->ibu_no_hp ?? ''; ?>',

         handleStatusOrangTuaChange() {
             if (this.statusOrangTua === 'Lengkap') {
                 this.ayahStatus = 'Hidup';
                 this.ibuStatus = 'Hidup';
             } else if (this.statusOrangTua === 'Yatim') {
                 this.ayahStatus = 'Meninggal';
                 this.ayahPekerjaan = 'Tidak bekerja';
                 this.ayahPenghasilan = 'Tidak berpenghasilan';
                 this.ayahNoHp = '';
                 this.ibuStatus = 'Hidup';
             } else if (this.statusOrangTua === 'Piatu') {
                 this.ayahStatus = 'Hidup';
                 this.ibuStatus = 'Meninggal';
                 this.ibuPekerjaan = 'Tidak bekerja';
                 this.ibuPenghasilan = 'Tidak berpenghasilan';
                 this.ibuNoHp = '';
             } else if (this.statusOrangTua === 'Yatim Piatu') {
                 this.ayahStatus = 'Meninggal';
                 this.ayahPekerjaan = 'Tidak bekerja';
                 this.ayahPenghasilan = 'Tidak berpenghasilan';
                 this.ayahNoHp = '';
                 this.ibuStatus = 'Meninggal';
                 this.ibuPekerjaan = 'Tidak bekerja';
                 this.ibuPenghasilan = 'Tidak berpenghasilan';
                 this.ibuNoHp = '';
             }
         },

         showToast: <?= $this->session->flashdata('success') ? 'true' : 'false'; ?>,
         init() {
             // 1. Jalankan sinkronisasi status otomatis saat halaman pertama dibuka
             this.handleStatusOrangTuaChange();

             // 2. Notifikasi Toast
             if (this.showToast) {
                 setTimeout(() => { this.showToast = false; }, 4000);
             }
         }
     }">
    <!-- TOAST NOTIFICATION SUKSES -->
    <template x-if="showToast">
        <div x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-xl shadow-xl dark:text-gray-400 dark:bg-gray-800 border border-gray-100 dark:border-gray-700"
            role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <i class="fa-solid fa-check text-base"></i>
            </div>
            <div class="ml-3 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">
                <?= $this->session->flashdata('success'); ?>
            </div>
            <button @click="showToast = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="sr-only">Close</span>
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    </template>

    <!-- TOAST NOTIFICATION ERROR (TAMBAHKAN INI) -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-xl shadow-xl dark:text-gray-400 dark:bg-gray-800 border border-rose-100 dark:border-rose-900"
            role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-rose-500 bg-rose-100 rounded-lg dark:bg-rose-900/40 dark:text-rose-200">
                <i class="fa-solid fa-triangle-exclamation text-base"></i>
            </div>
            <div class="ml-3 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">
                <?= $this->session->flashdata('error'); ?>
            </div>
            <button type="button" onclick="this.parentElement.style.display='none'" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="sr-only">Close</span>
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Banner Header Bergaya Elegan -->
    <div class="bg-gray-900 text-white rounded-2xl p-6 shadow-md flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                <a href="<?= base_url('siswa'); ?>" class="hover:underline">Peserta Didik</a>
                <span>/</span>
                <span class="text-primary-400">Edit Data</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-primary-400"></i>
                Edit Data Peserta Didik: <span class="text-primary-300"><?= htmlspecialchars($siswa->nama); ?></span>
            </h1>
            <p class="text-xs text-gray-400 mt-1">Kelola dan perbarui informasi lengkap peserta didik berdasarkan kategori tab.</p>
        </div>
        <div>
            <a href="<?= base_url('siswa'); ?>" class="inline-flex items-center px-4 py-2 text-xs font-medium text-gray-200 bg-gray-800 border border-gray-700 rounded-xl hover:bg-gray-700 shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Kembali ke Daftar Siswa
            </a>
        </div>
    </div>

    <!-- SATU FORM UTAMA YANG MEMBUNGKUS SELURUH TAB -->
    <form action="<?= base_url('siswa/update_pribadi/' . $siswa->id); ?>" method="POST">

        <!-- Navigasi Tab Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="border-b border-gray-200 dark:border-gray-700 px-4 sm:px-6">
                <nav class="flex space-x-6 overflow-x-auto" aria-label="Tabs">
                    <!-- Tab 1: Data Pribadi -->
                    <button type="button" @click="activeTab = 'pribadi'"
                        :class="activeTab === 'pribadi' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-id-card"></i> Data Pribadi
                    </button>

                    <!-- Tab 2: Alamat & Kontak -->
                    <button type="button" @click="activeTab = 'alamat'"
                        :class="activeTab === 'alamat' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-map-location-dot"></i> Alamat & Kontak
                    </button>

                    <!-- Tab 3: Orang Tua / Wali -->
                    <button type="button" @click="activeTab = 'ortu'"
                        :class="activeTab === 'ortu' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-users"></i> Orang Tua / Wali
                    </button>
                    <!-- Tab Periodik -->
                    <button type="button" @click="activeTab = 'periodik'"
                        :class="activeTab === 'periodik' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-ruler-combined"></i> Priodik
                    </button>

                    <!-- Tab Prestasi -->
                    <button type="button" @click="activeTab = 'prestasi'"
                        :class="activeTab === 'prestasi' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-trophy"></i> Prestasi
                    </button>

                    <!-- Tab Beasiswa -->
                    <button type="button" @click="activeTab = 'beasiswa'"
                        :class="activeTab === 'beasiswa' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-graduation-cap"></i> Beasiswa
                    </button>

                    <!-- Tab Kesejahteraan -->
                    <button type="button" @click="activeTab = 'kesejahteraan'"
                        :class="activeTab === 'kesejahteraan' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-hand-holding-heart"></i> Kesejahteraan
                    </button>



                    <!-- Tab 1: Dokumen -->
                    <button type="button" @click="activeTab = 'dokumen'"
                        :class="activeTab === 'dokumen' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-folder-open"></i> Dokumen
                    </button>

                    <!-- Tab 2: Tamat Belajar / Lulus -->
                    <?php if ($this->session->userdata('role') !== 'wali_kelas'): ?>
                        <button type="button" @click="activeTab = 'lulus'"
                            :class="activeTab === 'lulus' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                            <i class="fa-solid fa-graduation-cap"></i> Tamat Belajar / Lulus
                        </button>
                    <?php endif; ?>

                    <!-- Tab Registrasi -->
                    <button type="button" @click="activeTab = 'registrasi'"
                        :class="activeTab === 'registrasi' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors">
                        <i class="fa-solid fa-file-pen"></i> Registrasi
                    </button>

                </nav>

            </div>

            <!-- ISI KONTEN TAB -->
            <div class="p-6">

                <!-- KONTEN TAB 1: DATA PRIBADI -->
                <div x-show="activeTab === 'pribadi'" x-cloak class="space-y-6">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">Formulir Data Pribadi Siswa</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs sm:text-sm">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" value="<?= htmlspecialchars($siswa->nama); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none" required>
                        </div>

                        <!-- Nama Panggilan -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan" value="<?= htmlspecialchars($siswa->nama_panggilan ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        </div>

                        <!-- NISN -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">NISN</label>
                            <input type="text" name="nisn" value="<?= htmlspecialchars($siswa->nisn ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        </div>

                        <!-- No Induk -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Induk / NIS</label>
                            <input type="text" name="no_induk" value="<?= htmlspecialchars($siswa->no_induk ?? ''); ?>" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 bg-gray-100 cursor-not-allowed outline-none" title="Nomor induk diisi melalui tab Registrasi Masuk">
                            <p class="text-[10px] text-gray-400 mt-1">Nomor induk dikelola otomatis melalui menu Registrasi Masuk.</p>
                        </div>
                        <!-- NIK -->
                        <div x-data="{ nik: '<?= htmlspecialchars($siswa->nik ?? '', ENT_QUOTES, 'UTF-8'); ?>' }">
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                NIK (Nomor Induk Kependudukan)
                            </label>
                            <input type="text"
                                name="nik"
                                x-model="nik"
                                @input="nik = nik.replace(/[^0-9]/g, '')"
                                maxlength="16"
                                autocomplete="off"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-colors disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                :class="nik.length > 0 && nik.length < 16 ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600'"
                                placeholder="16 digit NIK">

                            <!-- Pesan Peringatan Jika Karakter Kurang dari 16 Digit (Hanya muncul jika bukan wali kelas atau jika diperlukan) -->
                            <template x-if="!<?= $is_wali_kelas ? 'true' : 'false'; ?> && nik.length > 0 && nik.length < 16">
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    Jumlah NIK kurang dari 16 digit (<span x-text="nik.length"></span>/16)
                                </p>
                            </template>
                        </div>
                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin</label>
                            <select name="jk" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <option value="L" <?= ($siswa->jk == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= ($siswa->jk == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($siswa->tempat_lahir ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= $siswa->tanggal_lahir; ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        </div>

                        <!-- No KK -->
                        <div x-data="{ noKk: '<?= htmlspecialchars($siswa->no_kk ?? '', ENT_QUOTES, 'UTF-8'); ?>' }">
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nomor Kartu Keluarga (KK)
                            </label>
                            <input type="text"
                                name="no_kk"
                                x-model="noKk"
                                @input="noKk = noKk.replace(/[^0-9]/g, '')"
                                maxlength="16"
                                autocomplete="off"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none transition-colors disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                :class="noKk.length > 0 && noKk.length < 16 ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600'"
                                placeholder="16 digit Nomor KK">

                            <!-- Pesan Peringatan Jika Karakter Kurang dari 16 Digit (Hanya untuk Admin/Staff) -->
                            <template x-if="!<?= $is_wali_kelas ? 'true' : 'false'; ?> && noKk.length > 0 && noKk.length < 16">
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    Jumlah Nomor KK kurang dari 16 digit (<span x-text="noKk.length"></span>/16)
                                </p>
                            </template>
                        </div>

                        <!-- No Akte Lahir -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Registrasi Akta Lahir</label>
                            <input type="text" name="no_akte_lahir" value="<?= htmlspecialchars($siswa->no_akte_lahir ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Agama</label>
                            <select name="agama" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Agama --</option>
                                <?php $list_agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']; ?>
                                <?php foreach ($list_agama as $ag): ?>
                                    <option value="<?= $ag; ?>" <?= ($siswa->agama == $ag) ? 'selected' : ''; ?>><?= $ag; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Kewarganegaraan -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan_siswa" value="<?= htmlspecialchars($siswa->kewarganegaraan_siswa ?? 'Indonesia'); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        </div>

                        <!-- Status Orang Tua -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Orang Tua</label>
                            <select name="status_orang_tua" x-model="statusOrangTua" @change="handleStatusOrangTuaChange()"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Status --</option>
                                <?php $list_st = ['Lengkap', 'Yatim', 'Piatu', 'Yatim Piatu']; ?>
                                <?php foreach ($list_st as $st): ?>
                                    <option value="<?= $st; ?>" <?= ($siswa->status_orang_tua == $st) ? 'selected' : ''; ?>><?= $st; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Bahasa Sehari-hari -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Bahasa Sehari-hari di Rumah</label>
                            <input type="text" name="bahasa_sehari_hari" value="<?= htmlspecialchars($siswa->bahasa_sehari_hari ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none" placeholder="Contoh: Indonesia, Jawa, Madura">
                        </div>

                        <!-- Berkebutuhan Khusus -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Berkebutuhan Khusus</label>
                            <select name="berkebutuhan_khusus" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <option value="">-- Tidak Ada / Normal --</option>
                                <?php if (isset($berkebutuhan_khusus)): ?>
                                    <?php foreach ($berkebutuhan_khusus as $bk): ?>
                                        <option value="<?= $bk->nama; ?>" <?= (isset($siswa->berkebutuhan_khusus) && $siswa->berkebutuhan_khusus == $bk->nama) ? 'selected' : ''; ?>>
                                            <?= $bk->nama; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- KONTEN TAB 2: ALAMAT & KONTEN WILAYAH -->
                <div x-show="activeTab === 'alamat'" x-cloak class="space-y-6"
                    x-data="{ 
                         provinceId: '<?= $siswa->province_id ?? ''; ?>',
                         regencyId: '<?= $siswa->regency_id ?? ''; ?>',
                         districtId: '<?= $siswa->district_id ?? ''; ?>',
                         villageId: '<?= $siswa->village_id ?? ''; ?>',
                         
                         kabupatenList: [],
                         kecamatanList: [],
                         desaList: [],

                         init() {
                             if(this.provinceId) this.fetchKabupaten(false);
                             if(this.regencyId) this.fetchKecamatan(false);
                             if(this.districtId) this.fetchDesa(false);
                         },

                         fetchKabupaten(reset = true) {
                             if(reset) { this.regencyId = ''; this.districtId = ''; this.villageId = ''; this.kecamatanList = []; this.desaList = []; }
                             if(!this.provinceId) { this.kabupatenList = []; return; }
                             fetch('<?= base_url('siswa/get_kabupaten/'); ?>' + this.provinceId)
                                 .then(res => res.json())
                                 .then(data => { this.kabupatenList = data; });
                         },

                         fetchKecamatan(reset = true) {
                             if(reset) { this.districtId = ''; this.villageId = ''; this.desaList = []; }
                             if(!this.regencyId) { this.kecamatanList = []; return; }
                             fetch('<?= base_url('siswa/get_kecamatan/'); ?>' + this.regencyId)
                                 .then(res => res.json())
                                 .then(data => { this.kecamatanList = data; });
                         },

                         fetchDesa(reset = true) {
                             if(reset) { this.villageId = ''; }
                             if(!this.districtId) { this.desaList = []; return; }
                             fetch('<?= base_url('siswa/get_desa/'); ?>' + this.districtId)
                                 .then(res => res.json())
                                 .then(data => { this.desaList = data; });
                         }
                     }">

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">Formulir Alamat & Wilayah Domisili</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs sm:text-sm">
                        <!-- Provinsi -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Provinsi</label>
                            <select name="province_id" x-model="provinceId" @change="fetchKabupaten()"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Provinsi --</option>
                                <?php foreach ($provinces as $prov): ?>
                                    <option value="<?= $prov->id; ?>"><?= $prov->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Kabupaten / Kota -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten / Kota</label>
                            <select name="regency_id" x-model="regencyId" @change="fetchKecamatan()"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Kabupaten / Kota --</option>
                                <template x-for="kab in kabupatenList" :key="kab.id">
                                    <option :value="kab.id" x-text="kab.nama" :selected="kab.id == regencyId"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan</label>
                            <select name="district_id" x-model="districtId" @change="fetchDesa()"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="">-- Pilih Kecamatan --</option>
                                <template x-for="kec in kecamatanList" :key="kec.id">
                                    <option :value="kec.id" x-text="kec.nama" :selected="kec.id == districtId"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Desa / Kelurahan -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Desa / Kelurahan</label>
                            <select name="village_id" x-model="villageId"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                                <template x-for="des in desaList" :key="des.id">
                                    <option :value="des.id" x-text="des.nama" :selected="des.id == villageId"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Jalan -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Jalan / Komplek / Perumahan</label>
                            <input type="text" name="jalan" value="<?= htmlspecialchars($siswa->jalan ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="Contoh: Jl. Melati No. 10">
                        </div>

                        <!-- Dusun -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Dusun / Kampung / Lingkungan</label>
                            <input type="text" name="dusun" value="<?= htmlspecialchars($siswa->dusun ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: Dusun Krajan">
                        </div>

                        <!-- RT & RW -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">RT</label>
                                <input type="text" name="rt" value="<?= htmlspecialchars($siswa->rt ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="001">
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">RW</label>
                                <input type="text" name="rw" value="<?= htmlspecialchars($siswa->rw ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="002">
                            </div>
                        </div>

                        <!-- Lintang & Bujur -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Lintang (Latitude)</label>
                            <input type="text" name="lintang" value="<?= htmlspecialchars($siswa->lintang ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: -8.4095">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Bujur (Longitude)</label>
                            <input type="text" name="bujur" value="<?= htmlspecialchars($siswa->bujur ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 114.2156">
                        </div>

                        <!-- Tombol Cek Maps -->
                        <!-- Tombol Cek Maps -->
                        <div class="md:col-span-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-white text-xs sm:text-sm">Titik Koordinat Lokasi Rumah</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        <?= (!empty($siswa->lintang) && !empty($siswa->bujur)) ? 'Koordinat tersimpan: ' . $siswa->lintang . ', ' . $siswa->bujur : 'Belum ada koordinat Lintang & Bujur yang diisi.'; ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Maps tetap bisa dilihat, atau dibiarkan seperti aslinya -->
                            <?php if (!empty($siswa->lintang) && !empty($siswa->bujur)): ?>
                                <a href="https://www.google.com/maps/search/?api=1&query=<?= $siswa->lintang; ?>,<?= $siswa->bujur; ?>" target="_blank" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-xs rounded-lg shadow-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Cek di Google Maps
                                </a>
                            <?php else: ?>
                                <span class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-500 font-medium text-xs rounded-lg cursor-not-allowed">
                                    Maps Belum Aktif
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Tempat Tinggal -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Tempat Tinggal</label>
                            <select name="tempat_tinggal"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="">-- Pilih Tempat Tinggal --</option>
                                <?php $list_tt = ['Bersama orang tua', 'Wali', 'Kost', 'Asrama', 'Panti asuhan', 'Lainnya']; ?>
                                <?php foreach ($list_tt as $tt): ?>
                                    <option value="<?= $tt; ?>" <?= (isset($siswa->tempat_tinggal) && $siswa->tempat_tinggal == $tt) ? 'selected' : ''; ?>><?= $tt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Moda Transportasi -->
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Moda Transportasi</label>
                            <select name="moda_transportasi"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="">-- Pilih Moda Transportasi --</option>
                                <?php $list_mt = ['Jalan kaki', 'Kendaraan pribadi', 'Kendaraan umum / angkot', 'Jemputan sekolah', 'Antar jemput orang tua', 'Kereta api', 'Ojek', 'Lainnya']; ?>
                                <?php foreach ($list_mt as $mt): ?>
                                    <option value="<?= $mt; ?>" <?= (isset($siswa->moda_transportasi) && $siswa->moda_transportasi == $mt) ? 'selected' : ''; ?>><?= $mt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- No HP / Telepon Siswa -->
                        <div class="md:col-span-2">
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor HP / WhatsApp Siswa</label>
                            <input type="text" name="no_hp" value="<?= htmlspecialchars($siswa->no_hp ?? ''); ?>"
                                <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 081234567890">
                        </div>
                    </div>
                </div>

                <!-- KONTEN TAB 3: ORANG TUA / WALI -->
                <div x-show="activeTab === 'ortu'" x-cloak class="space-y-8">

                    <!-- ================= AYAH KANDUNG ================= -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700"
                        x-data="{ 
                             provinceId: '<?= $siswa->ayah_province_id ?? ''; ?>',
                             regencyId: '<?= $siswa->ayah_regency_id ?? ''; ?>',
                             districtId: '<?= $siswa->ayah_district_id ?? ''; ?>',
                             villageId: '<?= $siswa->ayah_village_id ?? ''; ?>',
                             kabupatenList: [], kecamatanList: [], desaList: [],
                             init() {
                                 if(this.provinceId) this.fetchKab(false);
                                 if(this.regencyId) this.fetchKec(false);
                                 if(this.districtId) this.fetchDes(false);
                             },
                             fetchKab(reset = true) {
                                 if(reset) { this.regencyId=''; this.districtId=''; this.villageId=''; this.kecamatanList=[]; this.desaList=[]; }
                                 if(!this.provinceId) { this.kabupatenList=[]; return; }
                                 fetch('<?= base_url('siswa/get_kabupaten/'); ?>' + this.provinceId).then(res => res.json()).then(data => { this.kabupatenList = data; });
                             },
                             fetchKec(reset = true) {
                                 if(reset) { this.districtId=''; this.villageId=''; this.desaList=[]; }
                                 if(!this.regencyId) { this.kecamatanList=[]; return; }
                                 fetch('<?= base_url('siswa/get_kecamatan/'); ?>' + this.regencyId).then(res => res.json()).then(data => { this.kecamatanList = data; });
                             },
                             fetchDes(reset = true) {
                                 if(reset) { this.villageId=''; }
                                 if(!this.districtId) { this.desaList=[]; return; }
                                 fetch('<?= base_url('siswa/get_desa/'); ?>' + this.districtId).then(res => res.json()).then(data => { this.desaList = data; });
                             }
                         }">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-user-tie text-purple-600"></i> Data Ayah Kandung
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ayah</label>
                                <input type="text" name="ayah_nama" value="<?= htmlspecialchars($siswa->ayah_nama ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                            </div>

                            <!-- Status Ayah -->
                            <!-- Status Ayah -->
                            <!-- Status Ayah -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ayah</label>
                                <input type="text" name="ayah_status" x-model="ayahStatus" readonly
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-gray-100 dark:bg-gray-800 outline-none cursor-default font-medium text-gray-700 dark:text-gray-200">
                            </div>
                            <div x-data="{ ayahNik: '<?= htmlspecialchars($siswa->ayah_nik ?? '', ENT_QUOTES, 'UTF-8'); ?>' }">
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">NIK Ayah</label>
                                <input type="text"
                                    name="ayah_nik"
                                    x-model="ayahNik"
                                    @input="ayahNik = ayahNik.replace(/[^0-9]/g, '')"
                                    maxlength="16"
                                    autocomplete="off"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none transition-colors disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    :class="ayahNik.length > 0 && ayahNik.length < 16 ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600'"
                                    placeholder="16 digit NIK Ayah">

                                <!-- Pesan Peringatan Jika Karakter Kurang dari 16 Digit (Hanya untuk Admin/Staff) -->
                                <template x-if="!<?= $is_wali_kelas ? 'true' : 'false'; ?> && ayahNik.length > 0 && ayahNik.length < 16">
                                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        Jumlah NIK Ayah kurang dari 16 digit (<span x-text="ayahNik.length"></span>/16)
                                    </p>
                                </template>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Lahir</label>
                                <input type="number" name="ayah_tahun_lahir"
                                    value="<?= (!empty($siswa->ayah_tahun_lahir) && $siswa->ayah_tahun_lahir != '0000' && $siswa->ayah_tahun_lahir != '0') ? htmlspecialchars($siswa->ayah_tahun_lahir) : ''; ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    placeholder="YYYY">
                            </div>

                            <!-- Pendidikan (Dari Master) -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pendidikan</label>
                                <select name="ayah_pendidikan" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <?php foreach ($pendidikan as $p): ?>
                                        <option value="<?= $p->nama ?? $p->id; ?>" <?= (isset($siswa->ayah_pendidikan) && ($siswa->ayah_pendidikan == $p->nama || $siswa->ayah_pendidikan == $p->id)) ? 'selected' : ''; ?>><?= $p->nama ?? $p->id; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Pekerjaan Ayah -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pekerjaan</label>
                                <select name="ayah_pekerjaan" x-model="ayahPekerjaan"
                                    :disabled="statusOrangTua === 'Yatim' || statusOrangTua === 'Yatim Piatu' || <?= $is_wali_kelas ? 'true' : 'false'; ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <template x-if="statusOrangTua === 'Yatim' || statusOrangTua === 'Yatim Piatu'">
                                        <option value="Tidak bekerja" selected>Tidak bekerja</option>
                                    </template>
                                    <?php foreach ($pekerjaan as $pk): ?>
                                        <option value="<?= $pk->nama_pekerjaan; ?>"><?= $pk->nama_pekerjaan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Penghasilan Bulanan Ayah -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penghasilan Bulanan</label>
                                <select name="ayah_penghasilan" x-model="ayahPenghasilan"
                                    :disabled="statusOrangTua === 'Yatim' || statusOrangTua === 'Yatim Piatu' || <?= $is_wali_kelas ? 'true' : 'false'; ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    <template x-if="statusOrangTua === 'Yatim' || statusOrangTua === 'Yatim Piatu'">
                                        <option value="Tidak berpenghasilan" selected>Tidak berpenghasilan</option>
                                    </template>
                                    <?php foreach ($penghasilan as $ph): ?>
                                        <?php $val_pen = $ph->nama_penghasilan ?? $ph->penghasilan ?? $ph->nama; ?>
                                        <option value="<?= htmlspecialchars($val_pen, ENT_QUOTES, 'UTF-8'); ?>"><?= $val_pen; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Alamat Ayah: Wilayah Bertingkat -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Provinsi (Ayah)</label>
                                <select name="ayah_province_id" x-model="provinceId" @change="fetchKab()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach ($provinces as $prov): ?>
                                        <option value="<?= $prov->id; ?>"><?= $prov->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten / Kota (Ayah)</label>
                                <select name="ayah_regency_id" x-model="regencyId" @change="fetchKec()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Kabupaten --</option>
                                    <template x-for="kab in kabupatenList" :key="kab.id">
                                        <option :value="kab.id" x-text="kab.nama" :selected="kab.id == regencyId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan (Ayah)</label>
                                <select name="ayah_district_id" x-model="districtId" @change="fetchDes()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <template x-for="kec in kecamatanList" :key="kec.id">
                                        <option :value="kec.id" x-text="kec.nama" :selected="kec.id == districtId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Desa / Kelurahan (Ayah)</label>
                                <select name="ayah_village_id" x-model="villageId"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Desa --</option>
                                    <template x-for="des in desaList" :key="des.id">
                                        <option :value="des.id" x-text="des.nama" :selected="des.id == villageId"></option>
                                    </template>
                                </select>
                            </div>
                            <!-- Nama Jalan -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Jalan (Ayah)</label>
                                <input type="text" name="ayah_jalan" value="<?= htmlspecialchars($siswa->ayah_jalan ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="Contoh: Jl. Melati">
                            </div>

                            <!-- Dusun / Kampung -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Dusun / Kampung (Ayah)</label>
                                <input type="text" name="ayah_dusun" value="<?= htmlspecialchars($siswa->ayah_dusun ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="Contoh: Dusun Krajan">
                            </div>

                            <!-- RT / RW -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">RT / RW</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="ayah_rt" value="<?= htmlspecialchars($siswa->ayah_rt ?? ''); ?>"
                                        <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                        autocomplete="off" class="px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="RT">
                                    <input type="text" name="ayah_rw" value="<?= htmlspecialchars($siswa->ayah_rw ?? ''); ?>"
                                        <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                        autocomplete="off" class="px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="RW">
                                </div>
                            </div>

                            <!-- Nomor HP / WhatsApp Ayah -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor HP / WhatsApp Ayah</label>
                                <input type="text" name="ayah_no_hp" x-model="ayahNoHp"
                                    :disabled="statusOrangTua === 'Yatim' || statusOrangTua === 'Yatim Piatu' || <?= $is_wali_kelas ? 'true' : 'false'; ?>"
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                    </div>

                    <!-- ================= IBU KANDUNG ================= -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700"
                        x-data="{ 
         provinceId: '<?= $siswa->ibu_province_id ?? ''; ?>',
         regencyId: '<?= $siswa->ibu_regency_id ?? ''; ?>',
         districtId: '<?= $siswa->ibu_district_id ?? ''; ?>',
         villageId: '<?= $siswa->ibu_village_id ?? ''; ?>',
         kabupatenList: [], kecamatanList: [], desaList: [],
         init() {
             if(this.provinceId) this.fetchKab(false);
             if(this.regencyId) this.fetchKec(false);
             if(this.districtId) this.fetchDes(false);
         },
         fetchKab(reset = true) {
             if(reset) { this.regencyId=''; this.districtId=''; this.villageId=''; this.kecamatanList=[]; this.desaList=[]; }
             if(!this.provinceId) { this.kabupatenList=[]; return; }
             fetch('<?= base_url('siswa/get_kabupaten/'); ?>' + this.provinceId).then(res => res.json()).then(data => { this.kabupatenList = data; });
         },
         fetchKec(reset = true) {
             if(reset) { this.districtId=''; this.villageId=''; this.desaList=[]; }
             if(!this.regencyId) { this.kecamatanList=[]; return; }
             fetch('<?= base_url('siswa/get_kecamatan/'); ?>' + this.regencyId).then(res => res.json()).then(data => { this.kecamatanList = data; });
         },
         fetchDes(reset = true) {
             if(reset) { this.villageId=''; }
             if(!this.districtId) { this.desaList=[]; return; }
             fetch('<?= base_url('siswa/get_desa/'); ?>' + this.districtId).then(res => res.json()).then(data => { this.desaList = data; });
         }
     }">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-user-nurse text-pink-600"></i> Data Ibu Kandung
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ibu</label>
                                <input type="text" name="ibu_nama" value="<?= htmlspecialchars($siswa->ibu_nama ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                            </div>

                            <!-- Status Ibu (Readonly otomatis) -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ibu</label>
                                <input type="text" name="ibu_status" x-model="ibuStatus" readonly
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-gray-100 dark:bg-gray-800 outline-none cursor-default font-medium text-gray-700 dark:text-gray-200">
                            </div>

                            <!-- NIK Ibu -->
                            <div x-data="{ ibuNik: '<?= htmlspecialchars($siswa->ibu_nik ?? '', ENT_QUOTES, 'UTF-8'); ?>' }">
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">NIK Ibu</label>
                                <input type="text"
                                    name="ibu_nik"
                                    x-model="ibuNik"
                                    @input="ibuNik = ibuNik.replace(/[^0-9]/g, '')"
                                    maxlength="16"
                                    autocomplete="off"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none transition-colors disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    :class="ibuNik.length > 0 && ibuNik.length < 16 ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600'"
                                    placeholder="16 digit NIK Ibu">

                                <template x-if="!<?= $is_wali_kelas ? 'true' : 'false'; ?> && ibuNik.length > 0 && ibuNik.length < 16">
                                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        Jumlah NIK Ibu kurang dari 16 digit (<span x-text="ibuNik.length"></span>/16)
                                    </p>
                                </template>
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Lahir</label>
                                <input type="number" name="ibu_tahun_lahir"
                                    value="<?= (!empty($siswa->ibu_tahun_lahir) && $siswa->ibu_tahun_lahir != '0000' && $siswa->ibu_tahun_lahir != '0') ? htmlspecialchars($siswa->ibu_tahun_lahir) : ''; ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    placeholder="YYYY">
                            </div>

                            <!-- Pendidikan -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pendidikan</label>
                                <select name="ibu_pendidikan" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <?php foreach ($pendidikan as $p): ?>
                                        <option value="<?= $p->nama ?? $p->id; ?>" <?= (isset($siswa->ibu_pendidikan) && ($siswa->ibu_pendidikan == $p->nama || $siswa->ibu_pendidikan == $p->id)) ? 'selected' : ''; ?>><?= $p->nama ?? $p->id; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Pekerjaan Ibu -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pekerjaan</label>
                                <select name="ibu_pekerjaan" x-model="ibuPekerjaan"
                                    :disabled="statusOrangTua === 'Piatu' || statusOrangTua === 'Yatim Piatu' || <?= $is_wali_kelas ? 'true' : 'false'; ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <template x-if="statusOrangTua === 'Piatu' || statusOrangTua === 'Yatim Piatu'">
                                        <option value="Tidak bekerja" selected>Tidak bekerja</option>
                                    </template>
                                    <?php foreach ($pekerjaan as $pk): ?>
                                        <option value="<?= $pk->nama_pekerjaan; ?>"><?= $pk->nama_pekerjaan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Penghasilan Bulanan Ibu -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penghasilan Bulanan</label>
                                <select name="ibu_penghasilan" x-model="ibuPenghasilan"
                                    :disabled="statusOrangTua === 'Piatu' || statusOrangTua === 'Yatim Piatu' || <?= $is_wali_kelas ? 'true' : 'false'; ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    <template x-if="statusOrangTua === 'Piatu' || statusOrangTua === 'Yatim Piatu'">
                                        <option value="Tidak berpenghasilan" selected>Tidak berpenghasilan</option>
                                    </template>
                                    <?php foreach ($penghasilan as $ph): ?>
                                        <?php $val_pen = $ph->nama_penghasilan ?? $ph->penghasilan ?? $ph->nama; ?>
                                        <option value="<?= htmlspecialchars($val_pen, ENT_QUOTES, 'UTF-8'); ?>"><?= $val_pen; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Alamat Ibu: Wilayah Bertingkat -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Provinsi (Ibu)</label>
                                <select name="ibu_province_id" x-model="provinceId" @change="fetchKab()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach ($provinces as $prov): ?>
                                        <option value="<?= $prov->id; ?>"><?= $prov->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten / Kota (Ibu)</label>
                                <select name="ibu_regency_id" x-model="regencyId" @change="fetchKec()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Kabupaten --</option>
                                    <template x-for="kab in kabupatenList" :key="kab.id">
                                        <option :value="kab.id" x-text="kab.nama" :selected="kab.id == regencyId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan (Ibu)</label>
                                <select name="ibu_district_id" x-model="districtId" @change="fetchDes()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <template x-for="kec in kecamatanList" :key="kec.id">
                                        <option :value="kec.id" x-text="kec.nama" :selected="kec.id == districtId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Desa / Kelurahan (Ibu)</label>
                                <select name="ibu_village_id" x-model="villageId"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Desa --</option>
                                    <template x-for="des in desaList" :key="des.id">
                                        <option :value="des.id" x-text="des.nama" :selected="des.id == villageId"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Nama Jalan -->
                            <div>
                                <label class="font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Jalan (Ibu)</label>
                                <input type="text" name="ibu_jalan" value="<?= htmlspecialchars($siswa->ibu_jalan ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="Contoh: Jl. Melati">
                            </div>

                            <!-- Dusun / Kampung -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Dusun / Kampung (Ibu)</label>
                                <input type="text" name="ibu_dusun" value="<?= htmlspecialchars($siswa->ibu_dusun ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="Contoh: Dusun Krajan">
                            </div>

                            <!-- RT / RW -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">RT / RW</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="ibu_rt" value="<?= htmlspecialchars($siswa->ibu_rt ?? ''); ?>"
                                        <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                        autocomplete="off" class="px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="RT">
                                    <input type="text" name="ibu_rw" value="<?= htmlspecialchars($siswa->ibu_rw ?? ''); ?>"
                                        <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                        autocomplete="off" class="px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="RW">
                                </div>
                            </div>

                            <!-- Nomor HP / WhatsApp Ibu -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor HP / WhatsApp Ibu</label>
                                <input type="text" name="ibu_no_hp" x-model="ibuNoHp"
                                    :disabled="statusOrangTua === 'Piatu' || statusOrangTua === 'Yatim Piatu' || <?= $is_wali_kelas ? 'true' : 'false'; ?>"
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                    </div>

                    <!-- ================= WALI SISWA ================= -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700"
                        x-data="{ 
         provinceId: '<?= $siswa->wali_province_id ?? ''; ?>',
         regencyId: '<?= $siswa->wali_regency_id ?? ''; ?>',
         districtId: '<?= $siswa->wali_district_id ?? ''; ?>',
         villageId: '<?= $siswa->wali_village_id ?? ''; ?>',
         kabupatenList: [], kecamatanList: [], desaList: [],
         init() {
             if(this.provinceId) this.fetchKab(false);
             if(this.regencyId) this.fetchKec(false);
             if(this.districtId) this.fetchDes(false);
         },
         fetchKab(reset = true) {
             if(reset) { this.regencyId=''; this.districtId=''; this.villageId=''; this.kecamatanList=[]; this.desaList=[]; }
             if(!this.provinceId) { this.kabupatenList=[]; return; }
             fetch('<?= base_url('siswa/get_kabupaten/'); ?>' + this.provinceId).then(res => res.json()).then(data => { this.kabupatenList = data; });
         },
         fetchKec(reset = true) {
             if(reset) { this.districtId=''; this.villageId=''; this.desaList=[]; }
             if(!this.regencyId) { this.kecamatanList=[]; return; }
             fetch('<?= base_url('siswa/get_kecamatan/'); ?>' + this.regencyId).then(res => res.json()).then(data => { this.kecamatanList = data; });
         },
         fetchDes(reset = true) {
             if(reset) { this.villageId=''; }
             if(!this.districtId) { this.desaList=[]; return; }
             fetch('<?= base_url('siswa/get_desa/'); ?>' + this.districtId).then(res => res.json()).then(data => { this.desaList = data; });
         }
     }">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-blue-600"></i> Data Wali (Opsional jika ikut wali)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Wali</label>
                                <input type="text" name="wali_nama" value="<?= htmlspecialchars($siswa->wali_nama ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                            </div>

                            <div x-data="{ waliNik: '<?= htmlspecialchars($siswa->wali_nik ?? '', ENT_QUOTES, 'UTF-8'); ?>' }">
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">NIK Wali</label>
                                <input type="text"
                                    name="wali_nik"
                                    x-model="waliNik"
                                    @input="waliNik = waliNik.replace(/[^0-9]/g, '')"
                                    maxlength="16"
                                    autocomplete="off"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none transition-colors disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    :class="waliNik.length > 0 && waliNik.length < 16 ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600'"
                                    placeholder="16 digit NIK Wali">

                                <template x-if="!<?= $is_wali_kelas ? 'true' : 'false'; ?> && waliNik.length > 0 && waliNik.length < 16">
                                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        Jumlah NIK Wali kurang dari 16 digit (<span x-text="waliNik.length"></span>/16)
                                    </p>
                                </template>
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Lahir</label>
                                <input type="number" name="wali_tahun_lahir"
                                    value="<?= (!empty($siswa->wali_tahun_lahir) && $siswa->wali_tahun_lahir != '0000' && $siswa->wali_tahun_lahir != '0') ? htmlspecialchars($siswa->wali_tahun_lahir) : ''; ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    placeholder="YYYY">
                            </div>

                            <!-- Pendidikan Wali -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pendidikan</label>
                                <select name="wali_pendidikan" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <?php foreach ($pendidikan as $p): ?>
                                        <?php $val_pnd = $p->nama_pendidikan ?? $p->pendidikan ?? $p->nama ?? $p->id; ?>
                                        <option value="<?= htmlspecialchars($val_pnd, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?= (isset($siswa->wali_pendidikan) && trim($siswa->wali_pendidikan) == trim($val_pnd)) ? 'selected' : ''; ?>>
                                            <?= $val_pnd; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Pekerjaan Wali -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pekerjaan</label>
                                <select name="wali_pekerjaan" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <?php foreach ($pekerjaan as $pk): ?>
                                        <?php $val_pek = $pk->nama_pekerjaan ?? $pk->pekerjaan ?? $pk->nama ?? $pk->id; ?>
                                        <option value="<?= htmlspecialchars($val_pek, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?= (isset($siswa->wali_pekerjaan) && trim($siswa->wali_pekerjaan) == trim($val_pek)) ? 'selected' : ''; ?>>
                                            <?= $val_pek; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Penghasilan Bulanan Wali -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penghasilan Bulanan</label>
                                <select name="wali_penghasilan" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    <?php foreach ($penghasilan as $ph): ?>
                                        <?php $val_pen = $ph->nama_penghasilan ?? $ph->penghasilan ?? $ph->nama ?? $ph->id; ?>
                                        <option value="<?= htmlspecialchars($val_pen, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?= (isset($siswa->wali_penghasilan) && trim($siswa->wali_penghasilan) == trim($val_pen)) ? 'selected' : ''; ?>>
                                            <?= $val_pen; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Alamat Wali: Wilayah Bertingkat -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Provinsi (Wali)</label>
                                <select name="wali_province_id" x-model="provinceId" @change="fetchKab()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach ($provinces as $prov): ?>
                                        <option value="<?= $prov->id; ?>"><?= $prov->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten / Kota (Wali)</label>
                                <select name="wali_regency_id" x-model="regencyId" @change="fetchKec()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Kabupaten --</option>
                                    <template x-for="kab in kabupatenList" :key="kab.id">
                                        <option :value="kab.id" x-text="kab.nama" :selected="kab.id == regencyId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan (Wali)</label>
                                <select name="wali_district_id" x-model="districtId" @change="fetchDes()"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <template x-for="kec in kecamatanList" :key="kec.id">
                                        <option :value="kec.id" x-text="kec.nama" :selected="kec.id == districtId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Desa / Kelurahan (Wali)</label>
                                <select name="wali_village_id" x-model="villageId"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Desa --</option>
                                    <template x-for="des in desaList" :key="des.id">
                                        <option :value="des.id" x-text="des.nama" :selected="des.id == villageId"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Jalan / Dusun (Wali)</label>
                                <input type="text" name="wali_jalan" value="<?= htmlspecialchars($siswa->wali_jalan ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="Contoh: Jl. Melati / Dusun Krajan">
                            </div>

                            <!-- RT / RW -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">RT / RW</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="wali_rt" value="<?= htmlspecialchars($siswa->wali_rt ?? ''); ?>"
                                        <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                        autocomplete="off" class="px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="RT">
                                    <input type="text" name="wali_rw" value="<?= htmlspecialchars($siswa->wali_rw ?? ''); ?>"
                                        <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                        autocomplete="off" class="px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="RW">
                                </div>
                            </div>

                            <!-- Nomor HP / WhatsApp Wali -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor HP / WhatsApp Wali</label>
                                <input type="text" name="wali_no_hp" value="<?= htmlspecialchars($siswa->wali_no_hp ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed" placeholder="08xxxxxxxxxx">
                            </div>

                            <!-- Hubungan dengan Siswa -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Hubungan dengan Siswa</label>
                                <select name="wali_status_hubungan" <?= $is_wali_kelas ? 'disabled' : ''; ?> class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                    <option value="">-- Pilih Hubungan --</option>
                                    <?php
                                    $list_hubungan = [
                                        'Ayah kandung',
                                        'Ibu kandung',
                                        'Ayah tiri',
                                        'Ibu tiri',
                                        'Kakak',
                                        'Kakek',
                                        'Nenek',
                                        'Paman',
                                        'Bibi',
                                        'Saudara lain',
                                        'Lainnya'
                                    ];
                                    ?>
                                    <?php foreach ($list_hubungan as $hb): ?>
                                        <option value="<?= $hb; ?>" <?= (isset($siswa->wali_status_hubungan) && $siswa->wali_status_hubungan == $hb) ? 'selected' : ''; ?>>
                                            <?= $hb; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tab 4: Periodik -->
                <div x-show="activeTab === 'periodik'" class="space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-ruler-combined text-primary-600"></i> Data Periodik Siswa
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm">
                            <!-- 1. Tinggi Badan -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan" value="<?= htmlspecialchars($siswa->tinggi_badan ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 165">
                            </div>

                            <!-- 2. Berat Badan -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Berat Badan (kg)</label>
                                <input type="number" step="0.1" name="berat_badan" value="<?= htmlspecialchars($siswa->berat_badan ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 55">
                            </div>

                            <!-- 3. Lingkar Kepala -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" name="lingkar_kepala" value="<?= htmlspecialchars($siswa->lingkar_kepala ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 54">
                            </div>

                            <!-- 4. Jarak Tempuh -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jarak ke Sekolah</label>
                                <select name="jarak_tempuh_kategori"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                                    <option value="">-- Pilih Jarak --</option>
                                    <option value="Kurang dari 1 km" <?= (isset($siswa->jarak_tempuh_kategori) && $siswa->jarak_tempuh_kategori == 'Kurang dari 1 km') ? 'selected' : ''; ?>>Kurang dari 1 km</option>
                                    <option value="Lebih dari 1 km" <?= (isset($siswa->jarak_tempuh_kategori) && $siswa->jarak_tempuh_kategori == 'Lebih dari 1 km') ? 'selected' : ''; ?>>Lebih dari 1 km</option>
                                </select>
                            </div>

                            <!-- 5. Sebutkan dalam km -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Sebutkan Jarak (km)</label>
                                <input type="text" name="jarak_km" value="<?= htmlspecialchars($siswa->jarak_km ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 2.5">
                            </div>

                            <!-- 6. Waktu Tempuh -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu Tempuh (Menit)</label>
                                <input type="number" name="waktu_tempuh" value="<?= htmlspecialchars($siswa->waktu_tempuh ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 15">
                            </div>

                            <!-- 7. Jumlah Saudara Kandung -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Saudara Kandung</label>
                                <input type="number" name="jml_saudara_kandung" value="<?= htmlspecialchars($siswa->jml_saudara_kandung ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 2">
                            </div>

                            <!-- 8. Anak Ke -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Anak Ke-</label>
                                <input type="number" name="anak_ke" value="<?= htmlspecialchars($siswa->anak_ke ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 1">
                            </div>

                            <!-- 9. Jumlah Saudara Tiri -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Saudara Tiri</label>
                                <input type="number" name="jml_saudara_tiri" value="<?= htmlspecialchars($siswa->jml_saudara_tiri ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 0">
                            </div>

                            <!-- 10. Jumlah Saudara Angkat -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Saudara Angkat</label>
                                <input type="number" name="jml_saudara_angkat" value="<?= htmlspecialchars($siswa->jml_saudara_angkat ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: 0">
                            </div>

                            <!-- 11. Penyakit yang Pernah Diderita -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penyakit yang Pernah Diderita</label>
                                <input type="text" name="riwayat_penyakit" value="<?= htmlspecialchars($siswa->riwayat_penyakit ?? ''); ?>"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Contoh: Asma / Tdk ada">
                            </div>

                            <!-- 12. Golongan Darah -->
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Golongan Darah</label>
                                <select name="golongan_darah"
                                    <?= $is_wali_kelas ? 'disabled' : ''; ?>
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                                    <option value="">-- Pilih Gol. Darah --</option>
                                    <?php $gol_darah = ['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Tidak Tahu']; ?>
                                    <?php foreach ($gol_darah as $gd): ?>
                                        <option value="<?= $gd; ?>" <?= (isset($siswa->golongan_darah) && $siswa->golongan_darah == $gd) ? 'selected' : ''; ?>>
                                            <?= $gd; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KONTEN TAB: PRESTASI                       -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'prestasi'" class="space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">

                        <!-- Header Tabel & Tombol Tambah -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-trophy text-yellow-500"></i> Data Prestasi Siswa
                            </h3>

                            <!-- Tombol untuk memicu modal (menggunakan event dispatch) -->
                            <?php if (!$is_wali_kelas): ?>
                                <button type="button" @click="$dispatch('open-modal-prestasi')" class="px-3.5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 shadow transition">
                                    <i class="fa-solid fa-plus"></i> Tambah Prestasi
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Tabel Daftar Prestasi -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">No</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Jenis</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tingkat</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Nama Prestasi</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tahun</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Penyelenggara</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Peringkat</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700 text-center">Aksi</th>
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
                                                <!-- Di dalam tabel, pada kolom Aksi -->
                                                <td class="p-2.5 border border-gray-200 dark:border-gray-700 text-center flex items-center justify-center gap-2">
                                                    <!-- Tombol Edit (Memicu modal edit dengan data prestasi terkait) -->
                                                    <button type="button" @click="$dispatch('open-modal-edit-prestasi', { 
        id: '<?= $p->id; ?>', 
        jenis: '<?= htmlspecialchars($p->jenis, ENT_QUOTES); ?>', 
        tingkat: '<?= htmlspecialchars($p->tingkat, ENT_QUOTES); ?>', 
        nama_prestasi: '<?= htmlspecialchars($p->nama_prestasi, ENT_QUOTES); ?>', 
        tahun: '<?= $p->tahun; ?>', 
        penyelenggara: '<?= htmlspecialchars($p->penyelenggara, ENT_QUOTES); ?>', 
        peringkat: '<?= htmlspecialchars($p->peringkat, ENT_QUOTES); ?>' 
    })" class="text-blue-500 hover:text-blue-700 p-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <a href="<?= site_url('siswa/hapus_prestasi/' . $p->id . '/' . $siswa->id); ?>" onclick="return confirm('Yakin ingin menghapus prestasi ini?')" class="text-red-500 hover:text-red-700 p-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="p-4 text-center text-gray-400 italic border border-gray-200 dark:border-gray-700">
                                                Belum ada data prestasi yang ditambahkan.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->




                <!-- Tab 6: Beasiswa -->
                <div x-show="activeTab === 'beasiswa'" x-cloak class="space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">

                        <!-- Header Tabel & Tombol Tambah -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-purple-600"></i> Data Beasiswa Siswa
                            </h3>
                            <?php if (!$is_wali_kelas): ?>
                                <button type="button" @click="$dispatch('open-modal-beasiswa')" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 shadow transition">
                                    <i class="fa-solid fa-plus"></i> Tambah Beasiswa
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Tabel Daftar Beasiswa -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">No</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Jenis</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Keterangan</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tahun Mulai</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Tahun Selesai</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700 text-center">Aksi</th>
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
                                                <td class="p-2.5 border border-gray-200 dark:border-gray-700 text-center flex items-center justify-center gap-2">
                                                    <!-- Tombol Edit -->
                                                    <button type="button" @click="$dispatch('open-modal-edit-beasiswa', { 
                                        id: '<?= $b->id; ?>', 
                                        jenis: '<?= htmlspecialchars($b->jenis, ENT_QUOTES); ?>', 
                                        keterangan: '<?= htmlspecialchars($b->keterangan, ENT_QUOTES); ?>', 
                                        tahun_mulai: '<?= $b->tahun_mulai; ?>', 
                                        tahun_selesai: '<?= $b->tahun_selesai; ?>' 
                                    })" class="text-blue-500 hover:text-blue-700 p-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <a href="<?= site_url('siswa/hapus_beasiswa/' . $b->id . '/' . $siswa->id); ?>" onclick="return confirm('Yakin ingin menghapus data beasiswa ini?')" class="text-red-500 hover:text-red-700 p-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="p-4 text-center text-gray-400 italic border border-gray-200 dark:border-gray-700">
                                                Belum ada data beasiswa yang ditambahkan.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Tab 7: Kesejahteraan (Menyusul) -->
                <!-- Tab Kesejahteraan -->
                <div x-show="activeTab === 'kesejahteraan'" x-cloak class="space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">

                        <!-- Header Tabel & Tombol Tambah -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-emerald-600"></i> Data Kesejahteraan / Bantuan Sosial Siswa
                            </h3>
                            <?php if (!$is_wali_kelas): ?>
                                <button type="button" @click="$dispatch('open-modal-kesejahteraan')" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 shadow transition">
                                    <i class="fa-solid fa-plus"></i> Tambah Kesejahteraan
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Tabel Daftar Kesejahteraan -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">No</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Jenis Kesejahteraan</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Nomor Kartu</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700">Nama di Kartu</th>
                                        <th class="p-2.5 border border-gray-200 dark:border-gray-700 text-center">Aksi</th>
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
                                                <td class="p-2.5 border border-gray-200 dark:border-gray-700 text-center flex items-center justify-center gap-2">
                                                    <!-- Tombol Edit -->
                                                    <button type="button" @click="$dispatch('open-modal-edit-kesejahteraan', { 
                                        id: '<?= $k->id; ?>', 
                                        jenis: '<?= htmlspecialchars($k->jenis, ENT_QUOTES); ?>', 
                                        no_kartu: '<?= htmlspecialchars($k->no_kartu, ENT_QUOTES); ?>', 
                                        nama_kartu: '<?= htmlspecialchars($k->nama_kartu, ENT_QUOTES); ?>' 
                                    })" class="text-blue-500 hover:text-blue-700 p-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <a href="<?= site_url('siswa/hapus_kesejahteraan/' . $k->id . '/' . $siswa->id); ?>" onclick="return confirm('Yakin ingin menghapus data kesejahteraan ini?')" class="text-red-500 hover:text-red-700 p-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="p-4 text-center text-gray-400 italic border border-gray-200 dark:border-gray-700">
                                                Belum ada data kesejahteraan yang ditambahkan.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Tab Registrasi -->
                <div x-show="activeTab === 'registrasi'" x-cloak class="space-y-6" x-data="{ subReg: 'masuk' }">
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">

                        <!-- Header & Tombol Sub-Tab -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-right-left text-blue-600"></i> Riwayat Registrasi Siswa
                            </h3>

                            <div class="inline-flex bg-gray-200 dark:bg-gray-800 p-1 rounded-xl text-xs font-medium">
                                <button type="button" @click="subReg = 'masuk'" :class="subReg === 'masuk' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400'" class="px-4 py-2 rounded-lg transition-all flex items-center gap-1.5">
                                    <i class="fa-solid fa-right-to-bracket"></i> Registrasi Masuk
                                </button>
                                <?php if (!$is_wali_kelas): ?>
                                    <button type="button" @click="subReg = 'keluar'" :class="subReg === 'keluar' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400'" class="px-4 py-2 rounded-lg transition-all flex items-center gap-1.5">
                                        <i class="fa-solid fa-right-from-bracket"></i> Registrasi Keluar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- SUB-TAB 1: REGISTRASI MASUK -->
                        <div x-show="subReg === 'masuk'" class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Form & Detail Registrasi Masuk</h4>
                                <?php if (!$is_wali_kelas): ?>
                                    <button type="button" @click="$dispatch('open-modal-reg-masuk')" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 shadow transition">
                                        <i class="fa-solid fa-pen-to-square"></i> <?= !empty($registrasi_masuk) ? 'Edit Registrasi Masuk' : 'Isi Registrasi Masuk'; ?>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Tampilan Ringkasan Data Masuk -->
                            <!-- Tampilan Ringkasan Data Masuk di edit.php -->
                            <!-- Tampilan Ringkasan Data Masuk di edit.php -->
                            <?php if (!empty($registrasi_masuk)): ?>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                                    <div>
                                        <p class="text-gray-400">Jenis Pendaftaran:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->jenis_pendaftaran); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Diterima di Kelas:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->diterima_di_kelas); ?></p>
                                    </div>

                                    <div>
                                        <p class="text-gray-400">Bidang Keahlian:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->bidang_keahlian ?? '-'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Program Keahlian:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->program_keahlian ?? '-'); ?></p>
                                    </div>

                                    <div>
                                        <p class="text-gray-400">Konsentrasi Keahlian:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->konsentrasi_keahlian); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Nomor Induk:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->no_induk); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Asal Sekolah (SMP/MTs):</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->asal_sekolah); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Tanggal Masuk:</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            <?= !empty($registrasi_masuk->tanggal_masuk) ? date('d/m/Y', strtotime($registrasi_masuk->tanggal_masuk)) : '-'; ?>
                                        </p>
                                    </div>

                                    <!-- Tambahan No & Tanggal Ijazah SMP/MTs -->
                                    <div>
                                        <p class="text-gray-400">No. Ijazah SMP/MTs:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_masuk->no_ijazah_smp ?? '-'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Tanggal Ijazah SMP/MTs:</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            <?= (!empty($registrasi_masuk->tanggal_ijazah_smp) && $registrasi_masuk->tanggal_ijazah_smp != '0000-00-00') ? date('d/m/Y', strtotime($registrasi_masuk->tanggal_ijazah_smp)) : '-'; ?>
                                        </p>
                                    </div>

                                    <?php if ($registrasi_masuk->jenis_pendaftaran === 'Pindahan'): ?>
                                        <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-3 mt-2 space-y-2">
                                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs font-semibold mb-1">Detail Siswa Pindahan</span>

                                            <!-- Baris 1: Sekolah Sebelumnya -->
                                            <div class="flex items-start">
                                                <span class="w-44 text-gray-400 shrink-0">Sekolah Sebelumnya</span>
                                                <span class="text-gray-400 mr-2">:</span>
                                                <span class="text-gray-800 dark:text-white font-medium"><?= htmlspecialchars($registrasi_masuk->sekolah_sebelumnya); ?></span>
                                            </div>

                                            <!-- Baris 2: Alasan Pindah -->
                                            <div class="flex items-start">
                                                <span class="w-44 text-gray-400 shrink-0">Alasan Pindah</span>
                                                <span class="text-gray-400 mr-2">:</span>
                                                <span class="text-gray-800 dark:text-white font-medium"><?= htmlspecialchars($registrasi_masuk->alasan_pindah); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 italic">
                                    Belum ada data registrasi masuk. Silakan klik tombol di atas untuk mengisi.
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- SUB-TAB 2: REGISTRASI KELUAR -->
                        <div x-show="subReg === 'keluar'" class="space-y-4" style="display: none;">
                            <div class="flex justify-between items-center">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Form & Detail Registrasi Keluar</h4>

                                <button type="button" @click="$dispatch('open-modal-reg-keluar')" class="px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 shadow transition">
                                    <i class="fa-solid fa-pen-to-square"></i> <?= !empty($registrasi_keluar) ? 'Edit Registrasi Keluar' : 'Isi Registrasi Keluar'; ?>
                                </button>
                            </div>

                            <!-- Tampilan Ringkasan Data Keluar -->
                            <?php if (!empty($registrasi_keluar)): ?>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                                    <div>
                                        <p class="text-gray-400">Keluar Karena:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_keluar->jenis_keluar); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Kelas Yang Ditinggalkan:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_keluar->kelas_ditinggalkan ?? '-'); ?></p>
                                    </div>
                                    <!-- Informasi Tahun Ajaran Keluar -->
                                    <div>
                                        <p class="text-gray-400">Tahun Ajaran Keluar:</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            <?= !empty($registrasi_keluar->nama_tahun_ajaran) ? htmlspecialchars($registrasi_keluar->nama_tahun_ajaran . ' (' . $registrasi_keluar->semester . ')') : '-'; ?>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Tanggal Keluar / Surat:</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            <?= (!empty($registrasi_keluar->tanggal_keluar) && $registrasi_keluar->tanggal_keluar != '0000-00-00')
                                                ? date('d/m/Y', strtotime($registrasi_keluar->tanggal_keluar))
                                                : ((!empty($registrasi_keluar->tanggal_surat) && $registrasi_keluar->tanggal_surat != '0000-00-00')
                                                    ? date('d/m/Y', strtotime($registrasi_keluar->tanggal_surat))
                                                    : '-'); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Alasan:</p>
                                        <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_keluar->alasan ?? '-'); ?></p>
                                    </div>

                                    <?php if ($registrasi_keluar->jenis_keluar === 'Mutasi'): ?>
                                        <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-3 mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-gray-400">No. Surat Mutasi:</p>
                                                <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_keluar->no_surat ?? '-'); ?></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-400">Sekolah Tujuan:</p>
                                                <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_keluar->nama_sekolah_tujuan ?? '-'); ?> (NPSN: <?= htmlspecialchars($registrasi_keluar->npsn_sekolah_tujuan ?? '-'); ?>)</p>
                                            </div>
                                            <div class="md:col-span-2">
                                                <p class="text-gray-400">Alamat Sekolah Tujuan:</p>
                                                <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($registrasi_keluar->alamat_sekolah ?? '-'); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 italic">
                                    Belum ada data registrasi keluar. Silakan klik tombol di atas untuk mengisi.
                                </div>
                            <?php endif; ?>
                        </div>


                    </div> <!-- Tutup div kontainer registrasi -->
                </div> <!-- Tutup div tab registrasi -->

                <!-- Tab Dokumen -->
                <div x-show="activeTab === 'dokumen'" class="space-y-6" style="display: none;">

                    <!-- HEADER PORTAL DOKUMEN -->
                    <div class="bg-indigo-50 dark:bg-indigo-950/40 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-900 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-indigo-600 text-white rounded-xl shadow-md">
                                <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Portal Dokumen Siswa</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <?= $is_wali_kelas ? 'Menampilkan berkas persyaratan dan administrasi peserta didik (Mode Lihat & Unduh).' : 'Lengkapi berkas persyaratan pendaftaran dan administrasi peserta didik.'; ?>
                                </p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full text-xs font-medium border border-emerald-200 dark:border-emerald-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-check"></i> Sistem Verifikasi Otomatis
                        </span>
                    </div>

                    <?php
                    // Mapping jenis dokumen
                    $jenis_dokumen_arr = [
                        'foto_diri'      => ['no' => 1, 'title' => 'Foto Diri', 'desc' => 'Format JPG/JPEG, Rasio 3×4 (Pas foto formal)'],
                        'kartu_keluarga' => ['no' => 2, 'title' => 'Kartu Keluarga (KK)', 'desc' => 'Format dokumen PDF yang jelas dan terbaca'],
                        'akte_kelahiran' => ['no' => 3, 'title' => 'Akte Kelahiran', 'desc' => 'Format dokumen PDF asli atau legalisir'],
                        'ijazah'         => ['no' => 4, 'title' => 'Ijazah SMP/MTs', 'desc' => 'Format dokumen PDF (Halaman depan & belakang)']
                    ];

                    // Buat array asosiatif dari database
                    $doc_uploaded = [];
                    if (!empty($dokumen_list)) {
                        foreach ($dokumen_list as $d) {
                            $doc_uploaded[trim($d->jenis_dokumen)] = $d;
                        }
                    }
                    ?>

                    <!-- GRID 4 KARTU DOKUMEN -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($jenis_dokumen_arr as $key => $info):
                            $uploaded = isset($doc_uploaded[$key]) ? $doc_uploaded[$key] : null;
                        ?>
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col justify-between">
                                <div>
                                    <!-- Header Kartu -->
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 text-xs font-bold flex items-center justify-center border border-indigo-200 dark:border-indigo-800"><?= $info['no']; ?></span>
                                            <h4 class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-white"><?= $info['title']; ?></h4>
                                        </div>
                                        <span class="text-[11px] text-gray-400 font-medium px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded-md">Max 1 MB</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4"><?= $info['desc']; ?></p>

                                    <!-- Box Konten File / Upload -->
                                    <?php if ($uploaded): ?>
                                        <!-- JIKA SUDAH DIUNGGAH -->
                                        <div class="border border-dashed border-gray-300 dark:border-gray-600 p-4 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/30">
                                            <div class="flex items-center gap-3 w-full sm:w-auto overflow-hidden">
                                                <?php
                                                $ext = pathinfo($uploaded->nama_file, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                                                ?>

                                                <?php if ($isImage): ?>
                                                    <div class="w-12 h-12 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white flex-shrink-0 flex items-center justify-center">
                                                        <img src="<?= base_url('uploads/dokumen/' . $uploaded->nama_file); ?>" alt="Preview" class="w-full h-full object-cover">
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-12 h-12 rounded-lg bg-rose-50 text-rose-600 flex-shrink-0 flex items-center justify-center">
                                                        <i class="fa-solid fa-file-pdf text-xl"></i>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="truncate">
                                                    <p class="text-xs font-semibold text-gray-800 dark:text-white truncate max-w-[150px] sm:max-w-[180px]"><?= $uploaded->nama_file; ?></p>
                                                    <p class="text-[10px] text-gray-400"><?= $uploaded->ukuran_file ?? 'Tersimpan'; ?></p>
                                                </div>
                                            </div>

                                            <!-- Tombol Aksi (Lihat, Unduh, Hapus) -->
                                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                                <a href="<?= base_url('uploads/dokumen/' . $uploaded->nama_file); ?>" target="_blank" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-xs font-medium flex items-center gap-1 transition">
                                                    <i class="fa-solid fa-eye"></i> Lihat
                                                </a>
                                                <a href="<?= base_url('uploads/dokumen/' . $uploaded->nama_file); ?>" download class="px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg text-xs font-medium flex items-center gap-1 transition">
                                                    <i class="fa-solid fa-download"></i> Unduh
                                                </a>

                                                <!-- Tombol Hapus hanya untuk Admin/Staff -->
                                                <?php if (!$is_wali_kelas): ?>
                                                    <a href="<?= site_url('siswa/hapus_dokumen/' . $uploaded->id . '/' . $siswa->id); ?>" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Dokumen">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- JIKA BELUM DIUNGGAH -->
                                        <?php if (!$is_wali_kelas): ?>
                                            <!-- Kotak Unggah untuk Admin/Staff -->
                                            <label class="border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 p-4 rounded-xl flex flex-col items-center justify-center cursor-pointer bg-gray-50/50 dark:bg-gray-900/30 transition group">
                                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full mb-1 group-hover:scale-110 transition">
                                                    <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                                                </div>
                                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Pilih file <?= $info['title']; ?></span>
                                                <span class="text-[10px] text-gray-400 mt-0.5">Format PDF / JPG (Maks. 1MB)</span>
                                                <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="uploadDokumenAjax(this, '<?= $key; ?>', '<?= $siswa->id; ?>')">
                                            </label>
                                        <?php else: ?>
                                            <!-- Informasi Kosong untuk Wali Kelas -->
                                            <div class="border border-dashed border-gray-200 dark:border-gray-700 p-4 rounded-xl flex items-center justify-center bg-gray-50/30 dark:bg-gray-900/20 text-gray-400 text-xs italic">
                                                Dokumen belum diunggah.
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

                <!-- SCRIPT AJAX DENGAN TOAST NOTIFICATION -->
                <script>
                    function uploadDokumenAjax(input, jenisDokumen, siswaId) {
                        if (input.files && input.files[0]) {
                            let file = input.files[0];

                            // Cek ukuran file di sisi klien (Maksimal 1 MB = 1048576 bytes)
                            if (file.size > 1048576) {
                                // Tampilkan pesan menggunakan toast error Anda atau alert kustom yang rapi
                                showCustomToast('Ukuran file terlalu besar! Maksimal 1 MB.', 'error');
                                input.value = '';
                                return;
                            }

                            let formData = new FormData();
                            formData.append('berkas_file', file);
                            formData.append('jenis_dokumen', jenisDokumen);

                            let url = "<?= site_url('siswa/upload_dokumen/'); ?>" + siswaId;

                            // Kirim via Fetch API tanpa mengganggu form utama halaman
                            fetch(url, {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => {
                                    location.reload();
                                })
                                .catch(error => {
                                    showCustomToast('Terjadi kesalahan saat mengunggah dokumen.', 'error');
                                    console.error(error);
                                });
                        }
                    }

                    // Fungsi opsional untuk memicu toast kustom jika diperlukan di sisi client
                    function showCustomToast(message, type) {
                        // Anda bisa memanfaatkan fungsi Alpine.js atau membuat elemen toast sementara di sini
                        alert(message); // Fallback atau sesuaikan dengan fungsi toast Alpine Anda
                    }
                </script>


                <!-- Lulus -->
                <!-- Tab Tamat Belajar / Lulus -->

                <div x-show="activeTab === 'lulus'" class="space-y-6" style="display: none;">

                    <!-- HEADER INFORMASI -->
                    <div class="bg-emerald-50 dark:bg-emerald-950/40 p-5 rounded-2xl border border-emerald-100 dark:border-emerald-900 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-emerald-600 text-white rounded-xl shadow-md">
                                <i class="fa-solid fa-graduation-cap text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Informasi Tamat Belajar & Kelulusan</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Data nomor ijazah, dokumen ijazah SMK, serta penelusuran tamatan (tracer study).</p>
                            </div>
                        </div>
                    </div>

                    <!-- GRID 2 KOLOM FORM -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- KOLOM 1: DATA IJAZAH & UPLOAD BERKAS -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm space-y-4">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-certificate"></i> 1. Data Ijazah
                            </h4>

                            <!-- Nomor Ijazah -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Ijazah</label>
                                <input type="text" name="nomor_ijazah" value="<?= $siswa->nomor_ijazah ?? ''; ?>" placeholder="Contoh: DN-01/M-SMK/03/2026" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- Tanggal Ijazah -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Ijazah</label>
                                <input type="date" name="tanggal_ijazah" value="<?= $siswa->tanggal_ijazah ?? ''; ?>" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- Upload Dokumen Ijazah SMK -->
                            <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5 flex items-center justify-between">
                                    <span>Scan Dokumen Ijazah SMK</span>
                                    <span class="text-[10px] text-gray-400 font-normal">Format PDF/JPG (Maks. 1MB)</span>
                                </label>

                                <?php
                                $ijazah_uploaded = null;
                                if (!empty($dokumen_list)) {
                                    foreach ($dokumen_list as $d) {
                                        if (trim($d->jenis_dokumen) == 'ijazah_smk') {
                                            $ijazah_uploaded = $d;
                                            break;
                                        }
                                    }
                                }
                                ?>

                                <?php if ($ijazah_uploaded): ?>
                                    <div class="border border-dashed border-gray-300 dark:border-gray-600 p-3 rounded-xl flex items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/30">
                                        <div class="flex items-center gap-2.5 overflow-hidden">
                                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex-shrink-0 flex items-center justify-center">
                                                <i class="fa-solid fa-file-pdf text-lg"></i>
                                            </div>
                                            <div class="truncate">
                                                <p class="text-xs font-semibold text-gray-800 dark:text-white truncate max-w-[140px]"><?= $ijazah_uploaded->nama_file; ?></p>
                                                <p class="text-[10px] text-gray-400"><?= $ijazah_uploaded->ukuran_file ?? 'Tersimpan'; ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <a href="<?= base_url('uploads/dokumen/' . $ijazah_uploaded->nama_file); ?>" target="_blank" class="px-2.5 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-xs font-medium flex items-center gap-1 transition">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('siswa/hapus_dokumen/' . $ijazah_uploaded->id . '/' . $siswa->id); ?>" onclick="return confirm('Yakin ingin menghapus ijazah ini?')" class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <label class="border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 p-3 rounded-xl flex items-center justify-center cursor-pointer bg-gray-50/50 dark:bg-gray-900/30 transition group">
                                        <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                            <i class="fa-solid fa-cloud-arrow-up text-indigo-600 dark:text-indigo-400 text-base"></i>
                                            <span class="text-xs font-medium">Pilih berkas Ijazah SMK</span>
                                        </div>
                                        <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="uploadDokumenAjax(this, 'ijazah_smk', '<?= $siswa->id; ?>')">
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- KOLOM 2: PENELUSURAN TAMATAN (TRACER STUDY) -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm space-y-4">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-briefcase"></i> 2. Penelusuran Tamatan (Tracer Study)
                            </h4>

                            <!-- 1. Melanjutkan ke -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">1. Melanjutkan ke (Kuliah/Instansi)</label>
                                <input type="text" name="melanjutkan_ke" value="<?= $siswa->melanjutkan_ke ?? ''; ?>" placeholder="Contoh: Universitas / Instansi (Jika Kuliah)" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- 2. Bekerja di -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">2. Bekerja di</label>
                                <input type="text" name="bekerja_di" value="<?= $siswa->bekerja_di ?? ''; ?>" placeholder="Contoh: Indomaret / PT. Sumber Makmur" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- 3. Tanggal Mulai Bekerja -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">3. Tanggal Mulai Bekerja</label>
                                <input type="date" name="tanggal_mulai_bekerja" value="<?= $siswa->tanggal_mulai_bekerja ?? ''; ?>" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- 4. Nama Perusahaan / Lembaga -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">4. Nama Perusahaan / Lembaga</label>
                                <input type="text" name="nama_perusahaan" value="<?= $siswa->nama_perusahaan ?? ''; ?>" placeholder="Contoh: PT. Sumber Makmur" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- 5. Penghasilan -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">5. Penghasilan / Gaji</label>
                                <select name="penghasilan_lulus" class="w-full text-xs rounded-xl border border-gray-300 dark:border-gray-600 px-3 py-2.5 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="">-- Pilih Kisaran Penghasilan --</option>
                                    <option value="Kurang dari Rp 1.000.000" <?= (isset($siswa->penghasilan_lulus) && $siswa->penghasilan_lulus == 'Kurang dari Rp 1.000.000') ? 'selected' : ''; ?>>Kurang dari Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 3.000.000" <?= (isset($siswa->penghasilan_lulus) && $siswa->penghasilan_lulus == 'Rp 1.000.000 - Rp 3.000.000') ? 'selected' : ''; ?>>Rp 1.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" <?= (isset($siswa->penghasilan_lulus) && $siswa->penghasilan_lulus == 'Rp 3.000.000 - Rp 5.000.000') ? 'selected' : ''; ?>>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="Lebih dari Rp 5.000.000" <?= (isset($siswa->penghasilan_lulus) && $siswa->penghasilan_lulus == 'Lebih dari Rp 5.000.000') ? 'selected' : ''; ?>>Lebih dari Rp 5.000.000</option>
                                </select>
                            </div>

                        </div>

                    </div>

                </div>

            </div> <!-- Tutup div isi konten tab -->
        </div> <!-- Tutup div navigasi tab card -->

        <!-- TOMBOL SIMPAN GLOBAL (Berada di DALAM tag form utama) -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                <?= $is_wali_kelas ? 'Mode Akses: Wali Kelas (Hanya Lihat Data)' : 'Pastikan data di semua tab sudah benar sebelum menekan tombol simpan.'; ?>
            </p>

            <?php if (!$is_wali_kelas): ?>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Perubahan
                </button>
            <?php endif; ?>
        </div>

    </form> <!-- SATU TAG PENUTUP FORM UTAMA DI SINI -->

</div> <!-- Tutup div x-data utama -->

<!-- Panggil Modal Pendukung -->
<?php $this->load->view('siswa/modals/modal_prestasi'); ?>
<?php $this->load->view('siswa/modals/modal_beasiswa'); ?>
<?php $this->load->view('siswa/modals/modal_kesejahteraan'); ?>
<?php $this->load->view('siswa/modals/modal_registrasi_masuk'); ?>
<?php $this->load->view('siswa/modals/modal_registrasi_keluar'); ?>