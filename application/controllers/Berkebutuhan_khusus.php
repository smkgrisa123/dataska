<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berkebutuhan_khusus extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_berkebutuhan_khusus');
    }

    public function index()
    {
        $data['berkebutuhan_khusus'] = $this->Model_berkebutuhan_khusus->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('berkebutuhan_khusus/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_berkebutuhan_khusus->simpan($data);
        $this->session->set_flashdata('success', 'Data berkebutuhan khusus berhasil ditambahkan.');
        redirect('berkebutuhan_khusus');
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->input->post('nama', true)
        ];

        $this->Model_berkebutuhan_khusus->update($id, $data);
        $this->session->set_flashdata('success', 'Data berkebutuhan khusus berhasil diperbarui.');
        redirect('berkebutuhan_khusus');
    }

    public function hapus($id)
    {
        $this->Model_berkebutuhan_khusus->hapus($id);
        $this->session->set_flashdata('success', 'Data berkebutuhan khusus berhasil dihapus.');
        redirect('berkebutuhan_khusus');
    }
}
