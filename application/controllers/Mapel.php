<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = 'Data Master Mata Pelajaran - DATASKA';

        $data['mapel'] = $this->db
            ->select('m.*, k.nama AS nama_jurusan')
            ->from('mapel m')
            ->join('kompetensi k', 'k.id = m.kompetensi_id', 'left')
            ->order_by('m.id', 'ASC')
            ->get()
            ->result();

        $data['kelompok_mapel'] = $this->db
            ->order_by('id_kelompok', 'ASC')
            ->get('kelompok_mapel')
            ->result();

        $data['kompetensi'] = $this->db
            ->order_by('id', 'ASC')
            ->get('kompetensi')
            ->result();

        $this->load->view('template/header', $data);
        $this->load->view('mapel/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $id = $this->input->post('id', true);
        $kompetensi_id = $this->input->post('kompetensi_id', true);
        $now = date('Y-m-d H:i:s');

        $data = [
            'nama'           => trim($this->input->post('nama', true)),
            'kode'           => strtoupper(trim($this->input->post('kode', true))),
            'kelompok_mapel' => trim($this->input->post('kelompok_mapel', true)),
            'kompetensi_id'  => !empty($kompetensi_id) ? $kompetensi_id : NULL,
            'updated_at'     => $now
        ];

        if (empty($id)) {
            $data['created_at'] = $now;
            $data['status']     = 'Aktif';
            $this->db->insert('mapel', $data);
            $this->session->set_flashdata('success', 'Data mata pelajaran berhasil ditambahkan!');
        } else {
            $this->db->where('id', $id);
            $this->db->update('mapel', $data);
            $this->session->set_flashdata('success', 'Data mata pelajaran berhasil diperbarui!');
        }

        redirect('mapel');
    }

    public function get_by_id($id)
    {
        $data = $this->db->get_where('mapel', ['id' => $id])->row();
        echo json_encode($data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mapel');

        $this->session->set_flashdata('success', 'Data mata pelajaran berhasil dihapus dari sistem!');
        redirect('mapel');
    }
}
