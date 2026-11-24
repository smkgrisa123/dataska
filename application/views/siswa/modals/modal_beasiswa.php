<!-- ========================================== -->
<!-- MODAL TAMBAH & EDIT BEASISWA               -->
<!-- ========================================== -->

<!-- Modal Tambah Beasiswa -->
<div x-data="{ openModal: false }" @open-modal-beasiswa.window="openModal = true" x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
    <div @click.outside="openModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-graduation-cap text-purple-600"></i> Tambah Beasiswa Siswa
            </h4>
            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form action="<?= site_url('siswa/tambah_beasiswa/' . $siswa->id); ?>" method="POST" class="space-y-4 text-xs sm:text-sm">
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Beasiswa</label>
                <select name="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                    <option value="">-- Pilih Jenis Beasiswa --</option>
                    <option value="Beasiswa Prestasi">Beasiswa Prestasi</option>
                    <option value="Beasiswa Miskin / PIP">Beasiswa Miskin / PIP</option>
                    <option value="Beasiswa Unggulan">Beasiswa Unggulan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Contoh: Sumber dana dari Pemerintah / Yayasan"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Mulai</label>
                    <input type="number" name="tahun_mulai" value="<?= date('Y'); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="2025">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Selesai</label>
                    <input type="number" name="tahun_selesai" value="<?= date('Y') + 1; ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="2026">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">Simpan Beasiswa</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Beasiswa -->
<div x-data="{ 
    openEditModal: false, 
    id: '', 
    jenis: '', 
    keterangan: '', 
    tahun_mulai: '', 
    tahun_selesai: '' 
}"
    @open-modal-edit-beasiswa.window="
    openEditModal = true; 
    id = $event.detail.id; 
    jenis = $event.detail.jenis; 
    keterangan = $event.detail.keterangan; 
    tahun_mulai = $event.detail.tahun_mulai; 
    tahun_selesai = $event.detail.tahun_selesai;
"
    x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
    <div @click.outside="openEditModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Beasiswa Siswa
            </h4>
            <button type="button" @click="openEditModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form :action="'<?= site_url('siswa/update_beasiswa/'); ?>' + id + '/<?= $siswa->id; ?>'" method="POST" class="space-y-4 text-xs sm:text-sm">
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Beasiswa</label>
                <select name="jenis" x-model="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                    <option value="">-- Pilih Jenis Beasiswa --</option>
                    <option value="Beasiswa Prestasi">Beasiswa Prestasi</option>
                    <option value="Beasiswa Miskin / PIP">Beasiswa Miskin / PIP</option>
                    <option value="Beasiswa Unggulan">Beasiswa Unggulan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                <textarea name="keterangan" x-model="keterangan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Mulai</label>
                    <input type="number" name="tahun_mulai" x-model="tahun_mulai" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Selesai</label>
                    <input type="number" name="tahun_selesai" x-model="tahun_selesai" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>