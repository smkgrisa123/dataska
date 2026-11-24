<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Sekolah_model');
    }

    public function index()
    {
        $data['title'] = 'Data Sekolah - DATASKA';
        $data['sekolah'] = $this->Sekolah_model->get_all_with_kebutuhan();
        $data['berkebutuhan_khusus'] = $this->Sekolah_model->get_kebutuhan_khusus();

        $data['bentuk_pendidikan_list'] = [
            'PAUD / TK',
            'SD',
            'SMP',
            'SMA',
            'SMK',
            'SLB',
            'PKBM / SKB'
        ];

        $this->load->view('template/header', $data);
        $this->load->view('sekolah/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $id = $this->input->post('id', true);
        $now = date('Y-m-d H:i:s');

        $bk_id = $this->input->post('berkebutuhan_khusus_id', true);
        $tgl_sk_pendirian = $this->input->post('tgl_sk_pendirian', true);
        $tgl_sk_izin = $this->input->post('tgl_sk_izin_operasional', true);
        $status_kepemilikan = $this->input->post('status_kepemilikan', true);

        $sosmed_arr = array_filter([
            'instagram' => trim($this->input->post('sosmed_ig', true)),
            'facebook'  => trim($this->input->post('sosmed_fb', true)),
            'youtube'   => trim($this->input->post('sosmed_yt', true)),
            'tiktok'    => trim($this->input->post('sosmed_tt', true)),
        ], function ($val) {
            return $val !== '';
        });

        $sosial_media = !empty($sosmed_arr) ? json_encode($sosmed_arr, JSON_UNESCAPED_UNICODE) : NULL;

        $data = [
            'nama_sekolah'            => trim($this->input->post('nama_sekolah', true)),
            'npsn'                    => trim($this->input->post('npsn', true)) ?: NULL,
            'bentuk_pendidikan'       => trim($this->input->post('bentuk_pendidikan', true)) ?: NULL,

            'alamat'                  => trim($this->input->post('alamat', true)) ?: NULL,
            'dusun'                   => trim($this->input->post('dusun', true)) ?: NULL,
            'rt'                      => trim($this->input->post('rt', true)) ?: NULL,
            'rw'                      => trim($this->input->post('rw', true)) ?: NULL,
            'desa'                    => trim($this->input->post('desa', true)) ?: NULL,
            'kecamatan'               => trim($this->input->post('kecamatan', true)) ?: NULL,
            'kabupaten'               => trim($this->input->post('kabupaten', true)) ?: NULL,
            'provinsi'                => trim($this->input->post('provinsi', true)) ?: NULL,
            'lintang'                 => trim($this->input->post('lintang', true)) ?: NULL,
            'bujur'                   => trim($this->input->post('bujur', true)) ?: NULL,

            'berkebutuhan_khusus_id'  => !empty($bk_id) ? $bk_id : NULL,
            'sk_pendirian'            => trim($this->input->post('sk_pendirian', true)) ?: NULL,
            'tgl_sk_pendirian'        => !empty($tgl_sk_pendirian) ? $tgl_sk_pendirian : NULL,
            'status_kepemilikan'      => !empty($status_kepemilikan) ? $status_kepemilikan : NULL,
            'yayasan'                 => trim($this->input->post('yayasan', true)) ?: NULL,
            'sk_izin_operasional'     => trim($this->input->post('sk_izin_operasional', true)) ?: NULL,
            'tgl_sk_izin_operasional' => !empty($tgl_sk_izin) ? $tgl_sk_izin : NULL,

            'no_telepon'              => trim($this->input->post('no_telepon', true)) ?: NULL,
            'no_hp'                   => trim($this->input->post('no_hp', true)) ?: NULL,
            'email'                   => trim($this->input->post('email', true)) ?: NULL,
            'website'                 => trim($this->input->post('website', true)) ?: NULL,
            'sosial_media'            => $sosial_media,

            'updated_at'              => $now
        ];

        if (empty($id)) {
            $data['created_at'] = $now;
            $this->Sekolah_model->simpan($data);
            $this->session->set_flashdata('success', 'Data sekolah berhasil ditambahkan!');
        } else {
            $this->Sekolah_model->simpan($data, $id);
            $this->session->set_flashdata('success', 'Data sekolah berhasil diperbarui!');
        }

        redirect('sekolah');
    }

    public function get_by_id($id)
    {
        $row = $this->Sekolah_model->get_by_id($id);
        echo json_encode($row);
    }

    public function hapus($id)
    {
        $this->Sekolah_model->hapus($id);
        $this->session->set_flashdata('success', 'Data sekolah berhasil dihapus!');
        redirect('sekolah');
    }
}
