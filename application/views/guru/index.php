<!-- Load CDN Pendukung (DataTables Tailwind & SweetAlert2) jika belum ada di layout utama -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-6" x-data="ptkApp()">

    <!-- Toast Flashdata dari Controller -->
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

    <!-- 1. CARD BAGIAN ATAS: Header & Tombol Aksi -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 flex flex-col gap-4">

        <!-- Judul Halaman / Identitas Menu di Bagian Atas -->
        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
            <div class="p-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                <i class="fa-solid fa-chalkboard-user text-base"></i>
            </div>
            <div>
                <h2 class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-wider">Data PTK / Guru</h2>
                <span class="text-[11px] text-gray-500 dark:text-gray-400">Manajemen Pendidik & Tenaga Kependidikan</span>
            </div>
        </div>

        <!-- Kelompok Tombol Aksi di Bagian Bawah -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Tombol Tambah -->
            <button @click="openModalTambah()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-user-plus mr-2"></i>Tambah
            </button>

            <!-- Tombol Ubah -->
            <button :disabled="selectedIds.length !== 1"
                @click="editData()"
                :class="selectedIds.length === 1 ? 'bg-purple-600 hover:bg-purple-700 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Ubah
            </button>

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

            <!-- Tombol Penugasan (Aktif jika 1 data dipilih) -->
            <button :disabled="selectedIds.length !== 1"
                @click="penugasanData()"
                :class="selectedIds.length === 1 ? 'bg-gray-600 hover:bg-gray-700 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-user-shield mr-2"></i> Penugasan
            </button>

            <!-- Tombol Profil Guru (Aktif jika 1 data dipilih) -->
            <button :disabled="selectedIds.length !== 1"
                @click="profilGuru()"
                :class="selectedIds.length === 1 ? 'bg-slate-700 hover:bg-slate-800 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                class="px-4 py-2 text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
                <i class="fa-solid fa-user mr-2"></i> Profil Guru
            </button>
        </div>

    </div>

    <!-- 2. CARD BAGIAN BAWAH: Kotak Khusus Tabel -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <table id="tabelGuru" class="w-full text-left border-collapse text-xs whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <th class="p-3 text-center w-10 no-sort">
                        <input type="checkbox" @change="toggleSelectAll" x-model="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="p-3">Sts</th>
                    <th class="p-3">Nama Lengkap</th>
                    <th class="p-3">JK</th>
                    <th class="p-3">Tmp. Lahir</th>
                    <th class="p-3">Tgl Lahir</th>
                    <th class="p-3">NIK</th>
                    <th class="p-3">NUPTK</th>
                    <th class="px-4 py-3 text-left">Jenis PTK</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                <?php if (!empty($guru)) : ?>
                    <?php foreach ($guru as $row) : ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="p-3 text-center">
                                <input type="checkbox" value="<?= $row->id; ?>" x-model="selectedIds" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-xs font-semibold">Aktif</span>
                            </td>
                            <td class="p-3 font-medium text-gray-900 dark:text-white"><?= $row->nama_lengkap; ?></td>
                            <td class="p-3"><?= $row->jk; ?></td>
                            <td class="p-3"><?= isset($row->tmp_lahir) ? $row->tmp_lahir : '-'; ?></td>
                            <td class="p-3"><?= !empty($row->tgl_lahir) ? date('d/m/Y', strtotime($row->tgl_lahir)) : '-'; ?></td>
                            <td class="p-3"><?= isset($row->nik) ? $row->nik : '-'; ?></td>
                            <td class="p-3"><?= isset($row->nuptk) ? $row->nuptk : '-'; ?></td>
                            <td class="p-3">
                                <?php
                                // Sesuaikan 'jenis_ptk' dengan nama kolom di database Anda 
                                // (atau bisa diganti dengan nama relasi jika diambil dari join tabel lain, misal $row->nama_jenis_ptk)
                                echo isset($row->jenis_ptk) ? $row->jenis_ptk : '-';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL TAMBAH / EDIT PTK -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div @click.away="isModalOpen = false" class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center" style="background-color: #1b2a47;">
                <h3 class="font-bold text-white text-sm" x-text="modalTitle"></h3>
                <button @click="isModalOpen = false" class="text-gray-300 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="<?= base_url('guru/simpan') ?>" method="POST" class="p-6 space-y-4 text-xs">
                <input type="hidden" name="id" x-model="formData.id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" x-model="formData.nama_lengkap" autocomplete="off" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Jenis Kelamin</label>
                        <select name="jk" x-model="formData.jk" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tempat Lahir</label>
                        <input type="text" name="tmp_lahir" x-model="formData.tmp_lahir" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Banyuwangi">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" x-model="formData.tgl_lahir" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" x-model="formData.no_hp" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NIK</label>
                        <input type="text" name="nik" x-model="formData.nik" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300">NUPTK</label>
                        <input type="text" name="nuptk" x-model="formData.nuptk" autocomplete="off" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="isModalOpen = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Panggil File Modal Penugasan DI DALAM WADAH X-DATA -->
    <?php $this->load->view('guru/modal_penugasan'); ?>

</div> <!-- END WADAH X-DATA -->

<!-- Script Inisialisasi DataTables & Skrip AlpineJS Pendukung -->
<script>
    $(document).ready(function() {
        var table = $('#tabelGuru').DataTable({
            "scrollY": "350px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "autoWidth": false,
            "order": [
                [2, "asc"]
            ],
            "language": {
                "search": "Cari Guru:",
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
                "targets": [0, 1]
            }]
        });

        setTimeout(function() {
            table.columns.adjust();
        }, 200);

        $(window).on('resize', function() {
            table.columns.adjust();
        });
    });

    function ptkApp() {
        return {
            selectedIds: [],
            selectAll: false,
            isModalOpen: false,
            modalTitle: 'Tambah Data PTK',

            // State untuk Modal Penugasan
            openModalPenugasan: false,
            guruIdPenugasan: null,

            formData: {
                id: '',
                nama_lengkap: '',
                jk: 'L',
                tmp_lahir: '',
                tgl_lahir: '',
                no_hp: '',
                nik: '',
                nuptk: ''
            },

            toggleSelectAll() {
                if (this.selectAll) {
                    this.selectedIds = [...document.querySelectorAll('tbody input[type="checkbox"]')].map(el => el.value);
                } else {
                    this.selectedIds = [];
                }
            },

            openModalTambah() {
                this.modalTitle = 'Tambah Data PTK Baru';
                this.formData = {
                    id: '',
                    nama_lengkap: '',
                    jk: 'L',
                    tmp_lahir: '',
                    tgl_lahir: '',
                    no_hp: '',
                    nik: '',
                    nuptk: ''
                };
                this.isModalOpen = true;
            },

            editData() {
                if (this.selectedIds.length !== 1) return;
                let id = this.selectedIds[0];
                window.location.href = '<?= base_url('guru/edit/'); ?>' + id;
            },

            penugasanData() {
                if (this.selectedIds.length !== 1) return;
                this.guruIdPenugasan = this.selectedIds[0];
                this.openModalPenugasan = true;
            },

            profilGuru() {
                if (this.selectedIds.length !== 1) return;
                let id = this.selectedIds[0];
                window.location.href = '<?= base_url('guru/profil/'); ?>' + id;
            },

            hapusData() {
                if (this.selectedIds.length === 0) return;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data PTK yang dipilih akan dihapus secara permanen!",
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
                        form.action = '<?= base_url('guru/hapus_bulk') ?>';

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
                form.action = '<?= base_url('guru/validasi_bulk') ?>';

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
        }
    }
</script>