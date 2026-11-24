<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pekerjaan extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('pekerjaan')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('pekerjaan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('pekerjaan', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('pekerjaan');
    }
}
