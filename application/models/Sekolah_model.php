<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah_model extends CI_Model
{
    private $table = 'sekolah';

    public function get_all_with_kebutuhan()
    {
        return $this->db
            ->select('s.*, bk.nama AS nama_kebutuhan_khusus')
            ->from($this->table . ' s')
            ->join('berkebutuhan_khusus bk', 'bk.id = s.berkebutuhan_khusus_id', 'left')
            ->order_by('s.id', 'ASC')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_kebutuhan_khusus()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get('berkebutuhan_khusus')
            ->result();
    }

    public function simpan($data, $id = null)
    {
        if (empty($id)) {
            return $this->db->insert($this->table, $data);
        }

        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function hapus($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
