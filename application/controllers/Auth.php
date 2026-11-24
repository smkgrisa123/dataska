<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        // Jika sudah login, langsung arahkan ke dashboard atau role masing-masing
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role(
                $this->session->userdata('role'),
                $this->session->userdata('is_wali_kelas')
            );
            return;
        }
        $this->load->view('auth/login');
    }

    public function proses()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $role     = $this->input->post('role', true);

        // Cari user berdasarkan username di database
        $user = $this->db->get_where('users', ['username' => $username])->row();

        if ($user) {
            // Cek apakah status akun aktif
            if ($user->status !== 'Aktif') {
                $this->session->set_flashdata('error', 'Akun Anda tidak aktif! Silakan hubungi Administrator.');
                redirect('auth');
                return;
            }

            // Cek Password (Mendukung Plain Text DAN Password Hash)
            if ($password === $user->password || password_verify($password, $user->password)) {

                // Cek kesesuaian role yang dipilih di form login dengan data di database
                if ($user->role !== $role) {
                    $this->session->set_flashdata('error', 'Hak akses (role) yang Anda pilih tidak sesuai dengan akun ini!');
                    redirect('auth');
                    return;
                }

                // =====================================================================
                // CEK PENUGASAN WALI KELAS DARI TABEL ROMBEL (ROBUST & FLEKSIBEL)
                // =====================================================================
                $rombel_wali = null;
                $guru_id = $user->guru_id ?? $user->id;

                // 1. Cek melalui relasi tabel guru dan id_gtk
                $this->db->select('rombel.*');
                $this->db->from('rombel');
                $this->db->join('guru', 'guru.id = rombel.id_gtk', 'left');

                if (!empty($guru_id)) {
                    $this->db->where('rombel.id_gtk', $guru_id);
                } else {
                    $this->db->group_start();
                    $this->db->where('LOWER(guru.nama) =', strtolower($user->nama));
                    $this->db->or_where('LOWER(guru.username) =', strtolower($user->username));
                    $this->db->or_where('LOWER(rombel.id_gtk) =', strtolower($user->id));
                    $this->db->group_end();
                }
                $rombel_wali = $this->db->get()->row();

                // 2. Cadangan pertama: Cek langsung berdasarkan id_gtk = user->id
                if (!$rombel_wali) {
                    $rombel_wali = $this->db->get_where('rombel', ['id_gtk' => $user->id])->row();
                }

                // 3. Cadangan kedua: Cek berdasarkan id_gtk = guru_id
                if (!$rombel_wali && !empty($guru_id)) {
                    $rombel_wali = $this->db->get_where('rombel', ['id_gtk' => $guru_id])->row();
                }

                $is_wali_kelas  = false;
                $rombel_id_wali = null;

                if ($rombel_wali) {
                    $is_wali_kelas  = true;
                    $rombel_id_wali = $rombel_wali->id;
                }

                // Set Session Pengguna
                $this->session->set_userdata([
                    'id'            => $user->id,
                    'guru_id'       => $guru_id,
                    'nama'          => $user->nama,
                    'username'      => $user->username,
                    'role'          => $user->role,
                    'is_wali_kelas' => $is_wali_kelas,
                    'rombel_id'     => $rombel_id_wali, // <-- Menyimpan ID rombel kelas bimbingan
                    'logged_in'     => TRUE
                ]);

                // Buat label role yang rapi untuk pesan sukses
                $role_label = $is_wali_kelas ? 'Wali Kelas' : ucwords(str_replace('_', ' ', $user->role));
                $this->session->set_flashdata('success', 'Selamat datang kembali, ' . $user->nama . '! Anda berhasil login sebagai ' . $role_label);

                // Redirect ke halaman sesuai role / status wali kelas
                $this->_redirect_by_role($user->role, $is_wali_kelas);
            } else {
                $this->session->set_flashdata('error', 'Password yang Anda masukkan salah!');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan di sistem!');
            redirect('auth');
        }
    }

    private function _redirect_by_role($role, $is_wali_kelas = false)
    {
        if ($role === 'administrator' || $role === 'wali_kelas' || $is_wali_kelas) {
            redirect('dashboard');
        } else {
            // Mengarahkan role lain ke panel akses umum
            redirect('akses');
        }
    }

    public function logout()
    {
        // Hapus seluruh sesi yang aktif dan kembalikan ke halaman login
        $this->session->sess_destroy();
        redirect('auth');
    }
}
