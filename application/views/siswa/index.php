<!-- Load CDN Pendukung (DataTables & SweetAlert2) jika belum ada di layout utama -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-6" x-data="siswaApp()">

    <!-- Toast Flashdata dari Controller (jika ada) -->
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

    <!-- 1. CARD BAGIAN ATAS: Header & Tombol Aksi (DIAM / TIDAK IKUT SCROLL) -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 flex flex-wrap items-center justify-between gap-4">

        <!-- Kelompok Tombol Aksi di Sebelah Kiri -->
        <div class="flex flex-wrap items-center gap-2">

            <!-- Tombol Tambah & Import HANYA untuk Admin/Staff -->
            <?php if ($this->session->userdata('role') !== 'wali_kelas'): ?>
                <!-- Tombol Tambah (Memicu Modal) -->
                <button @click="openModalTambah()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                    <i class="fa-solid fa-user-plus mr-2"></i>Tambah
                </button>

                <!-- Tombol Upload / Import Excel -->
                <button type="button" onclick="$('#modalImport').removeClass('hidden')" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                    <i class="fa-solid fa-file-excel mr-2"></i> Import Excel
                </button>
            <?php endif; ?>

            <!-- Tombol Download / Export Excel (Bisa diakses oleh semua, termasuk Wali Kelas) -->
            <a href="<?= base_url('siswa/export_excel'); ?>" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-download mr-2"></i> Download
            </a>
            <button :disabled="selectedIds.length !== 1"
                @click="editData()"
                :class="selectedIds.length === 1 ? 'bg-purple-600 hover:bg-purple-700 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Ubah
            </button>

            <!-- Tombol Ubah, Hapus, Validasi, & Cetak PDF HANYA untuk Admin/Staff -->
            <?php if ($this->session->userdata('role') !== 'wali_kelas'): ?>
                <!-- Tombol Ubah -->

                <!-- Tombol Hapus -->
                <button :disabled="selectedIds.length === 0"
                    @click="hapusData()"
                    :class="selectedIds.length > 0 ? 'bg-rose-500 hover:bg-rose-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                    class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                    <i class="fa-solid fa-trash-can mr-2"></i> Hapus
                </button>

                <!-- Tombol Validasi -->
                <button :disabled="selectedIds.length === 0"
                    @click="validasiData()"
                    :class="selectedIds.length > 0 ? 'bg-sky-500 hover:bg-sky-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                    class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                    <i class="fa-solid fa-circle-check mr-2"></i> Validasi
                </button>


            <?php endif; ?>
            <!-- Tombol Cetak PDF -->
            <button :disabled="selectedIds.length === 0"
                @click="cetakPdfPilihan()"
                :class="selectedIds.length > 0 ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-file-pdf mr-2"></i> Cetak PDF
            </button>
        </div>

        <!-- Bagian Kanan: Filter Rombel -->
        <div class="flex items-center gap-2">
            <select id="filterRombel" class="px-3 py-2 border rounded-lg text-xs dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Rombel ...</option>
                <?php if (!empty($master_rombel)) : ?>
                    <?php foreach ($master_rombel as $r) : ?>
                        <?php
                        $nama_rombel = isset($r->nama_kelas) ? $r->nama_kelas : (isset($r->nama) ? $r->nama : (isset($r->rombel) ? $r->rombel : ''));
                        ?>
                        <?php if (!empty($nama_rombel)) : ?>
                            <option value="<?= $nama_rombel; ?>"><?= $nama_rombel; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <!-- 2. CARD BAGIAN BAWAH: Kotak Khusus Tabel (Menggunakan ScrollY DataTables ala Dapodik) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <table id="tabelSiswa" class="w-full text-left border-collapse text-xs whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <th class="p-3 text-center w-10 no-sort">
                        <input type="checkbox" @change="toggleSelectAll" x-model="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="p-3">Sts</th>
                    <th class="p-3">Vld</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Tempat Lahir</th>
                    <th class="p-3">Tanggal Lahir</th>
                    <th class="p-3">JK</th>
                    <th class="p-3">NISN</th>
                    <th class="p-3">No. Induk</th>
                    <th class="p-3">Tingkat Kelas</th>
                    <th class="p-3">Rombel</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $row) : ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="p-3 text-center">
                                <input type="checkbox" value="<?= $row->id; ?>" x-model="selectedIds" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="p-3">
                                <i class="fa-solid fa-user-tie text-emerald-600" title="Siswa Aktif"></i>
                            </td>
                            <td class="p-3">
                                <?php if (isset($row->status_validasi) && $row->status_validasi == 1) : ?>
                                    <i class="fa-solid fa-check text-emerald-500 font-bold" title="Valid"></i>
                                <?php else : ?>
                                    <i class="fa-solid fa-xmark text-rose-500" title="Belum Valid"></i>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 font-medium text-gray-900 dark:text-white"><?= $row->nama; ?></td>
                            <td class="p-3"><?= isset($row->tempat_lahir) ? $row->tempat_lahir : '-'; ?></td>
                            <td class="p-3"><?= !empty($row->tanggal_lahir) ? date('d/m/Y', strtotime($row->tanggal_lahir)) : '-'; ?></td>
                            <td class="p-3"><?= $row->jk; ?></td>
                            <td class="p-3"><?= $row->nisn; ?></td>
                            <td class="p-3"><?= $row->no_induk; ?></td>
                            <td class="p-3"><?= isset($row->nama_tingkat) ? $row->nama_tingkat : '-'; ?></td>
                            <td class="p-3">
                                <?php if (!empty($row->nama_kelas)): ?>
                                    <span class="px-2 py-1 bg-sky-100 text-sky-700 rounded text-xs font-semibold">
                                        <?= $row->nama_kelas; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400">Belum Ada Rombel</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL TAMBAH / EDIT SISWA -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div @click.away="isModalOpen = false" class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 dark:text-white text-sm" x-text="modalTitle"></h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="<?= base_url('siswa/simpan') ?>" method="POST" class="p-6 space-y-4 text-xs">
                <input type="hidden" name="id" x-model="formData.id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nama Lengkap</label>
                        <input type="text" name="nama" x-model="formData.nama" autocomplete="off" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NISN</label>
                        <input type="text" name="nisn" x-model="formData.nisn" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Jenis Kelamin</label>
                        <select name="jk" x-model="formData.jk" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" x-model="formData.tempat_lahir" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Banyuwangi">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" x-model="formData.tanggal_lahir" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tingkat Kelas (Master)</label>
                        <select name="tingkat_id" x-model="formData.tingkat_id" autocomplete="off" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Tingkat --</option>
                            <?php if (!empty($master_tingkat)) : ?>
                                <?php foreach ($master_tingkat as $t) : ?>
                                    <option value="<?= $t->id; ?>"><?= $t->nama; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="isModalOpen = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inisialisasi DataTables & Skrip Pendukung -->
<script>
    $(document).ready(function() {
        var table = $('#tabelSiswa').DataTable({
            "scrollY": "350px", // Tinggi optimal agar informasi bawah tidak terpotong saat zoom 85%-100%
            "scrollX": true, // Mengaktifkan scroll horizontal
            "scrollCollapse": true, // Menyusutkan tinggi tabel secara otomatis jika data sedikit
            "paging": true,
            "autoWidth": false, // Mencegah lebar kolom header dan isi tidak sinkron/tidak lurus
            "order": [
                [3, "asc"]
            ], // Mengurutkan tabel secara otomatis berdasarkan kolom Nama (indeks 3) dari A-Z
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
            },
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 1, 2]
            }]
        });

        // Memastikan keselarasan kolom lurus sempurna setelah tabel dimuat dan saat ukuran window berubah
        setTimeout(function() {
            table.columns.adjust();
        }, 200);

        $(window).on('resize', function() {
            table.columns.adjust();
        });

        // Event listener untuk dropdown filter rombel secara live
        $('#filterRombel').on('change', function() {
            var selectedRombel = $(this).val();
            table.column(10).search(selectedRombel).draw();
        });

        // Penangkap Session Flashdata untuk Toast Notification
        <?php if ($this->session->flashdata('success')) : ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '<?= $this->session->flashdata('success'); ?>',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<?= $this->session->flashdata('error'); ?>',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true
            });
        <?php endif; ?>
    });

    function siswaApp() {
        return {
            selectedIds: [],
            selectAll: false,
            isModalOpen: false,
            modalTitle: 'Tambah Data Siswa',
            formData: {
                id: '',
                nama: '',
                no_induk: '',
                nisn: '',
                tempat_lahir: '',
                tanggal_lahir: '',
                jk: 'L',
                tingkat_id: '',
                rombel: ''
            },

            toggleSelectAll() {
                if (this.selectAll) {
                    this.selectedIds = [...document.querySelectorAll('tbody input[type="checkbox"]')].map(el => el.value);
                } else {
                    this.selectedIds = [];
                }
            },

            openModalTambah() {
                this.modalTitle = 'Registrasi / Tambah Siswa Baru';
                this.formData = {
                    id: '',
                    nama: '',
                    no_induk: '',
                    nisn: '',
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    jk: 'L',
                    tingkat_id: '',
                    rombel: ''
                };
                this.isModalOpen = true;
            },

            editData() {
                if (this.selectedIds.length !== 1) return;
                let id = this.selectedIds[0];
                window.location.href = '<?= base_url('siswa/edit/'); ?>' + id;
            },

            hapusData() {
                if (this.selectedIds.length === 0) return;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data siswa yang dipilih akan dihapus secara permanen!",
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
                        form.action = '<?= base_url('siswa/hapus_bulk') ?>';

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
                });
            },

            validasiData() {
                if (this.selectedIds.length === 0) return;
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= base_url('siswa/validasi_bulk') ?>';

                this.selectedIds.forEach(id => {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            },

            cetakPdfPilihan() {
                if (this.selectedIds.length === 0) return;

                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= base_url('siswa/cetak_pdf_pilihan'); ?>';

                this.selectedIds.forEach(id => {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
                form.remove();
            }
        }
    }
</script>

<!-- Modal Import Excel -->
<div id="modalImport" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-lg">
        <h3 class="text-lg font-bold mb-2">Import Data Siswa dari Excel</h3>
        <p class="text-xs text-gray-500 mb-4">Pastikan data yang di-import sudah sesuai dengan format template resmi.</p>

        <!-- Tombol Download Template -->
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
            <div>
                <span class="block text-xs font-semibold text-blue-700">Belum punya formatnya?</span>
                <span class="block text-[11px] text-blue-500">Download template kosong terlebih dahulu.</span>
            </div>
            <a href="<?= base_url('siswa/download_template'); ?>" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-download mr-1.5"></i> Template Excel
            </a>
        </div>

        <!-- Form Upload -->
        <form action="<?= base_url('siswa/import_excel'); ?>" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel yang Telah Diisi (.xls)</label>
                <input type="file" name="file_excel" class="w-full border border-gray-300 p-2 rounded-lg text-sm" required accept=".xls, .xlsx">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="$('#modalImport').addClass('hidden')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-xs font-semibold rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg">Upload & Import</button>
            </div>
        </form>
    </div>
</div>