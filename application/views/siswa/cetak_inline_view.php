<div class="h-auto min-h-screen p-4 sm:p-6 space-y-6 overflow-y-auto">

    <!-- Toolbar Tombol Refresh & Cetak -->
    <div class="no-print bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs font-semibold text-gray-700 dark:text-gray-300">
            <i class="fa-solid fa-file-pdf text-red-600"></i>
            <span>Pratinjau Dokumen Peserta Didik (A4 Compliant)</span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="location.reload();" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl flex items-center gap-1.5 transition">
                <i class="fa-solid fa-rotate"></i> Refresh
            </button>
            <button type="button" onclick="window.print();" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl flex items-center gap-1.5 shadow-sm transition">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Lembar Dokumen Formulir A4 -->
    <div class="flex justify-center pb-32 pt-4 px-6">
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl border border-gray-300 p-6 text-black print-area">

            <?php if (!empty($siswa)) : ?>
                <?php foreach ($siswa as $row) : ?>

                    <!-- KOP FORMULIR -->
                    <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 8px; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 3px;">
                        DATA PESERTA DIDIK SMK PGRI PESANGGARAN
                    </div>

                    <?php
                    $foto_dokumen = $this->db->get_where('dokumen_siswa', [
                        'siswa_id' => $row->id,
                        'jenis_dokumen' => 'foto_diri'
                    ])->row();

                    // Ambil nama wilayah siswa
                    $siswa_prov = !empty($row->province_id) ? ($this->db->get_where('wilayah_provinsi', ['id' => $row->province_id])->row()->nama ?? '-') : '-';
                    $siswa_kab  = !empty($row->regency_id) ? ($this->db->get_where('wilayah_kabupaten', ['id' => $row->regency_id])->row()->nama ?? '-') : '-';
                    $siswa_kec  = !empty($row->district_id) ? ($this->db->get_where('wilayah_kecamatan', ['id' => $row->district_id])->row()->nama ?? '-') : '-';
                    $siswa_des  = !empty($row->village_id) ? ($this->db->get_where('wilayah_desa', ['id' => $row->village_id])->row()->nama ?? '-') : '-';

                    // Ambil nama wilayah ayah, ibu, wali
                    $ayah_prov = !empty($row->ayah_province_id) ? ($this->db->get_where('wilayah_provinsi', ['id' => $row->ayah_province_id])->row()->nama ?? '-') : '-';
                    $ayah_kab  = !empty($row->ayah_regency_id) ? ($this->db->get_where('wilayah_kabupaten', ['id' => $row->ayah_regency_id])->row()->nama ?? '-') : '-';
                    $ayah_kec  = !empty($row->ayah_district_id) ? ($this->db->get_where('wilayah_kecamatan', ['id' => $row->ayah_district_id])->row()->nama ?? '-') : '-';
                    $ayah_des  = !empty($row->ayah_village_id) ? ($this->db->get_where('wilayah_desa', ['id' => $row->ayah_village_id])->row()->nama ?? '-') : '-';

                    $ibu_prov  = !empty($row->ibu_province_id) ? ($this->db->get_where('wilayah_provinsi', ['id' => $row->ibu_province_id])->row()->nama ?? '-') : '-';
                    $ibu_kab   = !empty($row->ibu_regency_id) ? ($this->db->get_where('wilayah_kabupaten', ['id' => $row->ibu_regency_id])->row()->nama ?? '-') : '-';
                    $ibu_kec   = !empty($row->ibu_district_id) ? ($this->db->get_where('wilayah_kecamatan', ['id' => $row->ibu_district_id])->row()->nama ?? '-') : '-';
                    $ibu_des   = !empty($row->ibu_village_id) ? ($this->db->get_where('wilayah_desa', ['id' => $row->ibu_village_id])->row()->nama ?? '-') : '-';

                    $wali_prov = !empty($row->wali_province_id) ? ($this->db->get_where('wilayah_provinsi', ['id' => $row->wali_province_id])->row()->nama ?? '-') : '-';
                    $wali_kab  = !empty($row->wali_regency_id) ? ($this->db->get_where('wilayah_kabupaten', ['id' => $row->wali_regency_id])->row()->nama ?? '-') : '-';
                    $wali_kec  = !empty($row->wali_district_id) ? ($this->db->get_where('wilayah_kecamatan', ['id' => $row->wali_district_id])->row()->nama ?? '-') : '-';
                    $wali_des  = !empty($row->wali_village_id) ? ($this->db->get_where('wilayah_desa', ['id' => $row->wali_village_id])->row()->nama ?? '-') : '-';

                    // Ambil data relasi tambahan dari database
                    $data_prestasi      = $this->db->get_where('prestasi_siswa', ['siswa_id' => $row->id])->result();
                    $data_beasiswa      = $this->db->get_where('beasiswa_siswa', ['siswa_id' => $row->id])->result();
                    $data_kesejahteraan = $this->db->get_where('kesejahteraan_siswa', ['siswa_id' => $row->id])->result();
                    $data_registrasi    = $this->db->get_where('registrasi_masuk', ['siswa_id' => $row->id])->row();
                    ?>

                    <!-- HALAMAN 1: I sampai IV (Data Pribadi, Alamat, Orang Tua, Wali) -->
                    <div class="page-content">
                        <!-- I. DATA PRIBADI SISWA + FOTO -->
                        <div style="border: 1px solid #333; margin-bottom: 4px; padding: 3px 5px;">
                            <div style="font-weight: bold; font-size: 8pt; background-color: #e5e7eb; padding: 2px 4px; margin: -3px -5px 3px -5px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                I. Data Pribadi Siswa
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <tr>
                                    <td style="width: 82%; vertical-align: top; padding-right: 6px;">
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 22%; font-weight: 600; padding: 1px;">Nama Lengkap</td>
                                                <td style="width: 28%; border-bottom: 1px dotted #666; padding: 1px;"><b><?= $row->nama ?? '-'; ?></b></td>
                                                <td style="width: 20%; font-weight: 600; padding-left: 6px;">Panggilan</td>
                                                <td style="width: 30%; border-bottom: 1px dotted #666; padding: 1px;"><?= $row->nama_panggilan ?? '-'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; padding: 1px;">NIK</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->nik ?? '-'; ?></td>
                                                <td style="font-weight: 600; padding-left: 6px;">NISN / No. Induk</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->nisn ?? '-'; ?> / <?= $row->no_induk ?? '-'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; padding: 1px;">Jenis Kelamin</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= isset($row->jk) ? ($row->jk == 'L' ? 'Laki-laki' : 'Perempuan') : '-'; ?></td>
                                                <td style="font-weight: 600; padding-left: 6px;">Tempat, Tgl Lahir</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->tempat_lahir ?? '-'; ?>, <?= (!empty($row->tanggal_lahir) && $row->tanggal_lahir != '0000-00-00') ? date('d-m-Y', strtotime($row->tanggal_lahir)) : '-'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; padding: 1px;">No. KK</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->no_kk ?? '-'; ?></td>
                                                <td style="font-weight: 600; padding-left: 6px;">No. Akte Lahir</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->no_akte_lahir ?? '-'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; padding: 1px;">Agama</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->agama ?? '-'; ?></td>
                                                <td style="font-weight: 600; padding-left: 6px;">Kewarganegaraan</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->kewarganegaraan_siswa ?? 'Indonesia'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; padding: 1px;">Kebutuhan Khusus</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->berkebutuhan_khusus ?? 'Tidak Ada'; ?></td>
                                                <td style="font-weight: 600; padding-left: 6px;">Status dlm Ortu</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->status_orang_tua ?? '-'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; padding: 1px;">Bahasa Sehari-hari</td>
                                                <td style="border-bottom: 1px dotted #666; padding: 1px;" colspan="3"><?= $row->bahasa_sehari_hari ?? '-'; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 18%; vertical-align: middle; text-align: center; border-left: 1px solid #ddd; padding-left: 6px;">
                                        <div style="width: 2.3cm; height: 3.1cm; border: 1px solid #333; margin: 0 auto; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; overflow: hidden; position: relative;">
                                            <?php if (!empty($foto_dokumen) && file_exists('./uploads/dokumen/' . $foto_dokumen->nama_file)) : ?>
                                                <img src="<?= base_url('uploads/dokumen/' . $foto_dokumen->nama_file); ?>" alt="Foto Siswa" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else : ?>
                                                <div style="font-size: 7px; color: #6b7280; text-align: center; padding: 2px; line-height: 1.2;">
                                                    <b>FOTO</b><br>3 x 4<br><span style="font-size: 5.5px; color: #9ca3af;">(Belum Ada)</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- II. DATA ALAMAT & TEMPAT TINGGAL -->
                        <div style="border: 1px solid #333; margin-bottom: 4px; padding: 3px 5px;">
                            <div style="font-weight: bold; font-size: 8pt; background-color: #e5e7eb; padding: 2px 4px; margin: -3px -5px 3px -5px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                II. Data Alamat & Tempat Tinggal
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <tr>
                                    <td style="width: 18%; font-weight: 600; padding: 1px;">Jalan / Dusun</td>
                                    <td style="width: 32%; border-bottom: 1px dotted #666; padding: 1px;"><?= $row->jalan ?? '-'; ?> / <?= $row->dusun ?? '-'; ?></td>
                                    <td style="width: 18%; font-weight: 600; padding-left: 6px;">RT / RW</td>
                                    <td style="width: 32%; border-bottom: 1px dotted #666; padding: 1px;"><?= $row->rt ?? '-'; ?> / <?= $row->rw ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1px;">Desa / Kelurahan</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $siswa_des; ?></td>
                                    <td style="font-weight: 600; padding-left: 6px;">Kecamatan</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $siswa_kec; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1px;">Kabupaten / Kota</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $siswa_kab; ?></td>
                                    <td style="font-weight: 600; padding-left: 6px;">Provinsi</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $siswa_prov; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1px;">Koordinat (Lintang/Bujur)</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->lintang ?? '-'; ?> / <?= $row->bujur ?? '-'; ?></td>
                                    <td style="font-weight: 600; padding-left: 6px;">Tempat Tinggal</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->tempat_tinggal ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1px;">Moda Transportasi</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->moda_transportasi ?? '-'; ?></td>
                                    <td style="font-weight: 600; padding-left: 6px;">No. HP / WA Siswa</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1px;"><?= $row->no_hp ?? '-'; ?></td>
                                </tr>
                            </table>
                        </div>

                        <!-- III. IDENTITAS ORANG TUA KANDUNG -->
                        <div style="border: 1px solid #333; margin-bottom: 4px; padding: 3px 5px;">
                            <div style="font-weight: bold; font-size: 8pt; background-color: #e5e7eb; padding: 2px 4px; margin: -3px -5px 3px -5px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                III. Identitas Orang Tua Kandung
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <tr>
                                    <td style="width: 22%; font-weight: 600; border: 1px solid #333; padding: 1.5px; background-color: #f3f4f6;">Keterangan</td>
                                    <td style="width: 39%; font-weight: bold; text-align: left; padding-left: 6px; border: 1px solid #333; background-color: #f3f4f6;">AYAH KANDUNG</td>
                                    <td style="width: 39%; font-weight: bold; text-align: left; padding-left: 6px; border: 1px solid #333; background-color: #f3f4f6;">IBU KANDUNG</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Nama Lengkap</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><b><?= $row->ayah_nama ?? '-'; ?></b></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><b><?= $row->ibu_nama ?? '-'; ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Status Ayah / Ibu</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ayah_status ?? '-'; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ibu_status ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">NIK</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ayah_nik ?? '-'; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ibu_nik ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Tahun Lahir</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= (!empty($row->ayah_tahun_lahir) && $row->ayah_tahun_lahir != '0000') ? $row->ayah_tahun_lahir : '-'; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= (!empty($row->ibu_tahun_lahir) && $row->ibu_tahun_lahir != '0000') ? $row->ibu_tahun_lahir : '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Pendidikan / Pekerjaan</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ayah_pendidikan ?? '-'; ?> / <?= $row->ayah_pekerjaan ?? '-'; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ibu_pendidikan ?? '-'; ?> / <?= $row->ibu_pekerjaan ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Penghasilan Bulanan</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ayah_penghasilan ?? '-'; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ibu_penghasilan ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Alamat / Dusun / RT/RW</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ayah_jalan ?? '-'; ?> (RT <?= $row->ayah_rt ?? '-'; ?>/RW <?= $row->ayah_rw ?? '-'; ?>)</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ibu_jalan ?? '-'; ?> (RT <?= $row->ibu_rt ?? '-'; ?>/RW <?= $row->ibu_rw ?? '-'; ?>)</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Desa / Kelurahan</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $ayah_des; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $ibu_des; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Kecamatan</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $ayah_kec; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $ibu_kec; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Kabupaten / Provinsi</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $ayah_kab; ?>, <?= $ayah_prov; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $ibu_kab; ?>, <?= $ibu_prov; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">No. HP / WhatsApp</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ayah_no_hp ?? '-'; ?></td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->ibu_no_hp ?? '-'; ?></td>
                                </tr>
                            </table>
                        </div>

                        <!-- IV. IDENTITAS WALI SISWA -->
                        <div style="border: 1px solid #333; margin-bottom: 4px; padding: 3px 5px;">
                            <div style="font-weight: bold; font-size: 8pt; background-color: #e5e7eb; padding: 2px 4px; margin: -3px -5px 3px -5px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                IV. Identitas Wali Siswa <span style="font-weight: normal; font-size: 7.5pt; color: #555;">(Diisi jika tinggal dengan wali)</span>
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <tr>
                                    <td style="width: 22%; font-weight: 600; border: 1px solid #333; padding: 1px; background-color: #f3f4f6;">Nama Lengkap Wali</td>
                                    <td style="width: 39%; text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><b><?= $row->wali_nama ?? '-'; ?></b></td>
                                    <td style="width: 14%; font-weight: 600; border: 1px solid #333; padding: 1px; background-color: #f3f4f6;">Status Hub</td>
                                    <td style="width: 25%; text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->wali_status_hubungan ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">NIK / Tahun Lahir</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->wali_nik ?? '-'; ?> / <?= (!empty($row->wali_tahun_lahir) && $row->wali_tahun_lahir != '0000') ? $row->wali_tahun_lahir : '-'; ?></td>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px; background-color: #f3f4f6;">Pendidikan</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->wali_pendidikan ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px;">Pekerjaan / Penghasilan</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->wali_pekerjaan ?? '-'; ?> (<?= $row->wali_penghasilan ?? '-'; ?>)</td>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px; background-color: #f3f4f6;">No. HP Wali</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;"><?= $row->wali_no_hp ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px; background-color: #f3f4f6;">Alamat / Desa</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;" colspan="3"><?= $row->wali_jalan ?? '-'; ?> (RT <?= $row->wali_rt ?? '-'; ?>/RW <?= $row->wali_rw ?? '-'; ?>), Desa <?= $wali_des; ?>, Kec. <?= $wali_kec; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; border: 1px solid #333; padding: 1px; background-color: #f3f4f6;">Kabupaten / Provinsi</td>
                                    <td style="text-align: left; padding-left: 6px; border: 1px solid #333; padding: 1px;" colspan="3"><?= $wali_kab; ?>, Prov. <?= $wali_prov; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- PEMAKSAAN PINDAH HALAMAN KEDUA UNTUK BAGIAN V SAMPAI IX -->
                    <div class="page-break"></div>

                    <!-- HALAMAN 2: V sampai IX (Data Periodik, Prestasi, Beasiswa, Kesejahteraan, Registrasi) -->
                    <div class="page-content">
                        <!-- V. DATA PERIODIK & FISIK SISWA -->
                        <div style="border: 1px solid #333; margin-bottom: 6px; padding: 4px 6px;">
                            <div style="font-weight: bold; font-size: 8.5pt; background-color: #e5e7eb; padding: 2.5px 5px; margin: -4px -6px 4px -6px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                V. Data Periodik & Fisik Siswa
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <tr>
                                    <td style="width: 20%; font-weight: 600; padding: 1.5px;">Tinggi / Berat Badan</td>
                                    <td style="width: 30%; border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->tinggi_badan ?? '-'; ?> cm / <?= $row->berat_badan ?? '-'; ?> kg</td>
                                    <td style="width: 20%; font-weight: 600; padding-left: 8px;">Lingkar Kepala</td>
                                    <td style="width: 30%; border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->lingkar_kepala ?? '-'; ?> cm</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1.5px;">Golongan Darah</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->golongan_darah ?? '-'; ?></td>
                                    <td style="font-weight: 600; padding-left: 8px;">Riwayat Penyakit</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->riwayat_penyakit ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1.5px;">Jarak Tempuh / KM</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->jarak_tempuh_kategori ?? '-'; ?> (<?= $row->jarak_km ?? '0'; ?> km)</td>
                                    <td style="font-weight: 600; padding-left: 8px;">Waktu Tempuh</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->waktu_tempuh ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1.5px;">Anak ke- / Kandung</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->anak_ke ?? '-'; ?> dari <?= $row->jml_saudara_kandung ?? '0'; ?> bersaudara</td>
                                    <td style="font-weight: 600; padding-left: 8px;">Saudara Tiri / Angkat</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $row->jml_saudara_tiri ?? '0'; ?> tiri, <?= $row->jml_saudara_angkat ?? '0'; ?> angkat</td>
                                </tr>
                            </table>
                        </div>

                        <!-- VI. PRESTASI SISWA (BERBENTUK TABEL) -->
                        <div style="border: 1px solid #333; margin-bottom: 6px; padding: 4px 6px;">
                            <div style="font-weight: bold; font-size: 8.5pt; background-color: #e5e7eb; padding: 2.5px 5px; margin: -4px -6px 4px -6px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                VI. Riwayat Prestasi Siswa
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <thead>
                                    <tr style="background-color: #f3f4f6;">
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 5%;">No</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 25%;">Nama Prestasi</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 15%;">Jenis</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 15%;">Tingkat</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 10%;">Tahun</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 15%;">Penyelenggara</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 15%;">Peringkat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data_prestasi)) : ?>
                                        <?php $no = 1;
                                        foreach ($data_prestasi as $p) : ?>
                                            <tr>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $no++; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px;"><?= $p->nama_prestasi ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $p->jenis ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $p->tingkat ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $p->tahun ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $p->penyelenggara ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $p->peringkat ?? '-'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" style="border: 1px solid #333; padding: 3.5px; text-align: center; color: #6b7280; font-style: italic;">Tidak ada data prestasi</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- VII. DATA BEASISWA (BERBENTUK TABEL) -->
                        <div style="border: 1px solid #333; margin-bottom: 6px; padding: 4px 6px;">
                            <div style="font-weight: bold; font-size: 8.5pt; background-color: #e5e7eb; padding: 2.5px 5px; margin: -4px -6px 4px -6px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                VII. Riwayat Beasiswa Siswa
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <thead>
                                    <tr style="background-color: #f3f4f6;">
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 5%;">No</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 30%;">Jenis Beasiswa</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 35%;">Keterangan</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 15%;">Tahun Mulai</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 15%;">Tahun Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data_beasiswa)) : ?>
                                        <?php $no = 1;
                                        foreach ($data_beasiswa as $b) : ?>
                                            <tr>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $no++; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px;"><?= $b->jenis ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px;"><?= $b->keterangan ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $b->tahun_mulai ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $b->tahun_selesai ?? '-'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" style="border: 1px solid #333; padding: 3.5px; text-align: center; color: #6b7280; font-style: italic;">Tidak ada data beasiswa</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- VIII. KESEJAHTERAAN / BANTUAN SOSIAL -->
                        <div style="border: 1px solid #333; margin-bottom: 6px; padding: 4px 6px;">
                            <div style="font-weight: bold; font-size: 8.5pt; background-color: #e5e7eb; padding: 2.5px 5px; margin: -4px -6px 4px -6px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                VIII. Kesejahteraan Peserta Didik (KIP / PKH / PIP dll)
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <thead>
                                    <tr style="background-color: #f3f4f6;">
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 5%;">No</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 35%;">Jenis Kartu / Bantuan</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 30%;">No. Kartu</th>
                                        <th style="border: 1px solid #333; padding: 2.5px; width: 30%;">Nama di Kartu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data_kesejahteraan)) : ?>
                                        <?php $no = 1;
                                        foreach ($data_kesejahteraan as $k) : ?>
                                            <tr>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $no++; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px;"><?= $k->jenis ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px; text-align: center;"><?= $k->no_kartu ?? '-'; ?></td>
                                                <td style="border: 1px solid #333; padding: 2.5px;"><?= $k->nama_kartu ?? '-'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" style="border: 1px solid #333; padding: 3.5px; text-align: center; color: #6b7280; font-style: italic;">Tidak ada data kesejahteraan</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- IX. REGISTRASI MASUK -->
                        <div style="border: 1px solid #333; margin-bottom: 4px; padding: 4px 6px;">
                            <div style="font-weight: bold; font-size: 8.5pt; background-color: #e5e7eb; padding: 2.5px 5px; margin: -4px -6px 4px -6px; border-bottom: 1px solid #333; text-transform: uppercase;">
                                IX. Registrasi Masuk Sekolah
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                                <tr>
                                    <td style="width: 20%; font-weight: 600; padding: 1.5px;">Jenis Pendaftaran</td>
                                    <td style="width: 30%; border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->jenis_pendaftaran ?? '-'; ?></td>
                                    <td style="width: 20%; font-weight: 600; padding-left: 8px;">Diterima di Kelas</td>
                                    <td style="width: 30%; border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->diterima_di_kelas ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1.5px;">Bidang Keahlian</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->bidang_keahlian ?? '-'; ?></td>
                                    <td style="font-weight: 600; padding-left: 8px;">Program Keahlian</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->program_keahlian ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1.5px;">Konsentrasi Keahlian</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->konsentrasi_keahlian ?? '-'; ?></td>
                                    <td style="font-weight: 600; padding-left: 8px;">Tanggal Masuk</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= (!empty($data_registrasi->tanggal_masuk) && $data_registrasi->tanggal_masuk != '0000-00-00') ? date('d-m-Y', strtotime($data_registrasi->tanggal_masuk)) : '-'; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 1.5px;">Asal Sekolah</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->asal_sekolah ?? '-'; ?></td>
                                    <td style="font-weight: 600; padding-left: 8px;">No. Ijazah / Tgl SMP</td>
                                    <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->no_ijazah_smp ?? '-'; ?> (<?= $data_registrasi->tanggal_ijazah_smp ?? '-'; ?>)</td>
                                </tr>
                                <?php if (isset($data_registrasi->jenis_pendaftaran) && $data_registrasi->jenis_pendaftaran === 'Pindahan') : ?>
                                    <tr>
                                        <td style="font-weight: 600; padding: 1.5px;">Sekolah Sebelumnya</td>
                                        <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->sekolah_sebelumnya ?? '-'; ?></td>
                                        <td style="font-weight: 600; padding-left: 8px;">Alasan Pindah</td>
                                        <td style="border-bottom: 1px dotted #666; padding: 1.5px;"><?= $data_registrasi->alasan_pindah ?? '-'; ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                    <!-- Pemisah Antar Siswa -->
                    <div style="page-break-after: always;"></div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- Aturan Margin Kertas A4 & CSS Cetak -->
<style>
    @page {
        size: A4;
        margin: 8mm 12mm 8mm 12mm;
    }

    @media print {

        aside,
        nav,
        header,
        footer,
        button,
        .no-print,
        .bg-white.dark\:bg-gray-800:first-of-type {
            display: none !important;
        }

        body,
        main,
        div {
            background: #fff !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .print-area {
            width: 100% !important;
            max-width: 100% !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }
    }
</style>