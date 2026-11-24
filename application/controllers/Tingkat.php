<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tingkat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = 'Data Master Tingkat - DATASKA';
        $data['tingkat'] = $this->db->order_by('urutan', 'ASC')->get('tingkat')->result();

        $this->load->view('template/header', $data);
        $this->load->view('tingkat/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $id = $this->input->post('id');
        $data = [
            'nama'       => $this->input->post('nama', true),
            'urutan'     => $this->input->post('urutan', true),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (empty($id)) {
            // Tambah Data Baru
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tingkat', $data);
            $this->session->set_flashdata('success', 'Data tingkat berhasil ditambahkan!');
        } else {
            // Update Data
            $this->db->where('id', $id);
            $this->db->update('tingkat', $data);
            $this->session->set_flashdata('success', 'Data tingkat berhasil diperbarui!');
        }

        redirect('tingkat');
    }

    public function get_by_id($id)
    {
        $data = $this->db->get_where('tingkat', ['id' => $id])->row();
        echo json_encode($data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tingkat');

        $this->session->set_flashdata('success', 'Data tingkat berhasil dihapus dari sistem!');
        redirect('tingkat');
    }
}
