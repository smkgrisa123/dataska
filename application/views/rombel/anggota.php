<!-- Load CSS & JS DataTables + SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Paksa CSS dasar agar mengizinkan scroll */
    html,
    body {
        overflow: auto !important;
        height: auto !important;
    }
</style>

<div class="container mx-auto px-4 py-6 space-y-6 pb-24" x-data="anggotaRombelApp()">

    <!-- Header Informasi Rombel -->
    <div class="bg-slate-900 text-white rounded-2xl p-6 shadow-md flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-2">
                <a href="<?= base_url('rombel'); ?>" class="hover:underline text-sky-400">Manajemen Rombel</a>
                <span>/</span>
                <span class="text-white font-medium">Anggota Rombel</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">
                Kelas:
                <?php
                if (isset($rombel->nama_tingkat) && isset($rombel->nama_kelas)) {
                    echo $rombel->nama_tingkat . ' ' . $rombel->nama_kelas;
                } elseif (isset($rombel->nama_rombel)) {
                    echo $rombel->nama_rombel;
                } else {
                    echo 'Rombel ID #' . $rombel->id;
                }
                ?>
            </h1>
            <p class="text-xs text-slate-400 mt-1">Kelola dan masukkan data siswa mentah ke dalam rombongan belajar ini secara massal.</p>
        </div>
        <div>
            <a href="<?= base_url('rombel'); ?>" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Rombel
            </a>
        </div>
    </div>

    <!-- Tombol Aksi & Informasi Jumlah -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 tracking-wider uppercase">SISWA DI ROMBEL INI</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1"><?= count($siswa_di_rombel); ?> Siswa</h3>
            </div>
            <div class="w-12 h-12 bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 tracking-wider uppercase">SISWA BELUM ADA ROMBEL</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1"><?= count($siswa_belum_ada_rombel); ?> Siswa Mentah</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-clock"></i>
            </div>
        </div>
    </div>

    <!-- Tombol Masukkan Siswa Terpilih -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-3">
        <div class="text-xs text-gray-500 dark:text-gray-400">
            * Centang data siswa mentah di bawah, lalu klik tombol untuk memasukkan mereka sekaligus ke rombel ini.
        </div>
        <button @click="submitPilihSiswa()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center gap-1.5 transition">
            <i class="fa-solid fa-circle-plus"></i> Masukkan Siswa Terpilih ke Rombel
        </button>
    </div>

    <!-- TABEL 1: Daftar Siswa yang Belum Punya Rombel (Data Mentah) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Pilih Siswa Mentah (Belum Masuk Rombel)</h3>
        <div class="overflow-x-auto">
            <table id="tabelSiswaMentah" class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b dark:border-gray-700 text-xs text-gray-600 dark:text-gray-300">
                        <th class="py-3 px-3 w-10 text-center">
                            <input type="checkbox" @change="toggleAllSiswa($event)" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                        </th>
                        <th class="py-3 px-3">NISN / Nama Siswa</th>
                        <th class="py-3 px-3">Jenis Kelamin</th>
                        <th class="py-3 px-3">Rombel Semester Lalu</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-700 dark:text-gray-200">
                    <?php foreach ($siswa_belum_ada_rombel as $s): ?>
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="py-3 px-3 text-center">
                                <input type="checkbox" value="<?= $s->id; ?>" x-model="selectedSiswaIds" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            </td>
                            <td class="py-3 px-3 font-semibold">
                                <?= isset($s->nama_lengkap) ? $s->nama_lengkap : (isset($s->nama) ? $s->nama : '-'); ?>
                            </td>
                            <td class="py-3 px-3"><?= !empty($s->jk) ? $s->jk : '-'; ?></td>
                            <td class="py-3 px-3">
                                <?php if (!empty($s->history_rombel)): ?>
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 rounded font-bold text-[11px]">
                                        <?= $s->history_rombel; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 italic">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABEL 2: Daftar Siswa yang Sudah Resmi di Rombel Ini -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 mt-6">
        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Daftar Anggota Siswa di Rombel Ini</h3>
        <div class="overflow-x-auto">
            <table id="tabelSiswaRombel" class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b dark:border-gray-700 text-xs text-gray-600 dark:text-gray-300">
                        <th class="py-3 px-3 w-10">No</th>
                        <th class="py-3 px-3">Nama Siswa</th>
                        <th class="py-3 px-3">Jenis Kelamin</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-700 dark:text-gray-200">
                    <?php $no = 1;
                    foreach ($siswa_di_rombel as $sr): $nama_sr = isset($sr->nama_lengkap) ? $sr->nama_lengkap : (isset($sr->nama) ? $sr->nama : '-');
                    ?>
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="py-3 px-3"><?= $no++; ?></td>
                            <td class="py-3 px-3 font-semibold"><?= $nama_sr; ?></td>
                            <td class="py-3 px-3"><?= !empty($sr->jk) ? $sr->jk : '-'; ?></td>
                            <td class="py-3 px-3 text-center">
                                <!-- Menggunakan SweetAlert konfirmasi langsung yang akurat mengambil data $sr -->
                                <button type="button"
                                    onclick="konfirmasiKeluarga(<?= $sr->id; ?>, '<?= addslashes($nama_sr); ?>')"
                                    class="px-2.5 py-1 bg-rose-500 hover:bg-rose-600 text-white text-[11px] font-semibold rounded shadow transition">
                                    Keluarkan
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Skrip pembuanka kunci scroll
        document.querySelectorAll('*').forEach(function(el) {
            let style = window.getComputedStyle(el);
            if (style.overflow === 'hidden' && el.tagName !== 'HTML' && el.tagName !== 'BODY' && el.tagName !== 'TABLE') {
                el.style.overflow = 'auto';
            }
            if (style.height === '100vh' || style.maxHeight === '100vh') {
                el.style.height = 'auto';
                el.style.maxHeight = 'none';
            }
        });
        document.body.style.overflow = 'auto';
        document.documentElement.style.overflow = 'auto';

        $(document).ready(function() {
            $('#tabelSiswaMentah').DataTable();
            $('#tabelSiswaRombel').DataTable();
        });

        // Toast Notifikasi Sukses
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

    // Fungsi Konfirmasi SweetAlert untuk mengeluarkan siswa dengan akurat
    function konfirmasiKeluarga(idSiswa, namaSiswa) {
        Swal.fire({
            title: 'Konfirmasi Pengeluaran',
            text: `Apakah Anda yakin ingin mengeluarkan ${namaSiswa} dari rombongan belajar ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Keluarkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('rombel/keluarkan_siswa/'); ?>" + idSiswa;
            }
        });
    }

    function anggotaRombelApp() {
        return {
            selectedSiswaIds: [],
            toggleAllSiswa(event) {
                if (event.target.checked) {
                    this.selectedSiswaIds = Array.from(document.querySelectorAll('#tabelSiswaMentah tbody input[type="checkbox"]')).map(el => el.value);
                } else {
                    this.selectedSiswaIds = [];
                }
            },
            submitPilihSiswa() {
                if (this.selectedSiswaIds.length === 0) {
                    Swal.fire('Peringatan', 'Silakan centang setidaknya satu data siswa yang ingin dimasukkan!', 'warning');
                    return;
                }

                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= base_url('rombel/tambah_siswa_bulk/' . $rombel->id); ?>';

                this.selectedSiswaIds.forEach(id => {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'siswa_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }
        }
    }
</script>