<?php $is_wali = ($this->session->userdata('role') === 'wali_kelas'); ?>

<style>
    /* Pastikan scroll vertikal tetap aktif di halaman dashboard tanpa mengubah header/footer */
    html,
    body {
        overflow-y: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    main,
    [class*="overflow-hidden"] {
        overflow-y: auto !important;
    }

    /* Kembalikan scroll horizontal tabel agar tetap rapi di dalam wrapper tabel */
    .table-scroll-x {
        overflow-x: auto !important;
    }
</style>

<div class="p-6 space-y-5">
    <!-- BANNER HEADER UTAMA -->
    <div class="bg-[#0f1c30] dark:bg-gray-800 rounded-2xl p-6 text-white shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-gray-100 dark:border-gray-700">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                <span>Beranda</span>
                <span>/</span>
                <span class="text-blue-400">Dashboard</span>
            </div>
            <h1 class="text-xl font-bold text-white flex items-center gap-2">
                <?php if ($is_wali): ?>
                    Dashboard Wali Kelas (<?= html_escape($info_kelas ?? 'Bimbingan'); ?>)
                <?php else: ?>
                    Dashboard Utama DATASKA
                <?php endif; ?>
            </h1>
            <p class="text-xs text-gray-400 mt-1">
                Selamat datang, <span class="text-gray-200 font-semibold"><?= html_escape($this->session->userdata('nama')); ?></span>.
                <?php if ($is_wali): ?>
                    Kelola dan pantau data peserta didik untuk rombongan belajar ini.
                <?php else: ?>
                    Pantau informasi statistik dan rekapitulasi data sekolah secara terintegrasi.
                <?php endif; ?>
            </p>
        </div>

        <div>
            <span class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold shadow-sm transition">
                <i class="fa-solid fa-calendar-days"></i> Tahun Ajaran Aktif
            </span>
        </div>
    </div>

    <?php if ($is_wali): ?>
        <!-- KARTU STATISTIK WALI KELAS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-100 mb-1">Jumlah Peserta Didik</p>
                    <h3 class="text-3xl font-extrabold"><?= number_format($total_siswa ?? 0); ?> <span class="text-sm font-normal text-emerald-100">Siswa</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-100 mb-1">Siswa Laki-laki</p>
                    <h3 class="text-3xl font-extrabold"><?= number_format($siswa_l ?? 0); ?> <span class="text-sm font-normal text-blue-100">Orang</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-mars"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-pink-100 mb-1">Siswa Perempuan</p>
                    <h3 class="text-3xl font-extrabold"><?= number_format($siswa_p ?? 0); ?> <span class="text-sm font-normal text-pink-100">Orang</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-venus"></i>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- 4 KELOMPOK STATISTIK ADMINISTRATOR -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            <!-- KELOMPOK 1: SISWA -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        1. Siswa
                    </h2>
                    <span class="text-[11px] text-gray-400">Peserta Didik</span>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-emerald-100">Jumlah Siswa</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($total_siswa ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-users text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-blue-500 to-indigo-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-100">Laki-laki</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($siswa_l ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-mars text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-pink-100">Perempuan</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($siswa_p ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-venus text-base opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- KELOMPOK 2: PTK -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        2. PTK
                    </h2>
                    <span class="text-[11px] text-gray-400">Pendidik</span>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-gradient-to-br from-cyan-500 to-teal-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-cyan-100">Jumlah PTK</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($jumlah_ptk ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-chalkboard-user text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-sky-500 to-blue-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-sky-100">Laki-laki</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($ptk_l ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-person text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-fuchsia-500 to-purple-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-fuchsia-100">Perempuan</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($ptk_p ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-person-dress text-base opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- KELOMPOK 3: TENDIK -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        3. Tendik
                    </h2>
                    <span class="text-[11px] text-gray-400">Tenaga Kependidikan</span>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-100">Jumlah Tendik</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($jumlah_tendik ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-user-tie text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-orange-500 to-red-600 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-orange-100">Laki-laki</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($tendik_l ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-user text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-lime-600 to-emerald-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-lime-100">Perempuan</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($tendik_p ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-user-check text-base opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- KELOMPOK 4: ROMBEL & TOTAL PTK + TENDIK -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                        4. Rombel &amp; Total PTK + Tendik
                    </h2>
                    <span class="text-[11px] text-gray-400">Ringkasan</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-violet-500 to-purple-700 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-violet-100">Jumlah Rombel</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($jumlah_rombel ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-chalkboard text-base opacity-80"></i>
                    </div>

                    <div class="bg-gradient-to-br from-slate-700 to-gray-900 text-white rounded-xl p-3.5 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-300">Total PTK &amp; Tendik</p>
                            <h3 class="text-xl font-extrabold mt-0.5"><?= number_format($total_ptk_tendik ?? 0); ?></h3>
                        </div>
                        <i class="fa-solid fa-users-gear text-base opacity-80"></i>
                    </div>
                </div>
            </div>

        </div>

        <?php
        $nama_sekolah = $sekolah->nama_sekolah ?? ($sekolah->nama ?? 'SMKS PGRI PESANGGARAN');
        $npsn         = $sekolah->npsn ?? '-';
        $bentuk       = $sekolah->bentuk_pendidikan ?? ($sekolah->jenjang ?? 'SMK');
        $status_skl   = $sekolah->status_sekolah ?? ($sekolah->status ?? 'Swasta');
        $kecamatan    = $sekolah->kecamatan ?? '-';
        $kabupaten    = $sekolah->kabupaten ?? '-';
        $provinsi     = $sekolah->provinsi ?? '-';
        $kepsek       = $sekolah->kepala_sekolah ?? ($sekolah->kepsek ?? 'Umi Qowiyah');
        $operator     = $sekolah->operator ?? ($this->session->userdata('nama') ?? '-');
        $username_skl = $sekolah->username ?? ($sekolah->email ?? '-');
        $kurikulum    = $sekolah->kurikulum ?? ($sekolah->implementasi_kurikulum ?? 'Merdeka');
        $status_bosp  = $sekolah->status_bosp ?? 'Bersedia Menerima BOSP';
        $bendahara    = $sekolah->bendahara_bosp ?? ($sekolah->bendahara ?? '-');
        ?>

        <!-- PROFIL SEKOLAH (KIRI) & JUMLAH PESERTA DIDIK PER ROMBEL (KANAN) -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-4 items-start">
            <!-- Kiri: Identitas Satuan Pendidikan (7 kolom) -->
            <div class="xl:col-span-7 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="px-5 py-3.5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-gray-500"></i>
                            <?= html_escape($nama_sekolah); ?>
                        </h3>
                        <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">NPSN: <?= html_escape($npsn); ?></span>
                    </div>

                    <div class="p-5 grid grid-cols-1 md:grid-cols-12 gap-5 items-center">
                        <div class="md:col-span-7 space-y-2 text-xs">
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Bentuk Pendidikan:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($bentuk); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($status_skl); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Kecamatan:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($kecamatan); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Kabupaten:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($kabupaten); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Provinsi:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($provinsi); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Kepala Sekolah:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($kepsek); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Operator:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($operator); ?></span>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                <span class="col-span-5 text-gray-500 dark:text-gray-400">Username:</span>
                                <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200 break-all"><?= html_escape($username_skl); ?></span>
                            </div>

                            <div class="pt-2 mt-2 border-t border-gray-100 dark:border-gray-700 space-y-2">
                                <div class="grid grid-cols-12 gap-2">
                                    <span class="col-span-5 text-gray-500 dark:text-gray-400">Implementasi Kurikulum:</span>
                                    <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($kurikulum); ?></span>
                                </div>
                                <div class="grid grid-cols-12 gap-2">
                                    <span class="col-span-5 text-gray-500 dark:text-gray-400">Status BOSP:</span>
                                    <span class="col-span-7 font-semibold text-emerald-600 dark:text-emerald-400"><?= html_escape($status_bosp); ?></span>
                                </div>
                                <div class="grid grid-cols-12 gap-2">
                                    <span class="col-span-5 text-gray-500 dark:text-gray-400">Bendahara BOSP:</span>
                                    <span class="col-span-7 font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($bendahara); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-5">
                            <div class="rounded-xl bg-gradient-to-br from-[#0f1c30] via-[#162a4a] to-sky-700 text-white p-6 flex flex-col items-center justify-center text-center min-h-[240px] shadow-inner">
                                <div class="w-12 h-12 rounded-xl bg-amber-400 text-[#0f1c30] flex items-center justify-center text-xl font-extrabold mb-3 shadow">
                                    <i class="fa-solid fa-database"></i>
                                </div>
                                <p class="text-sm font-extrabold tracking-wide leading-snug uppercase">
                                    Satu Data<br>Pendidikan<br>Indonesia
                                </p>
                                <span class="mt-2 text-[11px] text-sky-200">DATASKA &bull; SMK GRISA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-5 py-3 bg-gray-50 dark:bg-gray-900/40 border-t border-gray-100 dark:border-gray-700 rounded-b-xl flex flex-wrap justify-end gap-2">
                    <a href="<?= site_url('sekolah'); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-600 hover:bg-slate-700 text-white text-xs font-medium transition">
                        <i class="fa-solid fa-circle-question"></i> Profil &amp; Data Sekolah
                    </a>
                    <a href="<?= site_url('rombel'); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-medium transition">
                        <i class="fa-solid fa-circle-info"></i> Info Rombel
                    </a>
                </div>
            </div>

            <!-- Kanan: Jumlah Peserta Didik per Rombel (5 kolom) -->
            <div class="xl:col-span-5 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-4 py-3.5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-users text-gray-500"></i>
                        Jumlah Peserta Didik per Rombel
                    </h3>
                    <span class="text-xs text-gray-400"><?= count($rekap_rombel ?? []); ?> Rombel</span>
                </div>

                <div class="table-scroll-x max-h-[420px] overflow-y-auto">
                    <table class="w-full text-[11px] text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-600 dark:text-gray-300 font-semibold sticky top-0 z-10 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="py-2 px-2 w-8">No</th>
                                <th class="py-2 px-2 whitespace-nowrap">Nama Rombel</th>
                                <th class="py-2 px-1.5 text-center">L</th>
                                <th class="py-2 px-1.5 text-center">P</th>
                                <th class="py-2 px-1.5 text-center">Jml</th>
                                <th class="py-2 px-1.5 text-center">Lulus</th>
                                <th class="py-2 px-1.5 text-center">Mutasi</th>
                                <th class="py-2 px-1.5 text-center">Keluar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/70 text-gray-700 dark:text-gray-200">
                            <?php if (!empty($rekap_rombel)): ?>
                                <?php
                                $no = 1;
                                $sum_l = $sum_p = $sum_jml = $sum_lulus = $sum_mutasi = $sum_keluar = 0;
                                foreach ($rekap_rombel as $r):
                                    $l      = (int) ($r->jml_l ?? 0);
                                    $p      = (int) ($r->jml_p ?? 0);
                                    $jml    = (int) ($r->jml_aktif ?? 0);
                                    $lulus  = (int) ($r->jml_lulus ?? 0);
                                    $mutasi = (int) ($r->jml_mutasi ?? 0);
                                    $keluar = (int) ($r->jml_keluar ?? 0);

                                    $sum_l      += $l;
                                    $sum_p      += $p;
                                    $sum_jml    += $jml;
                                    $sum_lulus  += $lulus;
                                    $sum_mutasi += $mutasi;
                                    $sum_keluar += $keluar;
                                ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                        <td class="py-2 px-2 text-gray-500"><?= $no++; ?></td>
                                        <td class="py-2 px-2 font-semibold text-gray-800 dark:text-white whitespace-nowrap"><?= html_escape($r->nama_rombel ?? '-'); ?></td>
                                        <td class="py-2 px-1.5 text-center"><?= number_format($l); ?></td>
                                        <td class="py-2 px-1.5 text-center"><?= number_format($p); ?></td>
                                        <td class="py-2 px-1.5 text-center font-bold text-gray-900 dark:text-white"><?= number_format($jml); ?></td>
                                        <td class="py-2 px-1.5 text-center"><?= number_format($lulus); ?></td>
                                        <td class="py-2 px-1.5 text-center"><?= number_format($mutasi); ?></td>
                                        <td class="py-2 px-1.5 text-center"><?= number_format($keluar); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="bg-gray-100 dark:bg-gray-900 font-bold text-gray-900 dark:text-white border-t-2 border-gray-200 dark:border-gray-700">
                                    <td class="py-2.5 px-2 whitespace-nowrap" colspan="2">Total Keseluruhan</td>
                                    <td class="py-2.5 px-1.5 text-center"><?= number_format($sum_l); ?></td>
                                    <td class="py-2.5 px-1.5 text-center"><?= number_format($sum_p); ?></td>
                                    <td class="py-2.5 px-1.5 text-center"><?= number_format($sum_jml); ?></td>
                                    <td class="py-2.5 px-1.5 text-center"><?= number_format($sum_lulus); ?></td>
                                    <td class="py-2.5 px-1.5 text-center"><?= number_format($sum_mutasi); ?></td>
                                    <td class="py-2.5 px-1.5 text-center"><?= number_format($sum_keluar); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="py-6 px-4 text-center text-gray-400">Belum ada data rombel untuk ditampilkan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>