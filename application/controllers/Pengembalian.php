<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/data_pengembalian');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT a.id_peminjaman, DATE_FORMAT(a.tgl_pengajuan, '%d-%b-%Y') tgl_pengajuan, 
    concat(DATE_FORMAT(a.pinjam_mulai, '%d-%b-%Y'), ' - ', DATE_FORMAT(a.pinjam_sampai, '%d-%b-%Y')) tgl_peminjaman , a.keterangan,
    DATE_FORMAT(a.pinjam_mulai, '%d-%b-%Y') pinjam_mulai,
    DATE_FORMAT(a.pinjam_sampai, '%d-%b-%Y') pinjam_sampai,
    a.status, a.no_induk, b.hak_akses, b.nama, b.no_wa, c.periode
    FROM tb_peminjaman a, tb_user b, tb_periode c
    where a.no_induk=b.no_induk
    and a.id_periode=c.id_periode
    and a.status in ('Approved','Selesai')")->result();;
    echo json_encode($data);
  }

}