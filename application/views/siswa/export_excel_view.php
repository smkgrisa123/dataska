<?php
// Mencegah error jika data kosong
$siswa = isset($siswa) ? $siswa : [];
date_default_timezone_set('Asia/Jakarta');
$tanggal_unduh = date('d-m-Y H:i:s');
?>

<!-- Judul Laporan Utama -->
<table>
    <tr>
        <td colspan="5" style="font-size: 14pt; font-weight: bold;">DATA LENGKAP SISWA/I SMK GRISA</td>
    </tr>
    <tr>
        <td colspan="5" style="font-size: 11pt; font-style: italic;">DI UNDUH PADA TANGGAL : <?= $tanggal_unduh; ?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
</table>

<!-- Tabel Data Rinci Siswa -->
<table border="1">
    <thead>
        <!-- Baris ke-1: Pengelompokan Kategori Utama (Merge Kolom) -->
        <tr style="background-color: #d9d9d9; font-weight: bold; text-align: center;">
            <th rowspan="2">No</th>
            <th colspan="15">DATA PRIBADI SISWA</th>
            <th colspan="13">DATA ALAMAT & TEMPAT TINGGAL</th>
            <th colspan="12">DATA AYAH KANDUNG</th>
            <th colspan="12">DATA IBU KANDUNG</th>
            <th colspan="12">DATA WALI SISWA</th>
            <th colspan="12">DATA PERIODIK & KESEHATAN</th>
            <th colspan="9">DATA PENDAFTARAN & MASUK SEKOLAH</th>
            <th rowspan="2">Tingkat Kelas</th>
            <th rowspan="2">Rombel</th>
            <th colspan="7">DATA KELULUSAN / TAMAT BELAJAR</th>
        </tr>

        <!-- Baris ke-2: Nama Kolom Rinci -->
        <tr style="background-color: #f2f2f2; font-weight: bold; text-align: center;">
            <!-- Data Pribadi (15 kolom) -->
            <th>Nama Lengkap</th>
            <th>Nama Panggilan</th>
            <th>NIK</th>
            <th>NISN</th>
            <th>No. Induk</th>
            <th>JK</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>No. KK</th>
            <th>No. Akte Lahir</th>
            <th>Agama</th>
            <th>Kewarganegaraan</th>
            <th>Berkebutuhan Khusus</th>
            <th>Status Orang Tua</th>
            <th>Bahasa Sehari-hari</th>

            <!-- Alamat & Tempat Tinggal (13 kolom) -->
            <th>Jalan</th>
            <th>Dusun</th>
            <th>RT</th>
            <th>RW</th>
            <th>Desa</th>
            <th>Kecamatan</th>
            <th>Kabupaten</th>
            <th>Provinsi</th>
            <th>Lintang</th>
            <th>Bujur</th>
            <th>Tempat Tinggal</th>
            <th>Moda Transportasi</th>
            <th>No. HP Siswa</th>

            <!-- Ayah Kandung (12 kolom) -->
            <th>Nama Ayah</th>
            <th>Status Ayah</th>
            <th>NIK Ayah</th>
            <th>Tahun Lahir Ayah</th>
            <th>Pendidikan Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Penghasilan Ayah</th>
            <th>Alamat Jalan Ayah</th>
            <th>Dusun Ayah</th>
            <th>RT Ayah</th>
            <th>RW Ayah</th>
            <th>No. HP Ayah</th>

            <!-- Ibu Kandung (12 kolom) -->
            <th>Nama Ibu</th>
            <th>Status Ibu</th>
            <th>NIK Ibu</th>
            <th>Tahun Lahir Ibu</th>
            <th>Pendidikan Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Penghasilan Ibu</th>
            <th>Alamat Jalan Ibu</th>
            <th>Dusun Ibu</th>
            <th>RT Ibu</th>
            <th>RW Ibu</th>
            <th>No. HP Ibu</th>

            <!-- Wali Siswa (12 kolom) -->
            <th>Nama Wali</th>
            <th>NIK Wali</th>
            <th>Hubungan Wali</th>
            <th>Tahun Lahir Wali</th>
            <th>Pendidikan Wali</th>
            <th>Pekerjaan Wali</th>
            <th>Penghasilan Wali</th>
            <th>Alamat Jalan Wali</th>
            <th>Dusun Wali</th>
            <th>RT Wali</th>
            <th>RW Wali</th>
            <th>No. HP Wali</th>

            <!-- Data Periodik & Kesehatan (12 kolom) -->
            <th>Tinggi Badan (cm)</th>
            <th>Berat Badan (kg)</th>
            <th>Lingkar Kepala (cm)</th>
            <th>Jarak Tempuh Kategori</th>
            <th>Jarak (KM)</th>
            <th>Waktu Tempuh</th>
            <th>Jumlah Saudara Kandung</th>
            <th>Anak Ke-</th>
            <th>Jumlah Saudara Tiri</th>
            <th>Jumlah Saudara Angkat</th>
            <th>Riwayat Penyakit</th>
            <th>Golongan Darah</th>

            <!-- Data Pendaftaran & Masuk Sekolah (9 kolom) -->
            <th>Jenis Pendaftaran</th>
            <th>Diterima di Kelas</th>
            <th>Bidang Keahlian</th>
            <th>Program Keahlian</th>
            <th>Konsentrasi Keahlian</th>
            <th>Tanggal Masuk</th>
            <th>Asal Sekolah</th>
            <th>No. Ijazah SMP</th>
            <th>Tanggal Ijazah SMP</th>

            <!-- Kelulusan / Tamat Belajar (7 kolom - Paling Akhir) -->
            <th>Nomor Ijazah</th>
            <th>Tanggal Ijazah</th>
            <th>Melanjutkan Ke</th>
            <th>Bekerja Di</th>
            <th>Tanggal Mulai Bekerja</th>
            <th>Nama Perusahaan</th>
            <th>Penghasilan Lulus</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($siswa)) : ?>
            <?php $no = 1;
            foreach ($siswa as $row) : ?>
                <tr>
                    <!-- No -->
                    <td align="center"><?= $no++; ?></td>

                    <!-- Data Pribadi -->
                    <td><?= isset($row->nama) ? $row->nama : '-'; ?></td>
                    <td><?= isset($row->nama_panggilan) ? $row->nama_panggilan : '-'; ?></td>
                    <td>'<?= isset($row->nik) ? $row->nik : '-'; ?></td>
                    <td>'<?= isset($row->nisn) ? $row->nisn : '-'; ?></td>
                    <td>'<?= isset($row->no_induk) ? $row->no_induk : '-'; ?></td>
                    <td align="center"><?= isset($row->jk) ? $row->jk : '-'; ?></td>
                    <td><?= isset($row->tempat_lahir) ? $row->tempat_lahir : '-'; ?></td>
                    <td align="center"><?= !empty($row->tanggal_lahir) ? date('d/m/Y', strtotime($row->tanggal_lahir)) : '-'; ?></td>
                    <td>'<?= isset($row->no_kk) ? $row->no_kk : '-'; ?></td>
                    <td>'<?= isset($row->no_akte_lahir) ? $row->no_akte_lahir : '-'; ?></td>
                    <td><?= isset($row->agama) ? $row->agama : '-'; ?></td>
                    <td><?= isset($row->kewarganegaraan_siswa) ? $row->kewarganegaraan_siswa : '-'; ?></td>
                    <td><?= isset($row->berkebutuhan_khusus) ? $row->berkebutuhan_khusus : '-'; ?></td>
                    <td><?= isset($row->status_orang_tua) ? $row->status_orang_tua : '-'; ?></td>
                    <td><?= isset($row->bahasa_sehari_hari) ? $row->bahasa_sehari_hari : '-'; ?></td>

                    <!-- Alamat & Tempat Tinggal -->
                    <td><?= isset($row->jalan) ? $row->jalan : '-'; ?></td>
                    <td><?= isset($row->dusun) ? $row->dusun : '-'; ?></td>
                    <td align="center"><?= isset($row->rt) ? $row->rt : '-'; ?></td>
                    <td align="center"><?= isset($row->rw) ? $row->rw : '-'; ?></td>
                    <td><?= isset($row->desa) ? $row->desa : '-'; ?></td>
                    <td><?= isset($row->kecamatan) ? $row->kecamatan : '-'; ?></td>
                    <td><?= isset($row->kabupaten) ? $row->kabupaten : '-'; ?></td>
                    <td><?= isset($row->provinsi) ? $row->provinsi : '-'; ?></td>
                    <td><?= isset($row->lintang) ? $row->lintang : '-'; ?></td>
                    <td><?= isset($row->bujur) ? $row->bujur : '-'; ?></td>
                    <td><?= isset($row->tempat_tinggal) ? $row->tempat_tinggal : '-'; ?></td>
                    <td><?= isset($row->moda_transportasi) ? $row->moda_transportasi : '-'; ?></td>
                    <td>'<?= isset($row->no_hp) ? $row->no_hp : '-'; ?></td>

                    <!-- Ayah Kandung -->
                    <td><?= isset($row->ayah_nama) ? $row->ayah_nama : '-'; ?></td>
                    <td><?= isset($row->ayah_status) ? $row->ayah_status : '-'; ?></td>
                    <td>'<?= isset($row->ayah_nik) ? $row->ayah_nik : '-'; ?></td>
                    <td align="center"><?= isset($row->ayah_tahun_lahir) ? $row->ayah_tahun_lahir : '-'; ?></td>
                    <td><?= isset($row->ayah_pendidikan) ? $row->ayah_pendidikan : '-'; ?></td>
                    <td><?= isset($row->ayah_pekerjaan) ? $row->ayah_pekerjaan : '-'; ?></td>
                    <td><?= isset($row->ayah_penghasilan) ? $row->ayah_penghasilan : '-'; ?></td>
                    <td><?= isset($row->ayah_jalan) ? $row->ayah_jalan : '-'; ?></td>
                    <td><?= isset($row->ayah_dusun) ? $row->ayah_dusun : '-'; ?></td>
                    <td align="center"><?= isset($row->ayah_rt) ? $row->ayah_rt : '-'; ?></td>
                    <td align="center"><?= isset($row->ayah_rw) ? $row->ayah_rw : '-'; ?></td>
                    <td>'<?= isset($row->ayah_no_hp) ? $row->ayah_no_hp : '-'; ?></td>

                    <!-- Ibu Kandung -->
                    <td><?= isset($row->ibu_nama) ? $row->ibu_nama : '-'; ?></td>
                    <td><?= isset($row->ibu_status) ? $row->ibu_status : '-'; ?></td>
                    <td>'<?= isset($row->ibu_nik) ? $row->ibu_nik : '-'; ?></td>
                    <td align="center"><?= isset($row->ibu_tahun_lahir) ? $row->ibu_tahun_lahir : '-'; ?></td>
                    <td><?= isset($row->ibu_pendidikan) ? $row->ibu_pendidikan : '-'; ?></td>
                    <td><?= isset($row->ibu_pekerjaan) ? $row->ibu_pekerjaan : '-'; ?></td>
                    <td><?= isset($row->ibu_penghasilan) ? $row->ibu_penghasilan : '-'; ?></td>
                    <td><?= isset($row->ibu_jalan) ? $row->ibu_jalan : '-'; ?></td>
                    <td><?= isset($row->ibu_dusun) ? $row->ibu_dusun : '-'; ?></td>
                    <td align="center"><?= isset($row->ibu_rt) ? $row->ibu_rt : '-'; ?></td>
                    <td align="center"><?= isset($row->ibu_rw) ? $row->ibu_rw : '-'; ?></td>
                    <td>'<?= isset($row->ibu_no_hp) ? $row->ibu_no_hp : '-'; ?></td>

                    <!-- Wali Siswa -->
                    <td><?= isset($row->wali_nama) ? $row->wali_nama : '-'; ?></td>
                    <td>'<?= isset($row->wali_nik) ? $row->wali_nik : '-'; ?></td>
                    <td><?= isset($row->wali_status_hubungan) ? $row->wali_status_hubungan : '-'; ?></td>
                    <td align="center"><?= isset($row->wali_tahun_lahir) ? $row->wali_tahun_lahir : '-'; ?></td>
                    <td><?= isset($row->wali_pendidikan) ? $row->wali_pendidikan : '-'; ?></td>
                    <td><?= isset($row->wali_pekerjaan) ? $row->wali_pekerjaan : '-'; ?></td>
                    <td><?= isset($row->wali_penghasilan) ? $row->wali_penghasilan : '-'; ?></td>
                    <td><?= isset($row->wali_jalan) ? $row->wali_jalan : '-'; ?></td>
                    <td><?= isset($row->wali_dusun) ? $row->wali_dusun : '-'; ?></td>
                    <td align="center"><?= isset($row->wali_rt) ? $row->wali_rt : '-'; ?></td>
                    <td align="center"><?= isset($row->wali_rw) ? $row->wali_rw : '-'; ?></td>
                    <td>'<?= isset($row->wali_no_hp) ? $row->wali_no_hp : '-'; ?></td>

                    <!-- Data Periodik & Kesehatan -->
                    <td align="center"><?= isset($row->tinggi_badan) ? $row->tinggi_badan : '-'; ?></td>
                    <td align="center"><?= isset($row->berat_badan) ? $row->berat_badan : '-'; ?></td>
                    <td align="center"><?= isset($row->lingkar_kepala) ? $row->lingkar_kepala : '-'; ?></td>
                    <td><?= isset($row->jarak_tempuh_kategori) ? $row->jarak_tempuh_kategori : '-'; ?></td>
                    <td align="center"><?= isset($row->jarak_km) ? $row->jarak_km : '-'; ?></td>
                    <td><?= isset($row->waktu_tempuh) ? $row->waktu_tempuh : '-'; ?></td>
                    <td align="center"><?= isset($row->jml_saudara_kandung) ? $row->jml_saudara_kandung : '0'; ?></td>
                    <td align="center"><?= isset($row->anak_ke) ? $row->anak_ke : '-'; ?></td>
                    <td align="center"><?= isset($row->jml_saudara_tiri) ? $row->jml_saudara_tiri : '0'; ?></td>
                    <td align="center"><?= isset($row->jml_saudara_angkat) ? $row->jml_saudara_angkat : '0'; ?></td>
                    <td><?= isset($row->riwayat_penyakit) ? $row->riwayat_penyakit : '-'; ?></td>
                    <td align="center"><?= isset($row->golongan_darah) ? $row->golongan_darah : '-'; ?></td>

                    <!-- Data Pendaftaran & Masuk Sekolah -->
                    <td><?= isset($row->jenis_pendaftaran) ? $row->jenis_pendaftaran : '-'; ?></td>
                    <td align="center"><?= isset($row->diterima_di_kelas) ? $row->diterima_di_kelas : '-'; ?></td>
                    <td><?= isset($row->bidang_keahlian) ? $row->bidang_keahlian : '-'; ?></td>
                    <td><?= isset($row->program_keahlian) ? $row->program_keahlian : '-'; ?></td>
                    <td><?= isset($row->konsentrasi_keahlian) ? $row->konsentrasi_keahlian : '-'; ?></td>
                    <td align="center"><?= !empty($row->tanggal_masuk) ? date('d/m/Y', strtotime($row->tanggal_masuk)) : '-'; ?></td>
                    <td><?= isset($row->asal_sekolah) ? $row->asal_sekolah : '-'; ?></td>
                    <td>'<?= isset($row->no_ijazah_smp) ? $row->no_ijazah_smp : '-'; ?></td>
                    <td align="center"><?= !empty($row->tanggal_ijazah_smp) ? date('d/m/Y', strtotime($row->tanggal_ijazah_smp)) : '-'; ?></td>

                    <!-- Tingkat Kelas & Rombel -->
                    <td align="center"><?= isset($row->nama_tingkat) ? $row->nama_tingkat : '-'; ?></td>
                    <td align="center"><?= isset($row->nama_kelas) ? $row->nama_kelas : 'Belum Ada Rombel'; ?></td>

                    <!-- Data Kelulusan (Paling Akhir) -->
                    <td>'<?= isset($row->nomor_ijazah) ? $row->nomor_ijazah : '-'; ?></td>
                    <td align="center"><?= !empty($row->tanggal_ijazah) ? date('d/m/Y', strtotime($row->tanggal_ijazah)) : '-'; ?></td>
                    <td><?= isset($row->melanjutkan_ke) ? $row->melanjutkan_ke : '-'; ?></td>
                    <td><?= isset($row->bekerja_di) ? $row->bekerja_di : '-'; ?></td>
                    <td align="center"><?= !empty($row->tanggal_mulai_bekerja) ? date('d/m/Y', strtotime($row->tanggal_mulai_bekerja)) : '-'; ?></td>
                    <td><?= isset($row->nama_perusahaan) ? $row->nama_perusahaan : '-'; ?></td>
                    <td><?= isset($row->penghasilan_lulus) ? $row->penghasilan_lulus : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>