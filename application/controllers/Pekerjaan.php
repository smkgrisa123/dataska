<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pekerjaan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pekerjaan');
    }

    public function index()
    {
        $data['pekerjaan'] = $this->Model_pekerjaan->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('pekerjaan/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama_pekerjaan' => $this->input->post('nama_pekerjaan', true),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->Model_pekerjaan->simpan($data);
        $this->session->set_flashdata('success', 'Data pekerjaan berhasil ditambahkan.');
        redirect('pekerjaan');
    }

    public function update($id)
    {
        $data = [
            'nama_pekerjaan' => $this->input->post('nama_pekerjaan', true),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->Model_pekerjaan->update($id, $data);
        $this->session->set_flashdata('success', 'Data pekerjaan berhasil diperbarui.');
        redirect('pekerjaan');
    }

    public function hapus($id)
    {
        $this->Model_pekerjaan->hapus($id);
        $this->session->set_flashdata('success', 'Data pekerjaan berhasil dihapus.');
        redirect('pekerjaan');
    }
}
