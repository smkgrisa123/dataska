<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kompetensi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kompetensi');
    }

    public function index()
    {
        $data['title'] = 'Data Kompetensi - Aplikasi Pengawasan TKA';
        $data['kompetensi'] = $this->M_kompetensi->get_data();

        // Hitung statistik untuk kartu atas
        $data['total_kompetensi'] = count($data['kompetensi']);
        $data['total_aktif'] = count(array_filter($data['kompetensi'], function ($v) {
            return $v->status == 'Aktif';
        }));

        $this->load->view('template/header', $data);
        $this->load->view('kompetensi/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'kode'                 => $this->input->post('kode'),
            'bidang_keahlian'      => $this->input->post('bidang_keahlian'),
            'program_keahlian'     => $this->input->post('program_keahlian'),
            'konsentrasi_keahlian' => $this->input->post('konsentrasi_keahlian'),
            'status'               => $this->input->post('status'),
            'created_at'           => date('Y-m-d H:i:s'),
            'updated_at'           => date('Y-m-d H:i:s')
        ];

        $this->M_kompetensi->insert($data);
        $this->session->set_flashdata('success', 'Data kompetensi berhasil ditambahkan!');
        redirect('kompetensi');
    }

    public function update($id)
    {
        $data = [
            'kode'                 => $this->input->post('kode'),
            'bidang_keahlian'      => $this->input->post('bidang_keahlian'),
            'program_keahlian'     => $this->input->post('program_keahlian'),
            'konsentrasi_keahlian' => $this->input->post('konsentrasi_keahlian'),
            'status'               => $this->input->post('status'),
            'updated_at'           => date('Y-m-d H:i:s')
        ];

        $this->M_kompetensi->update($id, $data);
        $this->session->set_flashdata('success', 'Data kompetensi berhasil diperbarui!');
        redirect('kompetensi');
    }

    public function hapus($id)
    {
        $this->M_kompetensi->delete($id);
        $this->session->set_flashdata('success', 'Data kompetensi berhasil dihapus!');
        redirect('kompetensi');
    }
}
