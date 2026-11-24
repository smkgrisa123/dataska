<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends MY_Controller // <-- Diubah dari CI_Controller ke MY_Controller (atau Admin_Controller)
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
        $this->load->model('Model_Tingkat');
        $this->load->model('Model_Rombel');

        // Jika MY_Controller Anda sudah otomatis mengecek login/session, 
        // Anda bisa menyisipkan pengecekan tambahan di sini jika perlu
    }

    public function index()
    {
        $role          = $this->session->userdata('role');
        $user_id       = $this->session->userdata('id'); // ID user yang sedang login
        $rombel_id     = $this->session->userdata('rombel_id');

        // Jika data rombel_id di session masih kosong tapi rolenya wali_kelas, 
        // cari otomatis langsung dari database berdasarkan id_gtk = user_id
        if (empty($rombel_id) && $role === 'wali_kelas') {
            $cek_rombel = $this->db->get_where('rombel', ['id_gtk' => $user_id])->row();
            if ($cek_rombel) {
                $rombel_id = $cek_rombel->id;
                // Simpan sementara ke session agar aman
                $this->session->set_userdata([
                    'is_wali_kelas' => true,
                    'rombel_id'     => $rombel_id
                ]);
            }
        }

        // Tentukan data siswa yang akan ditampilkan
        if ($role === 'wali_kelas' && !empty($rombel_id)) {
            // Jika wali kelas, tampilkan HANYA siswa di rombel miliknya
            $data['siswa'] = $this->Siswa_model->get_siswa_by_rombel($rombel_id);
        } else {
            // Jika Administrator atau role lain, tampilkan seluruh siswa
            $data['siswa'] = $this->Siswa_model->get_all_siswa();
        }

        $data['master_rombel']  = $this->Model_Rombel->get_all();
        $data['master_tingkat'] = $this->Model_Tingkat->get_all();

        // Muat tampilan halaman siswa
        $this->load->view('template/header');
        $this->load->view('siswa/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $id = $this->input->post('id');
        $data = [
            'nama'          => $this->input->post('nama'),
            'no_induk'      => $this->input->post('no_induk'),
            'nisn'          => $this->input->post('nisn'),
            'tahun_ajaran_id' => $this->input->post('tahun_ajaran_id', true),
            'tempat_lahir'  => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'jk'            => $this->input->post('jk'),
            'tingkat_id'    => $this->input->post('tingkat_id'),

        ];

        if (empty($id)) {
            $this->Siswa_model->insert($data);
            $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan!');
        } else {
            $this->Siswa_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui!');
        }
        redirect('siswa');
    }

    public function get_by_id($id)
    {
        $data = $this->Siswa_model->get_by_id($id);
        echo json_encode($data);
    }

    public function hapus_bulk()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            $this->Siswa_model->delete_multiple($ids);
        }
        $this->session->set_flashdata('success', 'Data siswa berhasil dihapus!');
        redirect('siswa');
    }

    public function validasi_bulk()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            $this->Siswa_model->validate_multiple($ids);
            $this->session->set_flashdata('success', 'Data siswa berhasil divalidasi!');
        }
        redirect('siswa');
    }

    public function pd_keluar()
    {
        // Mengambil data siswa yang keluar / mutasi (misal status_validasi = 3)
        $this->db->where('status_validasi', 3);
        $data['siswa_keluar'] = $this->db->get('siswa')->result();

        $data['title'] = 'Data Peserta Didik Keluar';
        $this->load->view('template/header', $data);
        $this->load->view('siswa/pd_keluar', $data);
        $this->load->view('template/footer');
    }
    // Proses Simpan Data PD Keluar


    public function pd_lulus()
    {
        // 1. Ambil data tahun ajaran untuk pilihan dropdown filter
        $data['list_tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();

        // 2. Tangkap parameter filter tahun jika dipilih user
        $tahun = $this->input->get('tahun');

        // 3. Query utama data siswa lulus (status_validasi = 2)
        $this->db->where('status_validasi', 2);

        // Jika filter tahun dipilih, tambahkan kondisi where
        if (!empty($tahun)) {
            // Sesuaikan nama kolom tahun lulus di database Anda, misal: 'tahun_lulus' atau 'tahun_ajaran'
            $this->db->where('tahun_lulus', $tahun);
        }

        $data['siswa_lulus'] = $this->db->get('siswa')->result();

        // 4. Load tampilan view
        $data['title'] = 'Data Peserta Didik Lulus';
        $this->load->view('template/header', $data);
        $this->load->view('siswa/pd_lulus', $data);
        $this->load->view('template/footer');
    }

    // Menampilkan halaman edit siswa dengan sistem tab
    // Menampilkan halaman edit siswa dengan sistem tab
    public function edit($id)
    {
        // Ambil data siswa berdasarkan ID
        $data['siswa'] = $this->db->get_where('siswa', ['id' => $id])->row();

        if (!$data['siswa']) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan.');
            redirect('siswa');
        }
        $data['siswa'] = $this->Siswa_model->get_by_id($id);

        if (!$data['siswa']) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan.');
            redirect('siswa');
        }
        // Ambil data master pendukung
        $data['provinces']     = $this->db->order_by('nama', 'ASC')->get('wilayah_provinsi')->result();
        $data['pendidikan']    = $this->db->get('pendidikan')->result();
        $data['pekerjaan']     = $this->db->get('pekerjaan')->result();
        $data['penghasilan']   = $this->db->get('penghasilan')->result();
        $data['berkebutuhan_khusus'] = $this->db->get('berkebutuhan_khusus')->result();
        $data['prestasi_list'] = $this->db->get_where('prestasi_siswa', ['siswa_id' => $id])->result();
        $data['beasiswa_list'] = $this->db->get_where('beasiswa_siswa', ['siswa_id' => $id])->result();
        $data['kesejahteraan_list'] = $this->db->get_where('kesejahteraan_siswa', ['siswa_id' => $id])->result();
        $data['registrasi_masuk'] = $this->db->get_where('registrasi_masuk', ['siswa_id' => $id])->row();

        // TAMBAHKAN BARIS INI:
        $data['registrasi_keluar'] = $this->db->get_where('registrasi_keluar', ['siswa_id' => $id])->row();

        $data['kompetensi_list'] = $this->db->get('kompetensi')->result();
        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();
        $data['dokumen_list'] = $this->db->get_where('dokumen_siswa', ['siswa_id' => $id])->result();

        $this->load->view('template/header', $data);
        $this->load->view('siswa/edit', $data); // Halaman utama edit yang memuat navigasi tab
        $this->load->view('template/footer');
    }



    // Ambil data Kabupaten
    public function get_kabupaten($province_id)
    {
        // Coba ganti 'provinsi_id' jika di database Anda namanya berbeda (misal: 'id_provinsi')
        $data = $this->db->get_where('wilayah_kabupaten', ['provinsi_id' => $province_id])->result();
        echo json_encode($data);
    }

    // Ambil data Kecamatan
    public function get_kecamatan($regency_id)
    {
        // Coba ganti 'kabupaten_id' jika di database Anda namanya berbeda (misal: 'id_kabupaten')
        $data = $this->db->get_where('wilayah_kecamatan', ['kabupaten_id' => $regency_id])->result();
        echo json_encode($data);
    }

    // Ambil data Desa
    public function get_desa($district_id)
    {
        // Coba ganti 'kecamatan_id' jika di database Anda namanya berbeda (misal: 'id_kecamatan')
        $data = $this->db->get_where('wilayah_desa', ['kecamatan_id' => $district_id])->result();
        echo json_encode($data);
    }

    // Proses update data pribadi
    public function update_pribadi($id)
    {
        $data = [
            // Data Pribadi
            'nama'                  => $this->input->post('nama'),
            'nama_panggilan'        => $this->input->post('nama_panggilan'),
            'nik'                   => $this->input->post('nik'),
            'nisn'                  => $this->input->post('nisn'),
            'no_induk'              => $this->input->post('no_induk'),
            'jk'                    => $this->input->post('jk'),
            'tempat_lahir'          => $this->input->post('tempat_lahir'),
            'tanggal_lahir'         => $this->input->post('tanggal_lahir'),
            'no_kk'                 => $this->input->post('no_kk'),
            'no_akte_lahir'         => $this->input->post('no_akte_lahir'),
            'agama'                 => $this->input->post('agama'),
            'kewarganegaraan_siswa' => $this->input->post('kewarganegaraan_siswa'),
            'berkebutuhan_khusus'   => $this->input->post('berkebutuhan_khusus'), // Sesuaikan nama kolom di tabel siswa jika berbeda
            'status_orang_tua'      => $this->input->post('status_orang_tua'),
            'bahasa_sehari_hari'    => $this->input->post('bahasa_sehari_hari'),

            // Data Alamat & ID Wilayah (Sangat Penting)
            'province_id'           => $this->input->post('province_id'),
            'regency_id'            => $this->input->post('regency_id'),
            'district_id'           => $this->input->post('district_id'),
            'village_id'            => $this->input->post('village_id'),

            // Data Alamat & Tempat Tinggal
            'jalan'                 => $this->input->post('jalan'),
            'dusun'                 => $this->input->post('dusun'),
            'rt'                    => $this->input->post('rt'),
            'rw'                    => $this->input->post('rw'),
            'desa'                  => $this->input->post('desa'),
            'kecamatan'             => $this->input->post('kecamatan'),
            'kabupaten'             => $this->input->post('kabupaten'),
            'provinsi'              => $this->input->post('provinsi'),
            'lintang'               => $this->input->post('lintang'),
            'bujur'                 => $this->input->post('bujur'),
            'tempat_tinggal'        => $this->input->post('tempat_tinggal'),
            'moda_transportasi'     => $this->input->post('moda_transportasi'),
            'no_hp'                 => $this->input->post('no_hp'), // <-- Tambahkan baris ini


            // Ayah Kandung
            'ayah_nama'         => $this->input->post('ayah_nama'),
            'ayah_status'       => $this->input->post('ayah_status'),
            'ayah_nik'          => $this->input->post('ayah_nik'),
            'ayah_tahun_lahir'  => $this->input->post('ayah_tahun_lahir'),
            'ayah_pendidikan'   => $this->input->post('ayah_pendidikan'),
            'ayah_pekerjaan'    => $this->input->post('ayah_pekerjaan'),
            'ayah_penghasilan'  => $this->input->post('ayah_penghasilan'),
            'ayah_province_id'  => $this->input->post('ayah_province_id'),
            'ayah_regency_id'   => $this->input->post('ayah_regency_id'),
            'ayah_district_id'  => $this->input->post('ayah_district_id'),
            'ayah_village_id'   => $this->input->post('ayah_village_id'),
            'ayah_jalan'        => $this->input->post('ayah_jalan'),
            'ayah_dusun'        => $this->input->post('ayah_dusun'),
            'ayah_rt'           => $this->input->post('ayah_rt'),
            'ayah_rw'           => $this->input->post('ayah_rw'),
            'ayah_no_hp'        => $this->input->post('ayah_no_hp'),

            // Ibu Kandung
            'ibu_nama'          => $this->input->post('ibu_nama'),
            'ibu_status'        => $this->input->post('ibu_status'),
            'ibu_nik'           => $this->input->post('ibu_nik'),
            'ibu_tahun_lahir'   => $this->input->post('ibu_tahun_lahir'),
            'ibu_pendidikan'    => $this->input->post('ibu_pendidikan'),
            'ibu_pekerjaan'     => $this->input->post('ibu_pekerjaan'),
            'ibu_penghasilan'   => $this->input->post('ibu_penghasilan'),
            'ibu_province_id'   => $this->input->post('ibu_province_id'),
            'ibu_regency_id'    => $this->input->post('ibu_regency_id'),
            'ibu_district_id'   => $this->input->post('ibu_district_id'),
            'ibu_village_id'    => $this->input->post('ibu_village_id'),
            'ibu_jalan'         => $this->input->post('ibu_jalan'),
            'ibu_dusun'         => $this->input->post('ibu_dusun'),
            'ibu_rt'            => $this->input->post('ibu_rt'),
            'ibu_rw'            => $this->input->post('ibu_rw'),
            'ibu_no_hp'         => $this->input->post('ibu_no_hp'),

            // Wali Siswa
            'wali_nama'         => $this->input->post('wali_nama'),
            'wali_nik'          => $this->input->post('wali_nik'),
            'wali_status_hubungan'  => $this->input->post('wali_status_hubungan'),
            'wali_tahun_lahir'  => $this->input->post('wali_tahun_lahir'),
            'wali_pendidikan'   => $this->input->post('wali_pendidikan'),
            'wali_pekerjaan'    => $this->input->post('wali_pekerjaan'),
            'wali_penghasilan'  => $this->input->post('wali_penghasilan'),
            'wali_province_id'  => $this->input->post('wali_province_id'),
            'wali_regency_id'   => $this->input->post('wali_regency_id'),
            'wali_district_id'  => $this->input->post('wali_district_id'),
            'wali_village_id'   => $this->input->post('wali_village_id'),
            'wali_jalan'        => $this->input->post('wali_jalan'),
            'wali_dusun'        => $this->input->post('wali_dusun'),
            'wali_rt'           => $this->input->post('wali_rt'),
            'wali_rw'           => $this->input->post('wali_rw'),
            'wali_no_hp'        => $this->input->post('wali_no_hp'),


            // Data Periodik
            'tinggi_badan'          => $this->input->post('tinggi_badan', true),
            'berat_badan'           => $this->input->post('berat_badan', true),
            'lingkar_kepala'        => $this->input->post('lingkar_kepala', true),
            'jarak_tempuh_kategori' => $this->input->post('jarak_tempuh_kategori', true),
            'jarak_km'              => $this->input->post('jarak_km', true),
            'waktu_tempuh'          => $this->input->post('waktu_tempuh', true),
            'jml_saudara_kandung'   => $this->input->post('jml_saudara_kandung', true),
            'anak_ke'               => $this->input->post('anak_ke', true),
            'jml_saudara_tiri'      => $this->input->post('jml_saudara_tiri', true),
            'jml_saudara_angkat'    => $this->input->post('jml_saudara_angkat', true),
            'riwayat_penyakit'      => $this->input->post('riwayat_penyakit', true),
            'golongan_darah'        => $this->input->post('golongan_darah', true),


            // Data Tamat Belajar / Kelulusan
            'nomor_ijazah'          => $this->input->post('nomor_ijazah'),
            'tanggal_ijazah'        => $this->input->post('tanggal_ijazah'),
            'melanjutkan_ke'        => $this->input->post('melanjutkan_ke'),
            'bekerja_di'            => $this->input->post('bekerja_di'),
            'tanggal_mulai_bekerja' => $this->input->post('tanggal_mulai_bekerja'),
            'nama_perusahaan'       => $this->input->post('nama_perusahaan'),
            'penghasilan_lulus'     => $this->input->post('penghasilan_lulus'),
        ];

        // 2. Konfigurasi dan Proses Upload File Ijazah
        if (!empty($_FILES['file_ijazah']['name'])) {
            $config['upload_path']   = './assets/uploads/ijazah/'; // Pastikan folder ini ada
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size']      = 2048; // Maksimal 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_ijazah')) {
                $uploadData = $this->upload->data();
                // Masukkan nama file ke array data database (sesuaikan nama kolom di database Anda)
                $data['file_ijazah'] = $uploadData['file_name'];
            } else {
                // Jika upload gagal, Anda bisa set flashdata error jika diperlukan
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }

        $this->db->where('id', $id);
        $this->db->update('siswa', $data);

        $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui!');
        redirect('siswa/edit/' . $id);
    }

    public function tambah_prestasi($siswa_id)
    {
        $data = [
            'siswa_id'      => $siswa_id,
            'jenis'         => $this->input->post('jenis', true),
            'tingkat'       => $this->input->post('tingkat', true),
            'nama_prestasi' => $this->input->post('nama_prestasi', true),
            'tahun'         => $this->input->post('tahun', true),
            'penyelenggara' => $this->input->post('penyelenggara', true),
            'peringkat'     => $this->input->post('peringkat', true),
        ];

        $this->db->insert('prestasi_siswa', $data);
        $this->session->set_flashdata('success', 'Data prestasi berhasil ditambahkan!');
        redirect('siswa/edit/' . $siswa_id . '#prestasi'); // <-- Tambahkan #prestasi
    }

    public function update_prestasi($id, $siswa_id)
    {
        $data = [
            'jenis'         => $this->input->post('jenis', true),
            'tingkat'       => $this->input->post('tingkat', true),
            'nama_prestasi' => $this->input->post('nama_prestasi', true),
            'tahun'         => $this->input->post('tahun', true),
            'penyelenggara' => $this->input->post('penyelenggara', true),
            'peringkat'     => $this->input->post('peringkat', true),
        ];

        $this->db->where('id', $id);
        $this->db->update('prestasi_siswa', $data);

        $this->session->set_flashdata('success', 'Data prestasi berhasil diperbarui!');
        redirect('siswa/edit/' . $siswa_id . '#prestasi'); // <-- Tambahkan #prestasi
    }

    public function hapus_prestasi($id, $siswa_id)
    {
        $this->db->delete('prestasi_siswa', ['id' => $id]);
        $this->session->set_flashdata('success', 'Data prestasi berhasil dihapus!');
        redirect('siswa/edit/' . $siswa_id . '#prestasi'); // <-- Tambahkan #prestasi
    }

    public function tambah_beasiswa($siswa_id)
    {
        $data = [
            'siswa_id'      => $siswa_id,
            'jenis'         => $this->input->post('jenis', true),
            'keterangan'    => $this->input->post('keterangan', true),
            'tahun_mulai'   => $this->input->post('tahun_mulai', true),
            'tahun_selesai' => $this->input->post('tahun_selesai', true),
        ];

        $this->db->insert('beasiswa_siswa', $data);
        $this->session->set_flashdata('success', 'Data beasiswa berhasil ditambahkan!');
        redirect('siswa/edit/' . $siswa_id . '#beasiswa');
    }

    public function update_beasiswa($id, $siswa_id)
    {
        $data = [
            'jenis'         => $this->input->post('jenis', true),
            'keterangan'    => $this->input->post('keterangan', true),
            'tahun_mulai'   => $this->input->post('tahun_mulai', true),
            'tahun_selesai' => $this->input->post('tahun_selesai', true),
        ];

        $this->db->where('id', $id);
        $this->db->update('beasiswa_siswa', $data);

        $this->session->set_flashdata('success', 'Data beasiswa berhasil diperbarui!');
        redirect('siswa/edit/' . $siswa_id . '#beasiswa');
    }

    public function hapus_beasiswa($id, $siswa_id)
    {
        $this->db->delete('beasiswa_siswa', ['id' => $id]);
        $this->session->set_flashdata('success', 'Data beasiswa berhasil dihapus!');
        redirect('siswa/edit/' . $siswa_id . '#beasiswa');
    }

    // 2. Fungsi Aksi Kesejahteraan:
    public function tambah_kesejahteraan($siswa_id)
    {
        $data = [
            'siswa_id'   => $siswa_id,
            'jenis'      => $this->input->post('jenis', true),
            'no_kartu'   => $this->input->post('no_kartu', true),
            'nama_kartu' => $this->input->post('nama_kartu', true),
        ];

        $this->db->insert('kesejahteraan_siswa', $data);
        $this->session->set_flashdata('success', 'Data kesejahteraan berhasil ditambahkan!');
        redirect('siswa/edit/' . $siswa_id . '#kesejahteraan');
    }

    public function update_kesejahteraan($id, $siswa_id)
    {
        $data = [
            'jenis'      => $this->input->post('jenis', true),
            'no_kartu'   => $this->input->post('no_kartu', true),
            'nama_kartu' => $this->input->post('nama_kartu', true),
        ];

        $this->db->where('id', $id);
        $this->db->update('kesejahteraan_siswa', $data);

        $this->session->set_flashdata('success', 'Data kesejahteraan berhasil diperbarui!');
        redirect('siswa/edit/' . $siswa_id . '#kesejahteraan');
    }

    public function hapus_kesejahteraan($id, $siswa_id)
    {
        $this->db->delete('kesejahteraan_siswa', ['id' => $id]);
        $this->session->set_flashdata('success', 'Data kesejahteraan berhasil dihapus!');
        redirect('siswa/edit/' . $siswa_id . '#kesejahteraan');
    }

    // 2. Fungsi Aksi Registrasi Masuk:
    public function simpan_registrasi_masuk($siswa_id)
    {
        $jenis_pendaftaran = $this->input->post('jenis_pendaftaran', true);
        $no_induk          = $this->input->post('no_induk', true); // Ambil input no_induk dari form registrasi

        $post_data = [
            'siswa_id'             => $siswa_id,
            'jenis_pendaftaran'    => $jenis_pendaftaran,
            'diterima_di_kelas'    => $this->input->post('diterima_di_kelas', true),
            'bidang_keahlian'      => $this->input->post('bidang_keahlian', true),
            'program_keahlian'     => $this->input->post('program_keahlian', true),
            'konsentrasi_keahlian' => $this->input->post('konsentrasi_keahlian', true),
            'no_induk'             => $no_induk,
            'tanggal_masuk'        => $this->input->post('tanggal_masuk', true),
            'asal_sekolah'         => $this->input->post('asal_sekolah', true),
            'no_ijazah_smp'        => $this->input->post('no_ijazah_smp', true),
            'tanggal_ijazah_smp'   => $this->input->post('tanggal_ijazah_smp', true),
            'sekolah_sebelumnya'   => ($jenis_pendaftaran === 'Pindahan') ? $this->input->post('sekolah_sebelumnya', true) : null,
            'alasan_pindah'        => ($jenis_pendaftaran === 'Pindahan') ? $this->input->post('alasan_pindah', true) : null,
        ];

        // 1. Simpan atau Update ke tabel registrasi_masuk
        $cek = $this->db->get_where('registrasi_masuk', ['siswa_id' => $siswa_id])->row();

        if ($cek) {
            $this->db->where('id', $cek->id);
            $this->db->update('registrasi_masuk', $post_data);
        } else {
            $this->db->insert('registrasi_masuk', $post_data);
        }

        // 2. OTOMATIS SYNC: Update juga kolom no_induk di tabel utama siswa
        $this->db->where('id', $siswa_id);
        $this->db->update('siswa', ['no_induk' => $no_induk]);

        $this->session->set_flashdata('success', 'Data registrasi masuk berhasil disimpan!');
        redirect('siswa/edit/' . $siswa_id . '#registrasi');
    }

    public function simpan_pd_keluar($siswa_id)
    {
        $jenis_keluar   = $this->input->post('jenis_keluar', true);
        $tanggal_keluar = $this->input->post('tanggal_keluar', true);
        $tanggal_surat  = $this->input->post('tanggal_surat', true);

        // Otomatisasi tanggal jika kosong / 0000-00-00
        if (empty($tanggal_keluar) || $tanggal_keluar == '0000-00-00') {
            $tanggal_keluar = (!empty($tanggal_surat) && $tanggal_surat != '0000-00-00') ? $tanggal_surat : date('Y-m-d');
        }

        $data = [
            'siswa_id'           => $siswa_id,
            'jenis_keluar'       => $jenis_keluar,
            'tanggal_keluar'     => $tanggal_keluar,
            'tahun_ajaran_id'    => $this->input->post('tahun_ajaran_id', true),
            'alasan'             => $this->input->post('alasan', true),
            'kelas_ditinggalkan' => $this->input->post('kelas_ditinggalkan', true),
        ];

        if ($jenis_keluar === 'Mutasi') {
            $data['no_surat']            = $this->input->post('no_surat', true);
            $data['tanggal_surat']       = $tanggal_surat;
            $data['nama_sekolah_tujuan'] = $this->input->post('nama_sekolah_tujuan', true);
            $data['npsn_sekolah_tujuan'] = $this->input->post('npsn_sekolah_tujuan', true);
            $data['alamat_sekolah']      = $this->input->post('alamat_sekolah', true);
        }

        $cek = $this->db->get_where('registrasi_keluar', ['siswa_id' => $siswa_id])->row();

        if ($cek) {
            $this->db->where('id', $cek->id);
            $this->db->update('registrasi_keluar', $data);
        } else {
            $this->db->insert('registrasi_keluar', $data);
        }

        // Ubah status validasi siswa menjadi 3 (keluar) dan kosongkan rombel_id
        $this->db->where('id', $siswa_id)->update('siswa', [
            'status_validasi' => 3,
            'rombel_id'       => NULL
        ]);

        $this->session->set_flashdata('success', 'Data registrasi keluar berhasil disimpan dan siswa dikeluarkan dari rombel.');
        redirect('siswa/keluar');
    }

    public function keluar()
    {
        $data['siswa_keluar'] = $this->Siswa_model->get_siswa_keluar();

        // Ambil data tahun ajaran untuk dropdown filter
        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();

        $data['total_keluar'] = count($data['siswa_keluar']);
        $data['mutasi']       = $this->Siswa_model->count_by_jenis('Mutasi');
        $data['undur_diri']   = $this->Siswa_model->count_by_jenis('Mengundurkan Diri');
        $data['wafat']        = $this->Siswa_model->count_by_jenis('Wafat');
        $data['hilang']       = $this->Siswa_model->count_by_jenis('Hilang');

        $data['content'] = 'siswa/pd_keluar';
        $this->load->view('template/header', $data);
        $this->load->view('siswa/pd_keluar', $data); // Menampilkan view data siswa keluar
        $this->load->view('template/footer');
    }

    public function aktifkan_kembali($id)
    {
        if (empty($id)) {
            redirect('siswa/keluar');
        }

        // 1. Ambil data registrasi keluar berdasarkan ID baris tabel registrasi_keluar
        $reg_keluar = $this->db->get_where('registrasi_keluar', ['id' => $id])->row();

        if ($reg_keluar) {
            $siswa_id = $reg_keluar->siswa_id; // Mendapatkan ID asli siswa dari kolom siswa_id

            // 2. Kembalikan status validasi siswa di tabel 'siswa' menjadi aktif (misal: 1)
            $this->db->where('id', $siswa_id)->update('siswa', ['status_validasi' => 1]);

            // 3. Hapus data dari tabel registrasi_keluar berdasarkan ID barisnya
            $this->db->where('id', $id)->delete('registrasi_keluar');
        }

        $this->session->set_flashdata('success', 'Siswa berhasil dikembalikan ke status aktif.');
        redirect('siswa/keluar');
    }

    public function upload_dokumen($siswa_id)
    {

        // Konfigurasi Upload File
        $config['upload_path']   = './uploads/dokumen/'; // Pastikan folder ini ada di root project
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 1024; // Maksimal 1 MB sesuai label UI
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);
        $jenis_dokumen = $this->input->post('jenis_dokumen'); // foto_diri, kartu_keluarga, akte_kelahiran, ijazah

        if (!$this->upload->do_upload('berkas_file')) {
            $error = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', 'Gagal unggah: ' . $error);
        } else {
            $file_data = $this->upload->data();
            $nama_file = $file_data['file_name'];
            $ukuran_kb = round($file_data['file_size'], 2) . ' KB';

            // Cek apakah dokumen jenis ini sudah pernah diunggah sebelumnya
            $existing = $this->db->get_where('dokumen_siswa', [
                'siswa_id' => $siswa_id,
                'jenis_dokumen' => $jenis_dokumen
            ])->row();

            if ($existing) {
                // Hapus file fisik lama jika ada
                @unlink('./uploads/dokumen/' . $existing->nama_file);
                // Update record database
                $this->db->where('id', $existing->id);
                $this->db->update('dokumen_siswa', [
                    'nama_file' => $nama_file,
                    'ukuran_file' => $ukuran_kb
                ]);
            } else {
                // Insert baru
                $this->db->insert('dokumen_siswa', [
                    'siswa_id' => $siswa_id,
                    'jenis_dokumen' => $jenis_dokumen,
                    'nama_file' => $nama_file,
                    'ukuran_file' => $ukuran_kb
                ]);
            }

            $this->session->set_flashdata('success', 'Dokumen berhasil diunggah.');
        }

        redirect('siswa/edit/' . $siswa_id);
    }

    public function hapus_dokumen($id, $siswa_id)
    {
        $doc = $this->db->get_where('dokumen_siswa', ['id' => $id])->row();
        if ($doc) {
            @unlink('./uploads/dokumen/' . $doc->nama_file);
            $this->db->delete('dokumen_siswa', ['id' => $id]);
            $this->session->set_flashdata('success', 'Dokumen berhasil dihapus.');
        }
        redirect('siswa/edit/' . $siswa_id);
    }

    public function get_detail_json($id)
    {
        // Ambil data siswa berdasarkan ID
        $siswa = $this->db->get_where('siswa', ['id' => $id])->row();

        // Ambil dokumen siswa
        $dokumen = $this->db->get_where('dokumen_siswa', ['siswa_id' => $id])->result();

        // Gabungkan dan kirim sebagai format JSON
        echo json_encode([
            'siswa' => $siswa,
            'dokumen_list' => $dokumen
        ]);
    }

    public function detail($id)
    {
        if (empty($id)) {
            redirect('siswa/keluar');
        }

        $sql = "SELECT siswa.*, 
                   wilayah_provinsi.nama as provinsi, 
                   wilayah_kabupaten.nama as kabupaten, 
                   wilayah_kecamatan.nama as kecamatan, 
                   wilayah_desa.nama as desa,
                   p_ayah.nama as ayah_provinsi_nama,
                   k_ayah.nama as ayah_kabupaten_nama,
                   c_ayah.nama as ayah_kecamatan_nama,
                   d_ayah.nama as ayah_desa_nama,
                   p_ibu.nama as ibu_provinsi_nama,
                   k_ibu.nama as ibu_kabupaten_nama,
                   c_ibu.nama as ibu_kecamatan_nama,
                   d_ibu.nama as ibu_desa_nama,
                   p_wali.nama as wali_provinsi_nama,
                   k_wali.nama as wali_kabupaten_nama,
                   c_wali.nama as wali_kecamatan_nama,
                   d_wali.nama as wali_desa_nama
            FROM siswa 
            LEFT JOIN wilayah_provinsi ON wilayah_provinsi.id = siswa.province_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.id = siswa.regency_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.id = siswa.district_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_desa ON wilayah_desa.id = siswa.village_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_provinsi p_ayah ON p_ayah.id = siswa.ayah_province_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kabupaten k_ayah ON k_ayah.id = siswa.ayah_regency_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kecamatan c_ayah ON c_ayah.id = siswa.ayah_district_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_desa d_ayah ON d_ayah.id = siswa.ayah_village_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_provinsi p_ibu ON p_ibu.id = siswa.ibu_province_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kabupaten k_ibu ON k_ibu.id = siswa.ibu_regency_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kecamatan c_ibu ON c_ibu.id = siswa.ibu_district_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_desa d_ibu ON d_ibu.id = siswa.ibu_village_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_provinsi p_wali ON p_wali.id = siswa.wali_province_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kabupaten k_wali ON k_wali.id = siswa.wali_regency_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_kecamatan c_wali ON c_wali.id = siswa.wali_district_id COLLATE utf8mb4_general_ci 
            LEFT JOIN wilayah_desa d_wali ON d_wali.id = siswa.wali_village_id COLLATE utf8mb4_general_ci 
            WHERE siswa.id = ?";

        $data['siswa'] = $this->db->query($sql, [$id])->row();

        if (empty($data['siswa'])) {
            redirect('siswa/keluar');
        }

        $data['dokumen_list']       = $this->db->get_where('dokumen_siswa', ['siswa_id' => $id])->result();
        $data['prestasi_list']      = $this->db->get_where('prestasi_siswa', ['siswa_id' => $id])->result();
        $data['beasiswa_list']      = $this->db->get_where('beasiswa_siswa', ['siswa_id' => $id])->result();
        $data['kesejahteraan_list'] = $this->db->get_where('kesejahteraan_siswa', ['siswa_id' => $id])->result();

        // Ambil data registrasi masuk secara langsung (karena kolom jurusan/bidang sudah ada di tabel ini)
        $data['registrasi_masuk']   = $this->db->get_where('registrasi_masuk', ['siswa_id' => $id])->row();

        // Ambil data registrasi keluar dengan JOIN ke tabel tahun_ajaran agar semester muncul
        $sql_reg_keluar = "SELECT registrasi_keluar.*, 
                                  CONCAT(tahun_ajaran.nama, ' (', tahun_ajaran.semester, ')') as nama_tahun_ajaran 
                           FROM registrasi_keluar 
                           LEFT JOIN tahun_ajaran ON tahun_ajaran.id = registrasi_keluar.tahun_ajaran_id 
                           WHERE registrasi_keluar.siswa_id = ?";
        $data['registrasi_keluar'] = $this->db->query($sql_reg_keluar, [$id])->row();

        $this->load->view('template/header', $data);
        $this->load->view('siswa/detail', $data);
        $this->load->view('template/footer');
    }

    public function import_excel()
    {
        date_default_timezone_set('Asia/Jakarta');

        if (isset($_FILES["file_excel"]["name"]) && !empty($_FILES["file_excel"]["tmp_name"])) {
            $path = $_FILES["file_excel"]["tmp_name"];

            $sukses = 0;
            $gagal = 0;

            // Membaca file CSV dengan pemisah titik koma (;)
            if (($handle = fopen($path, "r")) !== FALSE) {
                $row_no = 0;
                while (($cols = fgetcsv($handle, 10000, ";")) !== FALSE) {
                    $row_no++;
                    // Lewati 2 baris pertama (Header / Judul Tabel)
                    if ($row_no <= 2) continue;

                    // Pastikan jumlah kolom minimal mencukupi
                    if (count($cols) >= 5) {
                        // Data Pribadi & Alamat untuk Tabel 'siswa'
                        $data_siswa = [
                            'nama'                  => trim($cols[1] ?? ''),
                            'nama_panggilan'        => trim($cols[2] ?? ''),
                            'nik'                   => str_replace("'", "", trim($cols[3] ?? '')),
                            'nisn'                  => str_replace("'", "", trim($cols[4] ?? '')),
                            'no_induk'              => str_replace("'", "", trim($cols[5] ?? '')),
                            'jk' => !empty(trim($cols[6] ?? '')) && trim($cols[6]) !== '-' ? trim($cols[6]) : 'L',
                            'tempat_lahir'          => trim($cols[7] ?? ''),
                            'tanggal_lahir'         => !empty($cols[8]) ? date('Y-m-d', strtotime(str_replace('/', '-', trim($cols[8])))) : null,
                            'no_kk'                 => str_replace("'", "", trim($cols[9] ?? '')),
                            'no_akte_lahir'         => str_replace("'", "", trim($cols[10] ?? '')),
                            'agama'                 => trim($cols[11] ?? ''),
                            'kewarganegaraan_siswa' => trim($cols[12] ?? ''),
                            'berkebutuhan_khusus'   => trim($cols[13] ?? ''),
                            'status_orang_tua'      => trim($cols[14] ?? ''),
                            'bahasa_sehari_hari'    => trim($cols[15] ?? ''),

                            'jalan'                 => trim($cols[16] ?? ''),
                            'dusun'                 => trim($cols[17] ?? ''),
                            'rt'                    => trim($cols[18] ?? ''),
                            'rw'                    => trim($cols[19] ?? ''),
                            'desa'                  => trim($cols[20] ?? ''),
                            'kecamatan'             => trim($cols[21] ?? ''),
                            'kabupaten'             => trim($cols[22] ?? ''),
                            'provinsi'              => trim($cols[23] ?? ''),
                            'lintang'               => trim($cols[24] ?? ''),
                            'bujur'                 => trim($cols[25] ?? ''),
                            'tempat_tinggal'        => trim($cols[26] ?? ''),
                            'moda_transportasi'     => trim($cols[27] ?? ''),
                            'no_hp'                 => str_replace("'", "", trim($cols[28] ?? '')),

                            'ayah_nama'             => trim($cols[29] ?? ''),
                            'ayah_status'           => trim($cols[30] ?? ''),
                            'ayah_nik'              => str_replace("'", "", trim($cols[31] ?? '')),
                            'ayah_tahun_lahir'      => trim($cols[32] ?? ''),
                            'ayah_pendidikan'       => trim($cols[33] ?? ''),
                            'ayah_pekerjaan'        => trim($cols[34] ?? ''),
                            'ayah_penghasilan'      => trim($cols[35] ?? ''),
                            'ayah_jalan'            => trim($cols[36] ?? ''),
                            'ayah_dusun'            => trim($cols[37] ?? ''),
                            'ayah_rt'               => trim($cols[38] ?? ''),
                            'ayah_rw'               => trim($cols[39] ?? ''),
                            'ayah_no_hp'            => str_replace("'", "", trim($cols[40] ?? '')),

                            'ibu_nama'              => trim($cols[41] ?? ''),
                            'ibu_status'            => trim($cols[42] ?? ''),
                            'ibu_nik'               => str_replace("'", "", trim($cols[43] ?? '')),
                            'ibu_tahun_lahir'       => trim($cols[44] ?? ''),
                            'ibu_pendidikan'        => trim($cols[45] ?? ''),
                            'ibu_pekerjaan'         => trim($cols[46] ?? ''),
                            'ibu_penghasilan'       => trim($cols[47] ?? ''),
                            'ibu_jalan'             => trim($cols[48] ?? ''),
                            'ibu_dusun'             => trim($cols[49] ?? ''),
                            'ibu_rt'                => trim($cols[50] ?? ''),
                            'ibu_rw'                => trim($cols[51] ?? ''),
                            'ibu_no_hp'             => str_replace("'", "", trim($cols[52] ?? '')),

                            'wali_nama'             => trim($cols[53] ?? ''),
                            'wali_nik'              => str_replace("'", "", trim($cols[54] ?? '')),
                            'wali_status_hubungan'  => trim($cols[55] ?? ''),
                            'wali_tahun_lahir'      => trim($cols[56] ?? ''),
                            'wali_pendidikan'       => trim($cols[57] ?? ''),
                            'wali_pekerjaan'        => trim($cols[58] ?? ''),
                            'wali_penghasilan'      => trim($cols[59] ?? ''),
                            'wali_jalan'            => trim($cols[60] ?? ''),
                            'wali_dusun'            => trim($cols[61] ?? ''),
                            'wali_rt'               => trim($cols[62] ?? ''),
                            'wali_rw'               => trim($cols[63] ?? ''),
                            'wali_no_hp'            => str_replace("'", "", trim($cols[64] ?? '')),

                            'tinggi_badan'          => trim($cols[65] ?? ''),
                            'berat_badan'           => trim($cols[66] ?? ''),
                            'lingkar_kepala'        => trim($cols[67] ?? ''),
                            'jarak_tempuh_kategori' => trim($cols[68] ?? ''),
                            'jarak_km'              => trim($cols[69] ?? ''),
                            'waktu_tempuh'          => trim($cols[70] ?? ''),
                            'jml_saudara_kandung'   => trim($cols[71] ?? ''),
                            'anak_ke'               => trim($cols[72] ?? ''),
                            'jml_saudara_tiri'      => trim($cols[73] ?? ''),
                            'jml_saudara_angkat'    => trim($cols[74] ?? ''),
                            'riwayat_penyakit'      => trim($cols[75] ?? ''),
                            'golongan_darah'        => trim($cols[76] ?? ''),
                        ];

                        foreach ($data_siswa as $key => $val) {
                            if ($val === '-' || $val === "'-" || $val === '' || $val === 'nan') {
                                $data_siswa[$key] = null;
                            }
                        }

                        if (!empty($data_siswa['nama'])) {
                            // 1. Insert ke tabel 'siswa' dan ambil ID-nya
                            $siswa_id = $this->Siswa_model->insert_siswa($data_siswa);

                            if ($siswa_id) {
                                // 2. Insert ke tabel relasi 'registrasi_masuk'
                                $data_registrasi = [
                                    'siswa_id'             => $siswa_id,
                                    'jenis_pendaftaran'    => trim($cols[77] ?? ''),
                                    'diterima_di_kelas'    => trim($cols[78] ?? ''),
                                    'bidang_keahlian'      => trim($cols[79] ?? ''),
                                    'program_keahlian'     => trim($cols[80] ?? ''),
                                    'konsentrasi_keahlian' => trim($cols[81] ?? ''),
                                    'tanggal_masuk'        => !empty($cols[82]) ? date('Y-m-d', strtotime(str_replace('/', '-', trim($cols[82])))) : null,
                                    'asal_sekolah'         => trim($cols[83] ?? ''),
                                    'no_ijazah_smp'        => str_replace("'", "", trim($cols[84] ?? '')),
                                    'tanggal_ijazah_smp'   => !empty($cols[85]) ? date('Y-m-d', strtotime(str_replace('/', '-', trim($cols[85])))) : null,
                                ];

                                $this->Siswa_model->insert_registrasi_masuk($data_registrasi);

                                $sukses++;
                            } else {
                                $gagal++;
                            }
                        }
                    }
                }
                fclose($handle);
            }

            // Set Flashdata untuk SweetAlert2 Toast
            if ($sukses > 0) {
                $this->session->set_flashdata('success', 'Berhasil mengimpor ' . $sukses . ' data peserta didik.' . ($gagal > 0 ? ' (Gagal: ' . $gagal . ')' : ''));
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data yang berhasil diimpor. (Gagal: ' . $gagal . ')');
            }

            redirect('siswa');
        } else {
            $this->session->set_flashdata('error', 'File CSV belum dipilih atau tidak valid!');
            redirect('siswa');
        }
    }


    public function download_template()
    {
        // Nama file Template Excel khusus Import
        $filename = "TEMPLATE_IMPORT_DATASKA_SMK_GRISA.xls";

        // Header agar browser membaca file sebagai dokumen Excel
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // PASTIKAN MEMUAT VIEW INI (bukan export_excel_view)
        $this->load->view('siswa/import_template_view');
    }


    public function export_excel()
    {
        // Set zona waktu ke Waktu Indonesia Barat (WIB)
        date_default_timezone_set('Asia/Jakarta');

        $role      = $this->session->userdata('role');
        $rombel_id = $this->session->userdata('rombel_id');

        // Ubah role ke huruf kecil semua untuk menghindari perbedaan penulisan (Wali Kelas vs wali_kelas)
        $role_lower = strtolower(trim($role));

        // Cek apakah yang login adalah wali kelas dan memiliki rombel_id
        if (($role_lower === 'wali_kelas' || $role_lower === 'wali kelas') && !empty($rombel_id)) {
            // Ambil khusus siswa di rombel yang diampu (jumlahnya 25 siswa)
            $data['siswa'] = $this->Siswa_model->get_siswa_by_rombel($rombel_id);
        } else {
            // Jika Admin atau Staff, ambil seluruh data siswa se-sekolah
            $data['siswa'] = $this->Siswa_model->get_all_siswa();
        }

        // Nama file Excel
        $filename = "DATASKA_SMK_GRISA_" . date('Y-m-d') . ".xls";

        // Header agar browser membaca file sebagai dokumen Excel
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Load view khusus untuk format tabel excel
        $this->load->view('siswa/export_excel_view', $data);
    }

    public function cetak_pdf_pilihan()
    {
        $ids_array = $this->input->post('ids');

        if (empty($ids_array)) {
            redirect('siswa');
        }

        $data['siswa'] = $this->Siswa_model->get_siswa_by_ids($ids_array);
        $data['title'] = 'Pratinjau Cetak Data Peserta Didik';

        // Cukup panggil header utama, view inline (tanpa sidebar ganda), dan footer
        $this->load->view('template/header', $data);
        $this->load->view('siswa/cetak_inline_view', $data);
        $this->load->view('template/footer');
    }
}
