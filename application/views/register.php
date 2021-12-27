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
  <link rel="stylesheet" href="<?php echo base_url('/assets/toastr/toastr.min.css'); ?>">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('/assets/NiceAdmin/assets/css/style.css'); ?>" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo base_url('/assets/images/logo/logo_lab.png'); ?>" alt="">
                  <span class="d-none d-lg-block">SiLabKu</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Buat Akun Baru</h5>
                    <p class="text-center small">Masukkan data diri anda</p>
                  </div>

                  <form class="row g-3" method="post" id="FRM_DATA">

                    <div class="col-6">
                      <label class="form-label">No Induk Siswa/Guru</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="no_induk" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">Nama Lengkap</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="nama" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label">Alamat</label>
                      <div class="input-group">
                        <textarea name="alamat" class="form-control"></textarea>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">No Telp</label>
                      <div class="input-group">
                        <input type="text" name="no_telp" class="form-control" onkeypress="return onlyNumberKey(event)" required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">No Whatsapp</label>
                      <div class="input-group">
                        <input type="text" name="no_wa" class="form-control" onkeypress="return onlyNumberKey(event)" required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">Jenis Kelamin</label>
                      <div class="input-group">
                        <select name="jekel" class="form-select">
                          <option value="Laki-laki">Laki-laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">User Akses</label>
                      <div class="input-group">
                      <select name="hak_akses" class="form-select">
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                      </select>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">Username</label>
                      <div class="input-group">
                        <input type="text" name="username" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label class="form-label">Password</label>
                      <div class="input-group">
                        <input type="password" name="password" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <a class="btn btn-warning w-100" href="<?php echo base_url("Login/")?>">Login</a>
                    </div>
                    <div class="col-6">
                      <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
                    </div>

                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="<?php echo base_url('/assets/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('/assets/toastr/toastr.min.js'); ?>"></script>
  <script>

    function onlyNumberKey(evt) {      
      // Only ASCII character in that range allowed
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57) && ASCIICode!=46)
          return false;
      return true;
    }

    $(function(){
      $("#FRM_DATA").submit(function(event){

        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "<?php echo site_url('Login/login') ?>",
            type: "POST",
            data: formData,
            dataType: "JSON",
            success: function(data){
              // console.log(data)
              if (data.status == "success") {
                window.location="<?php echo base_url('home');?>"
              }else{
                toastr.error(data.message)
              }
            }
        })
      })
    })
  </script>
</body>

</html>