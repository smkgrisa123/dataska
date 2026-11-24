<!-- ========================================== -->
<!-- MODAL TAMBAH & EDIT PRESTASI               -->
<!-- ========================================== -->

<!-- Modal Tambah Prestasi -->
<div x-data="{ openModal: false }" @open-modal-prestasi.window="openModal = true" x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
    <div @click.outside="openModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-trophy text-yellow-500"></i> Tambah Prestasi Siswa
            </h4>
            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form action="<?= site_url('siswa/tambah_prestasi/' . $siswa->id); ?>" method="POST" class="space-y-4 text-xs sm:text-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Prestasi</label>
                    <select name="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Sains">Sains</option>
                        <option value="Seni">Seni</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tingkat</label>
                    <select name="tingkat" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="Sekolah">Sekolah</option>
                        <option value="Kecamatan">Kecamatan</option>
                        <option value="Kabupaten">Kabupaten</option>
                        <option value="Provinsi">Provinsi</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Contoh: Olimpiade Matematika">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                    <input type="number" name="tahun" value="<?= date('Y'); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penyelenggara</label>
                    <input type="text" name="penyelenggara" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Penyelenggara">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Peringkat</label>
                    <input type="text" name="peringkat" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Contoh: Juara 1">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium">Simpan Prestasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Prestasi -->
<div x-data="{ 
    openEditModal: false, 
    id: '', 
    jenis: '', 
    tingkat: '', 
    nama_prestasi: '', 
    tahun: '', 
    penyelenggara: '', 
    peringkat: '' 
}"
    @open-modal-edit-prestasi.window="
    openEditModal = true; 
    id = $event.detail.id; 
    jenis = $event.detail.jenis; 
    tingkat = $event.detail.tingkat; 
    nama_prestasi = $event.detail.nama_prestasi; 
    tahun = $event.detail.tahun; 
    penyelenggara = $event.detail.penyelenggara; 
    peringkat = $event.detail.peringkat;
"
    x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
    <div @click.outside="openEditModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Prestasi Siswa
            </h4>
            <button type="button" @click="openEditModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form :action="'<?= site_url('siswa/update_prestasi/'); ?>' + id + '/<?= $siswa->id; ?>'" method="POST" class="space-y-4 text-xs sm:text-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Prestasi</label>
                    <select name="jenis" x-model="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Sains">Sains</option>
                        <option value="Seni">Seni</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tingkat</label>
                    <select name="tingkat" x-model="tingkat" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="Sekolah">Sekolah</option>
                        <option value="Kecamatan">Kecamatan</option>
                        <option value="Kabupaten">Kabupaten</option>
                        <option value="Provinsi">Provinsi</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" x-model="nama_prestasi" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                    <input type="number" name="tahun" x-model="tahun" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penyelenggara</label>
                    <input type="text" name="penyelenggara" x-model="penyelenggara" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Peringkat</label>
                    <input type="text" name="peringkat" x-model="peringkat" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Contoh: Juara 1">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>