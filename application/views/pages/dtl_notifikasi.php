<main id="main" class="main" style="/*margin-left: 250px;padding: 10px 20px;*/">

  <section class="section">
    <form id="FRM_DATA">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Details</h5>
              <table id="tb_data" class="table table-bordered table-striped" style="font-size:12px;">
                <?php echo $table; ?>
              </table>
              
            </div>
          </div>

        </div>

      </div>
    </form>
  </section>

</main>
<script src="<?php echo base_url('/assets/jquery/jquery.min.js'); ?>"></script>
<script>
  $(function(){
    $("#btnKirim").click(function(){
      var data = $("#FRM_DATA input[type='checkbox']").serializeArray();

      $.ajax({
          url: "<?php echo site_url('Dtl/send_pengembalian') ?>",
          type: "POST",
          data: $.param(data),
          dataType: "JSON",
          beforeSend: function(){
            $("#LOADER").show();
          },
          complete: function(){
            $("#LOADER").hide();
          },
          success: function(data){
            // console.log(data);
            if(data.status == "success") {
              toastr.info(data.message)
            }else{
              alert('Gagal Mengirim Pesan');
            }
          }
      });

    })
  })
</script>