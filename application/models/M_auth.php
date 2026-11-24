<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{

    public function cek_login($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }
}
