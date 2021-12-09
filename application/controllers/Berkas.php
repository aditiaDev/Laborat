<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller {

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
    if($this->session->userdata('level') == "calon_pelamar" )
      $this->load->view('pelamar/berkas');
    else
      $this->load->view('template/berkas');
    $this->load->view('template/footer');
  }

  public function getAllData(){
  	$this->db->select("a.*, b.nm_pelamar, CONCAT(b.lulusan, ' - ', b.jurusan) pendidikan, c.nm_lowongan_kerja");
    $this->db->from('tb_berkas a'); 
    $this->db->join('tb_pelamar b', 'a.id_pelamar=b.id_pelamar', 'left');
    $this->db->join('tb_lowongan_kerja c', 'b.id_lowongan_kerja=c.id_lowongan_kerja', 'left');
    $this->db->order_by('a.id_berkas','desc');         
    $data['data'] = $this->db->get()->result();

  	echo json_encode($data);
  }

  public function getAllDataUser(){
  	$this->db->select("a.*, b.nm_pelamar, CONCAT(b.lulusan, ' - ', b.jurusan) pendidikan, c.nm_lowongan_kerja");
    $this->db->from('tb_berkas a'); 
    $this->db->join('tb_pelamar b', 'a.id_pelamar=b.id_pelamar', 'left');
    $this->db->join('tb_lowongan_kerja c', 'b.id_lowongan_kerja=c.id_lowongan_kerja', 'left');
    $this->db->where('b.id_user', $this->session->userdata('id_user'));
    $this->db->order_by('a.id_berkas','desc');         
    $data['data'] = $this->db->get()->result();

  	echo json_encode($data);
  }

  public function getPelamarBerkas(){
    $this->db->from('tb_pelamar');
    $this->db->order_by('nm_pelamar', 'asc');
    $data = $this->db->get()->result();
    echo json_encode($data);
  }
  
  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_pelamar', 'Pelamar', 'required');
    $this->form_validation->set_rules('nm_berkas', 'Nama Berkas', 'required');
    
    if (empty($_FILES['file_berkas']['name'])){
      $this->form_validation->set_rules('file_berkas', 'File Berkas', 'required');
    }

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "id_pelamar" => $this->input->post('id_pelamar'),
      "nm_berkas" => $this->input->post('nm_berkas'),
    );

    if(!empty($_FILES['file_berkas']['name']))
		{
			$upload = $this->_do_upload();
			$data['file_berkas'] = $upload;
		}
    
    
    $this->db->insert('tb_berkas', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function saveDataPelamar(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_berkas', 'Nama Berkas', 'required');
    
    if (empty($_FILES['file_berkas']['name'])){
      $this->form_validation->set_rules('file_berkas', 'File Berkas', 'required');
    }

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id_pelamar = $this->db->query("SELECT id_pelamar FROM tb_pelamar WHERE id_user='".$this->session->userdata('id_user')."'
                            LIMIT 1")->row()->id_pelamar;

    $data = array(
      "id_pelamar" => $id_pelamar,
      "nm_berkas" => $this->input->post('nm_berkas'),
    );

    if(!empty($_FILES['file_berkas']['name']))
		{
			$upload = $this->_do_upload();
			$data['file_berkas'] = $upload;
		}
    
    
    $this->db->insert('tb_berkas', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/berkas/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
    $config['max_size']             = 5000; //set max size allowed in Kilobyte
    $config['max_width']            = 4000; // set max width image allowed
    $config['max_height']           = 4000; // set max height allowed
    $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('file_berkas')) //upload and validate
    {
      $data['inputerror'][] = 'file_berkas';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

  public function deleteData(){

    $this->db->select('file_berkas');
    $this->db->from('tb_berkas');
		$this->db->where('id_berkas', $this->input->post('id_berkas'));
		$files = $this->db->get()->row();

		// print_r($files->file_berkas);
		if(file_exists('assets/images/berkas/'.$files->file_berkas) && $files->file_berkas)
			unlink('assets/images/berkas/'.$files->file_berkas);

    $this->db->where('id_berkas', $this->input->post('id_berkas'));
    $this->db->delete('tb_berkas');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}