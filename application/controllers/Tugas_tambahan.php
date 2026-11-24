<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tugas_tambahan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_tugas_tambahan');
    }

    public function index()
    {
        $data['tugas_tambahan'] = $this->Model_tugas_tambahan->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('tugas_tambahan/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama_tugas' => $this->input->post('nama_tugas', true),
            'status'     => $this->input->post('status', true),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->Model_tugas_tambahan->simpan($data);
        $this->session->set_flashdata('success', 'Data tugas tambahan berhasil ditambahkan.');
        redirect('tugas_tambahan');
    }

    public function update($id)
    {
        $data = [
            'nama_tugas' => $this->input->post('nama_tugas', true),
            'status'     => $this->input->post('status', true),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->Model_tugas_tambahan->update($id, $data);
        $this->session->set_flashdata('success', 'Data tugas tambahan berhasil diperbarui.');
        redirect('tugas_tambahan');
    }

    public function hapus($id)
    {
        $this->Model_tugas_tambahan->hapus($id);
        $this->session->set_flashdata('success', 'Data tugas tambahan berhasil dihapus.');
        redirect('tugas_tambahan');
    }
}
