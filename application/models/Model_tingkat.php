<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tingkat extends CI_Model
{

    public function get_all()
    {
        // Mengambil data diurutkan berdasarkan kolom 'urutan'
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get('tingkat')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('tingkat', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tingkat', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tingkat');
    }
}
