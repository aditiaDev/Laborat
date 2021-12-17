<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Pengadaan</h5>
              
              <div class="row">
                <div class="col-3">
                  <a class="btn btn-sm btn-primary rounded-pill" href="<?php echo base_url('pengadaan/addData')?>" style="margin-bottom: 10px;" ><i class="bi bi-cloud-plus-fill"></i> Tambah</a>
                </div>
              </div>
              
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                  <tr style="text-align: center;">
                    <th >ID</th>
                    <th>Periode</th>
                    <th >Tanggal Pengajuan</th>
                    <th >Dibuat Oleh</th>
                    <th>Ketrangan</th>
                    <th>Status</th>
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
            <form id="FRM_DATA" method="post" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kode kategori</label>
                      <input type="text" class="form-control" name="id_kategori">
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <label>Deskripsi</label>
                      <input type="text" class="form-control" name="deskripsi">
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
    })

    function REFRESH_DATA(){
      $('#tb_data').DataTable().destroy();
      var tb_data =  $("#tb_data").DataTable({
          "order": [[ 2, "desc" ], [ 0, "asc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('Pengadaan/getBuktiBeli') ?>",
              "type": "POST",
          },
          "columns": [
              { "data": "id_pengadaan" },
              { "data": "periode"},
              { "data": "tgl_pengajuan"},
              { "data": null,
                "render": function(data){
                    return data.no_induk+' - '+data.nama+' ('+data.hak_akses+')'
                }
              },
              { "data": "keterangan"},
              { "data": "status"},
              { "data": null, 
                "render" : function(data){
                  return "<a class='btn btn-sm btn-info' href='<?php echo base_url('pengadaan/dtlData/"+data.id_pengadaan+"')?>' title='View Data'><i class='bi bi-eye-fill'></i> </a> "+
                    "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_pengadaan+"\");'><i class='bi bi-trash'></i> </button>"
                },
                className: "text-center"
              },
          ]
        }
      )
    }


    function ACTION(urlPost, formData){
      $.ajax({
          url: urlPost,
          type: "POST",
          data: formData,
          dataType: "JSON",
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

      urlPost = "<?php echo site_url('pengadaan/deleteData') ?>";
      formData = "id_pengadaan="+id
      ACTION(urlPost, formData)
    }
  </script>