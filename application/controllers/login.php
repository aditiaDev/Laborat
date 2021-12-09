<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent::__construct();
    
  }

  public function index(){
    if($this->session->userdata('id_user'))
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
          'id_user'=>$row->id_user,
          'level'=>$row->level,
          'username'=>$row->username,
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
    $this->session->unset_userdata('id_user');
    $this->session->sess_destroy();
    redirect('/', 'refresh');
  }

  public function register($id=null){
    if(!$id) redirect('/');
    $this->db->select('id_lowongan_kerja, nm_lowongan_kerja');
    $this->db->from('tb_lowongan_kerja');
    $this->db->where('id_lowongan_kerja', $id);
    $data['data'] = $this->db->get()->row();
    // print_r($data);
    $this->load->view('register', $data);
  }

  public function signUp(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_lowongan_kerja', 'Lowongan Kerja', 'required');
    $this->form_validation->set_rules('nm_pelamar', 'Nama Pelamar', 'required');
    $this->form_validation->set_rules('alamat_pelamar', 'Alamat', 'required');
    $this->form_validation->set_rules('no_tlp', 'No Telphone', 'required');
    $this->form_validation->set_rules('lulusan', 'Pendidikan', 'required');
    $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
    $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
    $this->form_validation->set_rules('kemampuan', 'Kemampuan', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $dataUser = array(
              "username" => $this->input->post('username'),
              "password" => $this->input->post('password'),
              "level" => "calon_pelamar",
            );
    $this->db->insert('tb_user', $dataUser);

    $id_user = $this->db->query("SELECT id_user FROM tb_user 
                                WHERE username='".$this->input->post('username')."' 
                                AND `password`='".$this->input->post('password')."' 
                                LIMIT 1")->row()->id_user;

    
    $data = array(
              "id_lowongan_kerja" => $this->input->post('id_lowongan_kerja'),
              "nm_pelamar" => $this->input->post('nm_pelamar'),
              "jenis_kelamin" => $this->input->post('jenis_kelamin'),
              "alamat_pelamar" => $this->input->post('alamat_pelamar'),
              "no_tlp" => $this->input->post('no_tlp'),
              "lulusan" => $this->input->post('lulusan'),
              "jurusan" => $this->input->post('jurusan'),
              "kemampuan" => $this->input->post('kemampuan'),
              "id_user" => $id_user,
            );
    $this->db->insert('tb_pelamar', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

}