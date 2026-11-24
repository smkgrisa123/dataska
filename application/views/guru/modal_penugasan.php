<!-- MODAL PENUGASAN PTK -->
<div x-show="openModalPenugasan" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <!-- Diperlebar menggunakan max-w-2xl -->
    <div @click.away="openModalPenugasan = false" class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">

        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-[#1b2a47]">
            <h3 class="font-bold text-white text-sm flex items-center gap-2">
                <i class="fa-solid fa-user-shield text-indigo-400"></i> Form Penugasan PTK
            </h3>
            <button @click="openModalPenugasan = false" class="text-gray-300 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body Form -->
        <div class="p-6 overflow-y-auto space-y-4 text-xs">
            <form :action="'<?= site_url('guru/simpan_penugasan/'); ?>' + guruIdPenugasan" method="POST" class="space-y-4" autocomplete="off">

                <!-- KELOMPOK 1: Surat Tugas -->
                <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-700 space-y-3">
                    <span class="font-bold text-indigo-600 dark:text-indigo-400 block text-[11px] uppercase tracking-wider">1. Informasi Surat Tugas</span>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nomor Surat Tugas *</label>
                        <input type="text" name="no_surat_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: 800/123/456.10/2026">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tanggal Surat Tugas *</label>
                            <input type="date" name="tanggal_surat_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">TMT Tugas (Mulai) *</label>
                            <input type="date" name="tmt_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- KELOMPOK 2: Status Keaktifan Sekolah (Diubah jadi Dropdown Induk / Tidak Induk) -->
                <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-700 space-y-2">
                    <span class="font-bold text-indigo-600 dark:text-indigo-400 block text-[11px] uppercase tracking-wider">2. Status Keaktifan Sekolah</span>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Status Sekolah *</label>
                        <select name="status_sekolah" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="Induk">Induk</option>
                            <option value="Tidak Induk">Tidak Induk</option>
                        </select>
                    </div>
                </div>

                <!-- KELOMPOK 3: Tugas Tambahan & Peran -->
                <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-700 space-y-3">
                    <span class="font-bold text-indigo-600 dark:text-indigo-400 block text-[11px] uppercase tracking-wider">3. Tugas Tambahan & Peran</span>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tugas Tambahan</label>
                        <select name="tugas_tambahan_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Tugas Tambahan --</option>
                            <?php if (!empty($tugas_tambahan)): foreach ($tugas_tambahan as $tt): ?>
                                    <option value="<?= $tt->id; ?>"><?= $tt->nama_tugas; ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Peran</label>
                        <select name="peran_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Peran --</option>
                            <?php if (!empty($peran)): foreach ($peran as $p): ?>
                                    <!-- Pastikan kolomnya sesuai, misal $p->nama_peran -->
                                    <option value="<?= $p->id; ?>"><?= $p->nama_peran; ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>

                <!-- KELOMPOK 4: Keluar -->
                <div class="p-3 bg-rose-50/50 dark:bg-rose-900/10 rounded-xl border border-rose-200 dark:border-rose-900/30 space-y-3">
                    <span class="font-bold text-rose-600 dark:text-rose-400 block text-[11px] uppercase tracking-wider">4. Diisi Saat Sudah Keluar (Opsional)</span>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Keluar Karena</label>
                        <select name="keluar_karena" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Alasan Keluar --</option>
                            <option value="Mutasi">Mutasi</option>
                            <option value="Resign / Mengundurkan Diri">Resign / Mengundurkan Diri</option>
                            <option value="Pensiun">Pensiun</option>
                            <option value="Wafat">Wafat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="openModalPenugasan = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm">Simpan Penugasan</button>
                </div>
            </form>
        </div>

    </div>
</div>