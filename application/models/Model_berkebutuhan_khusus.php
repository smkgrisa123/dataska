<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_berkebutuhan_khusus extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('berkebutuhan_khusus')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('berkebutuhan_khusus', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('berkebutuhan_khusus', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('berkebutuhan_khusus');
    }
}
