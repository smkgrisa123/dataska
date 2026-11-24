<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller // Dilindungi oleh akses login/admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    // 1. READ (Tampil Data & Data Pendukung untuk Modal)
    public function index()
    {
        $data['title']          = 'Manajemen Hak Akses - DATASKA';
        $data['users']          = $this->db->get('users')->result();

        // Ambil data peran
        $data['list_peran']     = $this->db->get('peran')->result();

        // Ambil PTK beserta peran penugasannya (tanpa group_by agar relasi peran terbawa)
        $this->db->select('guru.id as guru_id, guru.nama_lengkap, peran.nama_peran');
        $this->db->from('guru');
        $this->db->join('guru_penugasan', 'guru_penugasan.guru_id = guru.id', 'inner');
        $this->db->join('peran', 'peran.id = guru_penugasan.peran_id', 'inner');
        $data['list_ptk']       = $this->db->get()->result();

        // Ambil data rombel lengkap dengan join
        $this->db->select('rombel.*, tingkat.nama as nama_tingkat, master_kelas.nama_kelas');
        $this->db->from('rombel');
        $this->db->join('tingkat', 'tingkat.id = rombel.id_tingkat', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        $data['master_rombel']  = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('users/index', $data);
        $this->load->view('template/footer');
    }

    // 2. CREATE (Tambah Data Pengguna & Relasi Rombel)
    public function simpan()
    {
        $nama      = $this->input->post('nama', true);
        $username  = $this->input->post('username', true);
        $password  = $this->input->post('password', true);
        $role      = $this->input->post('role', true);
        $rombel_id = $this->input->post('rombel_id', true);

        // Validasi sederhananya
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('role', 'Peran', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('users');
        } else {
            // Data untuk tabel users
            $data_user = [
                'nama'     => $nama,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role'     => $role,
                'status'   => 'Aktif'
            ];

            $this->db->insert('users', $data_user);
            $user_id = $this->db->insert_id(); // Ambil ID user yang baru saja dibuat

            // Jika role yang dipilih adalah wali kelas dan rombel dipilih, update tabel rombel
            if ($role === 'wali_kelas' && !empty($rombel_id)) {
                $this->db->where('id', $rombel_id);
                $this->db->update('rombel', ['id_gtk' => $user_id]);
            }

            $this->session->set_flashdata('success', 'Pengguna baru berhasil ditambahkan!');
            redirect('users');
        }
    }

    // 3. EDIT (Ubah Data Pengguna)
    public function edit($id)
    {
        $nama     = $this->input->post('nama', true);
        $password = $this->input->post('password', true);
        $role     = $this->input->post('role', true);
        $status   = $this->input->post('status', true);

        $data_update = [
            'nama'   => $nama,
            'role'   => $role,
            'status' => $status
        ];

        // Jika password diisi, update passwordnya juga
        if (!empty($password)) {
            $data_update['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id', $id);
        $this->db->update('users', $data_update);

        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui!');
        redirect('users');
    }

    // 4. HAPUS (Hapus Pengguna)
    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->session->set_flashdata('success', 'Pengguna berhasil dihapus dari sistem!');
        redirect('users');
    }
}
