<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){
    // $data['model'] = $this->barangModel->getData();

    // $this->load->view('home', $data);
    $this->db->order_by("deskripsi", "asc");
    $data['kategori'] = $this->db->get('tb_kategori')->result();

    // $this->db->order_by("deskripsi", "asc");
    $data['laborat'] = $this->db->query("SELECT a.id,A.no_induk, B.nama, A.id_laborat, C.deskripsi FROM tb_laboran A, tb_user B, tb_laborat C
    WHERE A.no_induk=B.no_induk
    AND A.id_laborat=C.id_laborat
    AND A.no_induk='".$this->session->userdata('no_induk')."'")->result();

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/barang', $data);
    $this->load->view('template/footer');
  }

  public function getAllData(){
  	$this->db->like('id_kategori', $this->input->post('id_kategori'));
    $this->db->like('id_laborat', $this->input->post('id_laborat'));
    $this->db->from('tb_barang');
    $this->db->order_by('id_barang', 'asc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

  public function getAllDataByUser(){
    $data['data'] = $this->db->query("SELECT A.* FROM tb_barang A, tb_laboran B
    WHERE A.id_laborat=B.id_laborat
    AND A.id_kategori LIKE '%".$this->input->post('id_kategori')."%'
    AND A.id_laborat LIKE '%".$this->input->post('id_laborat')."%'
    AND B.no_induk='".$this->session->userdata('no_induk')."'")->result();
    echo json_encode($data);
  }

  public function generate_kode(){
    $id_kategori = $this->input->post('id_kategori');
    $id_laborat = $this->input->post('id_laborat');
    $unik = $id_laborat.$id_kategori;
    $kode = $this->db->query("select MAX(id_barang) LAST_NO from tb_barang WHERE id_barang LIKE '".$unik."%'")->row()->LAST_NO;
    
    $urutan = (int) substr($kode,-4);
    $urutan++;
    $kode = $unik . sprintf("%04s", $urutan);
    echo $kode;
  }

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/barang/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png';
    $config['max_size']             = 5000; //set max size allowed in Kilobyte
    $config['max_width']            = 4000; // set max width image allowed
    $config['max_height']           = 4000; // set max height allowed
    $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('foto')) //upload and validate
    {
      $data['inputerror'] = 'foto';
			$data['message'] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

  public function saveData(){
    
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_barang', 'Kode Barang', 'required|is_unique[tb_barang.id_barang]');
    $this->form_validation->set_rules('nama_barang', 'Deskripsi', 'required|is_unique[tb_barang.nama_barang]');
    $this->form_validation->set_rules('stock', 'stock', 'required|numeric');
    $this->form_validation->set_rules('stock_tersedia', 'Stock Tersedia', 'required|numeric');
    $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');

    $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
    $this->form_validation->set_rules('id_laborat', 'Laborat', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "id_barang" => $this->input->post('id_barang'),
              "nama_barang" => $this->input->post('nama_barang'),
              "stock" => $this->input->post('stock'),
              "stock_tersedia" => $this->input->post('stock_tersedia'),
              "harga_beli" => $this->input->post('harga_beli'),
              "min_stock" => $this->input->post('min_stock'),
              "id_kategori" => $this->input->post('id_kategori'),
              "id_laborat" => $this->input->post('id_laborat'),
            );

    if(!empty($_FILES['foto']['name'])){
      $upload = $this->_do_upload();
      $data['foto'] = $upload;
    }

    $this->db->insert('tb_barang', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData($id_barang){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_barang', 'Kode Barang', 'required');
    $this->form_validation->set_rules('nama_barang', 'Deskripsi', 'required');
    $this->form_validation->set_rules('stock', 'stock', 'required|numeric');
    $this->form_validation->set_rules('stock_tersedia', 'Stock Tersedia', 'required|numeric');
    $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');

    $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
    $this->form_validation->set_rules('id_laborat', 'Laborat', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "nama_barang" => $this->input->post('nama_barang'),
      "stock" => $this->input->post('stock'),
      "stock_tersedia" => $this->input->post('stock_tersedia'),
      "harga_beli" => $this->input->post('harga_beli'),
      "min_stock" => $this->input->post('min_stock'),
      "id_kategori" => $this->input->post('id_kategori'),
      "id_laborat" => $this->input->post('id_laborat'),
    );

    if(!empty($_FILES['foto']['name'])){
      $upload = $this->_do_upload();
      $data['foto'] = $upload;
    }

    $this->db->where('id_barang', $id_barang);
    $this->db->update('tb_barang', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_barang', $this->input->post('id_barang'));
    $this->db->delete('tb_barang');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}