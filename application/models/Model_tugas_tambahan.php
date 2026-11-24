<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tugas_tambahan extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tugas_tambahan')->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('tugas_tambahan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tugas_tambahan', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tugas_tambahan');
    }
}
