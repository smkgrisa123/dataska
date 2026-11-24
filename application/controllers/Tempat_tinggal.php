<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tempat_tinggal extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_tempat_tinggal');
    }

    public function index()
    {
        $data['tempat_tinggal'] = $this->Model_tempat_tinggal->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('tempat_tinggal/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_tempat_tinggal->simpan($data);
        $this->session->set_flashdata('success', 'Data tempat tinggal berhasil ditambahkan.');
        redirect('tempat_tinggal');
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_tempat_tinggal->update($id, $data);
        $this->session->set_flashdata('success', 'Data tempat tinggal berhasil diperbarui.');
        redirect('tempat_tinggal');
    }

    public function hapus($id)
    {
        $this->Model_tempat_tinggal->hapus($id);
        $this->session->set_flashdata('success', 'Data tempat tinggal berhasil dihapus.');
        redirect('tempat_tinggal');
    }
}
