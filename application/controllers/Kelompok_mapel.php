<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelompok_mapel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = 'Data Master Kelompok Mapel - DATASKA';
        $data['kelompok_mapel'] = $this->db->order_by('id_kelompok', 'ASC')->get('kelompok_mapel')->result();

        $this->load->view('template/header', $data);
        $this->load->view('kelompok_mapel/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $id = $this->input->post('id_kelompok', true);
        $data = [
            'kelompok_mapel' => $this->input->post('kelompok_mapel', true)
        ];

        if (empty($id)) {
            // Tambah Data Baru
            $this->db->insert('kelompok_mapel', $data);
            $this->session->set_flashdata('success', 'Data kelompok mapel berhasil ditambahkan!');
        } else {
            // Update Data
            $this->db->where('id_kelompok', $id);
            $this->db->update('kelompok_mapel', $data);
            $this->session->set_flashdata('success', 'Data kelompok mapel berhasil diperbarui!');
        }

        redirect('kelompok_mapel');
    }

    public function get_by_id($id)
    {
        $data = $this->db->get_where('kelompok_mapel', ['id_kelompok' => $id])->row();
        echo json_encode($data);
    }

    public function hapus($id)
    {
        $this->db->where('id_kelompok', $id);
        $this->db->delete('kelompok_mapel');

        $this->session->set_flashdata('success', 'Data kelompok mapel berhasil dihapus dari sistem!');
        redirect('kelompok_mapel');
    }
}
