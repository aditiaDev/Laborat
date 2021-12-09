<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Users</h5>
              
              <div class="row">
                <div class="col-2" style="width: 125px;">
                  <button class="btn btn-sm btn-primary rounded-pill" style="margin-bottom: 10px;" id="add_data"><i class="bi bi-cloud-plus-fill"></i> Tambah</button>
                </div>
                <div class="col-4">
                  <div class="row">
                    <label class="col-sm-3 col-form-label">Select</label>
                    <div class="col-sm-9">
                      <select class="form-select" name="src_jenis">
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                        <option value="laboran">Laboran</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="kepsek">Kepala Sekolah</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                  <tr style="text-align: center;">
                    <th >NIK/NIS</th>
                    <!-- <th >Jenis</th> -->
                    <th >Nama</th>
                    <th >Jekel</th>
                    <th >Telp</th>
                    <th >Whatsapp</th>
                    <th >Status</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>

        </div>

      </div>

      <!-- Basic Modal -->
      <div class="modal fade" id="modal_add" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form id="FRM_DATA">
              <div class="modal-header">
                <h5 class="modal-title">Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>NIK/NIS</label>
                      <input type="text" class="form-control" name="no_induk" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Alamat</label>
                      <textarea name="alamat" name="alamat" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>No. Telp</label>
                      <input type="text" class="form-control" name="no_telp" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>No. Whatsapp</label>
                      <input type="text" class="form-control" name="no_wa" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Jekel</label>
                      <select name="jekel" id="" class="form-select">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Hak Akses</label>
                      <select name="hak_akses" id="" class="form-select">
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                        <option value="laboran">Laboran</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="kepsek">Kepala Sekolah</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Status Akun</label>
                      <select name="status" id="" class="form-select">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="BTN_SAVE">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- End Basic Modal-->
    </section>

  </main>
  <script src="<?php echo base_url('/assets/jquery/jquery.min.js'); ?>"></script>
  <script>
    var save_method;
    var id_data;

    $(function(){
      REFRESH_DATA()

      $("[name='src_jenis']").change(function(){
        REFRESH_DATA()
      })

      $("#add_data").click(function(){
        $("#FRM_DATA")[0].reset()
        $("[name='no_induk']").attr('readonly', false)
        save_method = "save"
        $("#modal_add .modal-title").text('Add Data')
        $("#modal_add").modal('show')
      })

      $("#BTN_SAVE").click(function(){
        event.preventDefault();
        var formData = $("#FRM_DATA").serialize();
        
        
        if(save_method == 'save') {
            urlPost = "<?php echo site_url('user/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('user/updateData') ?>";
            formData+="&no_induk="+id_data
        }
        // console.log(formData)
        ACTION(urlPost, formData)
        $("#modal_add").modal('hide')
      })

    })

    function REFRESH_DATA(){
      $('#tb_data').DataTable().destroy();
      var tb_data =  $("#tb_data").DataTable({
          "order": [[ 0, "desc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('user/getAllData') ?>",
              "type": "POST",
              "data": {
                "jenis" : $("[name='src_jenis']").val()
              }
          },
          "columns": [
              { "data": "no_induk" },
              { "data": "nama"},
              { "data": "jekel"},
              { "data": "no_telp"},
              { "data": "no_wa"},
              { "data": "status"},
              { "data": null, 
                "render" : function(data){
                  return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'><i class='bi bi-pencil-square'></i> </button> "+
                    "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.no_induk+"\");'><i class='bi bi-trash'></i> </button>"
                },
                className: "text-center"
              },
          ]
        }
      )
    }

    function editData(data, index){
      console.log(data)
      save_method = "edit"
      id_data = data.no_induk;
      $("#modal_add .modal-title").text('Edit Data')
      $("[name='no_induk']").val(data.no_induk)
      $("[name='nama']").val(data.nama)
      $("[name='alamat']").val(data.alamat)
      $("[name='no_telp']").val(data.no_telp)
      $("[name='no_wa']").val(data.no_wa)
      $("[name='jekel']").val(data.jekel)
      $("[name='username']").val(data.username)
      $("[name='password']").val(data.password)
      $("[name='hak_akses']").val(data.hak_akses)
      $("[name='status']").val(data.status)

      $("[name='no_induk']").attr('readonly', true)
      $("#modal_add").modal('show')
    }

    function ACTION(urlPost, formData){
      $.ajax({
          url: urlPost,
          type: "POST",
          data: formData,
          dataType: "JSON",
          beforeSend: function () {
            $("#LOADER").show();
          },
          complete: function () {
            $("#LOADER").hide();
          },
          success: function(data){
            console.log(data)
            if (data.status == "success") {
              toastr.info(data.message)
              REFRESH_DATA()

            }else{
              toastr.error(data.message)
            }
          }
      })
    }

    function deleteData(id){
      if(!confirm('Delete this data?')) return

      urlPost = "<?php echo site_url('user/deleteData') ?>";
      formData = "no_induk="+id
      ACTION(urlPost, formData)
    }
  </script>