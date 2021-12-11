
<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-xs-12 col-lg-12">
                <table class="table tb_no_top">
                  <tr>
                      <td>ID Transaksi</td>
                      <td><input type="text" class="form-control" name="id_peminjaman" readonly></td>
                      <td>Tanggal</td>
                      <td><input type="text" class="form-control datepicker" name="tgl_pengajuan" value="<?php echo date('d-M-Y'); ?>"></td>
                  </tr>
                  <tr>
                      <td>Pinjam</td>
                      <td><input type="text" class="form-control" name="id_supplier" readonly></td>
                      <td>Sampai</td>
                      <td><button class="btn btn-default" type="button" id="btn_supl"><i class="fas fa-list"></i></button></td>
                      <td colspan="2"><input type="text" class="form-control" name="nm_supplier" readonly></td>
                      <td>Status</td>
                      <td><input type="text" class="form-control" style="text-transform: uppercase;" name="status_pembelian" value="pengajuan" readonly></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

</main>