<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laborat extends CI_Controller {

  public function __construct(){
    parent::__construct();
    // if(!$this->session->userdata('no_induk'))
    //   redirect('login', 'refresh');

  }

  public function index(){
    // $data['model'] = $this->UserModel->getData();

    // $this->load->view('home', $data);
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/laborat');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $this->db->from('tb_laborat');
    $this->db->order_by('id_laborat', 'asc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

  

  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_laborat', 'Kode Laborat', 'required|is_unique[tb_laborat.id_laborat]');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "id_laborat" => $this->input->post('id_laborat'),
              "deskripsi" => $this->input->post('deskripsi'),
            );
    $this->db->insert('tb_laborat', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_laborat', 'Kode Laborat', 'required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
        "deskripsi" => $this->input->post('deskripsi'),
    );
    $this->db->where('id_laborat', $this->input->post('id_laborat'));
    $this->db->update('tb_laborat', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_laborat', $this->input->post('id_laborat'));
    $this->db->delete('tb_laborat');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}