<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <form id="FRM_DATA" method="post">
            <div class="card-body">
              
              <div class="row">
                <div class="col-lg-12">
                  <table class="table tb_no_top">
                    <tr>
                        <td style="width: 120px;">No Monitoring</td>
                        <td><input type="text" class="form-control" name="id_monitoring" value="<New>" readonly></td>
                        <td>Tanggal</td>
                        <td><input type="text" class="form-control datepicker" name="tgl_monitoring" readonly value="<?php echo date('d-M-Y'); ?>"></td>
                        <td>Dibuat</td>
                        <td><input type="text" class="form-control" name="no_induk" value="<?php echo $this->session->userdata('no_induk') ?>" readonly></td>
                        <td><input type="text" class="form-control" name="nama" value="<?php echo $this->session->userdata('nama') ?>" readonly></td>
                    </tr>
                    <tr>
                      <td>Laborat</td>
                      <td><input type="text" class="form-control" name="id_laborat" readonly></td>
                      <td><button class="btn btn-outline-secondary" id="BTN_LAB"><i class="bi bi-list-task"></i></button></td>
                      <td colspan="2"><input type="text" class="form-control" name="nm_laborat" readonly></td>
                      <td style="text-align: right;">Status</td>
                      <td><input type="text" class="form-control" name="status" value="Proses" readonly></td>
                    </tr>
                    <tr>
                      <td>Keterangan</td>
                      <td colspan="4">
                        <textarea name="keterangan" class="form-control"></textarea>
                      </td>
                    </tr>
                  </table>
                </div>
                <?php  if($this->session->userdata('hak_akses') == "sarpras" ){ ?>
                <div class="col-lg-12">
                  <div style="justify-content: center;display: flex;margin-bottom: 15px;">
                    <button type="button" id="BTN_APPROVE" class="btn btn-sm btn-warning" style="margin-right: 10px;" ><i class="bi bi-check2-all"></i> Approve</button>
                    <button type="button" id="BTN_NOT_APPROVE" class="btn btn-sm btn-danger" ><i class="bi bi-x-circle"></i> Not Approve</button>
                  </div>
                </div>
                <?php } ?>
                <div class="col-lg-12">
                  <div style="position: relative;height: 400px;overflow: auto;display: block;">
                    <table class="tabel" id="tb_data" style="min-width:1000px;font-size: 12px;">
                      <thead>
                        <th style="width: 60px;"><button type="button" class="btn btn-sm btn-light" id="ADD_ITEM"><i class="bi bi-plus-square"></i></button></th>
                        <th style="width: 170px;">Kode Barang</th>
                        <th style="width: 60px;"></th>
                        <th style="width: 250px;">Deskripsi</th>
                        <th style="width: 90px;">Stok di Sistem</th>
                        <th style="width: 90px;">Stok Aktual</th>
                        <th style="width: 90px;">Jml Barang</br>Bagus</th>
                        <th style="width: 90px;">Jml Barang</br>Jelek</th>
                      </thead>
                      <tbody >
                          
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

      </div>

    </div>

    <!-- Basic Modal -->
      <div class="modal fade" id="modal_barang" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-12">
                    <table id="tb_barang" class="table table-bordered table-striped" style="font-size:12px;width:100%;">
                      <thead>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_laborat" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-12">
                    <table id="tb_laborat" class="table table-bordered table-striped" style="font-size:12px;width:100%;">
                      <thead>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div>
      <!-- End Basic Modal-->
  </section>

</main>
<script src="<?php echo base_url('/assets/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/datepicker/gijgo.min.js'); ?>" type="text/javascript"></script>
<script>
  var indexRow
  var save_method='save';
  var id_data;
  var data_not_in="'XYZ'";
  ACTION_MENU()
  BUTTON_ACTION(true)
  $("#BTN_SAVE").attr('disabled', false)
  $("#BTN_BATAL").attr('disabled', false)

  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
  $('.datepicker').datepicker({
      uiLibrary: 'bootstrap4',
      iconsLibrary: 'bootstrapicons',
      showOnFocus: true, showRightIcon: false,
      format: 'dd-mmm-yyyy',
      maxDate: function () {
          return $('#endDate').val();
      }
  });
  
  <?php    
    if(@$id){
  ?>
      REFRESH_DATA('<?php echo $id; ?>')
      

      BUTTON_ACTION(false)
      
      $("#BTN_SAVE").attr('disabled', true)
      $("#BTN_BATAL").attr('disabled', true)

  <?php } ?>

  function CONTROL_NEW(param){

    $("#BTN_LAB").attr('disabled',param)
    $("#ADD_ITEM").attr('disabled',param)
    $(".delRow").attr('disabled',param)

    $("[name='keterangan']").attr('disabled',param)
    $(".showItem").attr('disabled', param)
    // $("[name='stock_sistem[]']").attr('readonly', param)
    $("[name='stock_actual[]']").attr('readonly', param)
    $("[name='qty_bagus[]']").attr('readonly', param)
    $("[name='qty_rusak[]']").attr('readonly', param)
  }

  $("#BTN_NEW").click(function(){
    event.preventDefault();
    window.location.href = '<?php echo site_url('Monitoring/addData') ?>';

  })

  $("#BTN_EDIT").click(function(){
    event.preventDefault();
    save_method='edit';
    id_data = $("[name='id_monitoring']").val()
    BUTTON_ACTION(true)

    $("#BTN_SAVE").attr('disabled', false)
    $("#BTN_BATAL").attr('disabled', false)
    $("#BTN_APPROVE").attr('disabled', true)
    $("#BTN_NOT_APPROVE").attr('disabled', true)
    $("[name='stock_actual[]']").attr('readonly', false)
    $("[name='qty_bagus[]']").attr('readonly', false)
    $("[name='qty_rusak[]']").attr('readonly', false)
  })

  $("#BTN_LAB").on("click",function() {
    event.preventDefault();
    tb_laborat = $('#tb_laborat').DataTable( {
        "order": [[ 0, "asc" ]],
        "pageLength": 25,
        "bInfo" : false,
        "bDestroy": true,
        "select": true,
        "ajax": {
            "url": "<?php echo site_url('Peminjaman/getDataLab') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_laborat" },{ "data": "deskripsi" }
        ]
    });

    $("#modal_laborat").modal('show')
  });

  $('body').on( 'dblclick', '#tb_laborat tbody tr', function (e) {
      var Rowdata = tb_laborat.row( this ).data();

      $("[name='id_laborat']").val(Rowdata.id_laborat);
      $("[name='nm_laborat']").val(Rowdata.deskripsi);
      
      $('#modal_laborat').modal('hide');
  });

  $("#tb_data").on("click", "tbody tr .showItem", function() {
    event.preventDefault();
    indexRow = $(this).closest('td').parent()[0].sectionRowIndex

    tb_barang = $('#tb_barang').DataTable( {
        "order": [[ 1, "asc" ]],
        "pageLength": 25,
        "bInfo" : false,
        "bDestroy": true,
        "select": true,
        "ajax": {
            "url": "<?php echo site_url('Monitoring/getDataBarang') ?>",
            "type": "POST",
            "data": {
                        id_laborat: $("[name='id_laborat']").val()
                    }
        },
        "columns": [
            { "data": "id_barang" },{ "data": "nama_barang" }
            ,{ "data": "stock" }
            ,{ "data": "foto",
              render: function (data, type, row, meta) {
                  if(data){
                    return "<a target='_blank' href='<?php echo base_url() ?>assets/images/barang/"+data+"'><img  style='max-width: 120px;' class='img-fluid' src='<?php echo base_url() ?>assets/images/barang/"+data+"' ></a>";
                  }else{
                    return "No File"
                  }
              }
            }
        ]
    });

    $("#modal_barang").modal('show')
  });

  $('body').on( 'dblclick', '#tb_barang tbody tr', function (e) {
      var Rowdata = tb_barang.row( this ).data();

      var id_barang = $("[name='id_barang[]']");
      data_not_in = "'XYZ'";
      for (var i = 0; i <id_barang.length; i++) {
        if (id_barang[i].value != '') {
          data_not_in  +=  ",'"+id_barang[i].value+"'";
        }
      }

      if (data_not_in.indexOf(Rowdata.id_barang) < 0) {
        $("[name='id_barang[]']").eq(indexRow).val(Rowdata.id_barang);
        $("#tb_data tbody tr:eq("+indexRow+") td:eq(3)").text(Rowdata.nama_barang);
        $("[name='stock_sistem[]']").eq(indexRow).val(Rowdata.stock);
      }else{
        alert("Item sudah ada di list");
        return;
      }
      $('#modal_barang').modal('hide');
  });

  $("#ADD_ITEM").click(function(){
    event.preventDefault();
    if($("[name='id_laborat']").val() == ""){
      alert('Pilih Laborat terlebih dahulu')
      return
    }
    row = '<tr>'+
              '<td style="text-align:center;"><button type="button" class="btn btn-sm btn-danger delRow"><i class="bi bi-x-square"></i></button></td>'+
              '<td><input type="text" class="form-control" name="id_barang[]" readonly required></td>'+
              '<td style="text-align:center;"><button class="btn btn-sm btn-outline-secondary showItem" ><i class="bi bi-list-task"></i></button></td>'+
              '<td></td>'+
              '<td><input type="text" class="form-control" name="stock_sistem[]" readonly onkeypress="return onlyNumberKey(event)" required ></td>'+
              '<td><input type="text" class="form-control" name="stock_actual[]" onkeypress="return onlyNumberKey(event)" required ></td>'+
              '<td><input type="text" class="form-control" name="qty_bagus[]" onkeypress="return onlyNumberKey(event)" required></td>'+
              '<td><input type="text" class="form-control" name="qty_rusak[]" onkeypress="return onlyNumberKey(event)" required></td>'+
          '</tr>';
    $("#tb_data tbody").append(row);
  })

  $("#tb_data").on("click", "tbody tr .delRow", function() {
    event.preventDefault();
    if(!confirm('Delete this data?')) return
      indexRow = $(this).closest('td').parent()[0].sectionRowIndex
      $("#tb_data tbody tr:eq("+indexRow+")").remove();
      
  });

  $("#BTN_SAVE").click(function(){
    event.preventDefault();
    var formData = $("#FRM_DATA").serialize();
    
    if(save_method == 'save') {
        urlPost = "<?php echo site_url('Monitoring/saveData') ?>";
    }else{
        urlPost = "<?php echo site_url('Monitoring/updateData') ?>";
        formData+="&id_monitoring="+id_data
    }
    // console.log(formData)
    ACTION(urlPost, formData)
  })

  function ACTION(urlPost, formData){
    $.ajax({
        url: urlPost,
        type: "POST",
        data: formData,
        dataType: "JSON",
        success: function(data){
          console.log(data)
          if (data.status == "success") {
            REFRESH_DATA(data.DOC_NO)
            toastr.info(data.message)
            $("[name='id_pengaduan']").val(data.DOC_NO)

            CONTROL_NEW(true)

            BUTTON_ACTION(false)
            $("#BTN_SAVE").attr('disabled', true)
            $("#BTN_BATAL").attr('disabled', true)

            
          }else{
            toastr.error(data.message)
          }
        }
    })
  }

  function REFRESH_DATA(id){
    var arr = [];var noRow=0;var rowData = '';
      $("#tb_data tbody tr").remove();
      $.ajax({
          url : "<?php echo site_url('Monitoring/getDataHdr') ?>",
          type: "POST",
          dataType: "JSON",
          data: {id_monitoring: id},
          success: function(data){
              // console.log(data);
              $("[name='id_monitoring']").val(data[0]['id_monitoring']);
              $("[name='tgl_monitoring']").val(data[0]['tgl_monitoring']);
              $("[name='no_induk']").val(data[0]['no_induk']);
              $("[name='nama']").val(data[0]['nama']);
              $("[name='status']").val(data[0]['status']);
              $("[name='keterangan']").val(data[0]['keterangan']);
              $("[name='id_laborat']").val(data[0]['id_laborat']);
              $("[name='nm_laborat']").val(data[0]['nm_laborat']);
              if (data[0]['status']=="Proses") {
                $("#BTN_APPROVE").attr('disabled',false);
                $("#BTN_NOT_APPROVE").attr('disabled',false);
              }else{
                $("#BTN_APPROVE").attr('disabled',true);
                $("#BTN_NOT_APPROVE").attr('disabled',true);
                $("#BTN_EDIT").attr('disabled',true);
                $("#BTN_DELETE").attr('disabled',true);
              }
          }
      });

      $.ajax({
          url : "<?php echo site_url('Monitoring/getDataItems') ?>",
          type: "POST",
          dataType: "JSON",
          data: {
            id_monitoring: id
          },
          success: function(data){
            
              $.each(data, function(index, value){
                
                noRow = index+1;
                rowData = '<tr>'+
                              '<td style="text-align:center;"><button type="button" class="btn btn-sm btn-danger delRow"><i class="bi bi-x-square"></i></button></td>'+
                              '<td><input type="text" class="form-control" name="id_barang[]" value="'+value['id_barang']+'" readonly required></td>'+
                              '<td style="text-align:center;"><button class="btn btn-sm btn-outline-secondary showItem" ><i class="bi bi-list-task"></i></button></td>'+
                              '<td>'+value['nama_barang']+'</td>'+
                              '<td><input type="text" class="form-control" value="'+value['stock_sistem']+'" name="stock_sistem[]" readonly onkeypress="return onlyNumberKey(event)" required ></td>'+
                              '<td><input type="text" class="form-control" value="'+value['stock_actual']+'" name="stock_actual[]" onkeypress="return onlyNumberKey(event)" required ></td>'+
                              '<td><input type="text" class="form-control" value="'+value['qty_bagus']+'" name="qty_bagus[]" onkeypress="return onlyNumberKey(event)" required></td>'+
                              '<td><input type="text" class="form-control" value="'+value['qty_rusak']+'" name="qty_rusak[]" onkeypress="return onlyNumberKey(event)" required></td>'+
                          '</tr>';
                          $("#tb_data tbody").append(rowData);
              });

              
              CONTROL_NEW(true)
          }
      });
  }


</script>