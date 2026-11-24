<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Master_Kelas extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('master_kelas')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('master_kelas', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('master_kelas', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('master_kelas', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('master_kelas');
    }
}
