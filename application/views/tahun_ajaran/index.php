<!-- Load CSS & JS DataTables + SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="w-full px-6 py-6 space-y-6 pb-24" x-data="tahunAjaranApp()">

    <!-- Header / Banner Utama -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-sky-950 text-white rounded-2xl p-6 shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-slate-700/50">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-2">
                <a href="<?= base_url('dashboard'); ?>" class="hover:underline text-sky-400">Dashboard</a>
                <span>/</span>
                <span class="text-white font-medium">Manajemen Tahun Ajaran</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-sky-400"></i> Data Tahun Ajaran & Semester
            </h1>
            <p class="text-xs text-slate-300 mt-1">Kelola data tahun ajaran akademik dan status keaktifan sistem sekolah.</p>
        </div>
        <div>
            <button @click="openModalTambah()" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-circle-plus"></i> Tambah Tahun Ajaran
            </button>
        </div>
    </div>

    <!-- Tabel Data Tahun Ajaran -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="overflow-x-auto">
            <table id="tabelTahunAjaran" class="w-full text-left border-collapse stripe hover">
                <thead>
                    <tr class="border-b dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Tahun Ajaran</th>
                        <th class="py-3 px-4">Semester</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-700 dark:text-gray-200 divide-y divide-gray-100 dark:divide-gray-700/50">
                    <?php $no = 1;
                    foreach ($tahun_ajaran as $row): ?>
                        <tr class="hover:bg-sky-50/40 dark:hover:bg-gray-700/30 transition">
                            <td class="py-3.5 px-4 text-center"><?= $no++; ?></td>
                            <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white"><?= $row->nama; ?></td>
                            <td class="py-3.5 px-4"><?= $row->semester; ?></td>
                            <td class="py-3.5 px-4 text-center">
                                <?php if ($row->status == 'Aktif'): ?>
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 rounded-full font-bold text-[10px]">Aktif</span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-full font-bold text-[10px]">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-center space-x-1">
                                <button @click="openModalEdit(<?= htmlspecialchars(json_encode($row)); ?>)" class="px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded shadow transition text-[11px]">
                                    Edit
                                </button>
                                <button onclick="konfirmasiHapus(<?= $row->id; ?>, '<?= $row->nama; ?>')" class="px-2.5 py-1 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded shadow transition text-[11px]">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM (TAMBAH / EDIT) -->
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display: none;">
        <div @click.away="showModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 space-y-5 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center border-b pb-3 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white" x-text="isEdit ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran Baru'"></h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Tahun Ajaran</label>
                    <input type="text" name="nama" x-model="formData.nama" placeholder="Contoh: 2025/2026" required class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Semester</label>
                    <select name="semester" x-model="formData.semester" required class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Keaktifan</label>
                    <select name="status" x-model="formData.status" required class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById('tabelTahunAjaran')) {
            $('#tabelTahunAjaran').DataTable({
                "language": {
                    "search": "Cari Tahun Ajaran:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "zeroRecords": "Data tidak ditemukan",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10
            });
        }

        // SweetAlert2 Toast Notifikasi Sukses
        <?php if ($this->session->flashdata('success')): ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '<?= $this->session->flashdata('success'); ?>',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
        <?php endif; ?>
    });

    function tahunAjaranApp() {
        return {
            showModal: false,
            isEdit: false,
            formAction: '',
            formData: {
                nama: '',
                semester: '',
                status: 'Aktif'
            },
            openModalTambah() {
                this.isEdit = false;
                this.formAction = '<?= base_url('tahunajaran/tambah'); ?>';
                this.formData = {
                    nama: '',
                    semester: '',
                    status: 'Aktif'
                };
                this.showModal = true;
            },
            openModalEdit(row) {
                this.isEdit = true;
                this.formAction = '<?= base_url('tahunajaran/update/'); ?>' + row.id;
                this.formData = {
                    nama: row.nama,
                    semester: row.semester,
                    status: row.status
                };
                this.showModal = true;
            }
        }
    }

    function konfirmasiHapus(id, nama) {
        Swal.fire({
            title: 'Hapus Tahun Ajaran?',
            text: `Apakah Anda yakin ingin menghapus data tahun ajaran ${nama}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('tahunajaran/hapus/'); ?>" + id;
            }
        });
    }
</script>