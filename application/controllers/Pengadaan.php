<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/data_pengadaan');
    $this->load->view('template/footer');
  }

  public function addData(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/pengadaan');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT a.id_pengadaan, DATE_FORMAT(a.tgl_pengajuan, '%d-%b-%Y') tgl_pengajuan, 
    a.status, a.no_induk, b.hak_akses, b.nama, c.periode, a.keterangan
    FROM tb_pengadaan a, tb_user b, tb_periode c
    where a.no_induk=b.no_induk
    and a.id_periode=c.id_periode")->result();;
    echo json_encode($data);
  }

  public function getDataBarang(){
    $this->db->select('id_barang, nama_barang, stock_tersedia, foto, harga_beli');
    $this->db->from('tb_barang'); 
    $this->db->where('id_laborat', $this->input->post('id_laborat'));
    $this->db->order_by('nama_barang','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

}