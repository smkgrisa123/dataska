<!-- ========================================== -->
<!-- MODAL FORM REGISTRASI MASUK                -->
<!-- ========================================== -->
<div x-data="{ 
    openModal: false,
    jenis_pendaftaran: '<?= isset($registrasi_masuk) ? $registrasi_masuk->jenis_pendaftaran : 'Siswa Baru'; ?>',
    diterima_di_kelas: '<?= isset($registrasi_masuk) ? $registrasi_masuk->diterima_di_kelas : ''; ?>',
    bidang_keahlian: '<?= isset($registrasi_masuk) ? $registrasi_masuk->bidang_keahlian : ''; ?>',
    program_keahlian: '<?= isset($registrasi_masuk) ? $registrasi_masuk->program_keahlian : ''; ?>',
    konsentrasi_keahlian: '<?= isset($registrasi_masuk) ? $registrasi_masuk->konsentrasi_keahlian : ''; ?>',
    no_induk: '<?= isset($registrasi_masuk) ? $registrasi_masuk->no_induk : ''; ?>',
    tanggal_masuk: '<?= isset($registrasi_masuk) ? $registrasi_masuk->tanggal_masuk : ''; ?>', 
    asal_sekolah: '<?= isset($registrasi_masuk) ? $registrasi_masuk->asal_sekolah : ''; ?>',
    no_ijazah_smp: '<?= isset($registrasi_masuk) ? $registrasi_masuk->no_ijazah_smp : ''; ?>',
    tanggal_ijazah_smp: '<?= isset($registrasi_masuk) ? $registrasi_masuk->tanggal_ijazah_smp : ''; ?>',
    sekolah_sebelumnya: '<?= isset($registrasi_masuk) ? $registrasi_masuk->sekolah_sebelumnya : ''; ?>',
    alasan_pindah: '<?= isset($registrasi_masuk) ? $registrasi_masuk->alasan_pindah : ''; ?>'
}"
    @open-modal-reg-masuk.window="openModal = true" x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">

    <div @click.outside="openModal = false" class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-2xl shadow-xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h4 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-blue-600"></i> Form Registrasi Masuk Siswa
            </h4>
            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form action="<?= site_url('siswa/simpan_registrasi_masuk/' . $siswa->id); ?>" method="POST" class="space-y-4 text-xs sm:text-sm">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Pendaftaran</label>
                    <select name="jenis_pendaftaran" x-model="jenis_pendaftaran" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="Siswa Baru">Siswa Baru</option>
                        <option value="Pindahan">Pindahan</option>
                        <option value="Kembali Bersekolah">Kembali Bersekolah</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Diterima di Kelas</label>
                    <select name="diterima_di_kelas" x-model="diterima_di_kelas" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X">X (Sepuluh)</option>
                        <option value="XI">XI (Sebelas)</option>
                        <option value="XII">XII (Duabelas)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Bidang Keahlian</label>
                    <select name="bidang_keahlian" x-model="bidang_keahlian" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Bidang --</option>
                        <?php
                        // Mengambil data unik bidang keahlian dari tabel kompetensi
                        $bidang_unik = array_unique(array_column($kompetensi_list, 'bidang_keahlian'));
                        foreach ($bidang_unik as $b):
                            if (!empty($b)):
                        ?>
                                <option value="<?= $b; ?>"><?= $b; ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Program Keahlian</label>
                    <select name="program_keahlian" x-model="program_keahlian" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Program --</option>
                        <?php
                        $program_unik = array_unique(array_column($kompetensi_list, 'program_keahlian'));
                        foreach ($program_unik as $p):
                            if (!empty($p)):
                        ?>
                                <option value="<?= $p; ?>"><?= $p; ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Konsentrasi Keahlian</label>
                    <select name="konsentrasi_keahlian" x-model="konsentrasi_keahlian" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                        <option value="">-- Pilih Konsentrasi --</option>
                        <?php foreach ($kompetensi_list as $k): ?>
                            <?php if (!empty($k->konsentrasi_keahlian)): ?>
                                <option value="<?= $k->konsentrasi_keahlian; ?>"><?= $k->konsentrasi_keahlian; ?> (<?= $k->nama; ?>)</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Induk (NIPD)</label>
                    <input type="text" name="no_induk" value="<?= isset($siswa->no_induk) ? $siswa->no_induk : ''; ?>" autocomplete="off" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nomor Induk Siswa">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Masuk Sekolah</label>
                    <input type="date" name="tanggal_masuk" x-model="tanggal_masuk" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
                <!-- Input Tahun Ajaran Masuk -->
                <div class="space-y-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tahun Ajaran Masuk <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_ajaran_id"
                        class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-xs sm:text-sm text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <?php if (!empty($tahun_ajaran)): ?>
                            <?php foreach ($tahun_ajaran as $ta): ?>
                                <option value="<?= $ta->id; ?>" <?= (isset($siswa) && $siswa->tahun_ajaran_id == $ta->id) ? 'selected' : ''; ?>>
                                    <?= $ta->nama . ' (' . $ta->semester . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Asal Sekolah (SMP/MTs)</label>
                    <input type="text" name="asal_sekolah" x-model="asal_sekolah" autocomplete="off" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nama SMP/MTs Asal">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. Ijazah SMP/MTs</label>
                    <input type="text" name="no_ijazah_smp" x-model="no_ijazah_smp" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nomor Ijazah">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Ijazah SMP/MTs</label>
                    <input type="date" name="tanggal_ijazah_smp"
                        value="<?= (!empty($siswa->tanggal_ijazah_smp) && $siswa->tanggal_ijazah_smp != '0000-00-00') ? $siswa->tanggal_ijazah_smp : ''; ?>"
                        x-model="tanggal_ijazah_smp"
                        autocomplete="off"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none">
                </div>
            </div>

            <!-- Tambahan untuk bagian Pindahan jika ada -->
            <div x-show="jenis_pendaftaran === 'Pindahan'" class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-700/50 space-y-4" style="display: none;">
                <h5 class="font-semibold text-amber-800 dark:text-amber-400 text-xs uppercase tracking-wider">Informasi Tambahan Siswa Pindahan</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Sekolah Sebelumnya</label>
                        <input type="text" name="sekolah_sebelumnya" x-model="sekolah_sebelumnya" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Nama Sekolah Asal Sebelumnya">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Pindah</label>
                        <textarea name="alasan_pindah" x-model="alasan_pindah" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white outline-none" placeholder="Alasan pindah sekolah"></textarea>
                    </div>
                </div>
            </div>



            <div class="flex justify-end gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 rounded-lg font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">Simpan Registrasi Masuk</button>
            </div>
        </form>
    </div>
</div>