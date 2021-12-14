<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Pengaduan</h5>
              
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                  <tr style="text-align: center;">
                    <th >NO Aduan</th>
                    <th>Periode</th>
                    <th >Tanggal Aduan</th>
                    <th >Dibuat Oleh</th>
                    <th>Keterangan</th>
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
            <form id="FRM_DATA">
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
      tb_data =  $("#tb_data").DataTable({
          "order": [[ 2, "desc" ], [ 0, "asc" ]],
          "ordering": false,
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('Pengaduan/getAllData') ?>",
              "type": "POST",
          },
          "columns": [
              { "data": "id_pengaduan" },
              { "data": "periode"},
              { "data": "tgl_pengaduan"},
              { "data": null,
                "render": function(data){
                    return data.no_induk+' - '+data.nama+' ('+data.hak_akses+')'
                }
              },
              { "data": "keterangan"},
              { "data": "status"},
              { "data": null, 
                "render" : function(data){
                  return "<a class='btn btn-sm btn-info' href='<?php echo base_url('pengaduan/dtlData/"+data.id_pengaduan+"')?>' title='View Data'><i class='bi bi-eye-fill'></i> </a> "+
                    "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_pengaduan+"\");'><i class='bi bi-trash'></i> </button>"
                },
                className: "text-center"
              },
          ]
        }
      )
    }

  $('#tb_data thead tr').clone(true).appendTo( '#tb_data thead' );
  $('#tb_data thead tr:eq(1) th').each( function (i) {
    
      var title = $(this).text();
      if(i==3)
          $(this).html("<select class='column_search'>"+
                          "<option value=''>All</option>"+
                          "<option value='siswa'>Siswa</option>"+
                          "<option value='guru'>Guru</option>"+
                      "</select>");
      else if(i==5)
      $(this).html("<select class='column_search'>"+
                        "<option value=''>All</option>"+
                        "<option value='Proses'>Proses</option>"+
                        "<option value='Approved'>Approved</option>"+
                        "<option value='Not Approved'>Not Approved</option>"+
                    "</select>");
      else
      $(this).html('');
  } );

  $( '#tb_data thead'  ).on( 'change', ".column_search",function () {
   
    tb_data
        .column( $(this).parent().index() )
        .search( this.value )
        .draw();
  } );

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

      urlPost = "<?php echo site_url('Peminjaman/deleteData') ?>";
      formData = "id_peminjaman="+id
      ACTION(urlPost, formData)
    }
  </script>