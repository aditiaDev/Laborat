<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <form action="<?php echo base_url('Laporan/ctkPeminjaman') ?>" method="POST" target="_blank">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Laporan Monitoring Alat Lab</h5>
              <div class="row">
                  <div class="col-2" style="margin-bottom: 10px;">
                      <input type="text" class="form-control" name="start_date" placeholder="Dari">
                  </div>
                  <div class="col-2" style="margin-bottom: 10px;">
                      <input type="text" class="form-control" name="end_date"  placeholder="Sampai">
                  </div>
                  <div class="col-3" style="margin-bottom: 10px;">
                      <button class="btn btn-outline-success" id="proses"><i class="bi bi-printer"></i> Cetak</button>
                  </div>
              </div>
              
            </div>
          </div>
        </form>
      </div>

    </div>
  </section>

</main>
<script src="<?php echo base_url('/assets/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/datepicker/gijgo.min.js'); ?>" type="text/javascript"></script>
<script>

    $("[name='start_date']").datepicker({
      uiLibrary: 'bootstrap4',
      iconsLibrary: 'bootstrapicons',
      showOnFocus: true, showRightIcon: true,
      format: 'yyyy-mm-dd',
    });

    $("[name='end_date']").datepicker({
      uiLibrary: 'bootstrap4',
      iconsLibrary: 'bootstrapicons',
      showOnFocus: true, showRightIcon: true,
      format: 'yyyy-mm-dd',
    });

</script>