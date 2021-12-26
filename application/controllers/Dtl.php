<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dtl extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('no_induk'))
      redirect('login', 'refresh');
  }

  public function Peminjaman(){
    $sql = $this->db->query("SELECT a.id_peminjaman, a.pinjam_sampai, a.no_induk, b.nama, b.no_wa FROM tb_peminjaman a, tb_user b
    where a.no_induk=b.no_induk
    and a.status='Approved' and a.pinjam_sampai<sysdate()
    ORDER BY a.pinjam_sampai asc")->result_array();

    $tbody="";
    foreach($sql as $row){
      $tbody .= "<tr>
                <td style='text-align: center;'><input type='checkbox' name='id_peminjaman[]' class='centang' value='".$row['id_peminjaman']."' checked></td>
                <td>".$row['id_peminjaman']."</td>
                <td>".$row['pinjam_sampai']."</td>
                <td>".$row['no_induk']." - ".$row['nama']."</td>
                <td>".$row['no_wa']."</td>
                </tr>";
    }

    $data['table'] = "<thead>
                        <th style='width: 70px;text-align: center;'><button type='button' id='btnKirim' class='btn btn-sm btn-warning'>Kirim</button></th>
                        <th>No Dokumen</th>
                        <th>Batas Peminjaman</th>
                        <th>Peminjam</th>
                        <th>No. Whatsapp</th>
                      </thead>
                      <tbody>"
                      .$tbody.
                      "</tbody>";

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/dtl_notifikasi', $data);
    $this->load->view('template/footer');
  }

  public function send_pengembalian(){
    $id_peminjaman = $this->input->post('id_peminjaman');

    foreach($id_peminjaman as $key => $each){
      $sql = $this->db->query("SELECT a.id_peminjaman, DATE_FORMAT(a.pinjam_sampai, '%d-%b-%Y') pinjam_sampai, a.no_induk, b.nama, b.no_wa FROM tb_peminjaman a, tb_user b
        where a.no_induk=b.no_induk
        and a.id_peminjaman='".$id_peminjaman[$key]."'")->result_array();

        foreach($sql as $row){
          $no_wa = $row['no_wa'];
          $message = "Peminjaman dengan no Dokumen ".$row['id_peminjaman']." atas nama ".$row['nama']."-".$row['no_induk'].", Batas Peminjaman berakhir pada ".$row['pinjam_sampai'];
          $this->zenziva_api($no_wa, $message);

        }
    }

    $output = array("status" => "success", "message" => "Pengiriman Pesan berhasil");
    echo json_encode($output);
  }

  function zenziva_api($no_wa, $message){
    $userkey = "8jhyem";
    $passkey = "n65hmpn9lo";
    $url = "https://console.zenziva.net/wareguler/api/sendWA/";

    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url);
    curl_setopt($curlHandle, CURLOPT_HEADER, 0);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
    curl_setopt($curlHandle, CURLOPT_POST, 1);
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
      'userkey' => $userkey,
      'passkey' => $passkey,
      'to' => $no_wa,
      'message' => $message
    ));
    $results = json_decode(curl_exec($curlHandle), true);
    curl_close($curlHandle);
    return $results['text'];
  }

  public function Pengaduan(){
    $sql = $this->db->query("SELECT a.id_pengaduan, a.tgl_pengaduan, a.keterangan, a.no_induk, b.nama 
    FROM tb_pengaduan a, tb_user b
    where a.no_induk=b.no_induk 
    and a.status='Proses' ORDER BY a.tgl_pengaduan ASC")->result_array();

    $tbody="";
    foreach($sql as $row){
      $tbody .= "<tr>
                <td>".$row['id_pengaduan']."</td>
                <td>".$row['tgl_pengaduan']."</td>
                <td>".$row['keterangan']."</td>
                <td>".$row['no_induk']." - ".$row['nama']."</td>
                <td style='text-align:center;'><a class='btn btn-sm btn-info' href='".base_url()."/pengaduan/dtlData/".$row['id_pengaduan']."'><i class='bi bi-eye-fill'></i></a></td>
                </tr>";
    }

    $data['table'] = "<thead>
                        <th>No Dokumen</th>
                        <th>Tgl Aduan</th>
                        <th>Keterangan</th>
                        <th>Dibuat oleh</th>
                        <th>Action</th>
                      </thead>
                      <tbody>"
                      .$tbody.
                      "</tbody>";

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/dtl_notifikasi', $data);
    $this->load->view('template/footer');
  }

  public function Pengadaan(){
    $sql = $this->db->query("SELECT a.id_pengadaan, a.tgl_pengajuan, a.keterangan, a.no_induk, b.nama 
    FROM tb_pengadaan a, tb_user b
    where a.no_induk=b.no_induk 
    and a.status='Proses' ORDER BY a.tgl_pengajuan ASC")->result_array();

    $tbody="";
    foreach($sql as $row){
      $tbody .= "<tr>
                <td>".$row['id_pengadaan']."</td>
                <td>".$row['tgl_pengajuan']."</td>
                <td>".$row['keterangan']."</td>
                <td>".$row['no_induk']." - ".$row['nama']."</td>
                <td style='text-align:center;'><a class='btn btn-sm btn-info' href='".base_url()."/pengadaan/dtlData/".$row['id_pengadaan']."'><i class='bi bi-eye-fill'></i></a></td>
                </tr>";
    }

    $data['table'] = "<thead>
                        <th>No Dokumen</th>
                        <th>Tgl Pengajuan</th>
                        <th>Keterangan</th>
                        <th>Dibuat oleh</th>
                        <th>Action</th>
                      </thead>
                      <tbody>"
                      .$tbody.
                      "</tbody>";

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/dtl_notifikasi', $data);
    $this->load->view('template/footer');
  }

  public function Stock(){
    $sql = $this->db->query("SELECT a.id_barang, a.nama_barang, a.stock, a.min_stock, b.deskripsi FROM tb_barang a, tb_laborat b where 
    a.id_laborat=b.id_laborat
    and a.stock<=a.min_stock
    ORDER BY a.id_laborat, a.id_barang")->result_array();

    $tbody="";
    foreach($sql as $row){
      $bg = "";
      if($row['stock'] < $row['min_stock']){
        $bg = "style='background-color: #fa7c88;'";
      }
      $tbody .= "<tr ".$bg.">
                <td>".$row['id_barang']."</td>
                <td>".$row['nama_barang']."</td>
                <td>".$row['stock']."</td>
                <td>".$row['min_stock']."</td>
                <td>".$row['deskripsi']."</td>
                </tr>";
    }

    $data['table'] = "<thead>
                        <th>ID Barang</th>
                        <th>Deskripsi</th>
                        <th>Stok Lab</th>
                        <th>Minimum Stok</th>
                        <th>Lab</th>
                      </thead>
                      <tbody>"
                      .$tbody.
                      "</tbody>";

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/dtl_notifikasi', $data);
    $this->load->view('template/footer');
  }

}