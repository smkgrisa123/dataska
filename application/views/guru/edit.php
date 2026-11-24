<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- WADAH UTAMA X-DATA -->
<div class="p-6 min-h-screen pb-24 overflow-y-auto" x-data="{ 
    activeTab: 'pribadi', 
    openModalSertifikasi: false,
    openModalEditSertifikasi: false,
    editSertifikasi: {},
    openModalPendidikan: false,
    openModalEditPendidikan: false,
    editPendidikan: {},
    openModalAnak: false,
    openModalEditAnak: false,
    editAnak: {},
    openModalDiklat: false,
    openModalEditDiklat: false,
    openModalPenugasan: false,
openModalEditPenugasan: false,
editPenugasan: {},
    editDiklat: {}
}">

    <!-- Toast Flashdata Sukses -->
    <?php if ($this->session->flashdata('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '<?= $this->session->flashdata('success'); ?>',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    <?php endif; ?>

    <!-- HEADER BANNER ATAS -->
    <div class="bg-slate-900 text-white p-6 rounded-2xl shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Pendidik & Tenaga Kependidikan / Edit Data</span>
            <h2 class="text-lg font-bold mt-1 flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-emerald-400"></i>
                Edit Data PTK: <?= strtoupper($guru->nama_lengkap); ?>
            </h2>
            <p class="text-xs text-slate-400 mt-1">Kelola dan perbarui informasi lengkap PTK berdasarkan kategori tab.</p>
        </div>
        <div>
            <a href="<?= base_url('guru'); ?>" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold rounded-xl flex items-center gap-2 border border-slate-700 transition shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Guru
            </a>
        </div>
    </div>

    <!-- NAVIGASI TAB -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">

        <div class="flex overflow-x-auto border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 pt-3 gap-2 rounded-t-2xl">
            <button @click="activeTab = 'pribadi'" :class="activeTab === 'pribadi' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-user"></i> Data Pribadi</button>
            <button @click="activeTab = 'kontak'" :class="activeTab === 'kontak' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-address-book"></i> Alamat & Kontak</button>
            <button @click="activeTab = 'kepegawaian'" :class="activeTab === 'kepegawaian' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-briefcase"></i> Kepegawaian & NUPTK</button>
            <button @click="activeTab = 'sertifikasi'" :class="activeTab === 'sertifikasi' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-certificate"></i> Sertifikasi</button>
            <button @click="activeTab = 'pendidikan'" :class="activeTab === 'pendidikan' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-graduation-cap"></i> Pendidikan Formal</button>
            <button @click="activeTab = 'anak'" :class="activeTab === 'anak' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-child"></i> Anak</button>
            <button @click="activeTab = 'diklat'" :class="activeTab === 'diklat' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-chalkboard-user"></i> Diklat</button>
            <button @click="activeTab = 'dokumen'" :class="activeTab === 'dokumen' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-folder-open"></i> Dokumen</button>
            <button @click="activeTab = 'penugasan'" :class="activeTab === 'penugasan' ? 'border-blue-600 text-blue-600 bg-white dark:bg-gray-800 shadow-sm' : 'border-transparent text-gray-500'" class="px-4 py-2.5 text-xs font-semibold border-b-2 rounded-t-xl transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-user-shield"></i> Penugasan</button>
        </div>

        <!-- FORM UTAMA -->
        <form action="<?= base_url('guru/update/' . $guru->id); ?>" method="POST" class="p-6 space-y-6 text-xs">

            <!-- TAB 1: DATA PRIBADI (LENGKAP) -->
            <div x-show="activeTab === 'pribadi'" class="space-y-4">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm border-b pb-2 mb-4">Formulir Data Pribadi PTK</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="<?= $guru->nama_lengkap; ?>" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" value="<?= $guru->nik; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Jenis Kelamin</label>
                        <select name="jk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="L" <?= $guru->jk == 'L' ? 'selected' : ''; ?>>Laki-laki (L)</option>
                            <option value="P" <?= $guru->jk == 'P' ? 'selected' : ''; ?>>Perempuan (P)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tempat Lahir</label>
                        <input type="text" name="tmp_lahir" value="<?= $guru->tmp_lahir; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" value="<?= $guru->tgl_lahir; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nama Ibu Kandung</label>
                        <input type="text" name="nama_ibu_kandung" value="<?= isset($guru->nama_ibu_kandung) ? $guru->nama_ibu_kandung : ''; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nomor Kartu Keluarga (KK)</label>
                        <input type="text" name="no_kk" value="<?= isset($guru->no_kk) ? $guru->no_kk : ''; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Agama</label>
                        <select name="agama" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" <?= (isset($guru->agama) && $guru->agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                            <option value="Kristen" <?= (isset($guru->agama) && $guru->agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                            <option value="Katolik" <?= (isset($guru->agama) && $guru->agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                            <option value="Hindu" <?= (isset($guru->agama) && $guru->agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                            <option value="Buddha" <?= (isset($guru->agama) && $guru->agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                            <option value="Konghucu" <?= (isset($guru->agama) && $guru->agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NPWP</label>
                        <input type="text" name="npwp" value="<?= isset($guru->npwp) ? $guru->npwp : ''; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nama Wajib Pajak</label>
                        <input type="text" name="nama_wajib_pajak" value="<?= isset($guru->nama_wajib_pajak) ? $guru->nama_wajib_pajak : ''; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" value="<?= isset($guru->kewarganegaraan) ? $guru->kewarganegaraan : 'Indonesia'; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Status Perkawinan</label>
                        <select name="status_perkawinan" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Status --</option>
                            <option value="Kawin" <?= (isset($guru->status_perkawinan) && $guru->status_perkawinan == 'Kawin') ? 'selected' : ''; ?>>Kawin</option>
                            <option value="Belum Kawin" <?= (isset($guru->status_perkawinan) && $guru->status_perkawinan == 'Belum Kawin') ? 'selected' : ''; ?>>Belum Kawin</option>
                            <option value="Janda/Duda" <?= (isset($guru->status_perkawinan) && $guru->status_perkawinan == 'Janda/Duda') ? 'selected' : ''; ?>>Janda/Duda</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nama Suami / Istri</label>
                        <input type="text" name="nama_suami_istri" value="<?= isset($guru->nama_suami_istri) ? $guru->nama_suami_istri : ''; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NIP Suami / Istri</label>
                        <input type="text" name="nip_suami_istri" value="<?= isset($guru->nip_suami_istri) ? $guru->nip_suami_istri : ''; ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Pekerjaan Suami / Istri</label>
                        <select name="pekerjaan_suami_istri_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Pekerjaan --</option>
                            <?php foreach ($master_pekerjaan as $pek) : ?>
                                <option value="<?= $pek->id; ?>" <?= ($guru->pekerjaan_suami_istri_id == $pek->id) ? 'selected' : ''; ?>>
                                    <?= $pek->nama_pekerjaan; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- TAB 2: ALAMAT & KONTAK (LENGKAP DENGAN DROPDOWN AJAX) -->
            <div x-show="activeTab === 'kontak'" x-cloak class="space-y-4">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm border-b pb-2 mb-4">Informasi Alamat & Kontak PTK</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="<?= isset($guru->no_hp) ? $guru->no_hp : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: 081234567890">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Email Pribadi</label>
                        <input type="email" name="email" value="<?= isset($guru->email) ? $guru->email : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: nama@email.com">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Provinsi</label>
                        <select name="wilayah_provinsi_id" id="provinsi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Provinsi --</option>
                            <?php if (!empty($provinsi)) : ?>
                                <?php foreach ($provinsi as $prov) : ?>
                                    <option value="<?= $prov->id; ?>" <?= (isset($guru->wilayah_provinsi_id) && $guru->wilayah_provinsi_id == $prov->id) ? 'selected' : ''; ?>>
                                        <?= $prov->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Kabupaten / Kota</label>
                        <select name="wilayah_kabupaten_id" id="kabupaten" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            <?php if (!empty($kabupaten)) : ?>
                                <?php foreach ($kabupaten as $kab) : ?>
                                    <option value="<?= $kab->id; ?>" <?= (isset($guru->wilayah_kabupaten_id) && $guru->wilayah_kabupaten_id == $kab->id) ? 'selected' : ''; ?>>
                                        <?= $kab->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Kecamatan</label>
                        <select name="wilayah_kecamatan_id" id="kecamatan" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Kecamatan --</option>
                            <?php if (!empty($kecamatan)) : ?>
                                <?php foreach ($kecamatan as $kec) : ?>
                                    <option value="<?= $kec->id; ?>" <?= (isset($guru->wilayah_kecamatan_id) && $guru->wilayah_kecamatan_id == $kec->id) ? 'selected' : ''; ?>>
                                        <?= $kec->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Desa / Kelurahan</label>
                        <select name="wilayah_desa_id" id="desa" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Desa/Kelurahan --</option>
                            <?php if (!empty($desa)) : ?>
                                <?php foreach ($desa as $des) : ?>
                                    <option value="<?= $des->id; ?>" <?= (isset($guru->wilayah_desa_id) && $guru->wilayah_desa_id == $des->id) ? 'selected' : ''; ?>>
                                        <?= $des->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Alamat Jalan</label>
                        <input type="text" name="alamat_jalan" value="<?= isset($guru->alamat_jalan) ? $guru->alamat_jalan : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Jl. Melati No. 10">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Dusun</label>
                        <input type="text" name="dusun" value="<?= isset($guru->dusun) ? $guru->dusun : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">RT</label>
                            <input type="text" name="rt" value="<?= isset($guru->rt) ? $guru->rt : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="001">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">RW</label>
                            <input type="text" name="rw" value="<?= isset($guru->rw) ? $guru->rw : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="002">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: KEPEGAWAIAN & NUPTK (DIKEMBALIKAN LENGKAP) -->
            <div x-show="activeTab === 'kepegawaian'" x-cloak class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Informasi Kepegawaian & NUPTK PTK</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Status Kepegawaian</label>
                        <select name="status_kepegawaian" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Status Kepegawaian --</option>
                            <option value="PNS" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'PNS') ? 'selected' : ''; ?>>PNS</option>
                            <option value="PNS Diperbantukan" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'PNS Diperbantukan') ? 'selected' : ''; ?>>PNS Diperbantukan</option>
                            <option value="PNS Depag" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'PNS Depag') ? 'selected' : ''; ?>>PNS Depag</option>
                            <option value="GTY/PTY" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'GTY/PTY') ? 'selected' : ''; ?>>GTY/PTY</option>
                            <option value="GTT/PTT Propinsi" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'GTT/PTT Propinsi') ? 'selected' : ''; ?>>GTT/PTT Propinsi</option>
                            <option value="GTT/PTT Kab/Kota" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'GTT/PTT Kab/Kota') ? 'selected' : ''; ?>>GTT/PTT Kab/Kota</option>
                            <option value="Guru Bantu Pusat" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'Guru Bantu Pusat') ? 'selected' : ''; ?>>Guru Bantu Pusat</option>
                            <option value="Guru Honor Sekolah" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'Guru Honor Sekolah') ? 'selected' : ''; ?>>Guru Honor Sekolah</option>
                            <option value="Tenaga Honor" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'Tenaga Honor') ? 'selected' : ''; ?>>Tenaga Honor</option>
                            <option value="CPNS" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'CPNS') ? 'selected' : ''; ?>>CPNS</option>
                            <option value="PPPK" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'PPPK') ? 'selected' : ''; ?>>PPPK</option>
                            <option value="PPNPN" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'PPNPN') ? 'selected' : ''; ?>>PPNPN</option>
                            <option value="Kontrak Kerja WNA" <?= (isset($guru->status_kepegawaian) && $guru->status_kepegawaian == 'Kontrak Kerja WNA') ? 'selected' : ''; ?>>Kontrak Kerja WNA</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NIP</label>
                        <input type="text" name="nip" value="<?= isset($guru->nip) ? $guru->nip : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nomor Induk Pegawai">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NIY / NIGK</label>
                        <input type="text" name="niy_nigk" value="<?= isset($guru->niy_nigk) ? $guru->niy_nigk : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="NIY / NIGK">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NUPTK</label>
                        <input type="text" name="nuptk" value="<?= isset($guru->nuptk) ? $guru->nuptk : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nomor Unik Pendidik dan Tenaga Kependidikan">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Jenis PTK</label>
                        <select name="jenis_ptk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Jenis PTK --</option>
                            <option value="Kepala Sekolah" <?= (isset($guru->jenis_ptk) && $guru->jenis_ptk == 'Kepala Sekolah') ? 'selected' : ''; ?>>Kepala Sekolah</option>
                            <option value="Guru" <?= (isset($guru->jenis_ptk) && $guru->jenis_ptk == 'Guru') ? 'selected' : ''; ?>>Guru</option>
                            <option value="Tenaga Kependidikan" <?= (isset($guru->jenis_ptk) && $guru->jenis_ptk == 'Tenaga Kependidikan') ? 'selected' : ''; ?>>Tenaga Kependidikan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">SK Pengangkatan</label>
                        <input type="text" name="sk_pengangkatan" value="<?= isset($guru->sk_pengangkatan) ? $guru->sk_pengangkatan : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nomor SK Pengangkatan">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">TMT Pengangkatan</label>
                        <input type="date" name="tmt_pengangkatan" value="<?= isset($guru->tmt_pengangkatan) ? $guru->tmt_pengangkatan : ''; ?>" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Lembaga Pengangkat</label>
                        <select name="lembaga_pengangkat" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Lembaga Pengangkat --</option>
                            <option value="Pemerintah Pusat" <?= (isset($guru->lembaga_pengangkat) && $guru->lembaga_pengangkat == 'Pemerintah Pusat') ? 'selected' : ''; ?>>Pemerintah Pusat</option>
                            <option value="Pemerintah Daerah" <?= (isset($guru->lembaga_pengangkat) && $guru->lembaga_pengangkat == 'Pemerintah Daerah') ? 'selected' : ''; ?>>Pemerintah Daerah</option>
                            <option value="Yayasan" <?= (isset($guru->lembaga_pengangkat) && $guru->lembaga_pengangkat == 'Yayasan') ? 'selected' : ''; ?>>Yayasan</option>
                            <option value="Komite Sekolah" <?= (isset($guru->lembaga_pengangkat) && $guru->lembaga_pengangkat == 'Komite Sekolah') ? 'selected' : ''; ?>>Komite Sekolah</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- TAB 4: SERTIFIKASI (CRUD LENGKAP DENGAN NRG & NOMOR PESERTA) -->
            <div x-show="activeTab === 'sertifikasi'" x-cloak class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Riwayat Sertifikasi PTK</h3>
                    <button type="button" @click="openModalSertifikasi = true" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-plus"></i> Tambah Sertifikasi</button>
                </div>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 text-xs">
                                <th class="p-3">No</th>
                                <th class="p-3">Jenis</th>
                                <th class="p-3">Nomor</th>
                                <th class="p-3">Tahun</th>
                                <th class="p-3">Bidang Studi</th>
                                <th class="p-3">NRG</th>
                                <th class="p-3">No. Peserta</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <?php if (!empty($sertifikasi)) : $no = 1;
                                foreach ($sertifikasi as $s): ?>
                                    <tr>
                                        <td class="p-3"><?= $no++; ?></td>
                                        <td class="p-3"><?= $s->jenis_sertifikasi; ?></td>
                                        <td class="p-3"><?= $s->nomor_sertifikasi; ?></td>
                                        <td class="p-3"><?= $s->tahun_sertifikasi; ?></td>
                                        <td class="p-3"><?= $s->bidang_studi; ?></td>
                                        <td class="p-3"><?= $s->nrg; ?></td>
                                        <td class="p-3"><?= $s->nomor_peserta; ?></td>
                                        <td class="p-3 text-center flex justify-center gap-1">
                                            <button type="button" @click="editSertifikasi = { id: '<?= $s->id; ?>', jenis_sertifikasi: '<?= $s->jenis_sertifikasi; ?>', nomor_sertifikasi: '<?= $s->nomor_sertifikasi; ?>', tahun_sertifikasi: '<?= $s->tahun_sertifikasi; ?>', bidang_studi: '<?= $s->bidang_studi; ?>', nrg: '<?= $s->nrg; ?>', nomor_peserta: '<?= $s->nomor_peserta; ?>' }; openModalEditSertifikasi = true;" class="text-amber-600 bg-amber-50 px-2 py-1 rounded">Edit</button>
                                            <a href="<?= site_url('guru/hapus_sertifikasi/' . $guru->id . '/$s->id'); ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 bg-red-50 px-2 py-1 rounded">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">Belum ada riwayat sertifikasi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 5: PENDIDIKAN FORMAL (10 KOLOM TERPISAH) -->
            <div x-show="activeTab === 'pendidikan'" x-cloak class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Riwayat Pendidikan Formal PTK</h3>
                    <button type="button" @click="openModalPendidikan = true" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Pendidikan
                    </button>
                </div>

                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 text-xs">
                                <th class="p-3">No</th>
                                <th class="p-3">Bidang Studi</th>
                                <th class="p-3">Jenjang Pendidikan</th>
                                <th class="p-3">Gelar Akademik</th>
                                <th class="p-3">Satuan Pendidikan Formal</th>
                                <th class="p-3">Tahun Masuk</th>
                                <th class="p-3">Tahun Lulus</th>
                                <th class="p-3">NIM</th>
                                <th class="p-3">Matkul</th>
                                <th class="p-3">Semester</th>
                                <th class="p-3">IPK</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <?php if (!empty($pendidikan)) : $no = 1;
                                foreach ($pendidikan as $p): ?>
                                    <tr>
                                        <td class="p-3"><?= $no++; ?></td>
                                        <td class="p-3"><?= $p->bidang_studi; ?></td>
                                        <td class="p-3"><?= $p->jenjang_pendidikan; ?></td>
                                        <td class="p-3"><?= $p->gelar_akademik; ?></td>
                                        <td class="p-3"><?= $p->nama_sekolah; ?></td>
                                        <td class="p-3"><?= $p->tahun_masuk; ?></td>
                                        <td class="p-3"><?= $p->tahun_lulus; ?></td>
                                        <td class="p-3"><?= $p->nim; ?></td>
                                        <td class="p-3"><?= $p->matkul; ?></td>
                                        <td class="p-3"><?= $p->semester; ?></td>
                                        <td class="p-3"><?= $p->ipk; ?></td>
                                        <td class="p-3 text-center flex justify-center gap-1">
                                            <button type="button" @click="editPendidikan = { 
                            id: '<?= $p->id; ?>', 
                            bidang_studi: '<?= $p->bidang_studi; ?>', 
                            jenjang_pendidikan: '<?= $p->jenjang_pendidikan; ?>', 
                            gelar_akademik: '<?= $p->gelar_akademik; ?>', 
                            nama_sekolah: '<?= $p->nama_sekolah; ?>', 
                            tahun_masuk: '<?= $p->tahun_masuk; ?>', 
                            tahun_lulus: '<?= $p->tahun_lulus; ?>', 
                            nim: '<?= $p->nim; ?>', 
                            matkul: '<?= $p->matkul; ?>', 
                            semester: '<?= $p->semester; ?>', 
                            ipk: '<?= $p->ipk; ?>' 
                        }; openModalEditPendidikan = true;" class="text-amber-600 bg-amber-50 px-2 py-1 rounded">Edit</button>

                                            <a href="<?= site_url('guru/hapus_pendidikan/' . $guru->id . '/' . $p->id); ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 bg-red-50 px-2 py-1 rounded">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="12" class="p-4 text-center text-gray-500">Belum ada riwayat pendidikan formal.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB: ANAK -->
            <div x-show="activeTab === 'anak'" x-cloak class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Data Anak PTK</h3>
                    <button type="button" @click="openModalAnak = true" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Data Anak
                    </button>
                </div>

                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 text-xs">
                                <th class="p-3">No</th>
                                <th class="p-3">Nama Anak</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">JK</th>
                                <th class="p-3">Tempat, Tanggal Lahir</th>
                                <th class="p-3">Jenjang Pendidikan</th>
                                <th class="p-3">Tahun Masuk - Lulus Sekolah</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <?php if (!empty($anak)) : $no = 1;
                                foreach ($anak as $a): ?>
                                    <tr>
                                        <td class="p-3"><?= $no++; ?></td>
                                        <td class="p-3 font-semibold"><?= $a->nama; ?></td>
                                        <td class="p-3"><?= $a->status; ?></td>
                                        <td class="p-3"><?= $a->jenis_kelamin; ?></td>
                                        <td class="p-3"><?= $a->tempat_lahir; ?>, <?= $a->tanggal_lahir ? date('d-m-Y', strtotime($a->tanggal_lahir)) : '-'; ?></td>
                                        <td class="p-3"><?= $a->jenjang_pendidikan; ?></td>
                                        <td class="p-3"><?= $a->tahun_masuk; ?> - <?= $a->tahun_lulus; ?></td>

                                        <!-- === LETAKKAN TOMBOL EDIT DI SINI (KOLOM AKSI) === -->
                                        <td class="p-3 text-center flex justify-center gap-1">
                                            <button type="button" @click="editAnak = { 
                id: '<?= $a->id; ?>', 
                nama: '<?= $a->nama; ?>', 
                status: '<?= $a->status; ?>', 
                jenis_kelamin: '<?= $a->jenis_kelamin; ?>', 
                tempat_lahir: '<?= $a->tempat_lahir; ?>', 
                tanggal_lahir: '<?= $a->tanggal_lahir; ?>', 
                jenjang_pendidikan: '<?= $a->jenjang_pendidikan; ?>', 
                tahun_masuk: '<?= $a->tahun_masuk; ?>', 
                tahun_lulus: '<?= $a->tahun_lulus; ?>' 
            }; openModalEditAnak = true;" class="text-amber-600 bg-amber-50 px-2 py-1 rounded">Edit</button>

                                            <a href="<?= site_url('guru/hapus_anak/' . $guru->id . '/' . $a->id); ?>" onclick="return confirm('Yakin ingin menghapus data anak ini?')" class="text-red-600 bg-red-50 px-2 py-1 rounded">Hapus</a>
                                        </td>
                                        <!-- ============================================== -->

                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">Belum ada data anak.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 7: DIKLAT (CRUD) -->
            <!-- TAB: DIKLAT -->
            <div x-show="activeTab === 'diklat'" x-cloak class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Riwayat Diklat PTK</h3>
                    <button type="button" @click="openModalDiklat = true" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Diklat
                    </button>
                </div>

                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 text-xs">
                                <th class="p-3">No</th>
                                <th class="p-3">Jenis Diklat</th>
                                <th class="p-3">Nama Diklat</th>
                                <th class="p-3">Penyelenggara</th>
                                <th class="p-3">Tahun</th>
                                <th class="p-3">Peran</th>
                                <th class="p-3">Tingkat</th>
                                <th class="p-3">Jam (JP)</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <?php if (!empty($diklat)) : $no = 1;
                                foreach ($diklat as $d): ?>
                                    <tr>
                                        <td class="p-3"><?= $no++; ?></td>
                                        <td class="p-3"><?= $d->jenis_diklat; ?></td>
                                        <td class="p-3 font-semibold"><?= $d->nama_diklat; ?></td>
                                        <td class="p-3"><?= $d->penyelenggara; ?></td>
                                        <td class="p-3"><?= $d->tahun; ?></td>
                                        <td class="p-3"><?= $d->peran; ?></td>
                                        <td class="p-3"><?= $d->tingkat; ?></td>
                                        <td class="p-3"><?= $d->berapa_jam; ?> Jam</td>
                                        <td class="p-3 text-center flex justify-center gap-1">
                                            <button type="button" @click="editDiklat = { 
                            id: '<?= $d->id; ?>', 
                            jenis_diklat: '<?= $d->jenis_diklat; ?>', 
                            nama_diklat: '<?= addslashes($d->nama_diklat); ?>', 
                            penyelenggara: '<?= addslashes($d->penyelenggara); ?>', 
                            tahun: '<?= $d->tahun; ?>', 
                            peran: '<?= addslashes($d->peran); ?>', 
                            tingkat: '<?= addslashes($d->tingkat); ?>', 
                            berapa_jam: '<?= $d->berapa_jam; ?>' 
                        }; openModalEditDiklat = true;" class="text-amber-600 bg-amber-50 px-2 py-1 rounded">Edit</button>

                                            <a href="<?= site_url('guru/hapus_diklat/' . $guru->id . '/' . $d->id); ?>" onclick="return confirm('Yakin ingin menghapus riwayat diklat ini?')" class="text-red-600 bg-red-50 px-2 py-1 rounded">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="9" class="p-4 text-center text-gray-500">Belum ada riwayat diklat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 8: DOKUMEN PTK -->
            <div x-show="activeTab === 'dokumen'" x-cloak class="space-y-6">

                <!-- HEADER PORTAL DOKUMEN -->
                <div class="bg-indigo-50 dark:bg-indigo-950/40 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-900 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-indigo-600 text-white rounded-xl shadow-md">
                            <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-white">Portal Berkas & Dokumen Pendukung PTK</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Lengkapi berkas kepegawaian. Maksimal ukuran file 500 KB (PDF / JPG / PNG).</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full text-xs font-medium border border-emerald-200 dark:border-emerald-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-check"></i> Auto Upload
                    </span>
                </div>

                <?php
                $jenis_dokumen_ptk = [
                    'foto_pribadi' => ['no' => 1, 'title' => 'Foto Pribadi', 'desc' => 'Format JPG/PNG (Pas foto formal)'],
                    'kk'           => ['no' => 2, 'title' => 'Kartu Keluarga (KK)', 'desc' => 'Format PDF / JPG / PNG'],
                    'ktp'          => ['no' => 3, 'title' => 'Kartu Tanda Penduduk (KTP)', 'desc' => 'Format PDF / JPG / PNG'],
                    'ijazah_sd'    => ['no' => 4, 'title' => 'Ijazah SD / Sederajat', 'desc' => 'Format PDF / JPG / PNG'],
                    'ijazah_smp'   => ['no' => 5, 'title' => 'Ijazah SMP / Sederajat', 'desc' => 'Format PDF / JPG / PNG'],
                    'ijazah_sma'   => ['no' => 6, 'title' => 'Ijazah SMA / Sederajat', 'desc' => 'Format PDF / JPG / PNG'],
                    'ijazah_s1'    => ['no' => 7, 'title' => 'Ijazah S1 / D4', 'desc' => 'Format PDF / JPG / PNG'],
                    'ijazah_s2'    => ['no' => 8, 'title' => 'Ijazah S2', 'desc' => 'Format PDF / JPG / PNG'],
                ];
                ?>

                <!-- GRID KARTU DOKUMEN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($jenis_dokumen_ptk as $key => $info):
                        $nama_file_tersimpan = (isset($dokumen->$key) && !empty($dokumen->$key)) ? $dokumen->$key : null;
                    ?>
                        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 text-xs font-bold flex items-center justify-center border border-indigo-200 dark:border-indigo-800"><?= $info['no']; ?></span>
                                        <h4 class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-white"><?= $info['title']; ?></h4>
                                    </div>
                                    <span class="text-[11px] text-gray-400 font-medium px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded-md">Max 500 KB</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4"><?= $info['desc']; ?></p>

                                <?php if ($nama_file_tersimpan): ?>
                                    <!-- FILE TERTERA (TAMPIL PREVIEW, LIHAT, UNDUH, HAPUS) -->
                                    <div class="border border-dashed border-gray-300 dark:border-gray-600 p-4 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/30">
                                        <div class="flex items-center gap-3 w-full sm:w-auto overflow-hidden">
                                            <?php
                                            $ext = pathinfo($nama_file_tersimpan, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                                            ?>

                                            <?php if ($isImage): ?>
                                                <div class="w-12 h-12 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white flex-shrink-0 flex items-center justify-center">
                                                    <img src="<?= base_url('uploads/dokumen_guru/' . $nama_file_tersimpan); ?>" alt="Preview" class="w-full h-full object-cover">
                                                </div>
                                            <?php else: ?>
                                                <div class="w-12 h-12 rounded-lg bg-rose-50 text-rose-600 flex-shrink-0 flex items-center justify-center">
                                                    <i class="fa-solid fa-file-pdf text-xl"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div class="truncate">
                                                <p class="text-xs font-semibold text-gray-800 dark:text-white truncate max-w-[150px] sm:max-w-[180px]"><?= $nama_file_tersimpan; ?></p>
                                                <p class="text-[10px] text-emerald-600 font-medium">Tersimpan di Server</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                            <a href="<?= base_url('uploads/dokumen_guru/' . $nama_file_tersimpan); ?>" target="_blank" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-xs font-medium flex items-center gap-1 transition">
                                                <i class="fa-solid fa-eye"></i> Lihat
                                            </a>
                                            <a href="<?= base_url('uploads/dokumen_guru/' . $nama_file_tersimpan); ?>" download class="px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg text-xs font-medium flex items-center gap-1 transition">
                                                <i class="fa-solid fa-download"></i> Unduh
                                            </a>
                                            <a href="<?= site_url('guru/hapus_dokumen_field/' . $guru->id . '/' . $key); ?>" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Dokumen">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- INPUT FILE AUTO-UPLOAD VIA AJAX -->
                                    <label class="border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 p-4 rounded-xl flex flex-col items-center justify-center cursor-pointer bg-gray-50/50 dark:bg-gray-900/30 transition group">
                                        <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full mb-1 group-hover:scale-110 transition">
                                            <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                                        </div>
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Pilih file <?= $info['title']; ?></span>
                                        <span class="text-[10px] text-gray-400 mt-0.5">Format PDF / JPG (Maks. 500 KB)</span>

                                        <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="uploadDokumenGuru(this, '<?= $key; ?>', '<?= $guru->id; ?>')">
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

            <!-- TAB PENUGASAN -->
            <div x-show="activeTab === 'penugasan'" x-cloak class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Riwayat Penugasan & Tugas Tambahan PTK</h3>
                    <button type="button" @click="openModalPenugasan = true" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Penugasan
                    </button>
                </div>

                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 text-xs">
                                <th class="p-3">No</th>
                                <th class="p-3">No. Surat Tugas</th>
                                <th class="p-3">Tgl Surat</th>
                                <th class="p-3">TMT Tugas</th>
                                <th class="p-3">Status Sekolah</th>
                                <th class="p-3">Tugas Tambahan</th>
                                <th class="p-3">Peran</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <?php if (!empty($penugasan_list)) : $no = 1;
                                foreach ($penugasan_list as $pt): ?>
                                    <tr>
                                        <td class="p-3"><?= $no++; ?></td>
                                        <td class="p-3 font-semibold"><?= $pt->no_surat_tugas; ?></td>
                                        <td class="p-3"><?= $pt->tanggal_surat_tugas ? date('d-m-Y', strtotime($pt->tanggal_surat_tugas)) : '-'; ?></td>
                                        <td class="p-3"><?= $pt->tmt_tugas ? date('d-m-Y', strtotime($pt->tmt_tugas)) : '-'; ?></td>
                                        <td class="p-3">
                                            <span class="px-2 py-1 bg-<?= $pt->status_sekolah == 'Induk' ? 'emerald' : 'amber'; ?>-100 text-<?= $pt->status_sekolah == 'Induk' ? 'emerald' : 'amber'; ?>-700 rounded text-[10px] font-semibold">
                                                <?= $pt->status_sekolah; ?>
                                            </span>
                                        </td>
                                        <td class="p-3"><?= $pt->nama_tugas_tambahan ?? '-'; ?></td>
                                        <td class="p-3"><?= $pt->nama_peran ?? '-'; ?></td>
                                        <td class="p-3 text-center flex justify-center gap-1">
                                            <button type="button" @click="editPenugasan = { 
                                id: '<?= $pt->id; ?>', 
                                no_surat_tugas: '<?= $pt->no_surat_tugas; ?>', 
                                tanggal_surat_tugas: '<?= $pt->tanggal_surat_tugas; ?>', 
                                tmt_tugas: '<?= $pt->tmt_tugas; ?>', 
                                status_sekolah: '<?= $pt->status_sekolah; ?>', 
                                tugas_tambahan_id: '<?= $pt->tugas_tambahan_id; ?>', 
                                peran_id: '<?= $pt->peran_id; ?>' 
                            }; openModalEditPenugasan = true;" class="text-amber-600 bg-amber-50 px-2 py-1 rounded">Edit</button>

                                            <a href="<?= site_url('guru/hapus_penugasan/' . $guru->id . '/' . $pt->id); ?>" onclick="return confirm('Yakin ingin menghapus data penugasan ini?')" class="text-red-600 bg-red-50 px-2 py-1 rounded">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">Belum ada riwayat penugasan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TOMBOL SIMPAN UTAMA HANYA DI BAWAH -->
            <div class="flex justify-end pt-6 pb-6 pr-6 border-t mt-6">
                <div class="flex items-center gap-3">
                    <a href="<?= base_url('guru'); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-xl text-xs">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-xs flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Utama
                    </button>
                </div>
            </div>

        </form> <!-- AKHIR FORM UTAMA -->
    </div> <!-- AKHIR CONTAINER TAB -->

    <!-- ================================================================= -->
    <!-- KUMPULAN MODAL (DI LUAR FORM UTAMA & DI DALAM WADAH X-DATA)      -->
    <!-- ================================================================= -->

    <!-- Modal Sertifikasi Tambah & Edit -->
    <div x-show="openModalSertifikasi" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalSertifikasi = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tambah Riwayat Sertifikasi</h3>
            <form action="<?= site_url('guru/tambah_sertifikasi/' . $guru->id); ?>" method="POST" class="space-y-3" autocomplete="off">
                <div>
                    <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">Jenis Sertifikasi</label>
                    <input type="text" name="jenis_sertifikasi" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">Nomor Sertifikasi</label>
                        <input type="text" name="nomor_sertifikasi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">Tahun</label>
                        <input type="number" name="tahun_sertifikasi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">Bidang Studi</label>
                    <input type="text" name="bidang_studi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">NRG</label>
                        <input type="text" name="nrg" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">Nomor Peserta</label>
                        <input type="text" name="nomor_peserta" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalSertifikasi = false" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openModalEditSertifikasi" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalEditSertifikasi = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Riwayat Sertifikasi</h3>
            <form :action="'<?= site_url('guru/update_sertifikasi/' . $guru->id); ?>/' + editSertifikasi.id" method="POST" class="space-y-3">
                <div><label class="block text-sm mb-1">Jenis Sertifikasi</label><input type="text" name="jenis_sertifikasi" x-model="editSertifikasi.jenis_sertifikasi" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Nomor Sertifikasi</label><input type="text" name="nomor_sertifikasi" x-model="editSertifikasi.nomor_sertifikasi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tahun</label><input type="number" name="tahun_sertifikasi" x-model="editSertifikasi.tahun_sertifikasi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">Bidang Studi</label><input type="text" name="bidang_studi" x-model="editSertifikasi.bidang_studi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">NRG</label><input type="text" name="nrg" x-model="editSertifikasi.nrg" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Nomor Peserta</label><input type="text" name="nomor_peserta" x-model="editSertifikasi.nomor_peserta" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalEditSertifikasi = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pendidikan Tambah & Edit -->
    <div x-show="openModalPendidikan" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalPendidikan = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-xl space-y-4 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tambah Riwayat Pendidikan Formal</h3>
            <form action="<?= site_url('guru/tambah_pendidikan/' . $guru->id); ?>" method="POST" class="space-y-3" autocomplete="off">
                <div><label class="block text-sm mb-1">1. Bidang Studi</label><input type="text" name="bidang_studi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">2. Jenjang Pendidikan</label><input type="text" name="jenjang_pendidikan" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">3. Gelar Akademik</label><input type="text" name="gelar_akademik" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">4. Satuan Pendidikan Formal</label><input type="text" name="nama_sekolah" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">5. Tahun Masuk</label><input type="number" name="tahun_masuk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">6. Tahun Lulus</label><input type="number" name="tahun_lulus" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">7. NIM</label><input type="text" name="nim" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">10. IPK</label><input type="text" name="ipk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">8. Matkul</label><input type="text" name="matkul" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">9. Semester</label><input type="number" name="semester" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalPendidikan = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openModalEditPendidikan" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalEditPendidikan = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-xl space-y-4 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Riwayat Pendidikan Formal</h3>
            <form :action="'<?= site_url('guru/update_pendidikan/' . $guru->id); ?>/' + editPendidikan.id" method="POST" class="space-y-3" autocomplete="off">
                <div><label class="block text-sm mb-1">1. Bidang Studi</label><input type="text" name="bidang_studi" x-model="editPendidikan.bidang_studi" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">2. Jenjang Pendidikan</label><input type="text" name="jenjang_pendidikan" x-model="editPendidikan.jenjang_pendidikan" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">3. Gelar Akademik</label><input type="text" name="gelar_akademik" x-model="editPendidikan.gelar_akademik" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">4. Satuan Pendidikan Formal</label><input type="text" name="nama_sekolah" x-model="editPendidikan.nama_sekolah" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">5. Tahun Masuk</label><input type="number" name="tahun_masuk" x-model="editPendidikan.tahun_masuk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">6. Tahun Lulus</label><input type="number" name="tahun_lulus" x-model="editPendidikan.tahun_lulus" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">7. NIM</label><input type="text" name="nim" x-model="editPendidikan.nim" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">10. IPK</label><input type="text" name="ipk" x-model="editPendidikan.ipk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">8. Matkul</label><input type="text" name="matkul" x-model="editPendidikan.matkul" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">9. Semester</label><input type="number" name="semester" x-model="editPendidikan.semester" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalEditPendidikan = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Anak Tambah & Edit -->
    <div x-show="openModalAnak" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalAnak = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tambah Data Anak</h3>
            <form action="<?= site_url('guru/tambah_anak/' . $guru->id); ?>" method="POST" class="space-y-3" autocomplete="off">
                <div><label class="block text-sm mb-1">Nama Anak</label><input type="text" name="nama" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm mb-1">Status Anak</label>
                        <select name="status" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            <option value="Anak Kandung">Anak Kandung</option>
                            <option value="Anak Tiri">Anak Tiri</option>
                            <option value="Anak Angkat">Anak Angkat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Tempat Lahir</label><input type="text" name="tempat_lahir" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">Jenjang Pendidikan</label><input type="text" name="jenjang_pendidikan" placeholder="SD / SMP / SMA / Belum Sekolah" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Tahun Masuk Sekolah</label><input type="number" name="tahun_masuk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tahun Lulus Sekolah</label><input type="number" name="tahun_lulus" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalAnak = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openModalEditAnak" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalEditAnak = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Data Anak</h3>
            <form :action="'<?= site_url('guru/update_anak/' . $guru->id); ?>/' + editAnak.id" method="POST" class="space-y-3" autocomplete="off">
                <div><label class="block text-sm mb-1">Nama Anak</label><input type="text" name="nama" x-model="editAnak.nama" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm mb-1">Status Anak</label>
                        <select name="status" x-model="editAnak.status" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            <option value="Anak Kandung">Anak Kandung</option>
                            <option value="Anak Tiri">Anak Tiri</option>
                            <option value="Anak Angkat">Anak Angkat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" x-model="editAnak.jenis_kelamin" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Tempat Lahir</label><input type="text" name="tempat_lahir" x-model="editAnak.tempat_lahir" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tanggal Lahir</label><input type="date" name="tanggal_lahir" x-model="editAnak.tanggal_lahir" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">Jenjang Pendidikan</label><input type="text" name="jenjang_pendidikan" x-model="editAnak.jenjang_pendidikan" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Tahun Masuk Sekolah</label><input type="number" name="tahun_masuk" x-model="editAnak.tahun_masuk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tahun Lulus Sekolah</label><input type="number" name="tahun_lulus" x-model="editAnak.tahun_lulus" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalEditAnak = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Diklat Tambah & Edit -->
    <div x-show="openModalDiklat" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalDiklat = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tambah Riwayat Diklat</h3>
            <form action="<?= site_url('guru/tambah_diklat/' . $guru->id); ?>" method="POST" class="space-y-3" autocomplete="off">
                <div><label class="block text-sm mb-1">Jenis Diklat</label><input type="text" name="jenis_diklat" placeholder="Fungsional / Teknis" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div><label class="block text-sm mb-1">Nama Diklat</label><input type="text" name="nama_diklat" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Penyelenggara</label><input type="text" name="penyelenggara" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tahun</label><input type="number" name="tahun" placeholder="2024" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Peran</label><input type="text" name="peran" placeholder="Peserta / Narasumber" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tingkat</label><input type="text" name="tingkat" placeholder="Nasional / Provinsi / Kabupaten" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">Berapa Jam (JP)</label><input type="number" name="berapa_jam" placeholder="32" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalDiklat = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openModalEditDiklat" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalEditDiklat = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Riwayat Diklat</h3>
            <form :action="'<?= site_url('guru/update_diklat/' . $guru->id); ?>/' + editDiklat.id" method="POST" class="space-y-3" autocomplete="off">
                <div><label class="block text-sm mb-1">Jenis Diklat</label><input type="text" name="jenis_diklat" x-model="editDiklat.jenis_diklat" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div><label class="block text-sm mb-1">Nama Diklat</label><input type="text" name="nama_diklat" x-model="editDiklat.nama_diklat" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Penyelenggara</label><input type="text" name="penyelenggara" x-model="editDiklat.penyelenggara" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tahun</label><input type="number" name="tahun" x-model="editDiklat.tahun" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-sm mb-1">Peran</label><input type="text" name="peran" x-model="editDiklat.peran" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                    <div><label class="block text-sm mb-1">Tingkat</label><input type="text" name="tingkat" x-model="editDiklat.tingkat" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                </div>
                <div><label class="block text-sm mb-1">Berapa Jam (JP)</label><input type="number" name="berapa_jam" x-model="editDiklat.berapa_jam" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalEditDiklat = false" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Penugasan -->
    <div x-show="openModalPenugasan" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalPenugasan = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl max-h-[90vh] overflow-y-auto text-xs">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white">Tambah Riwayat Penugasan</h3>
            <form action="<?= site_url('guru/tambah_penugasan/' . $guru->id); ?>" method="POST" class="space-y-3" autocomplete="off">
                <div>
                    <label class="block font-semibold mb-1">Nomor Surat Tugas</label>
                    <input type="text" name="no_surat_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block font-semibold mb-1">Tanggal Surat Tugas</label>
                        <input type="date" name="tanggal_surat_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TMT Tugas</label>
                        <input type="date" name="tmt_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Status Sekolah</label>
                    <select name="status_sekolah" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="Induk">Induk</option>
                        <option value="Tidak Induk">Tidak Induk</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Tugas Tambahan</label>
                    <select name="tugas_tambahan_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Tugas Tambahan --</option>
                        <?php foreach ($tugas_tambahan as $tt): ?>
                            <option value="<?= $tt->id; ?>"><?= $tt->nama_tugas ?? $tt->nama_tugas_tambahan; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Peran</label>
                    <select name="peran_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Peran --</option>
                        <?php foreach ($peran as $p): ?>
                            <option value="<?= $p->id; ?>"><?= $p->nama_peran; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalPenugasan = false" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Penugasan -->
    <div x-show="openModalEditPenugasan" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.stop @click.outside="openModalEditPenugasan = false" class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg space-y-4 shadow-xl max-h-[90vh] overflow-y-auto text-xs">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white">Edit Riwayat Penugasan</h3>
            <form :action="'<?= site_url('guru/update_penugasan/' . $guru->id); ?>/' + editPenugasan.id" method="POST" class="space-y-3" autocomplete="off">
                <div>
                    <label class="block font-semibold mb-1">Nomor Surat Tugas</label>
                    <input type="text" name="no_surat_tugas" x-model="editPenugasan.no_surat_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block font-semibold mb-1">Tanggal Surat Tugas</label>
                        <input type="date" name="tanggal_surat_tugas" x-model="editPenugasan.tanggal_surat_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TMT Tugas</label>
                        <input type="date" name="tmt_tugas" x-model="editPenugasan.tmt_tugas" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Status Sekolah</label>
                    <select name="status_sekolah" x-model="editPenugasan.status_sekolah" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="Induk">Induk</option>
                        <option value="Tidak Induk">Tidak Induk</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Tugas Tambahan</label>
                    <select name="tugas_tambahan_id" x-model="editPenugasan.tugas_tambahan_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Tugas Tambahan --</option>
                        <?php foreach ($tugas_tambahan as $tt): ?>
                            <option value="<?= $tt->id; ?>"><?= $tt->nama_tugas ?? $tt->nama_tugas_tambahan; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Peran</label>
                    <select name="peran_id" x-model="editPenugasan.peran_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Peran --</option>
                        <?php foreach ($peran as $p): ?>
                            <option value="<?= $p->id; ?>"><?= $p->nama_peran; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-3">
                    <button type="button" @click="openModalEditPenugasan = false" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div> <!-- AKHIR WADAH UTAMA X-DATA -->

<!-- SCRIPT JQUERY & AJAX -->
<script>
    // FUNGSI UPLOAD DOKUMEN GURU AJAX
    function uploadDokumenGuru(input, jenisDokumen, guruId) {
        if (input.files && input.files[0]) {
            let formData = new FormData();
            formData.append('berkas', input.files[0]);

            Swal.fire({
                title: 'Mengunggah...',
                text: 'Sedang mengunggah dokumen, mohon tunggu.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '<?= base_url('guru/upload_dokumen_satuan/'); ?>' + guruId + '/' + jenisDokumen,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Unggah',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal menghubungi server atau ukuran file melebihi 500 KB.'
                    });
                }
            });
        }
    }

    // DROPDOWN WILAYAH BERTINGKAT
    $(document).ready(function() {
        let savedDesaId = "<?= isset($guru->wilayah_desa_id) ? $guru->wilayah_desa_id : ''; ?>";
        let initialKecamatanId = $('#kecamatan').val();

        if (initialKecamatanId) {
            $.ajax({
                url: '<?= base_url('guru/get_desa_ajax'); ?>',
                type: 'POST',
                data: {
                    kecamatan_id: initialKecamatanId
                },
                dataType: 'json',
                success: function(response) {
                    let options = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                    $.each(response, function(index, item) {
                        let selected = (item.id == savedDesaId) ? 'selected' : '';
                        options += '<option value="' + item.id + '" ' + selected + '>' + item.nama + '</option>';
                    });
                    $('#desa').html(options);
                }
            });
        }

        $('#provinsi').on('change', function() {
            let provinsi_id = $(this).val();
            $('#kabupaten').html('<option value="">Memuat...</option>');
            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#desa').html('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (provinsi_id) {
                $.ajax({
                    url: '<?= base_url('guru/get_kabupaten_ajax'); ?>',
                    type: 'POST',
                    data: {
                        provinsi_id: provinsi_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                        $.each(response, function(index, item) {
                            options += '<option value="' + item.id + '">' + item.nama + '</option>';
                        });
                        $('#kabupaten').html(options);
                    }
                });
            } else {
                $('#kabupaten').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
            }
        });

        $('#kabupaten').on('change', function() {
            let kabupaten_id = $(this).val();
            $('#kecamatan').html('<option value="">Memuat...</option>');
            $('#desa').html('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kabupaten_id) {
                $.ajax({
                    url: '<?= base_url('guru/get_kecamatan_ajax'); ?>',
                    type: 'POST',
                    data: {
                        kabupaten_id: kabupaten_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        let options = '<option value="">-- Pilih Kecamatan --</option>';
                        $.each(response, function(index, item) {
                            options += '<option value="' + item.id + '">' + item.nama + '</option>';
                        });
                        $('#kecamatan').html(options);
                    }
                });
            } else {
                $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
            }
        });

        $('#kecamatan').on('change', function() {
            let kecamatan_id = $(this).val();
            $('#desa').html('<option value="">Memuat...</option>');

            if (kecamatan_id) {
                $.ajax({
                    url: '<?= base_url('guru/get_desa_ajax'); ?>',
                    type: 'POST',
                    data: {
                        kecamatan_id: kecamatan_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        let options = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                        $.each(response, function(index, item) {
                            options += '<option value="' + item.id + '">' + item.nama + '</option>';
                        });
                        $('#desa').html(options);
                    }
                });
            } else {
                $('#desa').html('<option value="">-- Pilih Desa/Kelurahan --</option>');
            }
        });
    });
</script>