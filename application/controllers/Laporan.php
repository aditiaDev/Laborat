<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('id_user'))
      redirect('login', 'refresh');
  }

  public function index(){
    
    

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('template/laporan');
    $this->load->view('template/footer');
  }

  public function cetakRangking(){
    
    $data['data'] = $this->db->query("SELECT c.nm_lowongan_kerja, b.nm_pelamar, a.total_nilai, b.alamat_pelamar, 
                            b.lulusan, b.jurusan, b.jenis_kelamin, b.kemampuan FROM tb_rangking a
                            LEFT JOIN tb_pelamar b ON a.id_pelamar=b.id_pelamar
                            LEFT JOIN tb_lowongan_kerja c ON b.id_lowongan_kerja=c.id_lowongan_kerja
                            WHERE c.id_lowongan_kerja='".$this->input->post('id_lowongan_kerja')."'
                            ORDER BY a.total_nilai DESC")->result_array();
    
    $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L', 'margin_left' => '5', 'margin_right' => '5']);
    $mpdf->setFooter('{PAGENO}');
    $html = $this->load->view('cetak/ctkRangking',$data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    // $this->load->view('cetak/ctkRangking',$data);
  }

}