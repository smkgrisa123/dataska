<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kompetensi extends CI_Model
{

    public function get_data()
    {
        return $this->db->get('kompetensi')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('kompetensi', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('kompetensi', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kompetensi', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('kompetensi');
    }
}
