<!-- ========================================== -->
<!-- MODAL FORM REGISTRASI KELUAR              -->
<!-- ========================================== -->
<div x-data="{ 
    openModal: false,
    jenis_keluar: '<?= isset($registrasi_keluar) ? $registrasi_keluar->jenis_keluar : 'Mutasi'; ?>',
    tanggal_keluar: '<?= isset($registrasi_keluar) ? $registrasi_keluar->tanggal_keluar : ''; ?>',
    kelas_ditinggalkan: '<?= isset($registrasi_keluar) ? $registrasi_keluar->kelas_ditinggalkan : ''; ?>',
    alasan: '<?= isset($registrasi_keluar) ? $registrasi_keluar->alasan : ''; ?>',
    no_surat: '<?= isset($registrasi_keluar) ? $registrasi_keluar->no_surat : ''; ?>',
    tanggal_surat: '<?= isset($registrasi_keluar) ? $registrasi_keluar->tanggal_surat : ''; ?>',
    nama_sekolah_tujuan: '<?= isset($registrasi_keluar) ? $registrasi_keluar->nama_sekolah_tujuan : ''; ?>',
    npsn_sekolah_tujuan: '<?= isset($registrasi_keluar) ? $registrasi_keluar->npsn_sekolah_tujuan : ''; ?>',
    alamat_sekolah: '<?= isset($registrasi_keluar) ? $registrasi_keluar->alamat_sekolah : ''; ?>'
}"
    @open-modal-reg-keluar.window="openModal = true" x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">

    <div @click.outside="openModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-2xl shadow-xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-right-from-bracket text-red-600"></i> Form Registrasi Keluar Siswa
            </h4>
            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form action="<?= site_url('siswa/simpan_pd_keluar/' . $siswa->id); ?>" method="POST" class="space-y-4 text-xs sm:text-sm">

            <!-- Keluar Karena -->
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keluar Karena <span class="text-red-500">*</span></label>
                <select name="jenis_keluar" x-model="jenis_keluar" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                    <option value="Mutasi">Mutasi</option>
                    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                    <option value="Wafat">Wafat</option>
                    <option value="Hilang">Hilang</option>
                </select>
            </div>

            <!-- INFORMASI UMUM: Kelas Ditinggalkan & Tahun Ajaran Keluar (Muncul di semua jenis keluar) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <!-- Kelas Yang Ditinggalkan (Read-Only) -->
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas Yang Ditinggalkan</label>
                    <input type="text"
                        value="<?= !empty($siswa->nama_kelas) ? $siswa->nama_kelas : 'Belum Ada Rombel'; ?>"
                        readonly
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 cursor-not-allowed outline-none font-medium">

                    <input type="hidden" name="kelas_ditinggalkan" value="<?= isset($siswa->nama_kelas) ? $siswa->nama_kelas : ''; ?>">
                </div>

                <!-- Pilihan Tahun Ajaran Saat Keluar -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tahun Ajaran Keluar <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_ajaran_id"
                        class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-xs sm:text-sm text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="">-- Pilih Tahun Ajaran Keluar --</option>
                        <?php
                        if (!empty($tahun_ajaran)):
                            foreach ($tahun_ajaran as $ta):
                        ?>
                                <option value="<?= $ta->id; ?>">
                                    <?= $ta->nama . ' (' . $ta->semester . ')'; ?>
                                </option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>

            <!-- JIKA MEMILIH MUTASI -->
            <div x-show="jenis_keluar === 'Mutasi'" class="space-y-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-700/50" style="display: none;">
                <h5 class="font-semibold text-amber-800 dark:text-amber-400 text-xs uppercase tracking-wider">Detail Mutasi Sekolah</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Surat <span class="text-red-500" x-show="jenis_keluar === 'Mutasi'">*</span></label>
                        <input type="text" name="no_surat" x-model="no_surat" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nomor Surat" :required="jenis_keluar === 'Mutasi'">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Surat <span class="text-red-500" x-show="jenis_keluar === 'Mutasi'">*</span></label>
                        <input type="date" name="tanggal_surat" x-model="tanggal_surat" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" :required="jenis_keluar === 'Mutasi'">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Sekolah Tujuan <span class="text-red-500" x-show="jenis_keluar === 'Mutasi'">*</span></label>
                        <input type="text" name="nama_sekolah_tujuan" x-model="nama_sekolah_tujuan" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nama Sekolah Tujuan" :required="jenis_keluar === 'Mutasi'">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">NPSN Sekolah Tujuan</label>
                        <input type="text" name="npsn_sekolah_tujuan" x-model="npsn_sekolah_tujuan" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="NPSN Sekolah Tujuan">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Mutasi <span class="text-red-500" x-show="jenis_keluar === 'Mutasi'">*</span></label>
                        <input type="text" name="alasan" x-model="alasan" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Alasan Mutasi" :required="jenis_keluar === 'Mutasi'">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Sekolah <span class="text-red-500" x-show="jenis_keluar === 'Mutasi'">*</span></label>
                        <textarea name="alamat_sekolah" x-model="alamat_sekolah" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Alamat lengkap sekolah tujuan" :required="jenis_keluar === 'Mutasi'"></textarea>
                    </div>
                </div>
            </div>

            <!-- JIKA MEMILIH MENGUNDURKAN DIRI / WAFAT / HILANG -->
            <div x-show="jenis_keluar !== 'Mutasi'" class="space-y-4 p-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl border border-gray-200 dark:border-gray-700" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Keluar <span class="text-red-500" x-show="jenis_keluar !== 'Mutasi'">*</span></label>
                        <input type="date" name="tanggal_keluar" x-model="tanggal_keluar" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" :required="jenis_keluar !== 'Mutasi'">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan / Keterangan <span class="text-red-500" x-show="jenis_keluar !== 'Mutasi'">*</span></label>
                    <textarea name="alasan" x-model="alasan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Tuliskan alasan..." :required="jenis_keluar !== 'Mutasi'"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">Simpan Registrasi Keluar</button>
            </div>
        </form>
    </div>
</div>