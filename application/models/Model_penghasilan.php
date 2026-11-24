<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_penghasilan extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('penghasilan')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('penghasilan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('penghasilan', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('penghasilan');
    }
}
