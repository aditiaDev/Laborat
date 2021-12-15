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
                        <td style="width: 110px;">No Pengadaan</td>
                        <td><input type="text" class="form-control" name="id_pengadaan" value="<New>" readonly></td>
                        <td>Tanggal</td>
                        <td><input type="text" class="form-control" name="tgl_pengajuan" readonly value="<?php echo date('d-M-Y'); ?>"></td>
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
                    <table class="tabel" id="tb_data" style="width:1200px;font-size: 12px;">
                      <thead>
                        <th style="width: 60px;"><button type="button" class="btn btn-sm btn-light" id="ADD_ITEM"><i class="bi bi-plus-square"></i></button></th>
                        <th style="width: 170px;">Item No</th>
                        <th style="width: 60px;"></th>
                        <th style="width: 300px;">Description</th>
                        <th style="width: 170px;">Qty Pengajuan</th>
                        <th>Qty di Setujui</th>
                        <th style="width: 190px;">Harga</th>
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
                        <th>Stock Tersedia</th>
                        <th>Harga Pembelian terakhir</th>
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
  
  <?php    
    if(@$id){
  ?>
      // REFRESH_DATA('<?php echo $id; ?>')
      

      BUTTON_ACTION(false)
      
      $("#BTN_SAVE").attr('disabled', true)
      $("#BTN_BATAL").attr('disabled', true)

  <?php } ?>

  $("#BTN_NEW").click(function(){
    event.preventDefault();
    window.location.href = '<?php echo site_url('Pengadaan/addData') ?>';

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
            "url": "<?php echo site_url('Pengadaan/getDataBarang') ?>",
            "type": "POST",
            "data": {
                        id_laborat: $("[name='id_laborat']").val()
                    }
        },
        "columns": [
            { "data": "id_barang" },{ "data": "nama_barang" }
            ,{ "data": "stock_tersedia" },{ "data": "harga_beli" }
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
        $("[name='harga[]']").eq(indexRow).val(Rowdata.harga_beli);
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
              '<td><input type="text" class="form-control" name="qty_pengajuan[]" onkeypress="return onlyNumberKey(event)" required ></td>'+
              '<td><input type="text" class="form-control" name="qty_approved[]" onkeypress="return onlyNumberKey(event)" readonly required ></td>'+
              '<td><input type="text" class="form-control" name="harga[]"  ></td>'+
          '</tr>';
    $("#tb_data tbody").append(row);
  })

  $("#tb_data").on("click", "tbody tr .delRow", function() {
    event.preventDefault();
    if(!confirm('Delete this data?')) return
      indexRow = $(this).closest('td').parent()[0].sectionRowIndex
      $("#tb_data tbody tr:eq("+indexRow+")").remove();
      
  });
</script>