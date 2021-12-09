<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RangkingModel extends CI_Model {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
  // Fungsi untuk menampilkan semua data siswa
  public function getNilai($id_kriteria, $id_pelamar, $id_loker){
    $sql = "SELECT a.nilai FROM tb_nilai a, tb_pelamar b
            WHERE a.id_pelamar=b.id_pelamar
            AND a.id_kriteria='".$id_kriteria."'
            AND b.id_pelamar='".$id_pelamar."'
            AND b.id_lowongan_kerja='".$id_loker."'";
    return $this->db->query($sql)->result_array();
  }

}