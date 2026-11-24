<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WaliKelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // 1. Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }

        // 2. Cek apakah user benar-benar berstatus Wali Kelas
        if (!$this->session->userdata('is_wali_kelas')) {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda tidak terdaftar sebagai Wali Kelas aktif.');
            redirect('auth/logout'); // Logout paksa agar tidak terjadi redirect loop
            return;
        }
    }

    public function dashboard()
    {
        $rombel_id = $this->session->userdata('rombel_id');

        if (empty($rombel_id)) {
            $data['total_siswa'] = 0;
            $data['siswa_l']     = 0;
            $data['siswa_p']     = 0;
        } else {
            // Total keseluruhan siswa di kelas
            $data['total_siswa'] = $this->db->get_where('siswa', ['rombel_id' => $rombel_id])->num_rows();

            // Sesuaikan 'jk' dengan nama kolom jenis kelamin di tabel siswa Anda
            $data['siswa_l']     = $this->db->where(['rombel_id' => $rombel_id, 'jk' => 'L'])->from('siswa')->count_all_results();

            $data['siswa_p']     = $this->db->where(['rombel_id' => $rombel_id, 'jk' => 'P'])->from('siswa')->count_all_results();
        }

        $data['title'] = 'Dashboard Wali Kelas - DATASKA';

        $this->load->view('template/header', $data);
        $this->load->view('walikelas/dashboard', $data);
        $this->load->view('template/footer');
    }
}
