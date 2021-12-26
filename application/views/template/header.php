<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SiLabKu</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url('/assets/images/logo/logo_lab.png'); ?>" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/vendor/quill/quill.snow.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/vendor/quill/quill.bubble.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/vendor/remixicon/remixicon.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/DataTables2/datatables.min.css'); ?>"/>
  <link rel="stylesheet" href="<?php echo base_url('/assets/toastr/toastr.min.css'); ?>">
  <link href="<?php echo base_url('/assets/datepicker/gijgo.min.css'); ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url('/assets/css/loader.css'); ?>">
  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/css/style.css'); ?>" rel="stylesheet">
  
  <script>
    
    function ACTION_MENU(){
      var htmlMenu = '<button class="btn btn-sm btn-outline-secondary" id="BTN_NEW"><i class="bi bi-card-text"></i> New</button> '+
      '<button class="btn btn-sm btn-outline-secondary" id="BTN_EDIT"><i class="bi bi-pencil-square"></i> Edit</button> '+
      '<button class="btn btn-sm btn-outline-primary" id="BTN_SAVE"><i class="bi bi-save-fill"></i> Save</button> '+
      '<button class="btn btn-sm btn-outline-warning" id="BTN_BATAL"><i class="bi bi-x-octagon-fill"></i> Batal</button> '+
      '<button class="btn btn-sm btn-outline-success" id="BTN_PRINT"><i class="bi bi-printer"></i></button> '+
      '<button class="btn btn-sm btn-outline-danger" id="BTN_DELETE"><i class="bi bi-trash"></i></button>'

      $("#search-bar").append(htmlMenu)
    }

    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57) && ASCIICode!=46)
            return false;
        return true;
    }

    function BUTTON_ACTION(param){
      $("#BTN_NEW").attr('disabled', param)
      $("#BTN_EDIT").attr('disabled', param)
      $("#BTN_SAVE").attr('disabled', param)
      $("#BTN_BATAL").attr('disabled', param)
      $("#BTN_PRINT").attr('disabled', param)
      $("#BTN_DELETE").attr('disabled', param)
    }
    
  </script>
  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
    label{
      font-family: 'bootstrap-icons';
    }

    .table tbody tr td input {
        font-size: 14px;
        font-family: serif;
    }

    .tabel {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }


    .tabel td, .tabel th {
      border: 1px solid #ddd;
      padding: 8px;
      
    }

    .tabel tr:nth-child(even){background-color: #f2f2f2;}

    .tabel tr:hover {background-color: #ddd;}

    .tabel th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #4CAF50;
      color: white;
    }
    .tabel thead th { 
      position: sticky; 
      top: 0; 
      z-index: 1;
      resize: horizontal;
      overflow: auto;
    }

    .tabel tbody tr td{
      font-size: 14px;
      font-family: serif;
    }

    .tabel tbody tr td input{
      font-size: 14px;
      font-family: serif;
    }

    .tb_no_top{
      font-family: serif;
    }
    
    .tb_no_top>thead>tr>th{
        border: none;
        vertical-align: middle;
    }
    .tb_no_top>tbody>tr>td{
        border-bottom: none;
        vertical-align: middle;
    }
    .slimScrollBar{
      width: 10px!important;
      background: rgb(204, 204, 204)!important;
      border-radius: 0px!important;
    }
    .content-wrapper{
      font-size: 12px;
    }
    .skin-blue-light .treeview-menu>li.active>a {
      font-weight: 400;
    }
  </style>
</head>

<body>
<div class="before-loader" id="LOADER" style="display: none;">
  <div class="loader5" ></div>
</div>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="<?php echo base_url('/assets/images/logo/logo_lab.png'); ?>" alt="">
        <span class="d-none d-lg-block">SiLabKu</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar" id="search-bar">
      <!-- <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form> -->
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <?php
            $pengaduan = $this->db->query("SELECT count(*) jml_aduan FROM tb_pengaduan where status='Proses'")->row()->jml_aduan;
            $pengadaan= $this->db->query("SELECT count(*) jml FROM tb_pengadaan where status='Proses'")->row()->jml;
            $peminjaman = $this->db->query("SELECT count(*) jml FROM tb_peminjaman where status='Approved' and pinjam_sampai<sysdate()")->row()->jml;
            $stock = $this->db->query("SELECT count(*) jml FROM tb_barang where stock<=min_stock")->row()->jml;
          ?>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header" style="text-align: left;">
              <i class="bi bi-exclamation-circle text-warning"></i>
              Pengaduan Kerusakan
              <a href="<?php echo base_url("Dtl/Pengaduan")?>"><span class="badge rounded-pill bg-primary p-2 ms-2"><?php echo $pengaduan ?></span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-header" style="text-align: left;">
              <i class="bi bi-exclamation-circle text-warning"></i>
              Pengadaan Barang
              <a href="<?php echo base_url("Dtl/Pengadaan")?>"><span class="badge rounded-pill bg-primary p-2 ms-2"><?php echo $pengadaan ?></span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-header" style="text-align: left;">
              <i class="bi bi-exclamation-circle text-warning"></i>
              Batas Waktu Peminjaman
              <a href="<?php echo base_url("Dtl/Peminjaman")?>"><span class="badge rounded-pill bg-primary p-2 ms-2"><?php echo $peminjaman ?></span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-header" style="text-align: left;">
              <i class="bi bi-exclamation-circle text-warning"></i>
              Stok Menipis
              <a href="<?php echo base_url("Dtl/Stock")?>"><span class="badge rounded-pill bg-primary p-2 ms-2"><?php echo $stock ?></span></a>
            </li>
            

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo base_url('/assets/images/logo/logo_lab.png'); ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $this->session->userdata('nama'); ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $this->session->userdata('nama'); ?></h6>
              <span><?php echo $this->session->userdata('hak_akses'); ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url("Login/logout")?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>