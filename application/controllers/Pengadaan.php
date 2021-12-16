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
    
    if($this->input->post('param') == "min_stock"){
      $data['data'] = $this->db->query("SELECT id_barang, nama_barang, min_stock, stock, foto, harga_beli
                      FROM tb_barang WHERE id_laborat='".$this->input->post('id_laborat')."' AND stock<min_stock
                      ")->result(); 
    }else{
      $data['data'] = $this->db->query("SELECT id_barang, nama_barang, min_stock, stock, foto, harga_beli
                      FROM tb_barang WHERE id_laborat='".$this->input->post('id_laborat')."'
                      ")->result(); 
    }
    

  	echo json_encode($data);
  }

  public function saveData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tgl_pengajuan', 'Tanggal Pengajuan', 'required');
    $this->form_validation->set_rules('no_induk', 'Nomor Induk User', 'required');

    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
    $this->form_validation->set_rules('qty_pengajuan[]', 'Qty Pengajuan', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $unik = 'PG'.date('Ym', strtotime($this->input->post('tgl_pengajuan')));
    $kode = $this->db->query("select MAX(id_pengadaan) LAST_NO from tb_pengadaan WHERE id_pengadaan LIKE '".$unik."%'")->row()->LAST_NO;
    
    $urutan = (int) substr($kode, -4);
    $urutan++;
    $kode = $unik . sprintf("%04s", $urutan);
    
    $id_periode = $this->db->query("SELECT max(id_periode) id_periode FROM tb_periode where status='Aktif'")->row()->id_periode;
    
    $dataHeader = array(
              "id_pengadaan" => $kode,
              "tgl_pengajuan" => date("Y-m-d", strtotime($this->input->post('tgl_pengajuan'))),
              "keterangan" => $this->input->post('keterangan'),
              "status" => "Proses",
              "no_induk" => $this->session->userdata('no_induk'),
              "id_periode" => $id_periode,
            );
    $this->db->insert('tb_pengadaan', $dataHeader);


    foreach($this->input->post('id_barang') as $key => $each){
      $total_belanja = $this->input->post('qty_pengajuan')[$key] * $this->input->post('harga')[$key];
      $dataDtl[] = array(
        "id_pengadaan" => $kode,
        "id_barang" => $this->input->post('id_barang')[$key],
        "qty_pengajuan" => $this->input->post('qty_pengajuan')[$key],
        "qty_approved" => $this->input->post('qty_pengajuan')[$key],
        "harga" => $this->input->post('harga')[$key],
        "total_belanja" => $total_belanja,
      );
    }

    $this->db->insert_batch('tb_dtl_pengadaan', $dataDtl);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan", "DOC_NO" => $kode);
    echo json_encode($output);

  }

  public function dtlData($id){

    $data['id'] = $id;
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/pengadaan', $data);
    $this->load->view('template/footer');
  }

  public function getDataHdr(){
    $id_pengadaan = $this->input->post('id_pengadaan');
    $data = $this->db->query("SELECT a.id_pengadaan, 
    DATE_FORMAT(a.tgl_pengajuan, '%d-%b-%Y') tgl_pengajuan, b.no_induk, b.nama, 
    a.keterangan, a.status, b.hak_akses 
    FROM tb_pengadaan a, tb_user b
    where a.no_induk=b.no_induk    
    and a.id_pengadaan='".$id_pengadaan."'")->result_array();

    $datalab = $this->db->query("SELECT * from tb_laborat where id_laborat = (
      SELECT z.id_laborat FROM tb_dtl_pengadaan y, tb_barang z WHERE 
      y.id_barang=z.id_barang
      and y.id_pengadaan='".$id_pengadaan."' limit 1
      )"
    )->result_array();

    if (!empty($datalab)){
      $data[0]['id_laborat']=$datalab[0]['id_laborat'];
      $data[0]['nm_laborat']=$datalab[0]['deskripsi'];
    }
    echo json_encode($data);
  }

  public function getDataItems(){
    $id_pengadaan = $this->input->post('id_pengadaan');
    $data = $this->db->query("SELECT a.id_barang, b.nama_barang, a.qty_pengajuan, a.qty_approved, a.harga
    FROM tb_dtl_pengadaan a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_pengadaan='".$id_pengadaan."'")->result_array();

    echo json_encode($data);
  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_pengadaan', 'No Aduan', 'required');
    $this->form_validation->set_rules('tgl_pengajuan', 'Tanggal Pengajuan', 'required');
    $this->form_validation->set_rules('no_induk', 'Nomor Induk User', 'required');

    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
    $this->form_validation->set_rules('qty_approved[]', 'Qty Approve', 'required');
    $this->form_validation->set_rules('harga[]', 'Harga', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    foreach($this->input->post('id_barang') as $key => $each){
      $total_belanja = $this->input->post('qty_approved')[$key] * $this->input->post('harga')[$key];
      $dataDtl = array(
        "qty_approved" => $this->input->post('qty_approved')[$key],
        "harga" => $this->input->post('harga')[$key],
        "total_belanja" => $total_belanja
      );

      $this->db->where('id_pengadaan', $this->input->post('id_pengadaan'));
      $this->db->where('id_barang', $this->input->post('id_barang')[$key]);
      $this->db->update('tb_dtl_pengadaan', $dataDtl);
    }

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update", "DOC_NO" => $this->input->post('id_pengadaan'));
    echo json_encode($output);

  }

  public function approve(){
    $id_pengadaan = $this->input->post('id_pengadaan');
    $hak_akses = $this->session->userdata('hak_akses');
    if($hak_akses == "sarpras"){
      $status = "Approved sarpras";
    }elseif($hak_akses == "kepsek"){
      $status = "Approved kepsek";
    }
    $this->db->set('status', $status);
    $this->db->where('id_pengadaan', $id_pengadaan);
    $this->db->update('tb_pengadaan');

    $output = array("status" => "success", "message" => "Document berhasil di Approve", "DOC_NO" => $id_pengadaan);
    echo json_encode($output);
  }

  public function notApprove(){
    $id_pengadaan = $this->input->post('id_pengadaan');
    $hak_akses = $this->session->userdata('hak_akses');
    if($hak_akses == "sarpras"){
      $status = "Not Approved sarpras";
    }elseif($hak_akses == "kepsek"){
      $status = "Not Approved kepsek";
    }
    $this->db->set('status', $status);
    $this->db->where('id_pengadaan', $id_pengadaan);
    $this->db->update('tb_pengadaan');

    $output = array("status" => "success", "message" => "Document tidak terapprove", "DOC_NO" => $id_pengadaan);
    echo json_encode($output);
  }

}