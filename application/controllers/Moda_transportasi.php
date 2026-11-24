<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Moda_transportasi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_moda_transportasi');
    }

    public function index()
    {
        $data['moda_transportasi'] = $this->Model_moda_transportasi->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('moda_transportasi/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_moda_transportasi->simpan($data);
        $this->session->set_flashdata('success', 'Data moda transportasi berhasil ditambahkan.');
        redirect('moda_transportasi');
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_moda_transportasi->update($id, $data);
        $this->session->set_flashdata('success', 'Data moda transportasi berhasil diperbarui.');
        redirect('moda_transportasi');
    }

    public function hapus($id)
    {
        $this->Model_moda_transportasi->hapus($id);
        $this->session->set_flashdata('success', 'Data moda transportasi berhasil dihapus.');
        redirect('moda_transportasi');
    }
}
