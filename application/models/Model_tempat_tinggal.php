<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tempat_tinggal extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tempat_tinggal')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('tempat_tinggal', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tempat_tinggal', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tempat_tinggal');
    }
}
