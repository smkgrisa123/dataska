<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TahunAjaran extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_ajaran_model'); // Memuat model yang baru dibuat
        $this->load->library('session');
    }

    public function index()
    {
        $data['tahun_ajaran'] = $this->Tahun_ajaran_model->semua_data();

        $this->load->view('template/header');
        $this->load->view('tahun_ajaran/index', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $status = $this->input->post('status', true);

        // Jika status yang ditambahkan Aktif, nonaktifkan status lainnya terlebih dahulu
        if ($status == 'Aktif') {
            $this->Tahun_ajaran_model->set_semua_tidak_aktif();
        }

        $data = [
            'nama'       => $this->input->post('nama', true),
            'semester'   => $this->input->post('semester', true),
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Tahun_ajaran_model->tambah($data);
        $this->session->set_flashdata('success', 'Data tahun ajaran berhasil ditambahkan.');
        redirect('tahunajaran');
    }

    public function update($id)
    {
        $status = $this->input->post('status', true);

        if ($status == 'Aktif') {
            $this->Tahun_ajaran_model->set_semua_tidak_aktif();
        }

        $data = [
            'nama'       => $this->input->post('nama', true),
            'semester'   => $this->input->post('semester', true),
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->Tahun_ajaran_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data tahun ajaran berhasil diperbarui.');
        redirect('tahunajaran');
    }

    public function hapus($id)
    {
        $this->Tahun_ajaran_model->hapus($id);
        $this->session->set_flashdata('success', 'Data tahun ajaran berhasil dihapus.');
        redirect('tahunajaran');
    }
}
