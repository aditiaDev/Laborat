<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent::__construct();
    
  }

  public function index(){
    if($this->session->userdata('no_induk'))
      redirect('home', 'refresh');

    $this->load->view('login');
  }

  public function login(){
    $this->db->where('username', $this->input->post('username'));  
    $this->db->where('password', $this->input->post('password'));  
    $query = $this->db->get('tb_user');   
    if($query->num_rows() > 0){  
      foreach ($query->result() as $row)
      {   
        $arrdata = array(
          'no_induk'=>$row->no_induk,
          'hak_akses'=>$row->hak_akses,
          'username'=>$row->username,
          'nama'=>$row->nama,
        );  
          $this->session->set_userdata($arrdata);
      }

      $output = array("status" => "success", "message" => "Login Berhasil");
    }else{  
      $output = array("status" => "error", "message" => "Login Gagal");  
    }

    echo json_encode($output);
  }

  function logout(){
    $this->session->unset_userdata('no_induk');
    $this->session->sess_destroy();
    redirect('/', 'refresh');
  }

  public function register(){
    $this->load->view('register');
  }


  public function signUp(){
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
              "status" => "Aktif",
            );
    $this->db->insert('tb_user', $data);

    $data = array(
          "no_induk" => $this->input->post('no_induk'),
          "tgl_daftar" => date("Y-m-d"),
        );
    $this->db->insert('tb_pendaftaran', $data);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

}