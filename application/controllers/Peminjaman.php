<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function index(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/data_peminjaman');
    $this->load->view('template/footer');
  }

  public function addData(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/peminjaman');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    if($this->session->userdata('hak_akses') == "siswa" or $this->session->userdata('hak_akses') == "guru"){
      $akses = " And a.no_induk='".$this->session->userdata('no_induk')."'";
    }
    $data['data'] = $this->db->query("SELECT a.id_peminjaman, DATE_FORMAT(a.tgl_pengajuan, '%d-%b-%Y') tgl_pengajuan, 
    concat(DATE_FORMAT(a.pinjam_mulai, '%d-%b-%Y'), ' - ', DATE_FORMAT(a.pinjam_sampai, '%d-%b-%Y')) tgl_peminjaman , a.keterangan,
    a.status, a.no_induk, b.hak_akses, b.nama, b.no_wa, c.periode
    FROM tb_peminjaman a, tb_user b, tb_periode c
    where a.no_induk=b.no_induk
    and a.id_periode=c.id_periode
    and a.status <> 'Selesai'".@$akses)->result();;
    echo json_encode($data);
  }

  public function dtlData($id){

    $data['id'] = $id;
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/peminjaman', $data);
    $this->load->view('template/footer');
  }

  public function getDataHdr(){
    $id_peminjaman = $this->input->post('id_peminjaman');
    $data = $this->db->query("SELECT a.id_peminjaman, DATE_FORMAT(tgl_pengajuan, '%d-%b-%Y') tgl_pengajuan, 
    DATE_FORMAT(pinjam_mulai, '%d-%b-%Y') pinjam_mulai, 
    DATE_FORMAT(pinjam_sampai, '%d-%b-%Y') pinjam_sampai, a.keterangan,
    a.status, a.no_induk, b.nama
    FROM tb_peminjaman a, tb_user b
    where a.no_induk=b.no_induk
    and a.id_peminjaman='".$id_peminjaman."'")->result_array();

    $datalab = $this->db->query("SELECT * from tb_laborat where id_laborat = (
      SELECT z.id_laborat FROM tb_dtl_peminjaman y, tb_barang z WHERE 
      y.id_barang=z.id_barang
      and y.id_peminjaman='".$id_peminjaman."' limit 1
      )"
    )->result_array();

    $data[0]['id_laborat']=$datalab[0]['id_laborat'];
    $data[0]['nm_laborat']=$datalab[0]['deskripsi'];

    echo json_encode($data);
  }

  public function getDataItems(){
    $id_peminjaman = $this->input->post('id_peminjaman');
    $data = $this->db->query("SELECT a.id_barang, b.nama_barang, a.qty_pinjam, a.qty_approved, b.stock_tersedia 
    FROM tb_dtl_peminjaman a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_peminjaman='".$id_peminjaman."'")->result_array();

    echo json_encode($data);
  }

  public function getDataBarang(){
    $this->db->select('id_barang, nama_barang, stock_tersedia, foto');
    $this->db->from('tb_barang'); 
    $this->db->where('id_laborat', $this->input->post('id_laborat'));
    $this->db->order_by('nama_barang','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

  public function getDataLab(){
    $this->db->from('tb_laborat');
    $this->db->order_by('id_laborat', 'asc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

  public function saveData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tgl_pengajuan', 'Tanggal Pengajuan', 'required');
    $this->form_validation->set_rules('no_induk', 'Nomor Induk User', 'required');
    $this->form_validation->set_rules('pinjam_mulai', 'Pinjam Mulai', 'required');
    $this->form_validation->set_rules('pinjam_sampai', 'Pinjam Sampai', 'required');

    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
    $this->form_validation->set_rules('qty_pinjam[]', 'Jml Pinjam', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $unik = 'PJ'.date('Ym', strtotime($this->input->post('tgl_pengajuan')));
    $kode = $this->db->query("select MAX(id_peminjaman) LAST_NO from tb_peminjaman WHERE id_peminjaman LIKE '".$unik."%'")->row()->LAST_NO;
    
    $urutan = (int) substr($kode, -4);
    $urutan++;
    $kode = $unik . sprintf("%04s", $urutan);
    
    $id_periode = $this->db->query("SELECT max(id_periode) id_periode FROM tb_periode where status='Aktif'")->row()->id_periode;
    
    $dataHeader = array(
              "id_peminjaman" => $kode,
              "tgl_pengajuan" => date("Y-m-d", strtotime($this->input->post('tgl_pengajuan'))),
              "pinjam_mulai" => date("Y-m-d", strtotime($this->input->post('pinjam_mulai'))),
              "pinjam_sampai" => date("Y-m-d", strtotime($this->input->post('pinjam_sampai'))),
              "keterangan" => $this->input->post('keterangan'),
              "status" => "Proses",
              "no_induk" => $this->session->userdata('no_induk'),
              "id_periode" => $id_periode,
            );
    $this->db->insert('tb_peminjaman', $dataHeader);


    foreach($this->input->post('id_barang') as $key => $each){
      $dataDtl[] = array(
        "id_peminjaman" => $kode,
        "id_barang" => $this->input->post('id_barang')[$key],
        "qty_pinjam" => $this->input->post('qty_pinjam')[$key],
        "qty_approved" => $this->input->post('qty_pinjam')[$key],
        "status" => "Proses",
      );
    }

    $this->db->insert_batch('tb_dtl_peminjaman', $dataDtl);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan", "DOC_NO" => $kode);
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
    $this->db->where('id_peminjaman', $this->input->post('id_peminjaman'));
    $this->db->delete('tb_dtl_peminjaman');

    $this->db->where('id_peminjaman', $this->input->post('id_peminjaman'));
    $this->db->delete('tb_peminjaman');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

  public function approve(){
    $id_peminjaman = $this->input->post('id_peminjaman');
    $this->db->set('status', 'Approved');
    $this->db->where('id_peminjaman', $id_peminjaman);
    $this->db->update('tb_peminjaman');

    $this->db->set('status', 'Approved');
    $this->db->where('id_peminjaman', $id_peminjaman);
    $this->db->update('tb_dtl_peminjaman');

    $output = array("status" => "success", "message" => "Document berhasil di Approve", "DOC_NO" => $id_peminjaman);
    echo json_encode($output);
  }

  public function notApprove(){
    $id_peminjaman = $this->input->post('id_peminjaman');
    $this->db->set('status', 'Not Approved');
    $this->db->where('id_peminjaman', $id_peminjaman);
    $this->db->update('tb_peminjaman');

    $this->db->set('status', 'Not Approved');
    $this->db->where('id_peminjaman', $id_peminjaman);
    $this->db->update('tb_dtl_peminjaman');

    $output = array("status" => "success", "message" => "Document tidak terapprove", "DOC_NO" => $id_peminjaman);
    echo json_encode($output);
  }

  public function pengembalian(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_peminjaman', 'id_peminjaman', 'required');
    $this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
        "tgl_kembali" => date("Y-m-d", strtotime($this->input->post('tgl_kembali'))),
        "denda_keterlambatan" => $this->input->post('denda_keterlambatan'),
        "ket_kembali" => $this->input->post('ket_kembali'),
        "status" => "Selesai",
    );
    $this->db->where('id_peminjaman', $this->input->post('id_peminjaman'));
    $this->db->update('tb_peminjaman', $data);

    $dataItems = array(
        "status" => "Selesai",
    );
    $this->db->where('id_peminjaman', $this->input->post('id_peminjaman'));
    $this->db->update('tb_dtl_peminjaman', $dataItems);

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function peminjamanRpt(){
    $id_peminjaman = $this->input->post('idpeminjaman');
    // $id_peminjaman = "PJ2021120001";
    $data['hdr'] = $this->db->query("SELECT a.id_peminjaman, DATE_FORMAT(tgl_pengajuan, '%d-%b-%Y') tgl_pengajuan, 
    DATE_FORMAT(pinjam_mulai, '%d-%b-%Y') pinjam_mulai, 
    DATE_FORMAT(pinjam_sampai, '%d-%b-%Y') pinjam_sampai, a.keterangan,
    a.no_induk, b.nama
    FROM tb_peminjaman a, tb_user b
    where a.no_induk=b.no_induk
    and a.id_peminjaman='".$id_peminjaman."'")->result_array();

    $data['items'] = $this->db->query("SELECT a.id_barang, b.nama_barang, a.qty_pinjam, a.qty_approved, b.stock_tersedia 
    FROM tb_dtl_peminjaman a, tb_barang b
    where a.id_barang=b.id_barang
    and a.id_peminjaman='".$id_peminjaman."'")->result_array();

    $mpdf = new \Mpdf\Mpdf(['format' => 'A4-P', 'margin_left' => '5', 'margin_right' => '5']);
    $mpdf->setFooter('{PAGENO}');
    $html = $this->load->view('report/peminjamanRpt',$data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }

}