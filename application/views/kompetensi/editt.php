<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Edit Kompetensi</h2>

        <form action="<?= site_url('kompetensi/update/' . $kompetensi->id) ?>" method="POST" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" value="<?= html_escape($kompetensi->bidang_keahlian ?? ''); ?>" placeholder="Contoh: Teknologi Manufaktur dan Rekayasa" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Program Keahlian</label>
                <input type="text" name="program_keahlian" value="<?= html_escape($kompetensi->program_keahlian ?? ''); ?>" placeholder="Contoh: Teknik Otomotif" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Konsentrasi Keahlian</label>
                <input type="text" name="konsentrasi_keahlian" value="<?= html_escape($kompetensi->konsentrasi_keahlian ?? ''); ?>" placeholder="Contoh: Teknik Alat Berat" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Nama Kompetensi</label>
                <input type="text" name="nama" value="<?= html_escape($kompetensi->nama ?? ''); ?>" required placeholder="Contoh: Manajemen Perkantoran" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Kode Kompetensi</label>
                <input type="text" name="kode" value="<?= html_escape($kompetensi->kode ?? ''); ?>" required placeholder="Contoh: TAB" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Aktif" <?= (($kompetensi->status ?? '') == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="Tidak Aktif" <?= (($kompetensi->status ?? '') == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <a href="<?= site_url('kompetensi') ?>" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-medium">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">Perbarui Data</button>
            </div>
        </form>
    </div>
</main>