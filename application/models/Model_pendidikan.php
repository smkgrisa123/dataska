<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendidikan extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('pendidikan')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('pendidikan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('pendidikan', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('pendidikan');
    }
}
