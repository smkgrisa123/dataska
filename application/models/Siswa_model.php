<?php
class Siswa_model extends CI_Model
{

    public function get_all_siswa()
    {
        $this->db->select('siswa.*, 
                           COALESCE(tingkat_rombel.nama, tingkat_langsung.nama) as nama_tingkat, 
                           master_kelas.nama_kelas as nama_kelas');
        $this->db->from('siswa');
        $this->db->join('rombel', 'rombel.id = siswa.rombel_id', 'left');
        $this->db->join('tingkat as tingkat_rombel', 'tingkat_rombel.id = rombel.id_tingkat', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');

        // JOIN tambahan langsung ke tabel tingkat berdasarkan tingkat_id di tabel siswa
        $this->db->join('tingkat as tingkat_langsung', 'tingkat_langsung.id = siswa.tingkat_id', 'left');

        // Sembunyikan siswa yang sudah lulus (status_validasi = 2) dan siswa yang sudah keluar (status_validasi = 3)
        $this->db->where('siswa.status_validasi !=', 2);
        $this->db->where('siswa.status_validasi !=', 3);

        $this->db->order_by('siswa.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('siswa.*, tingkat_rombel.nama as nama_tingkat, master_kelas.nama_kelas as nama_kelas');
        $this->db->from('siswa');
        $this->db->join('rombel', 'rombel.id = siswa.rombel_id', 'left');
        $this->db->join('tingkat as tingkat_rombel', 'tingkat_rombel.id = rombel.id_tingkat', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        $this->db->where('siswa.id', $id);
        return $this->db->get()->row();
    }

    public function insert($data)
    {
        return $this->db->insert('siswa', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('siswa', $data);
    }

    public function delete_multiple($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->delete('siswa');
    }

    public function validate_multiple($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->update('siswa', ['status_validasi' => 1]);
    }
    public function get_siswa_keluar()
    {
        $this->db->select('siswa.*, rombel.id as rombel_id, tingkat_rombel.nama as nama_tingkat, master_kelas.nama_kelas as nama_kelas, 
                       registrasi_keluar.*, 
                       tahun_ajaran.nama as nama_tahun_ajaran, 
                       tahun_ajaran.semester');
        $this->db->from('siswa');
        $this->db->join('registrasi_keluar', 'registrasi_keluar.siswa_id = siswa.id', 'left');
        $this->db->join('rombel', 'rombel.id = siswa.rombel_id', 'left');
        $this->db->join('tingkat as tingkat_rombel', 'tingkat_rombel.id = rombel.id_tingkat', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        $this->db->join('tahun_ajaran', 'tahun_ajaran.id = registrasi_keluar.tahun_ajaran_id', 'left'); // Join tahun ajaran keluar
        $this->db->where('siswa.status_validasi', 3);
        $this->db->order_by('siswa.id', 'DESC');
        return $this->db->get()->result();
    }
    public function count_by_jenis($jenis)
    {
        $this->db->from('registrasi_keluar');
        $this->db->join('siswa', 'siswa.id = registrasi_keluar.siswa_id', 'inner');
        $this->db->where('siswa.status_validasi', 3);
        $this->db->where('registrasi_keluar.jenis_keluar', $jenis);
        return $this->db->count_all_results();
    }

    public function get_siswa_by_ids($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->get('siswa')->result();
    }

    public function insert_siswa($data)
    {
        $this->db->insert('siswa', $data);
        return $this->db->insert_id(); // Mengembalikan ID siswa yang baru dimasukkan
    }

    public function insert_registrasi_masuk($data)
    {
        return $this->db->insert('registrasi_masuk', $data);
    }

    public function get_siswa_by_rombel($rombel_id)
    {
        $this->db->select('siswa.*, 
                           COALESCE(tingkat_rombel.nama, tingkat_langsung.nama) as nama_tingkat, 
                           master_kelas.nama_kelas as nama_kelas');
        $this->db->from('siswa');
        $this->db->join('rombel', 'rombel.id = siswa.rombel_id', 'left');
        $this->db->join('tingkat as tingkat_rombel', 'tingkat_rombel.id = rombel.id_tingkat', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        $this->db->join('tingkat as tingkat_langsung', 'tingkat_langsung.id = siswa.tingkat_id', 'left');

        // Filter khusus berdasarkan rombel_id wali kelas yang sedang login
        $this->db->where('siswa.rombel_id', $rombel_id);

        // Sembunyikan siswa yang sudah lulus (2) atau keluar (3)
        $this->db->where('siswa.status_validasi !=', 2);
        $this->db->where('siswa.status_validasi !=', 3);

        $this->db->order_by('siswa.id', 'DESC');
        return $this->db->get()->result();
    }
}
