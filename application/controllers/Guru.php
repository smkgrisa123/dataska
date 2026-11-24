<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Guru');
    }

    public function index()
    {
        $data['guru'] = $this->M_Guru->get_all_guru();
        $data['tugas_tambahan'] = $this->M_Guru->get_master_tugas_tambahan();
        $data['peran']          = $this->M_Guru->get_master_peran();
        $this->load->view('template/header', $data);
        $this->load->view('guru/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'jk'           => $this->input->post('jk'),
            'tmp_lahir'    => $this->input->post('tmp_lahir'),
            'tgl_lahir'    => $this->input->post('tgl_lahir'),
            'nik'          => $this->input->post('nik'),
            'nuptk'        => $this->input->post('nuptk'),
            'no_hp'        => $this->input->post('no_hp'),
            'status'       => 'Aktif',
            'created_at'   => date('Y-m-d H:i:s')
        ];
        $this->M_Guru->insert_guru($data);
        $this->session->set_flashdata('success', 'Data PTK berhasil ditambahkan!');
        redirect('guru');
    }

    // Halaman Edit dengan Tabs (Data Pribadi & Alamat)
    public function edit($id)
    {
        $data['guru'] = $this->M_Guru->get_by_id($id);
        if (!$data['guru']) {
            show_404();
        }
        // TAMBAHKAN BARIS INI UNTUK MEMUAT DATA SERTIFIKASI:
        $data['sertifikasi'] = $this->M_Guru->get_sertifikasi_by_guru($id);
        // Ambil master data pekerjaan & provinsi
        $data['master_pekerjaan'] = $this->M_Guru->get_master_pekerjaan();
        $data['provinsi']         = $this->M_Guru->get_provinsi();
        $data['pendidikan']  = $this->M_Guru->get_pendidikan_by_guru($id);
        $data['anak'] = $this->M_Guru->get_anak_by_guru($id);
        $data['diklat'] = $this->M_Guru->get_diklat_by_guru($id);
        $data['dokumen'] = $this->M_Guru->get_dokumen_by_guru($id);
        $data['tugas_tambahan'] = $this->M_Guru->get_master_tugas_tambahan();
        $data['peran']          = $this->M_Guru->get_master_peran();
        $data['penugasan']      = $this->M_Guru->get_penugasan_by_guru($id);
        $data['penugasan_list']  = $this->M_Guru->get_penugasan_by_guru($id);
        $data['tugas_tambahan']  = $this->M_Guru->get_master_tugas_tambahan(); // Sesuaikan nama fungsi model Anda
        $data['peran']           = $this->M_Guru->get_master_peran();           // Sesuaikan nama fungsi model Anda

        // Ambil data wilayah awal berdasarkan yang tersimpan di database
        $data['kabupaten'] = !empty($data['guru']->wilayah_provinsi_id) ? $this->M_Guru->get_kabupaten_by_prov($data['guru']->wilayah_provinsi_id) : [];
        $data['kecamatan'] = !empty($data['guru']->wilayah_kabupaten_id) ? $this->M_Guru->get_kecamatan_by_kab($data['guru']->wilayah_kabupaten_id) : [];
        $data['desa']      = !empty($data['guru']->wilayah_kecamatan_id) ? $this->M_Guru->get_desa_by_kec($data['guru']->wilayah_kecamatan_id) : [];


        $this->load->view('template/header', $data);
        $this->load->view('guru/edit', $data);
        $this->load->view('template/footer');
    }

    // Proses Update Data Lengkap (Data Pribadi & Alamat)
    public function update($id)
    {

        $data = [
            'nama_lengkap'              => $this->input->post('nama_lengkap'),
            'nik'                       => $this->input->post('nik'),
            'jk'                        => $this->input->post('jk'),
            'tmp_lahir'                 => $this->input->post('tmp_lahir'),
            'tgl_lahir'                 => $this->input->post('tgl_lahir'),
            'nama_ibu_kandung'          => $this->input->post('nama_ibu_kandung'),
            'no_kk'                     => $this->input->post('no_kk'),
            'agama'                     => $this->input->post('agama'),
            'npwp'                      => $this->input->post('npwp'),
            'nama_wajib_pajak'          => $this->input->post('nama_wajib_pajak'),
            'kewarganegaraan'           => $this->input->post('kewarganegaraan'),
            'status_perkawinan'         => $this->input->post('status_perkawinan'),
            'nama_suami_istri'          => $this->input->post('nama_suami_istri'),
            'nip_suami_istri'           => $this->input->post('nip_suami_istri'),
            'pekerjaan_suami_istri_id'  => $this->input->post('pekerjaan_suami_istri_id'),
            // Data Alamat
            'alamat_jalan'              => $this->input->post('alamat_jalan'),
            'dusun'                     => $this->input->post('dusun'),
            'rt'                        => $this->input->post('rt'),
            'rw'                        => $this->input->post('rw'),
            'wilayah_provinsi_id'       => $this->input->post('wilayah_provinsi_id'),
            'wilayah_kabupaten_id'      => $this->input->post('wilayah_kabupaten_id'),
            'wilayah_kecamatan_id'      => $this->input->post('wilayah_kecamatan_id'),
            'wilayah_desa_id'           => $this->input->post('wilayah_desa_id'),
            'no_hp'                 => $this->input->post('no_hp'),
            'email'                 => $this->input->post('email'),


            // Data Kepegawaian
            'status_kepegawaian'   => $this->input->post('status_kepegawaian'),
            'nip'                   => $this->input->post('nip'),
            'niy_nigk'              => $this->input->post('niy_nigk'),
            'nuptk'                 => $this->input->post('nuptk'),
            'jenis_ptk'             => $this->input->post('jenis_ptk'),
            'sk_pengangkatan'       => $this->input->post('sk_pengangkatan'),
            'tmt_pengangkatan'      => $this->input->post('tmt_pengangkatan'),
            'lembaga_pengangkat'    => $this->input->post('lembaga_pengangkat'),
            'updated_at'            => date('Y-m-d H:i:s')
        ];

        $this->M_Guru->update_guru($id, $data);
        $this->session->set_flashdata('success', 'Data PTK berhasil diperbarui!');
        redirect('guru/edit/' . $id);
    }

    // Fungsi AJAX untuk Dropdown Bertingkat Wilayah
    public function get_kabupaten_ajax()
    {
        $provinsi_id = $this->input->post('provinsi_id');
        $data = $this->M_Guru->get_kabupaten_by_prov($provinsi_id);
        echo json_encode($data);
    }

    public function get_kecamatan_ajax()
    {
        $kabupaten_id = $this->input->post('kabupaten_id');
        $data = $this->M_Guru->get_kecamatan_by_kab($kabupaten_id);
        echo json_encode($data);
    }

    public function get_desa_ajax()
    {
        $kecamatan_id = $this->input->post('kecamatan_id');
        $data = $this->M_Guru->get_desa_by_kec($kecamatan_id);
        echo json_encode($data);
    }

    public function hapus_bulk()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->M_Guru->delete_guru($id);
            }
            $this->session->set_flashdata('success', 'Data PTK terpilih berhasil dihapus!');
        }
        redirect('guru');
    }

    // Proses Tambah Sertifikasi
    public function tambah_sertifikasi($guru_id)
    {
        $data = [
            'guru_id'           => $guru_id,
            'jenis_sertifikasi' => $this->input->post('jenis_sertifikasi'),
            'nomor_sertifikasi' => $this->input->post('nomor_sertifikasi'),
            'tahun_sertifikasi' => $this->input->post('tahun_sertifikasi'),
            'bidang_studi'      => $this->input->post('bidang_studi'),
            'nrg'               => $this->input->post('nrg'),
            'nomor_peserta'     => $this->input->post('nomor_peserta')
        ];

        $this->M_Guru->insert_sertifikasi($data);
        $this->session->set_flashdata('success', 'Riwayat sertifikasi berhasil ditambahkan!');
        redirect('guru/edit/' . $guru_id);
    }

    public function update_sertifikasi($guru_id, $sertifikasi_id)
    {
        $data = [
            'jenis_sertifikasi' => $this->input->post('jenis_sertifikasi'),
            'nomor_sertifikasi' => $this->input->post('nomor_sertifikasi'),
            'tahun_sertifikasi' => $this->input->post('tahun_sertifikasi'),
            'bidang_studi'      => $this->input->post('bidang_studi'),
            'nrg'               => $this->input->post('nrg'),
            'nomor_peserta'     => $this->input->post('nomor_peserta')
        ];

        // Panggil fungsi model untuk memperbarui data berdasarkan ID sertifikasi
        $this->M_Guru->update_sertifikasi($sertifikasi_id, $data);

        // Berikan flashdata sukses dan kembalikan ke halaman edit guru
        $this->session->set_flashdata('success', 'Riwayat sertifikasi berhasil diperbarui!');
        redirect('guru/edit/' . $guru_id);
    }
    // Proses Hapus Sertifikasi
    public function hapus_sertifikasi($guru_id, $sertifikasi_id)
    {
        $this->M_Guru->delete_sertifikasi($sertifikasi_id);
        $this->session->set_flashdata('success', 'Riwayat sertifikasi berhasil dihapus!');
        redirect('guru/edit/' . $guru_id);
    }

    public function tambah_pendidikan($guru_id)
    {
        $data = [
            'guru_id'            => $guru_id,
            'bidang_studi'       => $this->input->post('bidang_studi'),
            'jenjang_pendidikan' => $this->input->post('jenjang_pendidikan'),
            'gelar_akademik'     => $this->input->post('gelar_akademik'),
            'nama_sekolah'       => $this->input->post('nama_sekolah'),
            'tahun_masuk'        => $this->input->post('tahun_masuk'),
            'tahun_lulus'        => $this->input->post('tahun_lulus'),
            'nim'                => $this->input->post('nim'),
            'matkul'             => $this->input->post('matkul'),
            'semester'           => $this->input->post('semester'),
            'ipk'                => $this->input->post('ipk')
        ];

        // Simpan ke database melalui model M_Guru
        $this->M_Guru->insert_pendidikan($data);

        // Berikan flashdata sukses dan kembalikan ke halaman edit
        $this->session->set_flashdata('success', 'Riwayat pendidikan formal berhasil ditambahkan!');
        redirect('guru/edit/' . $guru_id);
    }

    public function update_pendidikan($guru_id, $pendidikan_id)
    {
        $data = [
            'bidang_studi'       => $this->input->post('bidang_studi'),
            'jenjang_pendidikan' => $this->input->post('jenjang_pendidikan'),
            'gelar_akademik'     => $this->input->post('gelar_akademik'),
            'nama_sekolah'       => $this->input->post('nama_sekolah'),
            'tahun_masuk'        => $this->input->post('tahun_masuk'),
            'tahun_lulus'        => $this->input->post('tahun_lulus'),
            'nim'                => $this->input->post('nim'),
            'matkul'             => $this->input->post('matkul'),
            'semester'           => $this->input->post('semester'),
            'ipk'                => $this->input->post('ipk')
        ];

        $this->M_Guru->update_pendidikan($pendidikan_id, $data);
        $this->session->set_flashdata('success', 'Riwayat pendidikan formal berhasil diperbarui!');
        redirect('guru/edit/' . $guru_id);
    }

    public function hapus_pendidikan($guru_id, $pendidikan_id)
    {
        $this->M_Guru->delete_pendidikan($pendidikan_id);
        $this->session->set_flashdata('success', 'Riwayat pendidikan formal berhasil dihapus!');
        redirect('guru/edit/' . $guru_id);
    }

    // Method Proses Tambah Anak
    public function tambah_anak($guru_id)
    {
        $data = [
            'guru_id'       => $guru_id,
            'nama'          => $this->input->post('nama'),
            'status'        => $this->input->post('status'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tempat_lahir'  => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'jenjang_pendidikan' => $this->input->post('jenjang_pendidikan'), // <--- Tambahan
            'tahun_masuk'   => $this->input->post('tahun_masuk'),
            'tahun_lulus'   => $this->input->post('tahun_lulus')
        ];

        $this->M_Guru->insert_anak($data);
        $this->session->set_flashdata('success', 'Data anak berhasil ditambahkan!');
        redirect('guru/edit/' . $guru_id);
    }

    // Method Proses Update Anak
    public function update_anak($guru_id, $anak_id)
    {
        $data = [
            'nama'          => $this->input->post('nama'),
            'status'        => $this->input->post('status'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tempat_lahir'  => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'jenjang_pendidikan' => $this->input->post('jenjang_pendidikan'), // <--- Tambahan
            'tahun_masuk'   => $this->input->post('tahun_masuk'),
            'tahun_lulus'   => $this->input->post('tahun_lulus')
        ];

        $this->M_Guru->update_anak($anak_id, $data);
        $this->session->set_flashdata('success', 'Data anak berhasil diperbarui!');
        redirect('guru/edit/' . $guru_id);
    }

    // Method Proses Hapus Anak
    public function hapus_anak($guru_id, $anak_id)
    {
        $this->M_Guru->delete_anak($anak_id);
        $this->session->set_flashdata('success', 'Data anak berhasil dihapus!');
        redirect('guru/edit/' . $guru_id);
    }


    // Di dalam function edit($id)

    // Method Tambah Diklat
    public function tambah_diklat($guru_id)
    {
        $data = [
            'guru_id'       => $guru_id,
            'jenis_diklat'  => $this->input->post('jenis_diklat'),
            'nama_diklat'   => $this->input->post('nama_diklat'),
            'penyelenggara' => $this->input->post('penyelenggara'),
            'tahun'         => $this->input->post('tahun'),
            'peran'         => $this->input->post('peran'),
            'tingkat'       => $this->input->post('tingkat'),
            'berapa_jam'    => $this->input->post('berapa_jam')
        ];

        $this->M_Guru->insert_diklat($data);
        $this->session->set_flashdata('success', 'Riwayat diklat berhasil ditambahkan!');
        redirect('guru/edit/' . $guru_id);
    }

    // Method Update Diklat
    public function update_diklat($guru_id, $diklat_id)
    {
        $data = [
            'jenis_diklat'  => $this->input->post('jenis_diklat'),
            'nama_diklat'   => $this->input->post('nama_diklat'),
            'penyelenggara' => $this->input->post('penyelenggara'),
            'tahun'         => $this->input->post('tahun'),
            'peran'         => $this->input->post('peran'),
            'tingkat'       => $this->input->post('tingkat'),
            'berapa_jam'    => $this->input->post('berapa_jam')
        ];

        $this->M_Guru->update_diklat($diklat_id, $data);
        $this->session->set_flashdata('success', 'Riwayat diklat berhasil diperbarui!');
        redirect('guru/edit/' . $guru_id);
    }

    // Method Hapus Diklat
    public function hapus_diklat($guru_id, $diklat_id)
    {
        $this->M_Guru->delete_diklat($diklat_id);
        $this->session->set_flashdata('success', 'Riwayat diklat berhasil dihapus!');
        redirect('guru/edit/' . $guru_id);
    }




    // Upload Dokumen Satuan per Kartu (Auto-Upload via AJAX)
    public function upload_dokumen_satuan($guru_id, $field_name)
    {
        $config['upload_path']   = './uploads/dokumen_guru/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = 500; // Maksimal 500 KB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        header('Content-Type: application/json');

        if ($this->upload->do_upload('berkas')) {
            $uploadData = $this->upload->data();
            $file_name = $uploadData['file_name'];

            $old_doc = $this->M_Guru->get_dokumen_by_guru($guru_id);
            if ($old_doc && !empty($old_doc->$field_name)) {
                $old_file = './uploads/dokumen_guru/' . $old_doc->$field_name;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }

            $this->M_Guru->save_dokumen($guru_id, [$field_name => $file_name]);
            echo json_encode(['status' => 'success', 'message' => 'Dokumen berhasil diunggah!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
        }
    }

    // Hapus Dokumen Satuan
    public function hapus_dokumen_field($guru_id, $field_name)
    {
        $old_doc = $this->M_Guru->get_dokumen_by_guru($guru_id);
        if ($old_doc && !empty($old_doc->$field_name)) {
            $old_file = './uploads/dokumen_guru/' . $old_doc->$field_name;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
            // Kosongkan field di database
            $this->M_Guru->save_dokumen($guru_id, [$field_name => null]);
            $this->session->set_flashdata('success', 'Dokumen berhasil dihapus.');
        }
        redirect('guru/edit/' . $guru_id);
    }


    // Proses Simpan Penugasan PTK
    public function simpan_penugasan($guru_id)
    {
        $data = [
            'no_surat_tugas'      => $this->input->post('no_surat_tugas'),
            'tanggal_surat_tugas' => $this->input->post('tanggal_surat_tugas'),
            'tmt_tugas'           => $this->input->post('tmt_tugas'),
            'status_sekolah'      => $this->input->post('status_sekolah'),
            'tugas_tambahan_id'   => $this->input->post('tugas_tambahan_id'),
            'peran_id'            => $this->input->post('peran_id')
        ];

        $this->M_Guru->save_penugasan($guru_id, $data);
        $this->session->set_flashdata('success', 'Data penugasan PTK berhasil disimpan!');
        redirect('guru/edit/' . $guru_id); // atau kembali ke halaman index/daftar guru sesuai kebutuhan
    }

    public function tambah_penugasan($guru_id)
    {
        $data = [
            'guru_id'             => $guru_id,
            'no_surat_tugas'      => $this->input->post('no_surat_tugas'),
            'tanggal_surat_tugas' => $this->input->post('tanggal_surat_tugas'),
            'tmt_tugas'           => $this->input->post('tmt_tugas'),
            'status_sekolah'      => $this->input->post('status_sekolah') ? 'Ya' : 'Tidak',
            'tugas_tambahan_id'   => $this->input->post('tugas_tambahan_id'),
            'peran_id'            => $this->input->post('peran_id'),
            'keluar_karena'       => $this->input->post('keluar_karena'),
            'tanggal_keluar'      => $this->input->post('tanggal_keluar') ?: null
        ];

        $this->M_Guru->insert_penugasan($data);
        $this->session->set_flashdata('success', 'Data penugasan berhasil disimpan!');
        redirect('guru/edit/' . $guru_id);
    }

    public function update_penugasan($guru_id, $penugasan_id)
    {
        $data = [
            'no_surat_tugas'      => $this->input->post('no_surat_tugas'),
            'tanggal_surat_tugas' => $this->input->post('tanggal_surat_tugas'),
            'tmt_tugas'           => $this->input->post('tmt_tugas'),
            'status_sekolah'      => $this->input->post('status_sekolah'),
            'tugas_tambahan_id'   => $this->input->post('tugas_tambahan_id'),
            'peran_id'            => $this->input->post('peran_id')
        ];
        $this->M_Guru->update_penugasan($penugasan_id, $data);
        $this->session->set_flashdata('success', 'Riwayat penugasan berhasil diperbarui!');
        redirect('guru/edit/' . $guru_id);
    }

    public function hapus_penugasan($guru_id, $penugasan_id)
    {
        $this->M_Guru->delete_penugasan($penugasan_id);
        $this->session->set_flashdata('success', 'Riwayat penugasan berhasil dihapus!');
        redirect('guru/edit/' . $guru_id);
    }
}
