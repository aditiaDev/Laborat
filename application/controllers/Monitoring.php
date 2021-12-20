<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/data_monitoring');
    $this->load->view('template/footer');
  }

  public function addData(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/monitoring');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    if($this->session->userdata('hak_akses') == "siswa" or $this->session->userdata('hak_akses') == "guru"){
      $akses = " And a.no_induk='".$this->session->userdata('no_induk')."'";
    }

    $data['data'] = $this->db->query("SELECT a.id_monitoring, c.periode, 
    DATE_FORMAT(a.tgl_monitoring, '%d-%b-%Y') tgl_monitoring, 
    b.no_induk, b.nama, b.hak_akses, 
    a.keterangan, a.status 
    FROM tb_monitoring a, tb_user b, tb_periode c
    where a.no_induk=b.no_induk
    and a.id_periode=c.id_periode
    ".@$akses)->result();;
    echo json_encode($data);
  }

}