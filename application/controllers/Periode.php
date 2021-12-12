<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/periode');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $this->db->from('tb_periode');
    $this->db->order_by('id_periode', 'desc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

  

  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('periode', 'Periode', 'required|is_unique[tb_periode.periode]');
    $this->form_validation->set_rules('status', 'status', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "periode" => $this->input->post('periode'),
              "status" => $this->input->post('status'),
            );
    $this->db->insert('tb_periode', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_periode', 'id_periode', 'required');
    $this->form_validation->set_rules('periode', 'Periode', 'required');
    $this->form_validation->set_rules('status', 'status', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
            "periode" => $this->input->post('periode'),
            "status" => $this->input->post('status'),
    );
    $this->db->where('id_periode', $this->input->post('id_periode'));
    $this->db->update('tb_periode', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_periode', $this->input->post('id_periode'));
    $this->db->delete('tb_periode');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}