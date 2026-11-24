<!-- ========================================== -->
<!-- MODAL TAMBAH & EDIT KESEJAHTERAAN          -->
<!-- ========================================== -->

<!-- Modal Tambah Kesejahteraan -->
<div x-data="{ openModal: false }" @open-modal-kesejahteraan.window="openModal = true" x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
    <div @click.outside="openModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-id-card text-emerald-600"></i> Tambah Kesejahteraan Siswa
            </h4>
            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form action="<?= site_url('siswa/tambah_kesejahteraan/' . $siswa->id); ?>" method="POST" class="space-y-4 text-xs sm:text-sm">
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kesejahteraan</label>
                <select name="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                    <option value="">-- Pilih Jenis Bantuan --</option>
                    <option value="PIP (Program Indonesia Pintar)">PIP (Program Indonesia Pintar)</option>
                    <option value="PKH (Program Keluarga Harapan)">PKH (Program Keluarga Harapan)</option>
                    <option value="KKS (Kartu Keluarga Sejahtera)">KKS (Kartu Keluarga Sejahtera)</option>
                    <option value="BPNT">BPNT</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Kartu</label>
                <input type="text" name="no_kartu" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Masukkan nomor kartu / identitas bantuan">
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama di Kartu</label>
                <input type="text" name="nama_kartu" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nama lengkap sesuai yang tertera di kartu">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">Simpan Kesejahteraan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kesejahteraan -->
<div x-data="{ 
    openEditModal: false, 
    id: '', 
    jenis: '', 
    no_kartu: '', 
    nama_kartu: '' 
}"
    @open-modal-edit-kesejahteraan.window="
    openEditModal = true; 
    id = $event.detail.id; 
    jenis = $event.detail.jenis; 
    no_kartu = $event.detail.no_kartu; 
    nama_kartu = $event.detail.nama_kartu;
"
    x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
    <div @click.outside="openEditModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Kesejahteraan Siswa
            </h4>
            <button type="button" @click="openEditModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form :action="'<?= site_url('siswa/update_kesejahteraan/'); ?>' + id + '/<?= $siswa->id; ?>'" method="POST" class="space-y-4 text-xs sm:text-sm">
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kesejahteraan</label>
                <select name="jenis" x-model="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                    <option value="">-- Pilih Jenis Bantuan --</option>
                    <option value="PIP (Program Indonesia Pintar)">PIP (Program Indonesia Pintar)</option>
                    <option value="PKH (Program Keluarga Harapan)">PKH (Program Keluarga Harapan)</option>
                    <option value="KKS (Kartu Keluarga Sejahtera)">KKS (Kartu Keluarga Sejahtera)</option>

                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Kartu</label>
                <input type="text" name="no_kartu" x-model="no_kartu" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama di Kartu</label>
                <input type="text" name="nama_kartu" x-model="nama_kartu" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>