<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun_ajaran_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function semua_data()
    {
        return $this->db->order_by('id', 'DESC')->get('tahun_ajaran')->result();
    }

    public function tambah($data)
    {
        return $this->db->insert('tahun_ajaran', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('tahun_ajaran', $data);
    }

    public function hapus($id)
    {
        return $this->db->where('id', $id)->delete('tahun_ajaran');
    }

    public function set_semua_tidak_aktif()
    {
        return $this->db->update('tahun_ajaran', ['status' => 'Tidak Aktif']);
    }
}
