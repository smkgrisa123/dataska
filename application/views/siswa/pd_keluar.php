<div class="space-y-6 p-4 sm:p-6" x-data="{ 
    search: '', 
    filterKategori: 'Semua', 
    filterTahun: 'Semua',
    get totalFiltered() {
        if (!this.$refs.tabelSiswa) return 0;
        let rows = this.$refs.tabelSiswa.querySelectorAll('tr');
        let count = 0;
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            
            let namaSiswa = row.getAttribute('data-nama') || '';
            let katSiswa = row.getAttribute('data-kategori') || '';
            let thnSiswa = row.getAttribute('data-tahun') || '';

            let matchSearch = this.search === '' || namaSiswa.includes(this.search.toLowerCase());
            let matchKat = this.filterKategori === 'Semua' || katSiswa === this.filterKategori;
            let matchThn = this.filterTahun === 'Semua' || String(thnSiswa) === String(this.filterTahun);

            if (matchSearch && matchKat && matchThn) {
                count++;
            }
        });
        return count;
    },
    countKategori(kategori) {
        if (!this.$refs.tabelSiswa) return 0;
        let rows = this.$refs.tabelSiswa.querySelectorAll('tr');
        let count = 0;
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            
            let namaSiswa = row.getAttribute('data-nama') || '';
            let katSiswa = row.getAttribute('data-kategori') || '';
            let thnSiswa = row.getAttribute('data-tahun') || '';

            let matchSearch = this.search === '' || namaSiswa.includes(this.search.toLowerCase());
            let matchKat = katSiswa === kategori; 
            let matchThn = this.filterTahun === 'Semua' || String(thnSiswa) === String(this.filterTahun);

            if (this.filterKategori !== 'Semua' && this.filterKategori !== kategori) return;

            if (matchSearch && matchKat && matchThn) {
                count++;
            }
        });
        return count;
    }
}">

    <!-- HEADER (Tanpa Tombol Tambah) -->
    <div class="bg-gray-900 dark:bg-gray-900 text-white p-6 md:p-8 rounded-2xl shadow-xl">
        <p class="text-xs uppercase tracking-wider text-gray-400 font-medium">Peserta Didik</p>
        <h1 class="text-xl md:text-2xl font-bold text-white mt-1">Siswa Keluar</h1>
        <p class="text-xs sm:text-sm text-gray-400 mt-1">Pantau dan kelola data siswa mutasi, mengundurkan diri, wafat, dan hilang.</p>
    </div>

    <!-- STATISTIK / METRIC CARDS -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase">Total Keluar</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1" x-text="totalFiltered">0</h3>
            </div>
            <div class="p-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl"><i class="fa-solid fa-users"></i></div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <p class="text-xs text-blue-500 font-medium uppercase">Mutasi</p>
                <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1" x-text="countKategori('Mutasi')">0</h3>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl"><i class="fa-solid fa-right-left"></i></div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <p class="text-xs text-amber-500 font-medium uppercase">Undur Diri</p>
                <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1" x-text="countKategori('Mengundurkan Diri')">0</h3>
            </div>
            <div class="p-3 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl"><i class="fa-solid fa-user-xmark"></i></div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <p class="text-xs text-rose-500 font-medium uppercase">Wafat</p>
                <h3 class="text-2xl font-bold text-rose-600 dark:text-rose-400 mt-1" x-text="countKategori('Wafat')">0</h3>
            </div>
            <div class="p-3 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl"><i class="fa-solid fa-dove"></i></div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between col-span-2 md:col-span-1">
            <div>
                <p class="text-xs text-purple-500 font-medium uppercase">Hilang</p>
                <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1" x-text="countKategori('Hilang')">0</h3>
            </div>
            <div class="p-3 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl"><i class="fa-solid fa-circle-question"></i></div>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between gap-4 items-center">
        <!-- Pencarian Nama -->
        <div class="relative w-full md:w-72">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-search"></i></span>
            <input type="text" x-model="search" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-xs sm:text-sm text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <!-- Filter Tahun Ajaran -->
            <div class="w-full sm:w-48">
                <select x-model="filterTahun" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-xs sm:text-sm text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="Semua">Semua Tahun Ajaran</option>
                    <?php if (!empty($tahun_ajaran)): ?>
                        <?php foreach ($tahun_ajaran as $ta): ?>
                            <option value="<?= $ta->id; ?>"><?= $ta->nama . ' (' . $ta->semester . ')'; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Filter Kategori Keluar -->
            <div class="w-full sm:w-48">
                <select x-model="filterKategori" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-xs sm:text-sm text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="Semua">Semua Kategori</option>
                    <option value="Mutasi">Mutasi</option>
                    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                    <option value="Wafat">Wafat</option>
                    <option value="Hilang">Hilang</option>
                </select>
            </div>
        </div>
    </div>

    <!-- TABEL DATA DENGAN SCROLL VERTIKAL & HORIZONTAL -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="max-h-[420px] overflow-y-auto overflow-x-auto w-full">
            <table class="w-full text-left border-collapse text-xs sm:text-sm whitespace-nowrap">
                <thead class="sticky top-0 bg-gray-50 dark:bg-gray-800 z-10">
                    <tr class="text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">NO</th>
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">NAMA SISWA</th>
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">TEMPAT, TANGGAL LAHIR</th>
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">KELAS DITINGGALKAN</th>
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">KELUAR KARENA</th>
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">TANGGAL KELUAR</th>
                        <th class="p-4 font-semibold bg-gray-50 dark:bg-gray-800">TAHUN AJARAN</th>
                        <th class="p-4 font-semibold text-center bg-gray-50 dark:bg-gray-800">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300" x-ref="tabelSiswa">
                    <?php if (!empty($siswa_keluar)): ?>
                        <?php
                        $bulanIndo = [
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember'
                        ];
                        $no = 1;
                        foreach ($siswa_keluar as $row):
                            $nama_siswa = isset($row->nama) ? $row->nama : '-';
                            $tempat_lahir = isset($row->tempat_lahir) ? $row->tempat_lahir : '-';

                            if (!empty($row->tanggal_lahir)) {
                                $tgl = date('d', strtotime($row->tanggal_lahir));
                                $bln = $bulanIndo[date('m', strtotime($row->tanggal_lahir))];
                                $thn = date('Y', strtotime($row->tanggal_lahir));
                                $tanggal_lahir = "$tgl $bln $thn";
                            } else {
                                $tanggal_lahir = '-';
                            }

                            $kelas_ditinggalkan = isset($row->kelas_ditinggalkan) ? $row->kelas_ditinggalkan : '-';
                            $jenis_keluar = isset($row->jenis_keluar) ? $row->jenis_keluar : '-';

                            if (!empty($row->tanggal_keluar)) {
                                $tgl_k = date('d', strtotime($row->tanggal_keluar));
                                $bln_k = $bulanIndo[date('m', strtotime($row->tanggal_keluar))];
                                $thn_k = date('Y', strtotime($row->tanggal_keluar));
                                $tanggal_keluar = "$tgl_k $bln_k $thn_k";
                            } else {
                                $tanggal_keluar = '-';
                            }

                            $tahun_ajaran_id_siswa = isset($row->tahun_ajaran_id) ? $row->tahun_ajaran_id : '';
                            $teks_tahun_ajaran = (isset($row->nama_tahun_ajaran) && !empty($row->nama_tahun_ajaran)) ? $row->nama_tahun_ajaran . ' (' . $row->semester . ')' : '-';
                            $row_id = isset($row->id) ? $row->id : '';
                        ?>
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition"
                                data-nama="<?= strtolower($nama_siswa); ?>"
                                data-kategori="<?= $jenis_keluar; ?>"
                                data-tahun="<?= $tahun_ajaran_id_siswa; ?>"
                                x-show="(search === '' || '<?= strtolower($nama_siswa); ?>'.includes(search.toLowerCase())) && 
            (filterKategori === 'Semua' || '<?= $jenis_keluar; ?>' === filterKategori) && 
            (filterTahun === 'Semua' || '<?= $tahun_ajaran_id_siswa; ?>' === filterTahun)">
                                <td class="p-4"><?= $no++; ?></td>
                                <td class="p-4 font-semibold text-gray-800 dark:text-white"><?= $nama_siswa; ?></td>
                                <td class="p-4"><?= $tempat_lahir . ', ' . $tanggal_lahir; ?></td>
                                <td class="p-4"><span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-medium"><?= $kelas_ditinggalkan; ?></span></td>
                                <td class="p-4">
                                    <?php
                                    $badgeColor = 'bg-blue-50 text-blue-600 border-blue-200';
                                    if ($jenis_keluar == 'Mengundurkan Diri') $badgeColor = 'bg-amber-50 text-amber-600 border-amber-200';
                                    if ($jenis_keluar == 'Wafat') $badgeColor = 'bg-rose-50 text-rose-600 border-rose-200';
                                    if ($jenis_keluar == 'Hilang') $badgeColor = 'bg-purple-50 text-purple-600 border-purple-200';
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium border <?= $badgeColor; ?>"><?= $jenis_keluar; ?></span>
                                </td>
                                <td class="p-4"><?= $tanggal_keluar; ?></td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-medium">
                                        <?= $teks_tahun_ajaran; ?>
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= site_url('siswa/aktifkan_kembali/' . $row_id); ?>" onclick="return confirm('Yakin ingin mengembalikan siswa ini menjadi siswa aktif?')" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition" title="Jadikan Siswa Aktif Kembali">
                                            <i class="fa-solid fa-user-check"></i>
                                        </a>
                                        <a href="<?= site_url('siswa/cetak_ket_keluar/' . $row_id); ?>" target="_blank" class="p-2 bg-sky-50 text-sky-600 hover:bg-sky-100 rounded-lg transition" title="Cetak Surat">
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                        <a href="<?= site_url('siswa/detail/' . (isset($row->siswa_id) ? $row->siswa_id : $row->id)); ?>" class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg transition" title="Detail Data Siswa">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="p-6 text-center text-gray-400">Belum ada data peserta didik keluar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL SISWA LENGKAP -->
<div x-data="{ 
        openModal: false, 
        activeTabDetail: 'pribadi',
        siswaData: {}, 
        dokumenList: [],
        isLoading: false,
        loadDetail(id) {
            this.openModal = true;
            this.isLoading = true;
            this.activeTabDetail = 'pribadi';
            fetch('<?= site_url('siswa/get_detail_json/'); ?>' + id)
                .then(res => res.json())
                .then(data => {
                    this.siswaData = data.siswa || {};
                    this.dokumenList = data.dokumen_list || [];
                    this.isLoading = false;
                })
                .catch(err => {
                    console.error(err);
                    this.isLoading = false;
                });
        }
     }"
    @buka-detail-modal.window="loadDetail($event.detail)"
    x-show="openModal"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4"
    style="display: none;">

    <div @click.away="openModal = false" class="bg-white dark:bg-gray-800 w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col max-h-[92vh]">

        <!-- Header Modal -->
        <div class="px-6 py-4 bg-emerald-600 text-white flex justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-user-gear text-lg"></i>
                <h3 class="text-sm font-bold uppercase tracking-wider">Detail Lengkap Peserta Didik</h3>
            </div>
            <button @click="openModal = false" class="text-white/80 hover:text-white p-1 rounded-lg transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6 overflow-y-auto space-y-6 text-xs sm:text-sm flex-grow">
            <template x-if="isLoading">
                <div class="py-20 text-center text-gray-500 flex flex-col items-center justify-center gap-2">
                    <i class="fa-solid fa-spinner fa-spin text-3xl text-emerald-600"></i>
                    <p>Memuat seluruh data siswa...</p>
                </div>
            </template>

            <template x-if="!isLoading">
                <div class="space-y-6">
                    <!-- NAVIGASI TAB KECIL -->
                    <div class="flex overflow-x-auto gap-2 pb-2 border-b border-gray-200 dark:border-gray-700 no-scrollbar">
                        <button type="button" @click="activeTabDetail = 'pribadi'" :class="activeTabDetail === 'pribadi' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-id-card"></i> Data Pribadi
                        </button>
                        <button type="button" @click="activeTabDetail = 'alamat'" :class="activeTabDetail === 'alamat' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-map-location-dot"></i> Alamat & Kontak
                        </button>
                        <button type="button" @click="activeTabDetail = 'ortu'" :class="activeTabDetail === 'ortu' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-users"></i> Orang Tua / Wali
                        </button>
                        <button type="button" @click="activeTabDetail = 'periodik'" :class="activeTabDetail === 'periodik' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-ruler-combined"></i> Periodik
                        </button>
                        <button type="button" @click="activeTabDetail = 'dokumen'" :class="activeTabDetail === 'dokumen' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-folder-open"></i> Dokumen
                        </button>
                        <button type="button" @click="activeTabDetail = 'lulus'" :class="activeTabDetail === 'lulus' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap"></i> Tamat / Keluar
                        </button>
                        <button type="button" @click="activeTabDetail = 'registrasi'" :class="activeTabDetail === 'registrasi' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-2 rounded-xl font-medium text-xs whitespace-nowrap transition flex items-center gap-1.5">
                            <i class="fa-solid fa-file-pen"></i> Registrasi
                        </button>
                    </div>

                    <!-- KONTEN TAB -->
                    <div x-show="activeTabDetail === 'pribadi'" class="space-y-4">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Informasi Pribadi Siswa</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <div><span class="text-gray-400 block text-[11px]">Nama Lengkap</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.nama ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Nama Panggilan</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.nama_panggilan ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Jenis Kelamin</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.jk ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">NIK</span><span class="font-semibold text-gray-800 dark:text-white font-mono" x-text="siswaData.nik ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">NISN</span><span class="font-semibold text-gray-800 dark:text-white font-mono" x-text="siswaData.nisn ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">No. Induk / NIS</span><span class="font-semibold text-gray-800 dark:text-white font-mono" x-text="siswaData.no_induk ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Tempat, Tanggal Lahir</span><span class="font-semibold text-gray-800 dark:text-white" x-text="(siswaData.tempat_lahir ?? '-') + ', ' + (siswaData.tanggal_lahir ?? '-')"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Agama</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.agama ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Kewarganegaraan</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.kewarganegaraan_siswa ?? '-'"></span></div>
                        </div>
                    </div>

                    <div x-show="activeTabDetail === 'alamat'" class="space-y-4" style="display: none;">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Alamat Tempat Tinggal & Kontak</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <div><span class="text-gray-400 block text-[11px]">Alamat Jalan</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.alamat ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">RT / RW</span><span class="font-semibold text-gray-800 dark:text-white" x-text="(siswaData.rt ?? '-') + ' / ' + (siswaData.rw ?? '-')"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Dusun / Desa</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.dusun ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Nomor Telepon / HP</span><span class="font-semibold text-gray-800 dark:text-white font-mono" x-text="siswaData.no_telp ?? '-'"></span></div>
                        </div>
                    </div>

                    <div x-show="activeTabDetail === 'ortu'" class="space-y-4" style="display: none;">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Data Ayah, Ibu, dan Wali</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 space-y-1">
                                <span class="text-emerald-600 font-bold block text-xs">Ayah Kandung</span>
                                <p><strong class="text-gray-400">Nama:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.nama_ayah ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Pendidikan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.pendidikan_ayah ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Pekerjaan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.pekerjaan_ayah ?? '-'"></span></p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 space-y-1">
                                <span class="text-emerald-600 font-bold block text-xs">Ibu Kandung</span>
                                <p><strong class="text-gray-400">Nama:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.nama_ibu ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Pendidikan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.pendidikan_ibu ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Pekerjaan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.pekerjaan_ibu ?? '-'"></span></p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 space-y-1">
                                <span class="text-emerald-600 font-bold block text-xs">Wali (Jika Ada)</span>
                                <p><strong class="text-gray-400">Nama:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.nama_wali ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Pekerjaan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.pekerjaan_wali ?? '-'"></span></p>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTabDetail === 'periodik'" class="space-y-4" style="display: none;">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Data Periodik (Tinggi, Berat, Jarak)</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <div><span class="text-gray-400 block text-[11px]">Tinggi Badan</span><span class="font-semibold text-gray-800 dark:text-white" x-text="(siswaData.tinggi_badan ?? '-') + ' cm'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Berat Badan</span><span class="font-semibold text-gray-800 dark:text-white" x-text="(siswaData.berat_badan ?? '-') + ' kg'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Jarak ke Sekolah</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.jarak_ke_sekolah ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Waktu Tempuh</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.waktu_tempuh ?? '-'"></span></div>
                        </div>
                    </div>

                    <div x-show="activeTabDetail === 'dokumen'" class="space-y-4" style="display: none;">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Berkas / Dokumen Terunggah</h4>
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <template x-if="dokumenList.length === 0">
                                <p class="text-gray-400 italic text-center py-4">Belum ada dokumen yang diunggah.</p>
                            </template>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <template x-for="doc in dokumenList">
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                                        <div>
                                            <p class="font-semibold uppercase text-[11px] text-indigo-600" x-text="doc.jenis_dokumen"></p>
                                            <p class="text-gray-700 dark:text-gray-300 truncate max-w-[200px]" x-text="doc.nama_file"></p>
                                        </div>
                                        <a :href="'<?= base_url('uploads/dokumen/'); ?>' + doc.nama_file" target="_blank" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-xs font-medium">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTabDetail === 'lulus'" class="space-y-4" style="display: none;">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Data Ijazah & Penelusuran Tamatan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 space-y-2">
                                <span class="font-bold text-emerald-600 block text-xs">Ijazah</span>
                                <p><strong class="text-gray-400">Nomor Ijazah:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.nomor_ijazah ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Tanggal Ijazah:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.tanggal_ijazah ?? '-'"></span></p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 space-y-2">
                                <span class="font-bold text-emerald-600 block text-xs">Tracer Study (Penelusuran)</span>
                                <p><strong class="text-gray-400">Melanjutkan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.melanjutkan_ke ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Bekerja di:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.bekerja_di ?? '-'"></span></p>
                                <p><strong class="text-gray-400">Perusahaan:</strong> <span class="text-gray-800 dark:text-white" x-text="siswaData.nama_perusahaan ?? '-'"></span></p>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTabDetail === 'registrasi'" class="space-y-4" style="display: none;">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 text-xs uppercase tracking-wider">Data Registrasi Masuk</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <div><span class="text-gray-400 block text-[11px]">Jenis Pendaftaran</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.jenis_pendaftaran ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Tanggal Masuk</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.tanggal_masuk ?? '-'"></span></div>
                            <div><span class="text-gray-400 block text-[11px]">Sekolah Asal</span><span class="font-semibold text-gray-800 dark:text-white" x-text="siswaData.sekolah_asal ?? '-'"></span></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-end flex-shrink-0">
            <button @click="openModal = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-medium transition">
                Tutup
            </button>
        </div>
    </div>
</div>