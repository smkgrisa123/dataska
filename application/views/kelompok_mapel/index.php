<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6" x-data="kelompokMapelApp()">
    <div class="w-full mx-auto">

        <!-- Header Banner Bergaya Navy (Sesuai Standar DATASKA) -->
        <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-2xl shadow-lg p-6 mb-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-slate-800">
            <div>
                <div class="flex items-center space-x-2 text-xs text-blue-300 mb-2 font-medium">
                    <a href="<?= site_url('dashboard'); ?>" class="hover:underline">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Data Kelompok Mapel</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📚</span>
                    <h1 class="text-xl font-bold tracking-wide">Data Master Kelompok Mapel</h1>
                </div>
                <p class="text-xs text-slate-300 mt-1 max-w-xl">
                    Kelola referensi nama kelompok mata pelajaran (contoh: Kelompok A (Umum), Kelompok B (Umum), Kelompok C (Peminatan)).
                </p>
            </div>

            <button @click="openModalTambah()" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-colors shadow-md shrink-0 cursor-pointer">
                <span class="mr-2 text-sm font-bold">+</span> Tambah Kelompok Mapel
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-4">
            <div class="overflow-x-auto">
                <table id="tabelKelompokMapel" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3 px-4 w-16 font-semibold">No</th>
                            <th class="py-3 px-4 font-semibold">Kelompok Mapel</th>
                            <th class="py-3 px-4 w-32 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-gray-700 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if (!empty($kelompok_mapel)): ?>
                            <?php $no = 1;
                            foreach ($kelompok_mapel as $km): ?>
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-3.5 px-4 font-medium"><?= $no++; ?></td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white"><?= html_escape($km->kelompok_mapel); ?></td>
                                    <td class="py-3.5 px-4 text-center">
                                        <div class="inline-flex items-center gap-1.5">
                                            <button @click="editData(<?= $km->id_kelompok; ?>)" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-medium transition flex items-center gap-1 cursor-pointer">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Ubah
                                            </button>
                                            <button @click="konfirmasiHapus('<?= site_url('kelompok_mapel/hapus/' . $km->id_kelompok); ?>')" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-medium transition flex items-center gap-1 cursor-pointer">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="py-6 px-4 text-center text-gray-400">Belum ada data kelompok mapel.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah/Ubah Kelompok Mapel -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div @click.away="isModalOpen = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-sm w-full p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                <h3 class="text-base font-bold text-gray-800 dark:text-white" x-text="modalTitle"></h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 text-sm cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="<?= site_url('kelompok_mapel/simpan'); ?>" method="POST" autocomplete="off" class="space-y-4">
                <input type="hidden" name="id_kelompok" x-model="formData.id_kelompok">

                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Kelompok Mapel</label>
                    <input type="text" name="kelompok_mapel" x-model="formData.kelompok_mapel" required placeholder="Contoh: Kelompok A (Umum)" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
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

        function kelompokMapelApp() {
            return {
                isModalOpen: false,
                modalTitle: 'Tambah Kelompok Mapel',
                formData: {
                    id_kelompok: '',
                    kelompok_mapel: ''
                },
                openModalTambah() {
                    this.modalTitle = 'Tambah Kelompok Mapel';
                    this.formData = {
                        id_kelompok: '',
                        kelompok_mapel: ''
                    };
                    this.isModalOpen = true;
                },
                editData(id) {
                    fetch(`<?= site_url('kelompok_mapel/get_by_id/') ?>${id}`)
                        .then(res => res.json())
                        .then(data => {
                            this.modalTitle = 'Ubah Kelompok Mapel';
                            this.formData = {
                                id_kelompok: data.id_kelompok,
                                kelompok_mapel: data.kelompok_mapel
                            };
                            this.isModalOpen = true;
                        });
                },
                konfirmasiHapus(urlDelete) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data kelompok mapel yang dihapus tidak dapat dikembalikan!",
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