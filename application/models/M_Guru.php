<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Guru extends CI_Model
{

    public function get_all_guru()
    {
        return $this->db->get('guru')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('guru', ['id' => $id])->row();
    }
    public function insert_guru($data)
    {
        return $this->db->insert('guru', $data);
    }
    public function update_guru($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('guru', $data);
    }

    // Ambil data dari tabel master pekerjaan
    public function get_master_pekerjaan()
    {
        return $this->db->get('pekerjaan')->result();
    }

    // Ambil data wilayah provinsi
    public function get_provinsi()
    {
        return $this->db->order_by('nama', 'ASC')->get('wilayah_provinsi')->result();
    }

    // Ambil kabupaten berdasarkan provinsi_id (coba sesuaikan jika nama kolomnya berbeda, misal id_provinsi)
    public function get_kabupaten_by_prov($provinsi_id)
    {
        return $this->db->where('provinsi_id', $provinsi_id)->order_by('nama', 'ASC')->get('wilayah_kabupaten')->result();
    }

    // Ambil kecamatan berdasarkan kabupaten_id
    public function get_kecamatan_by_kab($kabupaten_id)
    {
        return $this->db->where('kabupaten_id', $kabupaten_id)->order_by('nama', 'ASC')->get('wilayah_kecamatan')->result();
    }

    // Ambil desa/kelurahan berdasarkan kecamatan_id
    public function get_desa_by_kec($kecamatan_id)
    {
        return $this->db->where('kecamatan_id', $kecamatan_id)->order_by('nama', 'ASC')->get('wilayah_desa')->result();
    }

    // Ambil data sertifikasi berdasarkan ID guru
    public function get_sertifikasi_by_guru($guru_id)
    {
        return $this->db->get_where('guru_sertifikasi', ['guru_id' => $guru_id])->result();
    }

    public function insert_sertifikasi($data)
    {
        return $this->db->insert('guru_sertifikasi', $data);
    }

    public function update_sertifikasi($id, $data)
    {
        return $this->db->where('id', $id)->update('guru_sertifikasi', $data);
    }

    // Hapus sertifikasi
    public function delete_sertifikasi($id)
    {
        return $this->db->where('id', $id)->delete('guru_sertifikasi');
    }

    // --- TABEL PENDIDIKAN FORMAL ---
    public function get_pendidikan_by_guru($guru_id)
    {
        return $this->db->get_where('guru_pendidikan', ['guru_id' => $guru_id])->result();
    }

    public function insert_pendidikan($data)
    {
        return $this->db->insert('guru_pendidikan', $data);
    }

    public function update_pendidikan($id, $data)
    {
        return $this->db->where('id', $id)->update('guru_pendidikan', $data);
    }

    public function delete_pendidikan($id)
    {
        return $this->db->where('id', $id)->delete('guru_pendidikan');
    }

    // --- TABEL ANAK ---
    public function get_anak_by_guru($guru_id)
    {
        return $this->db->get_where('guru_anak', ['guru_id' => $guru_id])->result();
    }
    public function insert_anak($data)
    {
        return $this->db->insert('guru_anak', $data);
    }
    public function update_anak($id, $data)
    {
        return $this->db->where('id', $id)->update('guru_anak', $data);
    }
    public function delete_anak($id)
    {
        return $this->db->where('id', $id)->delete('guru_anak');
    }

    // --- TABEL DIKLAT ---
    public function get_diklat_by_guru($guru_id)
    {
        return $this->db->get_where('guru_diklat', ['guru_id' => $guru_id])->result();
    }

    public function insert_diklat($data)
    {
        return $this->db->insert('guru_diklat', $data);
    }

    public function update_diklat($id, $data)
    {
        return $this->db->where('id', $id)->update('guru_diklat', $data);
    }

    public function delete_diklat($id)
    {
        return $this->db->where('id', $id)->delete('guru_diklat');
    }

    // --- TABEL DOKUMEN GURU ---
    public function get_dokumen_by_guru($guru_id)
    {
        return $this->db->get_where('guru_dokumen', ['guru_id' => $guru_id])->row();
    }

    public function save_dokumen($guru_id, $data)
    {
        $cek = $this->get_dokumen_by_guru($guru_id);
        if ($cek) {
            $this->db->where('guru_id', $guru_id)->update('guru_dokumen', $data);
        } else {
            $data['guru_id'] = $guru_id;
            $this->db->insert('guru_dokumen', $data);
        }
    }

    // Ambil master tugas tambahan
    public function get_master_tugas_tambahan()
    {
        return $this->db->get('tugas_tambahan')->result();
    }

    // Ambil master peran
    public function get_master_peran()
    {
        return $this->db->get('peran')->result();
    }

    // Simpan atau update penugasan guru
    public function save_penugasan($guru_id, $data)
    {
        // Cek apakah guru sudah punya data penugasan
        $exists = $this->db->get_where('guru_penugasan', ['guru_id' => $guru_id])->row();
        if ($exists) {
            $this->db->where('guru_id', $guru_id);
            return $this->db->update('guru_penugasan', $data);
        } else {
            $data['guru_id'] = $guru_id;
            return $this->db->insert('guru_penugasan', $data);
        }
    }



    // Ambil semua penugasan berdasarkan guru_id
    public function get_penugasan_by_guru($guru_id)
    {
        $this->db->select('guru_penugasan.*, tugas_tambahan.nama_tugas as nama_tugas_tambahan, peran.nama_peran');
        $this->db->from('guru_penugasan');
        $this->db->join('tugas_tambahan', 'tugas_tambahan.id = guru_penugasan.tugas_tambahan_id', 'left');
        $this->db->join('peran', 'peran.id = guru_penugasan.peran_id', 'left');
        $this->db->where('guru_penugasan.guru_id', $guru_id);
        return $this->db->get()->result();
    }

    public function insert_penugasan($data)
    {
        return $this->db->insert('guru_penugasan', $data);
    }

    public function update_penugasan($penugasan_id, $data)
    {
        $this->db->where('id', $penugasan_id);
        return $this->db->update('guru_penugasan', $data);
    }

    public function delete_penugasan($penugasan_id)
    {
        $this->db->where('id', $penugasan_id);
        return $this->db->delete('guru_penugasan');
    }
}
