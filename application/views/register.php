<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JobLook</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/adminlte/dist/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('/assets/adminlte/plugins/toastr/toastr.min.css'); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box" style="width: 540px;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h3>JobLook</h3>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new user</p>

      <form method="post" id="FRM_DATA">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Posisi yg dilamar </label>
              <input type="hidden" class="form-control" name="id_lowongan_kerja" value="<?php echo $data->id_lowongan_kerja; ?>">
              <input type="text" class="form-control" name="nm_lowongan_kerja" value="<?php echo $data->nm_lowongan_kerja; ?>" disabled>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Nama Pelamar</label>
              <input type="text" class="form-control" name="nm_pelamar">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" name="username" >
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Jenis Kelamin</label>
              <select class="form-control" name="jenis_kelamin">
                <option value="pria">Pria</option>
                <option value="wanita">Wanita</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>No. Telp</label>
              <input type="text" class="form-control" name="no_tlp">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Pendidikan Terakhir</label>
              <select class="form-control" name="lulusan">
                <option value="SMA">SMA</option>
                <option value="DI">DI</option>
                <option value="DII">DII</option>
                <option value="DIII">DIII</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Jurusan</label>
              <input type="text" class="form-control" name="jurusan">
            </div>
          </div>
        </div>
        <div class="form-group">
          <P>Alamat</P>
          <input type="text" class="form-control" name="alamat_pelamar">
        </div>
        <div class="form-group">
          <P>Kemampuan</P>
          <textarea name="kemampuan" class="form-control" rows="5"></textarea>
        </div>
        <div class="row">
          <div class="col-4">
            <a href="<?php echo base_url("login")?>" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Login Page</a>
          </div>
          <div class="col-4"></div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-info btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url('/assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('/assets/adminlte/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/adminlte/plugins/toastr/toastr.min.js'); ?>"></script>
<script>
  $(function(){
    $("#FRM_DATA").submit(function(event){

      event.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
          url: "<?php echo site_url('login/signUp') ?>",
          type: "POST",
          data: formData,
          dataType: "JSON",
          /*beforeSend: function () {
            $("#LOADER").show();
          },
          complete: function () {
            $("#LOADER").hide();
          },*/
          success: function(data){
            console.log(data)
            if (data.status == "success") {
              alert('Pendaftaran Berhasil')
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
