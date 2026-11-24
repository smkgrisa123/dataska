<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6">
    <div class="max-w-7xl mx-auto space-y-6 pb-24">

        <!-- HEADER BANNER -->
        <div class="bg-gray-900 text-white p-6 md:p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <nav class="text-xs text-gray-400 mb-1 flex items-center space-x-2">
                    <span>Beranda</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span>Peserta Didik</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-white font-medium">Siswa Keluar / Lulus</span>
                </nav>
                <h1 class="text-xl md:text-2xl font-bold tracking-tight text-white mt-1">Siswa Keluar / Lulus</h1>
                <p class="text-xs sm:text-sm text-gray-400 mt-1">Pantau dan kelola data siswa yang telah menyelesaikan masa studi.</p>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Card Total Lulus -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total PD Lulus</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1"><?= count($siswa_lulus ?? []); ?></h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card Jumlah Laki-laki -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Laki-laki</p>
                    <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                        <?= count(array_filter($siswa_lulus ?? [], function ($row) {
                            return $row->jk == 'L';
                        })); ?>
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                    L
                </div>
            </div>

            <!-- Card Jumlah Perempuan -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Perempuan</p>
                    <h3 class="text-xl font-bold text-pink-600 dark:text-pink-400 mt-1">
                        <?= count(array_filter($siswa_lulus ?? [], function ($row) {
                            return $row->jk == 'P';
                        })); ?>
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-pink-50 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center font-bold">
                    P
                </div>
            </div>
        </div>

        <!-- FILTER TAHUN AJARAN -->
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm space-y-3">
            <form method="GET" action="" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-300">Tahun Ajaran:</span>
                    <select name="tahun" onchange="this.form.submit()" class="px-3 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-blue-500 text-gray-800 dark:text-gray-200">
                        <option value="">Semua Tahun Ajaran</option>
                        <?php if (!empty($list_tahun_ajaran)): ?>
                            <?php foreach ($list_tahun_ajaran as $t): ?>
                                <option value="<?= $t->nama; ?>" <?= (isset($_GET['tahun']) && $_GET['tahun'] == $t->nama) ? 'selected' : ''; ?>>
                                    <?= $t->nama; ?> (<?= $t->semester; ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- <div>
                    <a href="<?= site_url('siswa/lulus'); ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs sm:text-sm font-medium rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filter
                    </a>
                </div> -->
            </form>
        </div>

        <!-- TABLE SECTION DENGAN DATATABLES -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-white text-sm">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Daftar Siswa Lulus
                </div>
            </div>

            <!-- Tabel dengan ID tabelLulus agar terhubung ke DataTables -->
            <table id="tabelLulus" class="w-full text-left border-collapse text-xs sm:text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/75 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3.5 px-4">NISN / NIS</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4 text-center">L/P</th>
                        <th class="py-3.5 px-4">Histori Rombel Terakhir</th>
                        <th class="py-3.5 px-4 text-center">Tahun Lulus</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                    <?php if (!empty($siswa_lulus)): ?>
                        <?php foreach ($siswa_lulus as $row): ?>
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-900 dark:text-white"><?= !empty($row->nisn) ? $row->nisn : '-'; ?></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?= !empty($row->no_induk) ? $row->no_induk : '-'; ?></div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 font-bold flex items-center justify-center text-xs">
                                            <?= strtoupper(substr($row->nama, 0, 1)); ?>
                                        </div>
                                        <span class="font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($row->nama); ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-2 py-0.5 text-xs rounded font-medium <?= ($row->jk == 'L') ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-pink-100 text-pink-800 dark:bg-pink-900/40 dark:text-pink-300'; ?>">
                                        <?= $row->jk; ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-gray-600 dark:text-gray-400">
                                    <?= !empty($row->history_rombel) ? htmlspecialchars($row->history_rombel) : '-'; ?>
                                </td>
                                <td class="py-4 px-4 text-center font-semibold text-primary-600 dark:text-primary-400">
                                    <?= !empty($row->tahun_lulus) ? $row->tahun_lulus : '-'; ?>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-emerald-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Lulus
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center space-x-1">
                                        <a href="<?= site_url('siswa/detail/' . $row->id); ?>" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg transition" title="Detail Siswa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="<?= site_url('siswa/print_lulus/' . $row->id); ?>" target="_blank" class="p-1.5 bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-lg transition" title="Print Data Kelulusan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                        <a href="<?= site_url('siswa/preview_ijazah/' . $row->id); ?>" target="_blank" class="p-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-900/30 dark:text-amber-400 rounded-lg transition" title="Preview Ijazah">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        <a href="<?= site_url('siswa/batalkan_kelulusan/' . $row->id); ?>" onclick="return confirm('Apakah Anda yakin ingin membatalkan status kelulusan siswa ini?')" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded-lg transition" title="Batalkan Kelulusan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<!-- Load Library DataTables Tailwind -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelLulus').DataTable({
            "scrollX": true, // Mengaktifkan scroll horizontal otomatis jika kolom banyak
            "scrollY": "400px", // Membatasi tinggi tabel vertikal sehingga bilah scroll kanan otomatis muncul jika data banyak
            "scrollCollapse": true, // Menyesuaikan tinggi secara dinamis jika data sedikit
            "autoWidth": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data siswa lulus tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>