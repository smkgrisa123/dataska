<!-- Load CSS & JS DataTables + SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="w-full px-6 py-6 space-y-6 pb-24">

    <!-- Header / Banner Utama -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-sky-950 text-white rounded-2xl p-6 shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-slate-700/50">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-2">
                <a href="<?= base_url('dashboard'); ?>" class="hover:underline text-sky-400">Dashboard</a>
                <span>/</span>
                <span class="text-white font-medium">Manajemen Kenaikan Kelas</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
                <i class="fa-solid fa-graduation-cap text-sky-400"></i> Proses Kenaikan Kelas & Kelulusan
            </h1>
            <p class="text-xs text-slate-300 mt-1">Pilih tingkat asal, centang peserta didik, lalu tentukan tingkat tujuan atau proses kelulusan secara massal[cite: 8].</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-sky-500/20 text-sky-300 border border-sky-500/30 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-calendar-days"></i> Tahun Ajaran Aktif
            </span>
        </div>
    </div>

    <!-- Filter Tingkat Asal Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="<?= base_url('kenaikanKelas'); ?>" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Pilih Tingkat Kelas Asal:</label>
                <select name="tingkat_id" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <option value="">-- Pilih Tingkat Asal --</option>
                    <?php foreach ($tingkat as $t): ?>
                        <option value="<?= $t->id; ?>" <?= (isset($selected_tingkat) && $selected_tingkat == $t->id) ? 'selected' : ''; ?>>
                            <?= $t->nama; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl shadow-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-filter"></i> Tampilkan Daftar Siswa
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel & Aksi Proses Kenaikan (Muncul Jika Siswa Tersedia) -->
    <?php if (!empty($selected_tingkat)): ?>
        <?php
        $ada_tingkat_tujuan = false;
        foreach ($tingkat as $t) {
            if ($t->id > $selected_tingkat) {
                $ada_tingkat_tujuan = true;
                break;
            }
        }
        ?>

        <form id="formKenaikan" action="<?= base_url('kenaikanKelas/proses_kenaikan'); ?>" method="POST">
            <input type="hidden" name="tingkat_asal" value="<?= $selected_tingkat; ?>">
            <!-- Hidden inputs untuk menampung semua ID siswa yang dicentang lintas pagination DataTable[cite: 8] -->
            <div id="containerHiddenSiswa"></div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Baris Informasi & Pilihan Tujuan -->
                <div class="p-5 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        Total Siswa Ditemukan: <span class="text-sky-600 dark:text-sky-400 font-bold"><?= count($siswa); ?> Orang</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <?php if ($ada_tingkat_tujuan): ?>
                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-400 whitespace-nowrap">Naik ke:</span>
                                <select id="tingkatTujuan" name="tingkat_tujuan" class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                    <option value="">-- Pilih Tingkat Tujuan --</option>
                                    <?php foreach ($tingkat as $t):
                                        if ($t->id > $selected_tingkat):
                                    ?>
                                            <option value="<?= $t->id; ?>"><?= $t->nama; ?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>

                            <button type="button" onclick="persiapkanSubmit('kenaikan')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow transition flex items-center gap-1.5 whitespace-nowrap">
                                <i class="fa-solid fa-circle-check"></i> Proses Kenaikan Kelas
                            </button>
                        <?php endif; ?>

                        <button type="button" onclick="persiapkanSubmit('lulus')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow transition flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-graduation-cap"></i> Luluskan Siswa Terpilih
                        </button>
                    </div>
                </div>

                <!-- Tabel Data Siswa dengan DataTable -->
                <div class="p-4 overflow-x-auto">
                    <table id="tabelKenaikanKelas" class="w-full text-left border-collapse stripe hover">
                        <thead>
                            <tr class="border-b dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-900/20">
                                <th class="py-3 px-4 w-12 text-center no-sort">
                                    <input type="checkbox" id="selectAll" checked class="rounded border-gray-300 text-sky-600 focus:ring-sky-500 w-4 h-4 cursor-pointer">
                                </th>
                                <th class="py-3 px-4">NISN / NIS</th>
                                <th class="py-3 px-4">Nama Siswa</th>
                                <th class="py-3 px-4">Jenis Kelamin</th>
                                <th class="py-3 px-4">Tingkat Saat Ini</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-gray-700 dark:text-gray-200 divide-y divide-gray-100 dark:divide-gray-700/50">
                            <?php foreach ($siswa as $s): ?>
                                <tr class="hover:bg-sky-50/40 dark:hover:bg-gray-700/30 transition">
                                    <td class="py-3.5 px-4 text-center">
                                        <input type="checkbox" value="<?= $s->id; ?>" checked class="checkbox-siswa rounded border-gray-300 text-sky-600 focus:ring-sky-500 w-4 h-4 cursor-pointer">
                                    </td>
                                    <td class="py-3.5 px-4 font-medium text-gray-600 dark:text-gray-300"><?= !empty($s->nisn) ? $s->nisn : (!empty($s->no_induk) ? $s->no_induk : '-'); ?></td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white"><?= isset($s->nama_lengkap) ? $s->nama_lengkap : (isset($s->nama) ? $s->nama : '-'); ?></td>
                                    <td class="py-3.5 px-4"><?= !empty($s->jk) ? $s->jk : '-'; ?></td>
                                    <td class="py-3.5 px-4 font-semibold text-sky-600 dark:text-sky-400"><?= isset($s->nama_tingkat) ? $s->nama_tingkat : '-'; ?></td>
                                    <td class="py-3.5 px-4 text-center">
                                        <?php if ($ada_tingkat_tujuan): ?>
                                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 rounded-full font-bold text-[10px]">
                                                Siap Naik
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300 rounded-full font-bold text-[10px]">
                                                Siap Diluluskan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
    let table;
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi DataTables
        if (document.getElementById('tabelKenaikanKelas')) {
            table = $('#tabelKenaikanKelas').DataTable({
                "language": {
                    "search": "Cari Siswa:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "zeroRecords": "Siswa tidak ditemukan",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }],
                "pageLength": 25
            });
        }

        // Fitur Pilih Semua Checkbox (mencakup seluruh halaman DataTables)
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = table.$('.checkbox-siswa', {
                    "page": "all"
                });
                checkboxes.each(function() {
                    this.checked = selectAll.checked;
                });
            });
        }

        // Notifikasi Toast Flashdata
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
        <?php elseif ($this->session->flashdata('error')): ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<?= $this->session->flashdata('error'); ?>',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
        <?php endif; ?>
    });

    // Fungsi untuk mengumpulkan checkbox dari semua halaman DataTable sebelum disubmit ke PHP
    function persiapkanSubmit(aksi) {
        document.getElementById('containerHiddenSiswa').innerHTML = '';

        const checkedBoxes = table.$('.checkbox-siswa:checked', {
            "page": "all"
        });

        if (checkedBoxes.length === 0) {
            Swal.fire('Peringatan', 'Pilih setidaknya satu siswa terlebih dahulu!', 'warning');
            return;
        }

        if (aksi === 'kenaikan') {
            const tingkatTujuan = document.getElementById('tingkatTujuan').value;
            if (!tingkatTujuan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tingkat Tujuan Belum Dipilih',
                    text: 'Mohon pilih tingkat kelas tujuan terlebih dahulu sebelum memproses kenaikan kelas!',
                    confirmButtonColor: '#0284c7'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Kenaikan Kelas',
                text: `Apakah Anda yakin ingin memproses kenaikan kelas untuk ${checkedBoxes.length} siswa terpilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Proses Naik Kelas',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    kirimData(checkedBoxes, '<?= base_url('kenaikanKelas/proses_kenaikan'); ?>', null);
                }
            });

        } else if (aksi === 'lulus') {
            Swal.fire({
                title: 'Konfirmasi Kelulusan Siswa',
                html: `
                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-3">Anda akan meluluskan <b>${checkedBoxes.length}</b> siswa terpilih. Silakan tentukan Tahun Ajaran / Tahun Lulus:</p>
                    <select id="swal-input-tahun" class="swal2-input text-xs rounded-xl">
                        <option value="">-- Pilih Tahun Ajaran / Lulus --</option>
                        <?php if (!empty($list_tahun_ajaran)): ?>
                            <?php foreach ($list_tahun_ajaran as $t): ?>
                                <option value="<?= $t->nama; ?>"><?= $t->nama; ?> (<?= $t->semester; ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Luluskan',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const tahunLulus = document.getElementById('swal-input-tahun').value;
                    if (!tahunLulus) {
                        Swal.showValidationMessage('Tahun kelulusan / ajaran wajib dipilih!');
                    }
                    return tahunLulus;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // PASTIKAN MENGARAH KE KenaikanKelas/proses_lulus
                    kirimData(checkedBoxes, '<?= base_url('kenaikanKelas/proses_lulus'); ?>', result.value);
                }
            });
        }
    }

    // Helper untuk menyuntikkan ID siswa dan tahun lulus ke form POST
    function kirimData(checkedBoxes, urlAction, tahunLulus) {
        const container = document.getElementById('containerHiddenSiswa');

        checkedBoxes.each(function() {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'siswa_ids[]';
            input.value = this.value;
            container.appendChild(input);
        });

        if (tahunLulus) {
            let inputTahun = document.createElement('input');
            inputTahun.type = 'hidden';
            inputTahun.name = 'tahun_lulus';
            inputTahun.value = tahunLulus;
            container.appendChild(inputTahun);
        }

        let form = document.getElementById('formKenaikan');
        form.action = urlAction;
        form.submit();
    }
</script>