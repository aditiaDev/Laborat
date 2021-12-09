<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

  public function __construct(){
    parent::__construct();

    if(!$this->session->userdata('id_user'))
      redirect('login', 'refresh');
  }

  public function index(){
    // $data['model'] = $this->UserModel->getData();

    // $this->load->view('home', $data);
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('template/kriteria');
    $this->load->view('template/footer');
  }

  public function getAllData(){
  	
    $this->db->from('tb_kriteria');
    $this->db->order_by('id_kriteria', 'asc');
    $data['data'] = $this->db->get()->result();

  	echo json_encode($data);
  }

  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kriteria', 'ID kriteria', 'required|is_unique[tb_kriteria.id_kriteria]');
    $this->form_validation->set_rules('nm_kriteria', 'Kriteria', 'required');
    $this->form_validation->set_rules('jenis_kiteria', 'Jenis kiteria', 'required');
    $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "id_kriteria" => $this->input->post('id_kriteria'),
              "nm_kriteria" => $this->input->post('nm_kriteria'),
              "jenis_kiteria" => $this->input->post('jenis_kiteria'),
              "bobot" => $this->input->post('bobot'),
            );
    $this->db->insert('tb_kriteria', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_kriteria', 'Kriteria', 'required');
    $this->form_validation->set_rules('jenis_kiteria', 'Jenis kiteria', 'required');
    $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "nm_kriteria" => $this->input->post('nm_kriteria'),
              "jenis_kiteria" => $this->input->post('jenis_kiteria'),
              "bobot" => $this->input->post('bobot'),
            );
    $this->db->where('id_kriteria', $this->input->post('id_kriteria'));
    $this->db->update('tb_kriteria', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){
    $this->db->where('id_kriteria', $this->input->post('id_kriteria'));
    $this->db->delete('tb_kriteria');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}