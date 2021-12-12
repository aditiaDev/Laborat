<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/user');
    $this->load->view('template/footer');
  }

  public function getAllData(){
  	$this->db->where('hak_akses', $this->input->post('jenis'));
    $this->db->from('tb_user');
    $this->db->order_by('nama', 'asc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

  

  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('no_induk', 'NIK/NIS', 'required|numeric|is_unique[tb_user.no_induk]');
    $this->form_validation->set_rules('nama', 'nama', 'required');
    $this->form_validation->set_rules('alamat', 'alamat', 'required');
    $this->form_validation->set_rules('no_telp', 'no_telp', 'required|numeric');
    $this->form_validation->set_rules('no_wa', 'no_wa', 'required|numeric');
    $this->form_validation->set_rules('jekel', 'jekel', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
    $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
    $this->form_validation->set_rules('hak_akses', 'hak_akses', 'required');
    $this->form_validation->set_rules('status', 'status', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "no_induk" => $this->input->post('no_induk'),
              "nama" => $this->input->post('nama'),
              "alamat" => $this->input->post('alamat'),
              "no_telp" => $this->input->post('no_telp'),
              "no_wa" => $this->input->post('no_wa'),
              "jekel" => $this->input->post('jekel'),
              "username" => $this->input->post('username'),
              "password" => $this->input->post('password'),
              "hak_akses" => $this->input->post('hak_akses'),
              "status" => $this->input->post('status'),
            );
    $this->db->insert('tb_user', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('no_induk', 'NIK/NIS', 'required|numeric');
    $this->form_validation->set_rules('nama', 'nama', 'required');
    $this->form_validation->set_rules('alamat', 'alamat', 'required');
    $this->form_validation->set_rules('no_telp', 'no_telp', 'required|numeric');
    $this->form_validation->set_rules('no_wa', 'no_wa', 'required|numeric');
    $this->form_validation->set_rules('jekel', 'jekel', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
    $this->form_validation->set_rules('hak_akses', 'hak_akses', 'required');
    $this->form_validation->set_rules('status', 'status', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
        "nama" => $this->input->post('nama'),
        "alamat" => $this->input->post('alamat'),
        "no_telp" => $this->input->post('no_telp'),
        "no_wa" => $this->input->post('no_wa'),
        "jekel" => $this->input->post('jekel'),
        "username" => $this->input->post('username'),
        "password" => $this->input->post('password'),
        "hak_akses" => $this->input->post('hak_akses'),
        "status" => $this->input->post('status'),
    );
    $this->db->where('no_induk', $this->input->post('no_induk'));
    $this->db->update('tb_user', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('no_induk', $this->input->post('no_induk'));
    $this->db->delete('tb_user');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}