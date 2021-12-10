<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Master Barang</h5>
              
              <div class="row">
                <div class="col-3">
                  <button class="btn btn-sm btn-primary rounded-pill" style="margin-bottom: 10px;" id="add_data"><i class="bi bi-cloud-plus-fill"></i> Tambah</button>
                </div>
              </div>
              
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                  <tr style="text-align: center;">
                    <th></th>
                    <th >Kode</th>
                    <th >Deskripsi</th>
                    <th >Kat</th>
                    <th >Lab</th>
                    <th >Total Stock</th>
                    <th >Stock in Lab</th>
                    <!-- <th >Harga Barang</th>
                    <th >Min Stock</th>
                    <th >Photo</th> -->
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
                      <label>Kategori</label>
                      <select name="id_kategori" id="" class="form-select">
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Laboratorium</label>
                      <select name="id_laborat" id="" class="form-select">
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Kode Barang</label>
                      <input type="text" class="form-control" name="id_barang" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Deskrispsi</label>
                      <input type="text" class="form-control" name="nama_barang" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Stock</label>
                      <input type="text" class="form-control" name="stock" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Stock Tersedia</label>
                      <input type="text" class="form-control" name="stock_tersedia" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Min Stock</label>
                      <input type="text" class="form-control" name="min_stock" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Harga Beli</label>
                      <input type="test" class="form-control" name="harga_beli" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label id="lbl_foto">Foto</label>
                      <div class="custom-file">
                        <input type="file"  name="foto">
                      </div>
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
    var tb_data;

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
            urlPost = "<?php echo site_url('barang/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('barang/updateData') ?>";
            formData+="&id_barang="+id_data
        }
        // console.log(formData)
        ACTION(urlPost, formData)
        $("#modal_add").modal('hide')
      })

    })

    function REFRESH_DATA(){
      $('#tb_data').DataTable().destroy();
      tb_data =  $("#tb_data").DataTable({
          "order": [[ 1, "desc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('barang/getAllData') ?>",
              "type": "POST",
              "data": {
                "id_kategori" : $("[name='src_kategori']").val(),
                "id_laborat" : $("[name='src_laborat']").val()
              }
          },
          "columns": [
              {
                "className":      'dt-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
              },
              { "data": "id_barang" },
              { "data": "nama_barang"},
              { "data": "id_kategori"},
              { "data": "id_laborat"},
              { "data": "stock"},
              { "data": "stock_tersedia"},
              // { "data": "harga_beli"},
              // { "data": "min_stock"},
              // { "data": "foto"},
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

    function format ( d ) {
      // `d` is the original data object for the row
      if(d.foto){
        img = "<a target='_blank' href='<?php echo base_url() ?>assets/images/barang/"+d.foto+"'><img  style='max-width: 120px;' class='img-fluid' src='<?php echo base_url() ?>assets/images/barang/"+d.foto+"' ></a>";
      }else{
        img = "No Image"
      }
      return '<table class="table table-bordered" style="width:450px;">'+
          '<tr>'+
              '<td style="width:80px;">Photo:</td>'+
              '<td>'+img+'</td>'+
          '</tr>'+
          '<tr>'+
              '<td>Harga:</td>'+
              '<td>'+d.harga_beli+'</td>'+
          '</tr>'+
          '<tr>'+
              '<td>Min Stock:</td>'+
              '<td>'+d.min_stock+'</td>'+
          '</tr>'+
      '</table>';
    }

    $('#tb_data tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = tb_data.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

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

      urlPost = "<?php echo site_url('barang/deleteData') ?>";
      formData = "id_barang="+id
      ACTION(urlPost, formData)
    }
  </script>