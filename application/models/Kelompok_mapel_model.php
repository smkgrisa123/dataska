<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelompok_mapel_model extends CI_Model
{

    private $table = 'kelompok_mapel';

    public function get_all()
    {
        return $this->db->order_by('id_kelompok', 'ASC')->get($this->table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_kelompok', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_kelompok', $id);
        return $this->db->delete($this->table);
    }
}
