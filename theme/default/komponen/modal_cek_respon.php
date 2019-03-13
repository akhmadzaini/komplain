<div class="modal fade" id="modal-respon" style="display: none;">
  <div class="modal-dialog">
    
    <form action="" id="frm-respon">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Tindak Lanjut Permohonan Komplain</h4>
        </div>

        <div class="modal-body">  

          <div class="box box-primary">
            <div class="box-body">
              

              <div class="form-group">
                <label>Tanggal tindak lanjut :</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" required="" name="tgl" disabled="">
                  </div>                
                </div>

              <div class="form-group">
                <label>Petugas :</label>
                <input type="text" class="form-control" name="pic" placeholder="Nama petugas yang dikirim" disabled="">
              </div>

              <div class="form-group">
                <label>Keterangan :</label>
                <textarea name="isi" id="" cols="30" rows="5" class="form-control" placeholder="Tulis keterangan yang diperlukan disini" disabled=""></textarea>
              </div>

            </div>
            <!-- /.box-body -->
    
            <div class="overlay" style="display: none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- /.overlay -->
    
          </div>
          <!--/.box-primary-->
        </div>
        <!--/.modal-body-->


        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Selesai</button>
        </div>
      </div>
      <!-- /.modal-content -->

    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<script>


  $(function(){

    $(document).on('click', '.btn-cek-respon', function(e){
      var id = $(this).data('id');
      $('#modal-respon').modal('show');
      $('.overlay').show();
      var data = {'id' : id};
      var url = '<?=site_url('json/get_tangani_komplain')?>';
      $.post(url, data, function(hasil){
        $('#frm-respon input[name="tgl"]').val(hasil.ex_tgl);
        $('#frm-respon input[name="pic"]').val(hasil.ex_pic_nama);
        $('#frm-respon textarea[name="isi"]').val(hasil.ex_isi);
        $('.overlay').hide();
        // console.log(hasil);
      });
    });

  });
</script>