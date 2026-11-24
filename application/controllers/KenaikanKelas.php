<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KenaikanKelas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    // 1. HALAMAN UTAMA & FILTER TINGKAT ASAL
    // 1. HALAMAN UTAMA & FILTER TINGKAT ASAL
    // 1. HALAMAN UTAMA & FILTER TINGKAT ASAL
    public function index()
    {
        $data['tingkat'] = $this->db->get('tingkat')->result();

        // Ambil data tahun ajaran untuk popup SweetAlert kelulusan
        $data['list_tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();

        $tingkat_id = $this->input->get('tingkat_id');
        $data['selected_tingkat'] = $tingkat_id;

        if (!empty($tingkat_id)) {
            $this->db->select('siswa.*, tingkat.nama as nama_tingkat');
            $this->db->from('siswa');
            $this->db->join('rombel', 'rombel.id = siswa.rombel_id', 'left');
            $this->db->join('tingkat', 'tingkat.id = COALESCE(rombel.id_tingkat, siswa.tingkat_id)', 'left');

            // BUNGKUS DENGAN GROUP_START & GROUP_END AGAR AMAN DARI LOGIKA OR
            $this->db->group_start();
            $this->db->where('rombel.id_tingkat', $tingkat_id);
            $this->db->or_where('(siswa.rombel_id IS NULL AND siswa.tingkat_id = ' . $tingkat_id . ')', NULL, FALSE);
            $this->db->group_end();

            // Sembunyikan siswa yang sudah lulus (2) atau keluar (3) secara mutlak
            $this->db->where('siswa.status_validasi !=', 2);
            $this->db->where('siswa.status_validasi !=', 3);

            $this->db->group_by('siswa.id');
            $data['siswa'] = $this->db->get()->result();
        } else {
            $data['siswa'] = [];
        }

        $this->load->view('template/header');
        $this->load->view('kenaikan_kelas/index', $data);
        $this->load->view('template/footer');
    }

    // 2. PROSES KENAIKAN KELAS MASSAL
    public function proses_kenaikan()
    {
        $tingkat_asal   = $this->input->post('tingkat_asal');
        $tingkat_tujuan = $this->input->post('tingkat_tujuan');
        $siswa_ids      = $this->input->post('siswa_ids');

        if (empty($tingkat_asal) || empty($tingkat_tujuan)) {
            $this->session->set_flashdata('error', 'Tingkat asal dan tujuan harus diisi!');
            redirect('kenaikanKelas');
        }

        if (empty($siswa_ids)) {
            $this->session->set_flashdata('warning', 'Tidak ada siswa yang dipilih untuk dinaikkan kelas.');
            redirect('kenaikanKelas?tingkat_id=' . $tingkat_asal);
        }

        $jumlah_berhasil = 0;

        foreach ($siswa_ids as $id_siswa) {
            $siswa = $this->db->select('siswa.*, master_kelas.nama_kelas as nama_rombel_lama')
                ->from('siswa')
                ->join('rombel', 'rombel.id = siswa.rombel_id', 'left')
                ->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left')
                ->where('siswa.id', $id_siswa)
                ->get()->row();

            // Memperbarui tingkat_id dan mengosongkan rombel agar siap masuk ke rombel baru
            $data_update = [
                'tingkat_id'     => $tingkat_tujuan,
                'rombel_id'      => NULL,
                'history_rombel' => !empty($siswa->nama_rombel_lama) ? $siswa->nama_rombel_lama : '-'
            ];

            $this->db->where('id', $id_siswa);
            $this->db->update('siswa', $data_update);

            if ($this->db->affected_rows() >= 0) {
                $jumlah_berhasil++;
            }
        }

        $this->session->set_flashdata('success', "Berhasil menaikkan tingkat untuk $jumlah_belhasil siswa!");
        redirect('kenaikanKelas?tingkat_id=' . $tingkat_asal);
    }

    // 3. PROSES KELULUSAN SISWA KELAS AKHIR
    public function proses_lulus()
    {
        $siswa_ids   = $this->input->post('siswa_ids');
        $tahun_lulus = $this->input->post('tahun_lulus'); // Menerima data tahun dari popup SweetAlert

        if (empty($siswa_ids)) {
            $this->session->set_flashdata('warning', 'Pilih siswa yang akan diluluskan terlebih dahulu.');
            redirect('kenaikanKelas');
        }

        if (empty($tahun_lulus)) {
            $this->session->set_flashdata('error', 'Tahun kelulusan wajib dipilih.');
            redirect('kenaikanKelas');
        }

        $jumlah_lulus = 0;

        foreach ($siswa_ids as $id_siswa) {
            $siswa = $this->db->select('siswa.*, master_kelas.nama_kelas as nama_rombel_lama')
                ->from('siswa')
                ->join('rombel', 'rombel.id = siswa.rombel_id', 'left')
                ->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left')
                ->where('siswa.id', $id_siswa)
                ->get()->row();

            $data_update = [
                'rombel_id'       => NULL,
                'status_validasi' => 2, // 2 menandakan status lulus
                'tahun_lulus'     => $tahun_lulus, // Menyimpan tahun kelulusan pilihan admin
                'history_rombel'  => !empty($siswa->nama_rombel_lama) ? $siswa->nama_rombel_lama . ' (Lulus)' : 'Lulus'
            ];

            $this->db->where('id', $id_siswa);
            $this->db->update('siswa', $data_update);

            if ($this->db->affected_rows() >= 0) {
                $jumlah_lulus++;
            }
        }

        $this->session->set_flashdata('success', "Selamat! Sebanyak $jumlah_lulus siswa berhasil diluluskan dengan Tahun Lulus: $tahun_lulus.");
        redirect('kenaikanKelas');
    }
}
