<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Rombel extends CI_Model
{
    public function get_all()
    {
        $this->db->select('rombel.*, tingkat.nama as nama_tingkat, kompetensi.konsentrasi_keahlian as nama_kompetensi, master_kelas.nama_kelas, guru.nama_lengkap as nama_gtk');
        $this->db->from('rombel');
        $this->db->join('tingkat', 'tingkat.id = rombel.id_tingkat', 'left');
        $this->db->join('kompetensi', 'kompetensi.id = rombel.id_kompetensi', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        $this->db->join('guru', 'guru.id = rombel.id_gtk', 'left');

        $this->db->order_by('rombel.id_tingkat', 'ASC');
        return $this->db->get()->result();
    }

    public function simpan($data)
    {
        return $this->db->insert('rombel', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('rombel', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        return $this->db->update('rombel', $data, ['id' => $id]);
    }
    public function delete($id)
    {
        return $this->db->delete('rombel', ['id' => $id]);
    }

    public function get_siswa_belum_rombel()
    {
        // Ambil semua siswa_id dari tabel registrasi_keluar
        $keluar = $this->db->select('siswa_id')->get('registrasi_keluar')->result_array();
        $id_keluar = array_column($keluar, 'siswa_id');

        // Ambil semua siswa_id dari tabel siswa_lulus (jika ada)
        $lulus = $this->db->select('siswa_id')->get('siswa_lulus')->result_array();
        $id_lulus = array_column($lulus, 'siswa_id');

        // Gabungkan ID yang harus dikecualikan
        $exclude_ids = array_merge($id_keluar, $id_lulus);

        // Query utama siswa
        $this->db->from('siswa');

        // Jika ada siswa yang keluar/lulus, kecualikan ID mereka
        if (!empty($exclude_ids)) {
            $this->db->where_not_in('id', $exclude_ids);
        }

        // Tambahkan kondisi belum masuk rombel jika ada kolomnya
        // $this->db->where('id_rombel', null);

        return $this->db->get()->result();
    }
}
