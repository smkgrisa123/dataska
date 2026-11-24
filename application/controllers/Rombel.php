<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rombel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Rombel');
        $this->load->model('Model_Master_Kelas');
    }

    public function index()
    {
        $data['rombel']       = $this->Model_Rombel->get_all();
        $data['tingkat']      = $this->db->get('tingkat')->result();
        $data['kompetensi']   = $this->db->get('kompetensi')->result();
        $data['master_kelas'] = $this->db->get('master_kelas')->result();
        $data['gtk']          = $this->db->get('guru')->result();
        $data['tahun_ajaran_list'] = $this->db->get('tahun_ajaran')->result();

        $this->load->view('template/header', $data);
        $this->load->view('rombel/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = array(
            'id_tingkat'      => $this->input->post('id_tingkat'),
            'id_kompetensi'   => $this->input->post('id_kompetensi'),
            'id_master_kelas' => $this->input->post('id_master_kelas'),
            'id_gtk'          => $this->input->post('id_gtk'),
            'tahun_ajaran'    => $this->input->post('tahun_ajaran')
        );

        $this->Model_Rombel->simpan($data);
        $this->session->set_flashdata('success', 'Data Rombel berhasil ditambahkan!');
        redirect('rombel');
    }

    public function get_by_id($id)
    {
        $data = $this->Model_Rombel->get_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id');

        $data = array(
            'id_tingkat'      => $this->input->post('id_tingkat'),
            'id_kompetensi'   => $this->input->post('id_kompetensi'),
            'id_master_kelas' => $this->input->post('id_master_kelas'),
            'id_gtk'          => $this->input->post('id_gtk'),
            'tahun_ajaran'    => $this->input->post('tahun_ajaran')
        );

        $this->Model_Rombel->update($id, $data);
        $this->session->set_flashdata('success', 'Data Rombel berhasil diperbarui!');
        redirect('rombel');
    }

    public function anggota($id_rombel)
    {
        // Menggunakan Model bawaan atau query yang hanya men-JOIN tabel yang pasti ada
        $this->db->select('rombel.*, tingkat.nama as nama_tingkat, master_kelas.nama_kelas');
        $this->db->from('rombel');
        $this->db->join('tingkat', 'tingkat.id = rombel.id_tingkat', 'left');
        $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        $this->db->where('rombel.id', $id_rombel);
        $data['rombel'] = $this->db->get()->row();

        // Fallback jika kosong
        if (!$data['rombel']) {
            $data['rombel'] = $this->db->get_where('rombel', ['id' => $id_rombel])->row();
        }

        $data['siswa_di_rombel'] = $this->db->get_where('siswa', ['rombel_id' => $id_rombel])->result();

        // --- AMBIL ID SISWA YANG SUDAH KELUAR DARI TABEL registrasi_keluar ---
        $keluar = $this->db->select('siswa_id')->get('registrasi_keluar')->result_array();
        $id_keluar = array_column($keluar, 'siswa_id');
        // -------------------------------------------------------------------

        // --- FILTER KETAT: Hanya ambil yang BELUM PUNYA ROMBEL DAN TIDAK KELUAR ---
        $this->db->where('status_validasi !=', 2);

        $this->db->group_start();
        $this->db->where('rombel_id IS NULL', NULL, FALSE);
        $this->db->or_where('rombel_id', 0);
        $this->db->or_where('rombel_id', '');
        $this->db->group_end();

        // Kecualikan siswa yang ada di daftar registrasi_keluar
        if (!empty($id_keluar)) {
            $this->db->where_not_in('id', $id_keluar);
        }

        $data['siswa_belum_ada_rombel'] = $this->db->get('siswa')->result();
        // ----------------------------------------------------------------------------------------------

        $this->load->view('template/header');
        $this->load->view('rombel/anggota', $data);
        $this->load->view('template/footer');
    }
    public function tambah_siswa_bulk($id_rombel)
    {
        $siswa_ids = $this->input->post('siswa_ids');
        $field_rombel = 'rombel_id'; // Sesuaikan dengan kolom di database siswa Anda

        if (!empty($siswa_ids)) {
            foreach ($siswa_ids as $id_siswa) {
                $this->db->where('id', $id_siswa);
                $this->db->update('siswa', [$field_rombel => $id_rombel]);
            }
            $this->session->set_flashdata('success', 'Siswa terpilih berhasil dimasukkan ke rombel.');
        } else {
            $this->session->set_flashdata('warning', 'Tidak ada siswa yang dipilih.');
        }

        redirect('rombel/anggota/' . $id_rombel);
    }

    public function keluarkan_siswa($id_siswa)
    {
        $field_rombel = 'rombel_id'; // Sesuaikan dengan kolom di database siswa Anda

        $this->db->where('id', $id_siswa);
        $this->db->update('siswa', [$field_rombel => NULL]);

        $this->session->set_flashdata('success', 'Siswa berhasil dikeluarkan dari rombel.');
        redirect($_SERVER['HTTP_REFERER']);
    }



    public function hapus_bulk()
    {
        $ids = $this->input->post('ids');

        if (empty($ids)) {
            $this->session->set_flashdata('warning', 'Pilih setidaknya satu data rombel yang ingin dihapus.');
            redirect('rombel');
        }

        $berhasil_hapus = 0;
        $gagal_hapus = 0;

        foreach ($ids as $id_rombel) {
            // Validasi pengamanan: Cek apakah masih ada siswa di dalam rombel ini
            $jumlah_siswa = $this->db->where('rombel_id', $id_rombel)->count_all_results('siswa');

            if ($jumlah_siswa > 0) {
                $gagal_hapus++;
            } else {
                $this->db->where('id', $id_rombel);
                $this->db->delete('rombel');
                $berhasil_hapus++;
            }
        }

        if ($gagal_hapus > 0) {
            $pesan = "Sebanyak $berhasil_hapus rombel berhasil dihapus. $gagal_hapus rombel GAGAL dihapus karena masih memiliki anggota siswa di dalamnya!";
            $this->session->set_flashdata('warning', $pesan);
        } else {
            $this->session->set_flashdata('success', "Data rombel terpilih berhasil dihapus.");
        }

        redirect('rombel');
    }

    public function hapus($id)
    {
        // Validasi pengamanan untuk hapus satuan
        $jumlah_siswa = $this->db->where('rombel_id', $id)->count_all_results('siswa');

        if ($jumlah_siswa > 0) {
            $this->session->set_flashdata('warning', 'Rombel GAGAL dihapus karena masih memiliki anggota siswa di dalamnya!');
        } else {
            $this->Model_Rombel->delete($id);
            $this->session->set_flashdata('success', 'Data Rombel berhasil dihapus!');
        }

        redirect('rombel');
    }
}
