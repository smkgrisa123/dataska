<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6"
    x-data="{
         search: '',
         showAddModal: false,
         showEditModal: false,
         showDeleteModal: false,
         deleteUrl: '',
         editId: '',
         editKode: '',
         editBidang: '',
         editProgram: '',
         editKonsentrasi: '',
         editNama: '',
         editStatus: 'Aktif',
         openEdit(id, kode, bidang, program, konsentrasi, nama, status) {
             this.editId = id;
             this.editKode = kode;
             this.editBidang = bidang;
             this.editProgram = program;
             this.editKonsentrasi = konsentrasi;
             this.editNama = nama;
             this.editStatus = status;
             this.showEditModal = true;
         },
         openDelete(url) {
             this.deleteUrl = url;
             this.showDeleteModal = true;
         }
     }">

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- HEADER BANNER -->
        <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <nav class="text-xs text-gray-400 mb-1 flex items-center space-x-2">
                    <span>Beranda</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span>Data Master</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-white font-medium">Kompetensi</span>
                </nav>
                <h1 class="text-xl font-bold tracking-tight">Manajemen Kompetensi</h1>
                <p class="text-xs text-gray-400">Pantau dan kelola data bidang, program, dan konsentrasi keahlian.</p>
            </div>
            <button @click="showAddModal = true" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow transition-colors">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Kompetensi
            </button>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Data</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1"><?= !empty($kompetensi) ? count($kompetensi) : 0; ?> Konsentrasi</h3>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-3 rounded-xl">
                    <i class="fa-solid fa-database text-lg"></i>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Status Aktif</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                        <?= !empty($kompetensi) ? count(array_filter($kompetensi, function ($r) {
                            return $r->status == 'Aktif';
                        })) : 0; ?> Aktif
                    </h3>
                </div>
                <div class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 p-3 rounded-xl">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                </div>
            </div>
        </div>

        <!-- SEARCH BAR -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative w-full md:w-96">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-xs text-gray-400"></i>
                <input type="text" x-model="search" placeholder="Cari bidang, program, konsentrasi, nama, atau kode..." class="w-full pl-9 pr-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3 px-4 font-semibold">NO</th>
                            <th class="py-3 px-4 font-semibold">BIDANG KEAHLIAN</th>
                            <th class="py-3 px-4 font-semibold">PROGRAM KEAHLIAN</th>
                            <th class="py-3 px-4 font-semibold">KONSENTRASI KEAHLIAN</th>
                            <th class="py-3 px-4 font-semibold">NAMA</th>
                            <th class="py-3 px-4 font-semibold">KODE</th>
                            <th class="py-3 px-4 font-semibold">STATUS</th>
                            <th class="py-3 px-4 font-semibold text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                        <?php if (!empty($kompetensi)): ?>
                            <?php $no = 1;
                            foreach ($kompetensi as $row):
                                $namaTampil = !empty($row->nama) ? $row->nama : ($row->konsentrasi_keahlian ?? '');
                            ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors"
                                    x-show="search === '' || '<?= strtolower(($row->bidang_keahlian ?? '') . ' ' . ($row->program_keahlian ?? '') . ' ' . ($row->konsentrasi_keahlian ?? '') . ' ' . ($namaTampil) . ' ' . ($row->kode ?? '')); ?>'.includes(search.toLowerCase())">
                                    <td class="py-3 px-4"><?= $no++; ?></td>
                                    <td class="py-3 px-4"><?= html_escape($row->bidang_keahlian ?: '-'); ?></td>
                                    <td class="py-3 px-4"><?= html_escape($row->program_keahlian ?: '-'); ?></td>
                                    <td class="py-3 px-4 font-semibold"><?= html_escape($row->konsentrasi_keahlian ?: '-'); ?></td>
                                    <td class="py-3 px-4 font-bold text-gray-900 dark:text-white"><?= html_escape($namaTampil ?: '-'); ?></td>
                                    <td class="py-3 px-4 font-mono font-medium"><?= html_escape($row->kode ?: '-'); ?></td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold <?= ($row->status == 'Aktif') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'; ?>">
                                            <?= html_escape($row->status); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center space-x-2">
                                        <button @click="openEdit('<?= $row->id; ?>', '<?= htmlspecialchars($row->kode ?? '', ENT_QUOTES); ?>', '<?= htmlspecialchars($row->bidang_keahlian ?? '', ENT_QUOTES); ?>', '<?= htmlspecialchars($row->program_keahlian ?? '', ENT_QUOTES); ?>', '<?= htmlspecialchars($row->konsentrasi_keahlian ?? '', ENT_QUOTES); ?>', '<?= htmlspecialchars($namaTampil, ENT_QUOTES); ?>', '<?= htmlspecialchars($row->status ?? 'Aktif', ENT_QUOTES); ?>')" class="inline-flex items-center px-2.5 py-1.5 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button @click.prevent="openDelete('<?= base_url('kompetensi/hapus/' . $row->id) ?>')" class="inline-flex items-center px-2.5 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="py-6 text-center text-gray-400">Belum ada data kompetensi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- MODAL TAMBAH -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-transition.opacity style="display: none;">
        <div @click.away="showAddModal = false" class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
                <h3 class="font-bold text-sm text-gray-800 dark:text-white">Tambah Kompetensi Baru</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="<?= base_url('kompetensi/simpan') ?>" method="POST" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Bidang Keahlian</label>
                    <input type="text" name="bidang_keahlian" placeholder="Contoh: Teknologi Manufaktur dan Rekayasa" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Program Keahlian</label>
                    <input type="text" name="program_keahlian" placeholder="Contoh: Teknik Otomotif" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Konsentrasi Keahlian</label>
                    <input type="text" name="konsentrasi_keahlian" placeholder="Contoh: Teknik Alat Berat" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Nama Kompetensi / Jurusan</label>
                    <input type="text" name="nama" required placeholder="Contoh: Manajemen Perkantoran" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Kode</label>
                    <input type="text" name="kode" required placeholder="Contoh: TAB" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-transition.opacity style="display: none;">
        <div @click.away="showEditModal = false" class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
                <h3 class="font-bold text-sm text-gray-800 dark:text-white">Edit Kompetensi</h3>
                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form :action="'<?= base_url('kompetensi/update/') ?>' + editId" method="POST" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Bidang Keahlian</label>
                    <input type="text" name="bidang_keahlian" x-model="editBidang" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Program Keahlian</label>
                    <input type="text" name="program_keahlian" x-model="editProgram" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Konsentrasi Keahlian</label>
                    <input type="text" name="konsentrasi_keahlian" x-model="editKonsentrasi" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Nama Kompetensi / Jurusan</label>
                    <input type="text" name="nama" x-model="editNama" required class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Kode</label>
                    <input type="text" name="kode" x-model="editKode" required class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" x-model="editStatus" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-transition.opacity style="display: none;">
        <div @click.away="showDeleteModal = false" class="bg-white dark:bg-gray-800 w-full max-w-sm rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 text-center space-y-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 mx-auto flex items-center justify-center text-lg">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h3 class="font-bold text-sm text-gray-800 dark:text-white">Hapus Data Kompetensi?</h3>
                <p class="text-xs text-gray-400 mt-1">Data yang dihapus tidak dapat dikembalikan lagi.</p>
            </div>
            <div class="flex justify-center space-x-2 pt-2">
                <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-medium text-xs">Batal</button>
                <a :href="deleteUrl" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium text-xs transition-colors inline-flex items-center">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <?php if ($this->session->flashdata('success')): ?>
        <div x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            class="fixed top-6 right-6 z-[9999] flex items-center bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-3 rounded-2xl shadow-2xl space-x-3 border border-gray-800 dark:border-gray-200 text-xs" style="display: none;">
            <div class="w-7 h-7 rounded-full bg-green-500/20 text-green-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check text-xs"></i>
            </div>
            <div class="pr-2">
                <p class="font-bold text-sm">Berhasil!</p>
                <p class="text-gray-400 dark:text-gray-600"><?= $this->session->flashdata('success'); ?></p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-white dark:hover:text-gray-900 ml-2">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    <?php endif; ?>

</main>