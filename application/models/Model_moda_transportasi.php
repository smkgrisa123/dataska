<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_moda_transportasi extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('moda_transportasi')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('moda_transportasi', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('moda_transportasi', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('moda_transportasi');
    }
}
