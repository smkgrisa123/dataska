<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth');
            return;
        }

        // Ambil data role dan status wali kelas dari session
        $role          = $this->session->userdata('role');
        $is_wali_kelas = $this->session->userdata('is_wali_kelas');

        // IZINKAN jika dia Administrator ATAU seorang Wali Kelas
        if ($role === 'administrator' || $is_wali_kelas || $role === 'wali_kelas') {
            return; // Loloskan akses
        }

        // Jika bukan keduanya (misal: role lain yang tidak berhak), tolak akses
        $this->session->set_flashdata('error', 'Akses ditolak! Anda tidak memiliki hak akses ke halaman tersebut.');
        redirect('akses');
    }
}
