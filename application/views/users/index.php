<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6"
    x-data="{ showAddModal: false, showEditModal: false, showDeleteModal: false, deleteId: '', deleteNama: '', editId: '', editNama: '', editUsername: '', editRole: '', editStatus: '', addRole: '' }">

    <!-- Toast Container Mengapung di Pojok Kanan Atas -->
    <div class="fixed top-20 right-6 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none">
        <?php if ($this->session->flashdata('success')): ?>
            <div id="toastAlert" class="pointer-events-auto flex items-center gap-3 p-4 rounded-xl bg-green-50 border-l-4 border-green-500 text-green-800 text-xs font-semibold shadow-lg transition-all duration-300 animate-slide-in">
                <span class="text-base">✅</span>
                <div class="flex-1">
                    <strong>Berhasil!</strong><br>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div id="toastAlert" class="pointer-events-auto flex items-center gap-3 p-4 rounded-xl bg-red-50 border-l-4 border-red-500 text-red-800 text-xs font-semibold shadow-lg transition-all duration-300 animate-slide-in">
                <span class="text-base">⚠️</span>
                <div class="flex-1">
                    <strong>Peringatan!</strong><br>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="w-full mx-auto">

        <!-- Header Banner Bergaya Navy -->
        <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-2xl shadow-lg p-6 mb-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-slate-800">
            <div>
                <!-- Breadcrumb -->
                <div class="flex items-center space-x-2 text-xs text-blue-300 mb-2 font-medium">
                    <a href="<?= site_url('dashboard'); ?>" class="hover:underline">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Hak Akses</span>
                </div>

                <!-- Judul & Ikon -->
                <div class="flex items-center gap-3">
                    <span class="text-2xl">👥</span>
                    <h1 class="text-xl font-bold tracking-wide">Data Hak Akses Pengguna</h1>
                </div>

                <!-- Deskripsi -->
                <p class="text-xs text-slate-300 mt-1 max-w-xl">
                    Kelola data pengguna, username, password, dan peran hak akses aplikasi secara terintegrasi.
                </p>
            </div>

            <!-- Tombol Tambah (Memicu Modal) -->
            <button @click="showAddModal = true" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-colors shadow-md shrink-0 cursor-pointer">
                <span class="mr-2 text-sm font-bold">+</span> Tambah Pengguna
            </button>
        </div>

        <!-- Tabel Data Pengguna (Melebar Penuh) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3.5 px-6 font-semibold">No</th>
                            <th class="py-3.5 px-6 font-semibold">Nama Lengkap</th>
                            <th class="py-3.5 px-6 font-semibold">Username</th>
                            <th class="py-3.5 px-6 font-semibold">Peran (Role)</th>
                            <th class="py-3.5 px-6 font-semibold">Status</th>
                            <th class="py-3.5 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-xs text-gray-700 dark:text-gray-300">
                        <?php $no = 1;
                        foreach ($users as $u): ?>
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="py-4 px-6 font-medium"><?= $no++; ?></td>
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white"><?= html_escape($u->nama); ?></td>
                                <td class="py-4 px-6 font-mono text-gray-600 dark:text-gray-400"><?= html_escape($u->username); ?></td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase 
                                    <?= ($u->role == 'administrator') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'; ?>">
                                        <?= str_replace('_', ' ', $u->role); ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold 
                                    <?= ($u->status == 'Aktif') ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'; ?>">
                                        <?= $u->status; ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button @click="showEditModal = true; editId = '<?= $u->id; ?>'; editNama = '<?= html_escape($u->nama); ?>'; editUsername = '<?= html_escape($u->username); ?>'; editRole = '<?= $u->role; ?>'; editStatus = '<?= $u->status; ?>';"
                                        class="inline-flex items-center px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition-colors font-medium text-[11px] cursor-pointer" title="Edit">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>
                                    <!-- Tombol Hapus (Memicu Modal Konfirmasi) -->
                                    <button @click="showDeleteModal = true; deleteId = '<?= $u->id; ?>'; deleteNama = '<?= html_escape($u->nama); ?>';"
                                        class="inline-flex items-center px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg transition-colors font-medium text-[11px] cursor-pointer" title="Hapus">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Belum ada data pengguna yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= MODAL TAMBAH PENGGUNA ================= -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div @click.away="showAddModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                <h3 class="text-base font-bold text-gray-800 dark:text-white">Tambah Pengguna Baru</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 text-sm cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="<?= base_url('users/simpan'); ?>" method="post" autocomplete="off" class="space-y-4">

                <!-- 1. PERAN -->
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Peran (Role Hak Akses)</label>
                    <select name="role" x-model="addRole" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                        <option value="">-- Pilih Peran --</option>
                        <?php if (!empty($list_peran)): ?>
                            <?php foreach ($list_peran as $p): ?>
                                <?php $role_value = strtolower(str_replace(' ', '_', $p->nama_peran)); ?>
                                <option value="<?= $role_value; ?>"><?= html_escape($p->nama_peran); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- FORM DINAMIS: Wali Kelas -->
                <div x-show="addRole === 'wali_kelas'" x-transition class="space-y-1">
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Pilih Rombel / Kelas Bimbingan</label>
                    <select name="rombel_id" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Kelas Rombel --</option>
                        <?php if (!empty($master_rombel)): ?>
                            <?php foreach ($master_rombel as $rombel): ?>
                                <option value="<?= $rombel->id; ?>"><?= html_escape($rombel->nama_kelas); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- 2. NAMA PTK (Difilter Berdasarkan Peran yang Dipilih) -->
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Nama PTK / Lengkap</label>
                    <select name="nama" id="select_nama" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                        <option value="">-- Pilih PTK dari Data Penugasan --</option>
                        <?php if (!empty($list_ptk)): ?>
                            <?php foreach ($list_ptk as $ptk): ?>
                                <?php $ptk_role_slug = strtolower(str_replace(' ', '_', $ptk->nama_peran)); ?>
                                <option value="<?= html_escape($ptk->nama_lengkap); ?>"
                                    x-show="addRole === '<?= $ptk_role_slug; ?>'"
                                    style="display: none;">
                                    <?= html_escape($ptk->nama_lengkap); ?> (<?= html_escape($ptk->nama_peran); ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- 3. USERNAME -->
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Username</label>
                    <input type="text" name="username" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- 4. PASSWORD -->
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" name="password" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- ================= MODAL EDIT PENGGUNA ================= -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div @click.away="showEditModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                <h3 class="text-base font-bold text-gray-800 dark:text-white">Edit Pengguna</h3>
                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 text-sm cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form :action="'<?= site_url('users/edit/'); ?>' + editId" method="POST" autocomplete="off" class="space-y-4">
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="editNama" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Username</label>
                    <input type="text" name="username" x-model="editUsername" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 cursor-not-allowed" readonly title="Username tidak dapat diubah">
                </div>
                <div>
                    <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Password Baru <span class="text-[10px] text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Peran (Role)</label>
                        <select name="role" x-model="editRole" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                            <option value="administrator">Administrator</option>
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="pembina_osis">Pembina OSIS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold text-gray-700 dark:text-gray-300">Status Akun</label>
                        <select name="status" x-model="editStatus" class="w-full h-10 px-3 border border-gray-200 rounded-xl text-xs bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL KONFIRMASI HAPUS ================= -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div @click.away="showDeleteModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-sm w-full p-6 border border-gray-100 dark:border-gray-700 text-center">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-base font-bold text-gray-800 dark:text-white mb-1">Konfirmasi Hapus</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">
                Apakah Anda yakin ingin menghapus pengguna <strong class="text-gray-700 dark:text-gray-200" x-text="deleteNama"></strong>? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex justify-center space-x-3">
                <button type="button" @click="showDeleteModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-xs font-semibold hover:bg-gray-50 cursor-pointer w-full">Batal</button>
                <a :href="'<?= site_url('users/hapus/'); ?>' + deleteId" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-sm transition-colors flex items-center justify-center w-full">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Otomatis Menghilangkan Toast -->
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toastAlert');
            if (toast) {
                toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
</main>