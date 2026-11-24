<!-- Load CSS & JS DataTables + SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.25rem 0.5rem;
        outline: none;
        font-size: 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0284c7 !important;
        color: white !important;
        border: none !important;
        border-radius: 0.375rem;
    }
</style>

<div class="container mx-auto px-4 py-6 space-y-6" x-data="rombelApp()">

    <!-- Banner Header ala Manajemen Kompetensi -->
    <div class="bg-slate-900 text-white rounded-2xl p-6 shadow-md flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <!-- Breadcrumbs -->
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-2">
                <span class="text-white font-medium">Rombongan Belajar</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Manajemen Rombel</h1>
            <p class="text-xs text-slate-400 mt-1">Pantau dan kelola data kelas aktif, tingkat, konsentrasi keahlian, dan wali kelas.</p>
        </div>
    </div>

    <!-- Kartu Statistik / Ringkasan Data -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Card 1: Total Data -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 tracking-wider uppercase">TOTAL DATA</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                    <?= count($rombel); ?> Rombel
                </h3>
            </div>
            <div class="w-12 h-12 bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-database"></i>
            </div>
        </div>

        <!-- Card 2: Status Aktif -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 tracking-wider uppercase">STATUS TAHUN AJARAN</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                    Aktif / Normal
                </h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- Toolbar Tombol Aksi (Checkboxes & Actions) -->
    <div class="bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-wrap items-center gap-2">
        <button class="px-3 py-1.5 bg-sky-500 text-white rounded text-xs flex items-center shadow-sm hover:bg-sky-600 transition">
            <i class="fa-solid fa-circle-question"></i>
        </button>
        <div class="h-5 w-[1px] bg-gray-300 dark:bg-gray-600 mx-1"></div>

        <!-- Tombol Tambah -->
        <button @click="openModalTambah()" class="px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded shadow-sm flex items-center gap-1.5 transition">
            <i class="fa-solid fa-plus"></i> Tambah
        </button>

        <!-- Tombol Ubah (Edit berdasarkan checkbox yang dipilih) -->
        <button @click="editDataSelected()" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold rounded shadow-sm flex items-center gap-1.5 transition">
            <i class="fa-solid fa-pen"></i> Ubah
        </button>

        <!-- Tombol Hapus -->
        <button @click="hapusSelected()" class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold rounded shadow-sm flex items-center gap-1.5 transition">
            <i class="fa-solid fa-trash"></i> Hapus
        </button>

        <!-- Tombol Anggota Rombel -->
        <button @click="bukaAnggotaRombel()" class="px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded shadow-sm flex items-center gap-1.5 transition">
            <i class="fa-solid fa-face-smile"></i> Anggota Rombel
        </button>
    </div>

    <!-- Tabel Rombel dengan Checkbox -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <table id="tabelRombel" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b dark:border-gray-700 text-xs text-gray-600 dark:text-gray-300">
                    <th class="py-3 px-3 w-10 text-center">
                        <input type="checkbox" @change="toggleAll($event)" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                    </th>
                    <th class="py-3 px-3">Tingkat</th>
                    <th class="py-3 px-3">Konsentrasi Keahlian</th>
                    <th class="py-3 px-3">Nama Rombel (Kelas)</th>
                    <th class="py-3 px-3">Wali Kelas</th>
                    <th class="py-3 px-3">Tahun Ajaran</th>
                </tr>
            </thead>
            <tbody class="text-xs text-gray-700 dark:text-gray-200">
                <?php foreach ($rombel as $r): ?>
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="py-3 px-3 text-center">
                            <input type="checkbox" value="<?= $r->id; ?>" x-model="selectedIds" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                        </td>
                        <td class="py-3 px-3"><?= isset($r->nama_tingkat) ? $r->nama_tingkat : '-'; ?></td>
                        <td class="py-3 px-3"><?= isset($r->nama_kompetensi) ? $r->nama_kompetensi : '-'; ?></td>
                        <td class="py-3 px-3 font-semibold"><?= isset($r->nama_kelas) ? $r->nama_kelas : '-'; ?></td>
                        <td class="py-3 px-3"><?= isset($r->nama_gtk) ? $r->nama_gtk : '-'; ?></td>
                        <td class="py-3 px-3"><?= isset($r->tahun_ajaran) ? $r->tahun_ajaran : '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Form Tambah / Ubah Rombel -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6 relative border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white" x-text="modalTitle"></h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form dinamis: jika ada id diarahkan ke rombel/update, jika kosong ke rombel/simpan -->
            <form :action="formData.id ? '<?= base_url('rombel/update'); ?>' : '<?= base_url('rombel/simpan'); ?>'" method="POST">
                <input type="hidden" name="id" x-model="formData.id">

                <div class="space-y-3">
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300 text-xs">Tingkat Kelas</label>
                        <select name="id_tingkat" x-model="formData.id_tingkat" required class="w-full text-xs px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Tingkat --</option>
                            <?php foreach ($tingkat as $t): ?>
                                <option value="<?= $t->id; ?>"><?= $t->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300 text-xs">Konsentrasi Keahlian</label>
                        <select name="id_kompetensi" x-model="formData.id_kompetensi" required class="w-full text-xs px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Konsentrasi Keahlian --</option>
                            <?php foreach ($kompetensi as $k): ?>
                                <option value="<?= $k->id; ?>"><?= $k->konsentrasi_keahlian; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300 text-xs">Nama Rombel (Master Kelas)</label>
                        <select name="id_master_kelas" x-model="formData.id_master_kelas" required class="w-full text-xs px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Master Kelas --</option>
                            <?php foreach ($master_kelas as $mk): ?>
                                <option value="<?= $mk->id; ?>"><?= $mk->nama_kelas; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300 text-xs">Wali Kelas</label>
                        <select name="id_gtk" x-model="formData.id_gtk" required class="w-full text-xs px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Wali Kelas (GTK) --</option>
                            <?php foreach ($gtk as $g): ?>
                                <option value="<?= $g->id; ?>"><?= $g->nama_lengkap; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300 text-xs">Tahun Ajaran & Semester</label>
                        <select name="tahun_ajaran" x-model="formData.tahun_ajaran" required class="w-full text-xs px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Tahun Ajaran & Semester --</option>
                            <?php if (isset($tahun_ajaran_list)): foreach ($tahun_ajaran_list as $ta): ?>
                                    <?php if ($ta->status == 'Aktif'): ?>
                                        <option value="<?= $ta->nama . ' (Semester ' . strtolower($ta->semester) . ')'; ?>">
                                            <?= $ta->nama; ?> (Semester <?= strtolower($ta->semester); ?>)
                                        </option>
                                    <?php endif; ?>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="isModalOpen = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#tabelRombel')) {
                $('#tabelRombel').DataTable().destroy();
            }
            $('#tabelRombel').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });

        // Notifikasi Toast Sukses
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

        // Notifikasi Toast Warning (Peringatan gagal hapus karena masih ada siswa)
        <?php if ($this->session->flashdata('warning')): ?>
            const ToastWarning = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
            ToastWarning.fire({
                icon: 'warning',
                title: '<?= $this->session->flashdata('warning'); ?>'
            });
        <?php endif; ?>
    });

    function rombelApp() {
        return {
            isModalOpen: false,
            modalTitle: 'Tambah Rombel',
            selectedIds: [],
            formData: {
                id: '',
                id_tingkat: '',
                id_kompetensi: '',
                id_master_kelas: '',
                id_gtk: '',
                tahun_ajaran: ''
            },
            toggleAll(event) {
                if (event.target.checked) {
                    this.selectedIds = Array.from(document.querySelectorAll('tbody input[type="checkbox"]')).map(el => el.value);
                } else {
                    this.selectedIds = [];
                }
            },
            openModalTambah() {
                this.modalTitle = 'Tambah Rombel Baru';
                this.formData = {
                    id: '',
                    id_tingkat: '',
                    id_kompetensi: '',
                    id_master_kelas: '',
                    id_gtk: '',
                    tahun_ajaran: ''
                };
                this.isModalOpen = true;
            },
            editDataSelected() {
                if (this.selectedIds.length === 0) {
                    Swal.fire('Peringatan', 'Pilih salah satu baris rombel yang ingin diubah terlebih dahulu!', 'warning');
                    return;
                }
                if (this.selectedIds.length > 1) {
                    Swal.fire('Peringatan', 'Hanya dapat mengubah satu data rombel dalam satu waktu!', 'warning');
                    return;
                }
                let id = this.selectedIds[0];
                fetch(`<?= base_url('rombel/get_by_id/') ?>${id}`)
                    .then(res => res.json())
                    .then(data => {
                        this.modalTitle = 'Ubah Rombel';
                        this.formData = {
                            id: data.id,
                            id_tingkat: data.id_tingkat,
                            id_kompetensi: data.id_kompetensi,
                            id_master_kelas: data.id_master_kelas,
                            id_gtk: data.id_gtk,
                            tahun_ajaran: data.tahun_ajaran
                        };
                        this.isModalOpen = true;
                    });
            },
            hapusSelected() {
                if (this.selectedIds.length === 0) {
                    Swal.fire('Peringatan', 'Pilih setidaknya satu data rombel yang ingin dihapus!', 'warning');
                    return;
                }
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data rombel yang dipilih akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '<?= base_url('rombel/hapus_bulk'); ?>';
                        this.selectedIds.forEach(id => {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            form.appendChild(input);
                        });
                        document.body.appendChild(form);
                        form.submit();
                    }
                })
            },
            bukaAnggotaRombel() {
                if (this.selectedIds.length !== 1) {
                    Swal.fire('Peringatan', 'Silakan centang tepat satu rombel untuk melihat anggota rombelnya!', 'warning');
                    return;
                }
                let id = this.selectedIds[0];
                window.location.href = `<?= base_url('rombel/anggota/') ?>${id}`;
            }
        }
    }
</script>