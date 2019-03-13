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
              
              <input type="hidden" name="id" value="">

              <div class="form-group">
                <label>Tanggal tindak lanjut :</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" required="" name="tgl">
                  </div>                
                </div>

              <div class="form-group">
                <label>Petugas :</label>
                <!--<input type="text" class="form-control" name="pic" placeholder="Nama petugas yang dikirim" required="">-->
                <?=combo_pic()?>
              </div>

              <div class="form-group">
                <label>Keterangan :</label>
                <textarea name="isi" id="" cols="30" rows="5" class="form-control" placeholder="Tulis keterangan yang diperlukan disini"></textarea>
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
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-flat btn-primary btn-ajukan">Tangani komplain ini</button>
        </div>
      </div>
      <!-- /.modal-content -->

    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<script>


  $(function(){

    $(document).on('click', '.btn-respon', function(e){
      var id = $(this).data('id');
      var disable = $(this).data('disabled');
      $('#frm-respon input[name="id"]').val(id);
      $('#modal-respon').modal('show');
      $('.overlay').show();
      var data = {'id' : id};
      var url = '<?=site_url('json/get_tangani_komplain')?>';
      $.post(url, data, function(hasil){
        $('#frm-respon input[name="tgl"]').val(hasil.ex_tgl);
        $('#frm-respon select[name="pic"]').val(hasil.ex_pic_nama).trigger('change');
        $('#frm-respon textarea[name="isi"]').val(hasil.ex_isi);
        $('.overlay').hide();
        // console.log(hasil);
      });
    });

    $(document).on('submit', '#frm-respon', function(e){
      $('.overlay').show();
      e.preventDefault();
      var data = $('#frm-respon').serialize();
      var url = "<?=site_url('json/tangani_komplain')?>";
      $.post(url, data, function(hasil){
        if(hasil.affected_rows > 0){
          alert('Tindak lanjut pada unit anda telah terekam di database kami');
        }
        $('.overlay').hide();
        $('#frm-filter').trigger('submit');
        $('#modal-respon').modal('hide');
      });
    });

  });
</script>