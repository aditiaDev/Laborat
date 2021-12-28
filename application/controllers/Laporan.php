<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');

  }

  public function peminjaman(){

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/lap_peminjaman');
    $this->load->view('template/footer');
  }

  public function ctkPeminjaman(){
    $data['data'] = $this->db->query("SELECT a.id_peminjaman, 
    concat(DATE_FORMAT(a.pinjam_mulai, '%d/%b/%Y'), ' - ', DATE_FORMAT(a.pinjam_sampai, '%d/%b/%Y')) tgl_peminjaman, 
    DATE_FORMAT(a.tgl_kembali, '%d/%b/%Y') tgl_kembali, a.keterangan,
    a.status, a.no_induk, b.hak_akses, b.nama, c.periode, d.id_barang, e.nama_barang, d.qty_approved
    FROM tb_peminjaman a, tb_dtl_peminjaman d, tb_barang e, tb_user b, tb_periode c
    where 
    a.id_peminjaman=d.id_peminjaman
    and d.id_barang=e.id_barang
    and a.no_induk=b.no_induk
    and a.id_periode=c.id_periode
    and a.status = 'Selesai'
    and a.pinjam_mulai >= '".$this->input->post('start_date')."' 
    and a.pinjam_mulai < DATE(DATE_ADD('".$this->input->post('end_date')."', INTERVAL 1 DAY))
    ORDER BY a.pinjam_mulai")->result_array();

    $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L', 'margin_left' => '5', 'margin_right' => '5']);
    $mpdf->setFooter('{PAGENO}');
    $html = $this->load->view('Report/ctkPeminjaman',$data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }

}