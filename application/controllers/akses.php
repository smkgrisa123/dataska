<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses extends CI_Controller // Ubah ke CI_Controller langsung atau MY_Controller sesuai base controller Anda
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session']);
        $this->load->helper(['url', 'form']);

        // Pastikan user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }
    }

    // Halaman utama yang mengatur tampilan berdasarkan role & status wali kelas
    public function index()
    {
        $role           = $this->session->userdata('role');
        $is_wali_kelas  = $this->session->userdata('is_wali_kelas');
        $rombel_id      = $this->session->userdata('rombel_id');

        $data['title']         = 'Panel Sistem DATASKA';
        $data['nama']          = $this->session->userdata('nama');
        $data['role']          = $role;
        $data['is_wali_kelas'] = $is_wali_kelas;

        // Jika user adalah wali kelas aktif, ambil data kelas binaannya untuk ditampilkan di panel
        if ($is_wali_kelas && $rombel_id) {
            $data['rombel'] = $this->db->get_where('rombel', ['id' => $rombel_id])->row();
            $data['siswa']  = $this->db->get_where('siswa', ['rombel_id' => $rombel_id])->result();
        }

        // Memuat file view utama panel akses
        $this->load->view('template/header', $data);
        $this->load->view('v_panel_akses', $data);
        $this->load->view('template/footer');
    }

    // Menu khusus untuk kelola data siswa dengan pembatasan hak akses
    public function data_siswa()
    {
        $role = $this->session->userdata('role');
        $is_wali_kelas = $this->session->userdata('is_wali_kelas');

        // Jika siswa murni, batasi akses
        if ($role === 'siswa') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            redirect('akses');
            return;
        }

        // Jika wali kelas, arahkan langsung ke dashboard wali kelas atau tampilkan data kelasnya
        if ($is_wali_kelas) {
            redirect('walikelas/dashboard');
            return;
        }

        // Ambil data siswa untuk Admin / Staf
        $data['siswa'] = $this->db->get('siswa')->result();
        $data['role']  = $role;
        $data['title'] = 'Data Peserta Didik';

        $this->load->view('template/header', $data);
        $this->load->view('v_data_siswa', $data);
        $this->load->view('template/footer');
    }

    // Fungsi aksi simpan data yang dikunci ketat
    public function simpan_data()
    {
        $role = $this->session->userdata('role');

        // Hanya Administrator dan Staf yang boleh menambah/mengubah data
        if (!in_array($role, ['administrator', 'staf'])) {
            $this->session->set_flashdata('error', 'Aksi ditolak! Anda berada dalam mode pembatasan hak akses.');
            redirect('akses/data_siswa');
            return;
        }

        // Proses simpan database di sini...
    }
}
