<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KriteriaModel extends CI_Model {
  // Fungsi untuk menampilkan semua data siswa
  public function getData(){
    return $this->db->get('tb_user')->result();
  }

}