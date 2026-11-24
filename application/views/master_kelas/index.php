<!-- Load CSS & JS DataTables + SweetAlert2 secara langsung agar pasti jalan -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto px-4 py-6" x-data="masterKelasApp()">

    <!-- Header & Tombol Tambah -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Data Master Kelas</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola referensi nama kelas baku (contoh: X TAB, XI TSM, dll.)</p>
        </div>
        <button @click="openModalTambah()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg flex items-center shadow-sm transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Master Kelas
        </button>
    </div>

    <!-- Tabel Master Kelas -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <table id="tabelMasterKelas" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b dark:border-gray-700 text-xs text-gray-600 dark:text-gray-300">
                    <th class="py-3 px-4 w-16">No</th>
                    <th class="py-3 px-4">Nama Kelas Baku</th>
                    <th class="py-3 px-4 w-32 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-xs text-gray-700 dark:text-gray-200">
                <?php $no = 1;
                foreach ($master_kelas as $mk): ?>
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="py-3 px-4"><?= $no++; ?></td>
                        <td class="py-3 px-4 font-semibold"><?= $mk->nama_kelas; ?></td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button @click="editData(<?= $mk->id; ?>)" class="px-2.5 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs transition flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-[10px]"></i> Ubah
                                </button>
                                <button @click="konfirmasiHapus('<?= base_url('master_kelas/hapus/' . $mk->id); ?>')" class="px-2.5 py-1 bg-rose-500 hover:bg-rose-600 text-white rounded text-xs transition flex items-center gap-1">
                                    <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Form Tambah/Ubah Master Kelas -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-sm p-6 relative border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white" x-text="modalTitle"></h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="<?= base_url('master_kelas/simpan'); ?>" method="POST">
                <input type="hidden" name="id" x-model="formData.id">

                <div class="space-y-4">
                    <div>
                        <label class="block font-semibold mb-1 text-gray-600 dark:text-gray-300 text-xs">Nama Kelas (Baku)</label>
                        <input type="text" name="nama_kelas" x-model="formData.nama_kelas" autocomplete="off" required placeholder="Contoh: X TAB" class="w-full text-xs px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <p class="text-[10px] text-gray-400 mt-1">Digunakan sebagai referensi utama pembuatan rombel.</p>
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
        // Inisialisasi DataTables secara aman
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#tabelMasterKelas')) {
                $('#tabelMasterKelas').DataTable().destroy();
            }
            $('#tabelMasterKelas').DataTable({
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

        // Toast Notification SweetAlert2
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

    function masterKelasApp() {
        return {
            isModalOpen: false,
            modalTitle: 'Tambah Master Kelas',
            formData: {
                id: '',
                nama_kelas: ''
            },
            openModalTambah() {
                this.modalTitle = 'Tambah Master Kelas Baru';
                this.formData = {
                    id: '',
                    nama_kelas: ''
                };
                this.isModalOpen = true;
            },
            editData(id) {
                fetch(`<?= base_url('master_kelas/get_by_id/') ?>${id}`)
                    .then(res => res.json())
                    .then(data => {
                        this.modalTitle = 'Ubah Master Kelas';
                        this.formData = {
                            id: data.id,
                            nama_kelas: data.nama_kelas
                        };
                        this.isModalOpen = true;
                    });
            },
            konfirmasiHapus(urlDelete) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data master kelas yang dihapus tidak dapat dikembalikan!",
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