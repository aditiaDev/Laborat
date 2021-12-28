<style>
  .sidebar-nav .nav-link {
    font-size: 13px;
  }
</style>
<aside id="sidebar" class="sidebar" style="/*width: 250px;padding: 10px;*/">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("home/")?>">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <?php if($this->session->userdata('hak_akses') <> "siswa"){ ?>
      <li class="nav-heading">Master</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <?php if($this->session->userdata('hak_akses') == "kepsek"){ ?>
          <li>
            <a href="<?php echo base_url("user/")?>">
              <i class="bi bi-circle"></i><span>Data User</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url("periode/")?>">
              <i class="bi bi-circle"></i><span>Periode Pendidikan</span>
            </a>
          </li>
          <?php } ?>
          <?php if($this->session->userdata('hak_akses') == "kepsek" or $this->session->userdata('hak_akses') == "sarpras"){ ?>
          <li>
            <a href="<?php echo base_url("laborat/")?>">
              <i class="bi bi-circle"></i><span>Data Laborat</span>
            </a>
          </li>
          
          <li>
            <a href="<?php echo base_url("kategori/")?>">
              <i class="bi bi-circle"></i><span>Kategori Barang</span>
            </a>
          </li>
          <?php } ?>
          <li>
            <a href="<?php echo base_url("barang/")?>">
              <i class="bi bi-circle"></i><span>Master Barang</span>
            </a>
          </li>
        </ul>
      </li>
      <?php } ?>

      <li class="nav-heading">Transaksi</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("peminjaman/")?>">
          <i class="bi bi-eyedropper"></i>
          <span>Peminjaman Alat</span>
        </a>
      </li>

      <?php if($this->session->userdata('hak_akses') == "laboran"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("pengembalian/")?>">
          <i class="bi bi-minecart"></i>
          <span>Pengembalian Alat</span>
        </a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('hak_akses') == "siswa" or $this->session->userdata('hak_akses') == "guru" or $this->session->userdata('hak_akses') == "laboran"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("pengaduan/")?>">
          <i class="bi bi-vector-pen"></i>
          <span>Pengaduan Kerusakan</span>
        </a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('hak_akses') == "laboran" or $this->session->userdata('hak_akses') == "sarpras"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("monitoring/")?>">
          <i class="bi bi-laptop"></i>
          <span>Monitoring Barang</span>
        </a>
      </li>
      <?php } ?>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("pengadaan/")?>">
          <i class="bi bi-journals"></i>
          <span>Pengadaan Barang</span>
        </a>
      </li>

      <?php if($this->session->userdata('hak_akses') == "bendahara"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("pengadaan/buktiBeli")?>">
          <i class="bi bi-journals"></i>
          <span>Upload Bukti Pembelian</span>
        </a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('hak_akses') == "bendahara" or $this->session->userdata('hak_akses') == "kepsek"){ ?>
      <li class="nav-heading">Report</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-printer"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url("Laporan/peminjaman")?>">
              <i class="bi bi-circle"></i><span>Peminjaman Alat</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Pengadaan Barang</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Monitoring Barang</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Pengaduan Kerusakan</span>
            </a>
          </li>
        </ul>
      </li>
      <?php } ?>

      <li class="nav-heading">More</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("Login/logout")?>">
          <i class="bi bi-box-arrow-in-left"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>

  </aside>