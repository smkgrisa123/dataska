<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Proteksi langsung di dalam controller ini
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard - DATASKA';

        $role      = strtolower(trim((string) $this->session->userdata('role')));
        $rombel_id = $this->session->userdata('rombel_id');

        if ($role === 'wali_kelas' && !empty($rombel_id)) {
            // Hitung khusus siswa aktif di rombel bimbingan
            $data['total_siswa'] = $this->db->from('siswa')
                ->where('rombel_id', $rombel_id)
                ->where('status_validasi !=', 2)
                ->where('status_validasi !=', 3)
                ->count_all_results();

            $data['siswa_l'] = $this->db->from('siswa')
                ->where(['rombel_id' => $rombel_id, 'jk' => 'L'])
                ->where('status_validasi !=', 2)
                ->where('status_validasi !=', 3)
                ->count_all_results();

            $data['siswa_p'] = $this->db->from('siswa')
                ->where(['rombel_id' => $rombel_id, 'jk' => 'P'])
                ->where('status_validasi !=', 2)
                ->where('status_validasi !=', 3)
                ->count_all_results();

            // Ambil nama kelas bimbingan
            $this->db->select('rombel.*, master_kelas.nama_kelas');
            $this->db->from('rombel');
            $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
            $this->db->where('rombel.id', $rombel_id);
            $rombel = $this->db->get()->row();

            $data['info_kelas'] = ($rombel && isset($rombel->nama_kelas)) ? $rombel->nama_kelas : 'Bimbingan';
        } else {
            // Administrator: total siswa aktif keseluruhan
            $data['total_siswa'] = $this->db->from('siswa')
                ->where('status_validasi !=', 2)
                ->where('status_validasi !=', 3)
                ->count_all_results();

            $data['siswa_l'] = $this->db->from('siswa')
                ->where('jk', 'L')
                ->where('status_validasi !=', 2)
                ->where('status_validasi !=', 3)
                ->count_all_results();

            $data['siswa_p'] = $this->db->from('siswa')
                ->where('jk', 'P')
                ->where('status_validasi !=', 2)
                ->where('status_validasi !=', 3)
                ->count_all_results();

            // Jumlah Rombel
            $data['jumlah_rombel'] = $this->db->table_exists('rombel')
                ? $this->db->count_all('rombel')
                : 0;

            // Hitung PTK & Tendik (menyesuaikan nama tabel jika memakai 'ptk' / 'guru' / 'tendik')
            $ptk_stats = $this->hitung_ptk_tendik();
            $data['jumlah_ptk']   = $ptk_stats['ptk_total'];
            $data['ptk_l']        = $ptk_stats['ptk_l'];
            $data['ptk_p']        = $ptk_stats['ptk_p'];
            $data['jumlah_tendik'] = $ptk_stats['tendik_total'];
            $data['tendik_l']     = $ptk_stats['tendik_l'];
            $data['tendik_p']     = $ptk_stats['tendik_p'];
            // Total keseluruhan PTK + Tendik
            $data['total_ptk_tendik'] = ($data['jumlah_ptk'] ?? 0) + ($data['jumlah_tendik'] ?? 0);

            // Ambil rekap peserta didik per rombel (L, P, Jml, Lulus, Mutasi, Keluar)
            $data['rekap_rombel'] = $this->get_rekap_rombel();

            // Ambil profil sekolah (sesuaikan jika tabel bernama 'sekolah' atau 'lembaga')
            $tabel_sekolah = $this->db->table_exists('sekolah') ? 'sekolah' : ($this->db->table_exists('lembaga') ? 'lembaga' : null);
            $data['sekolah'] = $tabel_sekolah ? $this->db->get($tabel_sekolah)->row() : null;

            // Ambil data profil sekolah dari tabel sekolah
            $data['sekolah'] = $this->db->table_exists('sekolah')
                ? $this->db->get('sekolah')->row()
                : null;

            $data['info_kelas'] = 'Administrator';
        }

        $this->load->view('template/header', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('template/footer');
    }

    private function hitung_ptk_tendik()
    {
        $res = [
            'ptk_total'    => 0,
            'ptk_l'        => 0,
            'ptk_p'        => 0,
            'tendik_total' => 0,
            'tendik_l'     => 0,
            'tendik_p'     => 0,
        ];

        // Cek tabel 'ptk', jika tidak ada coba 'guru'
        $tabel_ptk = $this->db->table_exists('ptk') ? 'ptk' : ($this->db->table_exists('guru') ? 'guru' : null);

        if ($tabel_ptk) {
            $kolom_jk = $this->db->field_exists('jk', $tabel_ptk)
                ? 'jk'
                : ($this->db->field_exists('jenis_kelamin', $tabel_ptk) ? 'jenis_kelamin' : null);

            $kolom_jenis = $this->db->field_exists('jenis_ptk', $tabel_ptk)
                ? 'jenis_ptk'
                : ($this->db->field_exists('kategori', $tabel_ptk) ? 'kategori' : null);

            if ($kolom_jenis) {
                // Jika tendik disimpan dalam tabel yang sama dengan pembeda jenis/kategori
                $this->db->from($tabel_ptk)
                    ->not_like($kolom_jenis, 'tendik', 'both')
                    ->not_like($kolom_jenis, 'tenaga kependidikan', 'both');
                $res['ptk_total'] = $this->db->count_all_results();

                if ($kolom_jk) {
                    $this->db->from($tabel_ptk)
                        ->not_like($kolom_jenis, 'tendik', 'both')
                        ->not_like($kolom_jenis, 'tenaga kependidikan', 'both')
                        ->where($kolom_jk, 'L');
                    $res['ptk_l'] = $this->db->count_all_results();

                    $this->db->from($tabel_ptk)
                        ->not_like($kolom_jenis, 'tendik', 'both')
                        ->not_like($kolom_jenis, 'tenaga kependidikan', 'both')
                        ->where($kolom_jk, 'P');
                    $res['ptk_p'] = $this->db->count_all_results();
                }

                $this->db->from($tabel_ptk)
                    ->group_start()
                    ->like($kolom_jenis, 'tendik', 'both')
                    ->or_like($kolom_jenis, 'tenaga kependidikan', 'both')
                    ->group_end();
                $res['tendik_total'] = $this->db->count_all_results();

                if ($kolom_jk) {
                    $this->db->from($tabel_ptk)
                        ->group_start()
                        ->like($kolom_jenis, 'tendik', 'both')
                        ->or_like($kolom_jenis, 'tenaga kependidikan', 'both')
                        ->group_end()
                        ->where($kolom_jk, 'L');
                    $res['tendik_l'] = $this->db->count_all_results();

                    $this->db->from($tabel_ptk)
                        ->group_start()
                        ->like($kolom_jenis, 'tendik', 'both')
                        ->or_like($kolom_jenis, 'tenaga kependidikan', 'both')
                        ->group_end()
                        ->where($kolom_jk, 'P');
                    $res['tendik_p'] = $this->db->count_all_results();
                }
            } else {
                $res['ptk_total'] = $this->db->count_all($tabel_ptk);
                if ($kolom_jk) {
                    $res['ptk_l'] = $this->db->where($kolom_jk, 'L')->from($tabel_ptk)->count_all_results();
                    $res['ptk_p'] = $this->db->where($kolom_jk, 'P')->from($tabel_ptk)->count_all_results();
                }
            }
        }

        // Jika ada tabel terpisah bernama 'tendik'
        if ($this->db->table_exists('tendik')) {
            $res['tendik_total'] = $this->db->count_all('tendik');
            $jk_tendik = $this->db->field_exists('jk', 'tendik')
                ? 'jk'
                : ($this->db->field_exists('jenis_kelamin', 'tendik') ? 'jenis_kelamin' : null);

            if ($jk_tendik) {
                $res['tendik_l'] = $this->db->where($jk_tendik, 'L')->from('tendik')->count_all_results();
                $res['tendik_p'] = $this->db->where($jk_tendik, 'P')->from('tendik')->count_all_results();
            }
        }

        return $res;
    }

    private function get_rekap_rombel()
    {
        if (!$this->db->table_exists('rombel') || !$this->db->table_exists('siswa')) {
            return [];
        }

        $ada_master_kelas = $this->db->table_exists('master_kelas') && $this->db->field_exists('id_master_kelas', 'rombel');
        $ada_nama_rombel  = $this->db->field_exists('nama_rombel', 'rombel');

        $select_nama = 'rombel.id';
        if ($ada_master_kelas && $ada_nama_rombel) {
            $select_nama .= ', COALESCE(master_kelas.nama_kelas, rombel.nama_rombel) as nama_rombel';
        } elseif ($ada_master_kelas) {
            $select_nama .= ', master_kelas.nama_kelas as nama_rombel';
        } elseif ($ada_nama_rombel) {
            $select_nama .= ', rombel.nama_rombel as nama_rombel';
        } else {
            $select_nama .= ', CONCAT("Rombel ", rombel.id) as nama_rombel';
        }

        $this->db->select($select_nama . ',
        SUM(CASE WHEN siswa.jk = "L" AND siswa.status_validasi NOT IN (2, 3) THEN 1 ELSE 0 END) as jml_l,
        SUM(CASE WHEN siswa.jk = "P" AND siswa.status_validasi NOT IN (2, 3) THEN 1 ELSE 0 END) as jml_p,
        SUM(CASE WHEN siswa.status_validasi NOT IN (2, 3) THEN 1 ELSE 0 END) as jml_aktif,
        SUM(CASE WHEN siswa.status_validasi = 2 THEN 1 ELSE 0 END) as jml_lulus,
        0 as jml_mutasi,
        SUM(CASE WHEN siswa.status_validasi = 3 THEN 1 ELSE 0 END) as jml_keluar
    ', false);

        $this->db->from('rombel');
        if ($ada_master_kelas) {
            $this->db->join('master_kelas', 'master_kelas.id = rombel.id_master_kelas', 'left');
        }
        $this->db->join('siswa', 'siswa.rombel_id = rombel.id', 'left');
        $this->db->group_by('rombel.id');
        $this->db->order_by('nama_rombel', 'ASC');

        return $this->db->get()->result();
    }
}
