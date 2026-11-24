<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penghasilan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_penghasilan');
    }

    public function index()
    {
        $data['penghasilan'] = $this->Model_penghasilan->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('penghasilan/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_penghasilan->simpan($data);
        $this->session->set_flashdata('success', 'Data penghasilan bulanan berhasil ditambahkan.');
        redirect('penghasilan');
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_penghasilan->update($id, $data);
        $this->session->set_flashdata('success', 'Data penghasilan bulanan berhasil diperbarui.');
        redirect('penghasilan');
    }

    public function hapus($id)
    {
        $this->Model_penghasilan->hapus($id);
        $this->session->set_flashdata('success', 'Data penghasilan bulanan berhasil dihapus.');
        redirect('penghasilan');
    }
}
