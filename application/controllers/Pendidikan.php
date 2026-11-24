<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pendidikan');
    }

    public function index()
    {
        $data['pendidikan'] = $this->Model_pendidikan->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('pendidikan/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_pendidikan->simpan($data);
        $this->session->set_flashdata('success', 'Data pendidikan berhasil ditambahkan.');
        redirect('pendidikan');
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_pendidikan->update($id, $data);
        $this->session->set_flashdata('success', 'Data pendidikan berhasil diperbarui.');
        redirect('pendidikan');
    }

    public function hapus($id)
    {
        $this->Model_pendidikan->hapus($id);
        $this->session->set_flashdata('success', 'Data pendidikan berhasil dihapus.');
        redirect('pendidikan');
    }
}
