<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Pengelola Laborat</h5>
              
              <div class="row">
                <div class="col-3">
                  <button class="btn btn-sm btn-primary rounded-pill" style="margin-bottom: 10px;" id="add_data"><i class="bi bi-cloud-plus-fill"></i> Tambah</button>
                </div>
              </div>
              
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                  <tr style="text-align: center;">
                    <th >NIK</th>
                    <th >Nama</th>
                    <th >ID Lab</th>
                    <th >Lab yg dikelola</th>
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
                      <label>NIK</label>
                      <select name="no_induk" class="form-select">
                        <option value="" disabled selected> - Pilih - </option>
                        <?php
                          foreach($user as $usr){
                            echo "<option value='".$usr->no_induk."'>".$usr->no_induk." - ".$usr->nama."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>ID LAB</label>
                      <select name="id_laborat" class="form-select">
                        <option value="" disabled selected> - Pilih - </option>
                        <?php
                          foreach($laborat as $lab){
                            echo "<option value='".$lab->id_laborat."'>".$lab->id_laborat." - ".$lab->deskripsi."</option>";
                          }
                        ?>
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
        save_method = "save"
        $("#modal_add .modal-title").text('Add Data')
        $("#modal_add").modal('show')
      })

      $("#BTN_SAVE").click(function(){
        event.preventDefault();
        var formData = $("#FRM_DATA").serialize();
        
        
        if(save_method == 'save') {
            urlPost = "<?php echo site_url('laboran/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('laboran/updateData') ?>";
            formData+="&id="+id_data
        }
        // console.log(formData)
        ACTION(urlPost, formData)
        $("#modal_add").modal('hide')
      })

    })

    function REFRESH_DATA(){
      $('#tb_data').DataTable().destroy();
      var tb_data =  $("#tb_data").DataTable({
          "order": [[ 1, "asc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('laboran/getAllData') ?>",
              "type": "POST",
          },
          "columns": [
              { "data": "no_induk" },
              { "data": "nama"},
              { "data": "id_laborat"},
              { "data": "deskripsi"},
              { "data": null, 
                "render" : function(data){
                  return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'><i class='bi bi-pencil-square'></i> </button> "+
                    "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id+"\");'><i class='bi bi-trash'></i> </button>"
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
      id_data = data.id;
      $("#modal_add .modal-title").text('Edit Data')
      $("[name='id_laborat']").val(data.id_laborat)
      $("[name='no_induk']").val(data.no_induk)
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

      urlPost = "<?php echo site_url('laboran/deleteData') ?>";
      formData = "id="+id
      ACTION(urlPost, formData)
    }
  </script>