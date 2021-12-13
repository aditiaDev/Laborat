<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Peminjaman</h5>
                            
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                  <tr style="text-align: center;">
                    <th >ID</th>
                    <th>Periode</th>
                    <th >Tanggal Pengajuan</th>
                    <th >Tanggal Peminjaman</th>
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
      <div class="modal fade" id="modal_kembali" tabindex="-1">
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
                      <label>ID Peminjaman</label>
                      <input type="text" class="form-control" name="id_peminjaman" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Tanggal Kembali</label>
                      <input type="text" class="form-control datepicker" name="tgl_kembali" onchange="hitungSelisihHari()">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>No Induk</label>
                      <input type="text" class="form-control" name="no_induk" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nama Peminjam</label>
                      <input type="text" class="form-control" name="nama" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Tanggal pinjam</label>
                      <input type="text" class="form-control" name="pinjam_mulai" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Sampai</label>
                      <input type="text" class="form-control" name="pinjam_sampai" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Keterlambatan (hari)</label>
                      <input type="text" class="form-control" name="hari_terlambat" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Denda</label>
                      <input type="text" class="form-control" name="denda_keterlambatan" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Remark Pengembalian</label>
                      <textarea name="ket_kembali" class="form-control"></textarea>
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
  <script src="<?php echo base_url('/assets/datepicker/gijgo.min.js'); ?>" type="text/javascript"></script>
  <script>
    var save_method;
    var id_data;

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    console.log(today)
    $('.datepicker').datepicker({
      uiLibrary: 'bootstrap4',
      iconsLibrary: 'bootstrapicons',
      showOnFocus: true, showRightIcon: false,
      minDate: today,
      format: 'dd-mmm-yyyy',
      maxDate: function () {
          return $('#endDate').val();
      }
    });

    $(function(){
      REFRESH_DATA()
    })

    function hitungSelisihHari(tgl1, tgl2){
      tgl1 = $("[name='pinjam_sampai']").val()
      tgl2 = $("[name='tgl_kembali']").val()
      // varibel miliday sebagai pembagi untuk menghasilkan hari
      var miliday = 24 * 60 * 60 * 1000;
      //buat object Date
      var tanggal1 = new Date(tgl1);
      var tanggal2 = new Date(tgl2);
      // console.log(tanggal1)
      // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
      var tglPertama = Date.parse(tanggal1);
      var tglKedua = Date.parse(tanggal2);
      var selisih = (tglKedua - tglPertama) / miliday;
      
      // return selisih;
      if(selisih < 0){
        selisih = 0
      }
      var denda = parseInt(selisih * 5000)
      $("[name='hari_terlambat']").val(selisih)
      $("[name='denda_keterlambatan']").val(denda)
    }

    function REFRESH_DATA(){
      $('#tb_data').DataTable().destroy();
      tb_data =  $("#tb_data").DataTable({
          "order": [[ 2, "desc" ], [ 0, "asc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('Pengembalian/getAllData') ?>",
              "type": "POST",
          },
          "columns": [
              { "data": "id_peminjaman" },
              { "data": "periode"},
              { "data": "tgl_pengajuan"},
              { "data": "tgl_peminjaman"},
              { "data": "keterangan"},
              { "data": "status"},
              { "data": null, 
                "render" : function(data){
                  // console.log(data)
                  if(data.status == "Approved"){
                    return "<button class='btn btn-sm btn-warning BTN_KEMBALI' title='Pengembalian'>Kembali</button>"
                  }else{
                    return ""
                  }
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

    $("#tb_data tbody").on("click", ".BTN_KEMBALI", function() {
      event.preventDefault();
      // var Rowdata = tb_data.row( this ).data();
      var data = tb_data.row( $(this).parents('tr') ).data();
      console.log(data)
      $("[name='id_peminjaman']").val(data.id_peminjaman)
      $("[name='no_induk']").val(data.no_induk)
      $("[name='nama']").val(data.nama)
      $("[name='pinjam_mulai']").val(data.pinjam_mulai)
      $("[name='pinjam_sampai']").val(data.pinjam_sampai)

      $("#modal_kembali").modal('show')
    })

  </script>