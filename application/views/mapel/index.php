<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6" x-data="mapelApp()">
    <div class="w-full mx-auto">

        <!-- Header Banner Bergaya Navy (Sesuai Standar DATASKA) -->
        <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-2xl shadow-lg p-6 mb-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-slate-800">
            <div>
                <div class="flex items-center space-x-2 text-xs text-blue-300 mb-2 font-medium">
                    <a href="<?= site_url('dashboard'); ?>" class="hover:underline">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Data Mata Pelajaran</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📖</span>
                    <h1 class="text-xl font-bold tracking-wide">Data Master Mata Pelajaran</h1>
                </div>
                <p class="text-xs text-slate-300 mt-1 max-w-xl">
                    Kelola nama mata pelajaran, kode mapel, kelompok mapel, serta cakupan jurusannya.
                </p>
            </div>

            <button @click="openModalTambah()" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-colors shadow-md shrink-0 cursor-pointer">
                <span class="mr-2 text-sm font-bold">+</span> Tambah Mapel
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-4">
            <div class="overflow-x-auto">
                <table id="tabelMapel" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3 px-4 w-16 font-semibold">No</th>
                            <th class="py-3 px-4 font-semibold">Nama Mata Pelajaran</th>
                            <th class="py-3 px-4 font-semibold">Kode</th>
                            <th class="py-3 px-4 font-semibold">Kelompok Mapel</th>
                            <th class="py-3 px-4 font-semibold">Jurusan</th>
                            <th class="py-3 px-4 w-32 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-gray-700 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if (!empty($mapel)): ?>
                            <?php $no = 1;
                            foreach ($mapel as $m): ?>
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-3.5 px-4 font-medium"><?= $no++; ?></td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white"><?= html_escape($m->nama); ?></td>
                                    <td class="py-3.5 px-4 font-mono text-gray-600 dark:text-gray-300"><?= html_escape($m->kode ?? '-'); ?></td>
                                    <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300"><?= html_escape($m->kelompok_mapel ?? '-'); ?></td>
                                    <td class="py-3.5 px-4">
                                        <?php if (!empty($m->kompetensi_id) && !empty($m->nama_jurusan)): ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                                <?= html_escape($m->nama_jurusan); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                                Semua Jurusan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <div class="inline-flex items-center gap-1.5">
                                            <button @click="editData(<?= $m->id; ?>)" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-medium transition flex items-center gap-1 cursor-pointer">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Ubah
                                            </button>
                                            <button @click="konfirmasiHapus('<?= site_url('mapel/hapus/' . $m->id); ?>')" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-medium transition flex items-center gap-1 cursor-pointer">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-center text-gray-400">Belum ada data mata pelajaran.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah/Ubah Mapel -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div @click.away="isModalOpen = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-sm w-full p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                <h3 class="text-base font-bold text-gray-800 dark:text-white" x-text="modalTitle"></h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 text-sm cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="<?= site_url('mapel/simpan'); ?>" method="POST" autocomplete="off" class="space-y-4">
                <input type="hidden" name="id" x-model="formData.id">

                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Nama Mata Pelajaran</label>
                    <input type="text" name="nama" x-model="formData.nama" required placeholder="Contoh: Pengetikan" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Kode Mapel</label>
                    <input type="text" name="kode" x-model="formData.kode" required placeholder="Contoh: KETIK" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500 uppercase">
                </div>

                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Kelompok Mapel</label>
                    <select name="kelompok_mapel" x-model="formData.kelompok_mapel" required class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Kelompok Mapel --</option>
                        <?php foreach ($kelompok_mapel as $km): ?>
                            <?php $val = trim($km->kelompok_mapel); ?>
                            <option value="<?= html_escape($val); ?>"><?= html_escape($val); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Jurusan / Kejuruan</label>
                    <select name="kompetensi_id" x-model="formData.kompetensi_id" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        <option value="">-- Semua Jurusan --</option>
                        <?php foreach ($kompetensi as $k): ?>
                            <option value="<?= $k->id; ?>"><?= html_escape($k->nama); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" @click="isModalOpen = false" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script SweetAlert & Alpine Handler -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($this->session->flashdata('success')): ?>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: '<?= $this->session->flashdata('success'); ?>'
                });
            <?php endif; ?>
        });

        function mapelApp() {
            return {
                isModalOpen: false,
                modalTitle: 'Tambah Mata Pelajaran',
                formData: {
                    id: '',
                    nama: '',
                    kode: '',
                    kelompok_mapel: '',
                    kompetensi_id: ''
                },
                openModalTambah() {
                    this.modalTitle = 'Tambah Mata Pelajaran';
                    this.formData = {
                        id: '',
                        nama: '',
                        kode: '',
                        kelompok_mapel: '',
                        kompetensi_id: ''
                    };
                    this.isModalOpen = true;
                },
                editData(id) {
                    fetch(`<?= site_url('mapel/get_by_id/') ?>${id}`)
                        .then(res => res.json())
                        .then(data => {
                            const selectEl = document.querySelector('select[name="kelompok_mapel"]');
                            const val = (data.kelompok_mapel || '').trim();

                            if (val && selectEl) {
                                const exists = Array.from(selectEl.options).some(opt => opt.value === val);
                                if (!exists) {
                                    selectEl.add(new Option(val, val, true, true));
                                }
                            }

                            this.modalTitle = 'Ubah Mata Pelajaran';
                            this.formData = {
                                id: data.id,
                                nama: data.nama,
                                kode: data.kode || '',
                                kelompok_mapel: val,
                                kompetensi_id: data.kompetensi_id ? String(data.kompetensi_id) : ''
                            };
                            this.isModalOpen = true;
                        });
                },
                konfirmasiHapus(urlDelete) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data mata pelajaran yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = urlDelete;
                        }
                    })
                }
            }
        }
    </script>
</main>