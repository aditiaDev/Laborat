<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/data_monitoring');
    $this->load->view('template/footer');
  }

  public function addData(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/monitoring');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    if($this->session->userdata('hak_akses') == "siswa" or $this->session->userdata('hak_akses') == "guru"){
      $akses = " And a.no_induk='".$this->session->userdata('no_induk')."'";
    }

    $data['data'] = $this->db->query("SELECT a.id_monitoring, c.periode, 
    DATE_FORMAT(a.tgl_monitoring, '%d-%b-%Y') tgl_monitoring, 
    b.no_induk, b.nama, b.hak_akses, 
    a.keterangan, a.status 
    FROM tb_monitoring a, tb_user b, tb_periode c
    where a.no_induk=b.no_induk
    and a.id_periode=c.id_periode
    ".@$akses)->result();;
    echo json_encode($data);
  }

  public function getDataBarang(){
    $this->db->select('id_barang, nama_barang, stock, foto');
    $this->db->from('tb_barang'); 
    $this->db->where('id_laborat', $this->input->post('id_laborat'));
    $this->db->order_by('nama_barang','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

  public function getDataHdr(){
    $id_monitoring = $this->input->post('id_monitoring');
    $data = $this->db->query("SELECT a.id_monitoring, DATE_FORMAT(tgl_monitoring, '%d-%b-%Y') tgl_monitoring, 
    a.keterangan,a.status, a.no_induk, b.nama
    FROM tb_monitoring a, tb_user b
    where a.no_induk=b.no_induk
    and a.id_monitoring='".$id_monitoring."'")->result_array();

    $datalab = $this->db->query("SELECT * from tb_laborat where id_laborat = (
      SELECT z.id_laborat FROM tb_dtl_monitoring y, tb_barang z WHERE 
      y.id_barang=z.id_barang
      and y.id_monitoring='".$id_monitoring."' limit 1
      )"
    )->result_array();

    $data[0]['id_laborat']=$datalab[0]['id_laborat'];
    $data[0]['nm_laborat']=$datalab[0]['deskripsi'];

    echo json_encode($data);
  }

  public function getDataItems(){
    $id_monitoring = $this->input->post('id_monitoring');
    $data = $this->db->query("SELECT a.id_barang, b.nama_barang, a.stock_sistem, a.stock_actual, a.qty_bagus, a.qty_rusak
    FROM tb_dtl_monitoring a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_monitoring='".$id_monitoring."'")->result_array();

    echo json_encode($data);
  }

  public function dtlData($id){

    $data['id'] = $id;
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/monitoring', $data);
    $this->load->view('template/footer');
  }

  public function saveData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tgl_monitoring', 'Tanggal Monitoring', 'required');
    $this->form_validation->set_rules('no_induk', 'Nomor Induk User', 'required');

    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
    $this->form_validation->set_rules('stock_actual[]', 'Stok Aktual', 'required');
    $this->form_validation->set_rules('qty_bagus[]', 'Jml yang Bagus', 'required');
    $this->form_validation->set_rules('qty_rusak[]', 'Jml yang jelek', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $unik = 'MN'.date('Ym', strtotime($this->input->post('tgl_monitoring')));
    $kode = $this->db->query("select MAX(id_monitoring) LAST_NO from tb_monitoring WHERE id_monitoring LIKE '".$unik."%'")->row()->LAST_NO;
    
    $urutan = (int) substr($kode, -4);
    $urutan++;
    $kode = $unik . sprintf("%04s", $urutan);
    
    $id_periode = $this->db->query("SELECT max(id_periode) id_periode FROM tb_periode where status='Aktif'")->row()->id_periode;
    
    $dataHeader = array(
              "id_monitoring" => $kode,
              "tgl_monitoring" => date("Y-m-d", strtotime($this->input->post('tgl_monitoring'))).' '.date("H:i:s"),
              "keterangan" => $this->input->post('keterangan'),
              "status" => "Proses",
              "no_induk" => $this->session->userdata('no_induk'),
              "id_periode" => $id_periode,
            );
    $this->db->insert('tb_monitoring', $dataHeader);


    foreach($this->input->post('id_barang') as $key => $each){
      $dataDtl[] = array(
        "id_monitoring" => $kode,
        "id_barang" => $this->input->post('id_barang')[$key],
        "stock_sistem" => $this->input->post('stock_sistem')[$key],
        "stock_actual" => $this->input->post('stock_actual')[$key],
        "qty_bagus" => $this->input->post('qty_bagus')[$key],
        "qty_rusak" => $this->input->post('qty_rusak')[$key],
      );
    }

    $this->db->insert_batch('tb_dtl_monitoring', $dataDtl);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan", "DOC_NO" => $kode);
    echo json_encode($output);

  }

  public function monitoringRpt(){
    $id_monitoring = $this->input->post('idmonitoring');

    $data['hdr'] = $this->db->query("SELECT a.id_monitoring, 
    DATE_FORMAT(a.tgl_monitoring, '%d-%b-%Y') tgl_monitoring, b.no_induk, b.nama, 
    REPLACE(a.keterangan,chr(13),'<br>') keterangan, a.status, b.hak_akses 
    FROM tb_monitoring a, tb_user b
    where a.no_induk=b.no_induk    
    and a.id_monitoring='".$id_monitoring."'")->result_array();

    $data['items'] = $this->db->query("SELECT a.id_barang, b.nama_barang, a.stock_sistem, a.stock_actual, a.qty_bagus, a.qty_rusak 
    FROM tb_dtl_monitoring a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_monitoring='".$id_monitoring."'")->result_array();

    $mpdf = new \Mpdf\Mpdf(['format' => 'A4-P', 'margin_left' => '5', 'margin_right' => '5']);
    $mpdf->setFooter('{PAGENO}');
    $html = $this->load->view('report/monitoringRpt',$data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }

  public function approve(){
    $id_monitoring = $this->input->post('id_monitoring');
    $this->db->set('status', 'Approved');
    $this->db->where('id_monitoring', $id_monitoring);
    $this->db->update('tb_monitoring');

    $this->db->set('status', 'Approved');
    $this->db->where('id_monitoring', $id_monitoring);
    $this->db->update('tb_dtl_monitoring');

    

    foreach($this->input->post('id_barang') as $key => $each){
      $id_barang = $this->input->post('id_barang')[$key];
      $this->db->query("UPDATE tb_barang SET stock=".$this->input->post('stock_actual')[$key]." WHERE id_barang='".$id_barang."'");
    }

    $output = array("status" => "success", "message" => "Document berhasil di Approve", "DOC_NO" => $id_monitoring);
    echo json_encode($output);

  }

  public function notApprove(){

    $id_monitoring = $this->input->post('id_monitoring');
    $this->db->set('status', 'Not Approved');
    $this->db->where('id_monitoring', $id_monitoring);
    $this->db->update('tb_monitoring');

    $this->db->set('status', 'Not Approved');
    $this->db->where('id_monitoring', $id_monitoring);
    $this->db->update('tb_dtl_monitoring');

    $output = array("status" => "success", "message" => "Document tidak terapprove", "DOC_NO" => $id_monitoring);
    echo json_encode($output);
  }

}