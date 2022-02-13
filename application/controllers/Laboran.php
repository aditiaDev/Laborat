<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboran extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){
    $this->db->order_by("nama", "asc");
    $this->db->where("hak_akses", "laboran");
    $data['user'] = $this->db->get('tb_user')->result();

    $this->db->order_by("deskripsi", "asc");
    $data['laborat'] = $this->db->get('tb_laborat')->result();

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/laboran', $data);
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT A.id ,A.no_induk, B.nama, A.id_laborat, C.deskripsi FROM tb_laboran A, tb_user B, tb_laborat C
    WHERE A.no_induk=B.no_induk
    AND A.id_laborat=C.id_laborat 
    AND B.status='Aktif'")->result();
    echo json_encode($data);
  }

  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('no_induk', 'NIK', 'required');
    $this->form_validation->set_rules('id_laborat', 'id_laborat', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "no_induk" => $this->input->post('no_induk'),
              "id_laborat" => $this->input->post('id_laborat'),
            );
    $this->db->insert('tb_laboran', $data);

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('no_induk', 'NIK', 'required');
    $this->form_validation->set_rules('id_laborat', 'id_laborat', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
              "no_induk" => $this->input->post('no_induk'),
              "id_laborat" => $this->input->post('id_laborat'),
            );
    $this->db->where('id', $this->input->post('id'));
    $this->db->update('tb_laboran', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id', $this->input->post('id'));
    $this->db->delete('tb_laboran');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}

?>