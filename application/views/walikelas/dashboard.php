<div class="p-6 space-y-6">
    <!-- Header Banner Wali Kelas -->
    <div class="bg-[#1b2a47] rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Panel Khusus Wali Kelas</span>
            <h1 class="text-2xl font-bold mt-1">
                Kelas: <?= $rombel->nama_rombel ?? $rombel->nama_kelas ?? 'Belum Diatur'; ?>
            </h1>
            <p class="text-xs text-gray-300 mt-1">
                Selamat datang, <strong><?= $this->session->userdata('nama'); ?></strong>. Anda mengelola data peserta didik untuk rombongan belajar ini.
            </p>
        </div>
        <div class="bg-[#0f1c30] px-4 py-3 rounded-xl border border-gray-700 text-center">
            <span class="block text-xs text-gray-400">Total Siswa Binaan</span>
            <span class="text-2xl font-bold text-amber-400"><?= $total_siswa; ?></span>
        </div>
    </div>

    <!-- Tabel Daftar Siswa di Rombel Ini -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="font-bold text-gray-800 dark:text-white text-sm">Daftar Peserta Didik Kelas <?= $rombel->nama_rombel ?? ''; ?></h2>
        </div>

        <div class="overflow-x-auto p-4">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase">
                        <th class="py-3 px-4 rounded-tl-lg">No</th>
                        <th class="py-3 px-4">NIS / NISN</th>
                        <th class="py-3 px-4">Nama Lengkap Siswa</th>
                        <th class="py-3 px-4">L/P</th>
                        <th class="py-3 px-4 rounded-tr-lg">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if (!empty($siswa)): $no = 1;
                        foreach ($siswa as $s): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-3 px-4"><?= $no++; ?></td>
                                <td class="py-3 px-4 font-mono"><?= $s->nis ?? '-'; ?> / <?= $s->nisn ?? '-'; ?></td>
                                <td class="py-3 px-4 font-semibold text-gray-800 dark:text-white"><?= $s->nama_siswa ?? $s->nama; ?></td>
                                <td class="py-3 px-4"><?= $s->jenis_kelamin ?? '-'; ?></td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-semibold">Aktif</span>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500">Belum ada data siswa yang terdaftar di rombel ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>