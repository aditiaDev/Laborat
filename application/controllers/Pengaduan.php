<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/data_pengaduan');
    $this->load->view('template/footer');
  }

  public function addData(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/pengaduan');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    if($this->session->userdata('hak_akses') == "siswa" or $this->session->userdata('hak_akses') == "guru"){
      $akses = " And a.no_induk='".$this->session->userdata('no_induk')."'";
    }

    $data['data'] = $this->db->query("SELECT a.id_pengaduan, c.periode, 
    DATE_FORMAT(a.tgl_pengaduan, '%d-%b-%Y') tgl_pengaduan, 
    b.no_induk, b.nama, b.hak_akses, 
    a.keterangan, a.status 
    FROM tb_pengaduan a, tb_user b, tb_periode c
    where a.no_induk=b.no_induk
    and a.id_periode=c.id_periode
    ".@$akses)->result();;
    echo json_encode($data);
  }

  public function saveData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tgl_pengaduan', 'Tanggal Pengaduan', 'required');
    $this->form_validation->set_rules('no_induk', 'Nomor Induk User', 'required');

    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
    $this->form_validation->set_rules('qty_rusak[]', 'Jml yang Rusak', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $unik = 'AD'.date('Ym', strtotime($this->input->post('tgl_pengaduan')));
    $kode = $this->db->query("select MAX(id_pengaduan) LAST_NO from tb_pengaduan WHERE id_pengaduan LIKE '".$unik."%'")->row()->LAST_NO;
    
    $urutan = (int) substr($kode, -4);
    $urutan++;
    $kode = $unik . sprintf("%04s", $urutan);
    
    $id_periode = $this->db->query("SELECT max(id_periode) id_periode FROM tb_periode where status='Aktif'")->row()->id_periode;
    
    $dataHeader = array(
              "id_pengaduan" => $kode,
              "tgl_pengaduan" => date("Y-m-d", strtotime($this->input->post('tgl_pengaduan'))),
              "keterangan" => $this->input->post('keterangan'),
              "status" => "Proses",
              "no_induk" => $this->session->userdata('no_induk'),
              "id_periode" => $id_periode,
            );
    $this->db->insert('tb_pengaduan', $dataHeader);


    foreach($this->input->post('id_barang') as $key => $each){
      $dataDtl[] = array(
        "id_pengaduan" => $kode,
        "id_barang" => $this->input->post('id_barang')[$key],
        "qty_rusak" => $this->input->post('qty_rusak')[$key],
        "qty_rusak_approved" => $this->input->post('qty_rusak')[$key],
        "ket_rusak" => $this->input->post('ket_rusak')[$key],
      );
    }

    $this->db->insert_batch('tb_dtl_pengaduan', $dataDtl);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan", "DOC_NO" => $kode);
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_pengaduan', 'No Aduan', 'required');
    $this->form_validation->set_rules('tgl_pengaduan', 'Tanggal Pengaduan', 'required');
    $this->form_validation->set_rules('no_induk', 'Nomor Induk User', 'required');

    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
    $this->form_validation->set_rules('qty_rusak[]', 'Jml yang Rusak', 'required');
    $this->form_validation->set_rules('qty_rusak_approved[]', 'Jml yang Rusak', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    foreach($this->input->post('id_barang') as $key => $each){
      $dataDtl = array(
        "qty_rusak_approved" => $this->input->post('qty_rusak_approved')[$key],
        "status" => $this->input->post('status')[$key],
      );

      $this->db->where('id_pengaduan', $this->input->post('id_pengaduan'));
      $this->db->where('id_barang', $this->input->post('id_barang')[$key]);
      $this->db->update('tb_dtl_pengaduan', $dataDtl);
    }

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update", "DOC_NO" => $this->input->post('id_pengaduan'));
    echo json_encode($output);

  }

  public function dtlData($id){

    $data['id'] = $id;
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/pengaduan', $data);
    $this->load->view('template/footer');
  }

  public function getDataHdr(){
    $id_pengaduan = $this->input->post('id_pengaduan');
    $data = $this->db->query("SELECT a.id_pengaduan, 
    DATE_FORMAT(a.tgl_pengaduan, '%d-%b-%Y') tgl_pengaduan, b.no_induk, b.nama, 
    a.keterangan, a.status, b.hak_akses 
    FROM tb_pengaduan a, tb_user b
    where a.no_induk=b.no_induk    
    and a.id_pengaduan='".$id_pengaduan."'")->result_array();

    $datalab = $this->db->query("SELECT * from tb_laborat where id_laborat = (
      SELECT z.id_laborat FROM tb_dtl_pengaduan y, tb_barang z WHERE 
      y.id_barang=z.id_barang
      and y.id_pengaduan='".$id_pengaduan."' limit 1
      )"
    )->result_array();

    if (!empty($datalab)){
      $data[0]['id_laborat']=$datalab[0]['id_laborat'];
      $data[0]['nm_laborat']=$datalab[0]['deskripsi'];
    }
    echo json_encode($data);
  }

  public function getDataItems(){
    $id_pengaduan = $this->input->post('id_pengaduan');
    $data = $this->db->query("SELECT a.id_barang, b.nama_barang, a.qty_rusak, a.qty_rusak_approved, a.ket_rusak, a.status 
    FROM tb_dtl_pengaduan a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_pengaduan='".$id_pengaduan."'")->result_array();

    echo json_encode($data);
  }

  public function approve(){
    $id_pengaduan = $this->input->post('id_pengaduan');
    $id_laborat = $this->input->post('id_laborat');

    $this->db->set('status', 'Approved');
    $this->db->where('id_pengaduan', $id_pengaduan);
    $this->db->update('tb_pengaduan');

    foreach($this->input->post('id_barang') as $key => $each){
      $status = $this->input->post('status')[$key];
      $id_barang = $this->input->post('id_barang')[$key];
      $qty_rusak = $this->input->post('qty_rusak_approved')[$key];

      $dataDtl = array(
        "status" => $status,
      );

      $this->db->where('id_pengaduan', $id_pengaduan);
      $this->db->where('id_barang', $id_barang);
      $this->db->update('tb_dtl_pengaduan', $dataDtl);
      ////////////////////////////////////////////////////////////////////////////////

      $sql = $this->db->query("SELECT stock, harga_beli FROM tb_barang 
                WHERE id_barang='".$id_barang."' AND id_laborat='".$id_laborat."'")->result_array();
      $prev_qty = $sql[0]['stock'];
      $harga = $sql[0]['harga_beli'];
      $balance_qty = $prev_qty-$qty_rusak;

      if($status == "Buang"){
        $dataTran = array(
              "tanggal_entry" => date("Y-m-d").' '.date("H:i:s"),
              "id_transaksi" => $id_pengaduan,
              "id_laborat" => $id_laborat,
              "id_barang" => $id_barang,
              "prev_qty" =>$prev_qty,
              "tran_qty" => -$qty_rusak,
              "balance_qty" =>$balance_qty,
              "harga_satuan" => $harga,
        );
        $this->db->insert('tb_transaksi', $dataTran); 
        
        $this->db->set('stock', $balance_qty);
        $this->db->where('id_barang', $id_barang);
        $this->db->where('id_laborat', $id_laborat);
        $this->db->update('tb_barang');
      }
      

    }

    $output = array("status" => "success", "message" => "Document berhasil di Approve", "DOC_NO" => $id_pengaduan);
    echo json_encode($output);
  }

  public function notApprove(){
    $id_pengaduan = $this->input->post('id_pengaduan');
    $this->db->set('status', 'Not Approved');
    $this->db->where('id_pengaduan', $id_pengaduan);
    $this->db->update('tb_pengaduan');

    $output = array("status" => "success", "message" => "Document tidak terapprove", "DOC_NO" => $id_pengaduan);
    echo json_encode($output);
  }

  public function pengaduanRpt(){
    $id_pengaduan = $this->input->post('idpengaduan');

    $data['hdr'] = $this->db->query("SELECT a.id_pengaduan, 
    DATE_FORMAT(a.tgl_pengaduan, '%d-%b-%Y') tgl_pengaduan, b.no_induk, b.nama, 
    a.keterangan, a.status, b.hak_akses 
    FROM tb_pengaduan a, tb_user b
    where a.no_induk=b.no_induk    
    and a.id_pengaduan='".$id_pengaduan."'")->result_array();

    $data['items'] = $this->db->query("SELECT a.id_barang, b.nama_barang, a.qty_rusak, a.qty_rusak_approved, a.ket_rusak, a.status 
    FROM tb_dtl_pengaduan a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_pengaduan='".$id_pengaduan."'")->result_array();

    $mpdf = new \Mpdf\Mpdf(['format' => 'A4-P', 'margin_left' => '5', 'margin_right' => '5']);
    $mpdf->setFooter('{PAGENO}');
    $html = $this->load->view('report/pengaduanRpt',$data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }

}