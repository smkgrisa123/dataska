<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_Kelas extends MY_Controller // Menggunakan MY_Controller sesuai permintaan
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Master_Kelas');
    }

    public function index()
    {
        $data['master_kelas'] = $this->Model_Master_Kelas->get_all();

        // Sesuaikan pemanggilan template header/footer dengan struktur bawaan MY_Controller Anda
        $this->load->view('template/header');
        $this->load->view('master_kelas/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $id = $this->input->post('id');
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas')
        ];

        if (empty($id)) {
            $this->Model_Master_Kelas->insert($data);
            $this->session->set_flashdata('success', 'Master kelas berhasil ditambahkan!');
        } else {
            $this->Model_Master_Kelas->update($id, $data);
            $this->session->set_flashdata('success', 'Master kelas berhasil diperbarui!');
        }
        redirect('master_kelas');
    }

    public function get_by_id($id)
    {
        $data = $this->Model_Master_Kelas->get_by_id($id);
        echo json_encode($data);
    }

    public function hapus($id)
    {
        $this->Model_Master_Kelas->delete($id);
        $this->session->set_flashdata('success', 'Master kelas berhasil dihapus!');
        redirect('master_kelas');
    }
}
