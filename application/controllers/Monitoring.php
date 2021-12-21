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

  public function getDataBarang(){
    $this->db->select('id_barang, nama_barang, stock, foto');
    $this->db->from('tb_barang'); 
    $this->db->where('id_laborat', $this->input->post('id_laborat'));
    $this->db->order_by('nama_barang','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

  public function getDataHdr(){
    $id_monitoring = $this->input->post('id_monitoring');
    $data = $this->db->query("SELECT a.id_monitoring, DATE_FORMAT(tgl_monitoring, '%d-%b-%Y') tgl_monitoring, 
    a.keterangan,a.status, a.no_induk, b.nama
    FROM tb_monitoring a, tb_user b
    where a.no_induk=b.no_induk
    and a.id_monitoring='".$id_monitoring."'")->result_array();

    $datalab = $this->db->query("SELECT * from tb_laborat where id_laborat = (
      SELECT z.id_laborat FROM tb_dtl_monitoring y, tb_barang z WHERE 
      y.id_barang=z.id_barang
      and y.id_monitoring='".$id_monitoring."' limit 1
      )"
    )->result_array();

    $data[0]['id_laborat']=$datalab[0]['id_laborat'];
    $data[0]['nm_laborat']=$datalab[0]['deskripsi'];

    echo json_encode($data);
  }

  public function getDataItems(){
    $id_monitoring = $this->input->post('id_monitoring');
    $data = $this->db->query("SELECT a.id_barang, b.nama_barang, a.stock_sistem, a.stock_actual, a.qty_bagus, a.qty_rusak
    FROM tb_dtl_monitoring a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_monitoring='".$id_monitoring."'")->result_array();

    echo json_encode($data);
  }

  public function dtlData($id){

    $data['id'] = $id;
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/monitoring', $data);
    $this->load->view('template/footer');
  }

}