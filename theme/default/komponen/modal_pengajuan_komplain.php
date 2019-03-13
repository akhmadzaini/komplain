<div class="modal fade" id="modal-pengajuan-komplain" style="display: none;">
  <div class="modal-dialog">
    
    <form action="" id="frm-pengajuan-komplain">
      <input type="hidden" name="jenis" value="<?=$this->session->jenis?>">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Pengajuan Komplain</h4>
        </div>

        <div class="modal-body">  
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group">
                <label for="">Unit</label>
                <?=combo_unit()?>
              </div>
              <div class="form-group">
                <label for="">Indikator/Kategori</label>
                <select name="proses_id" class="form-control" required="">
                  <option value="">-- Pilih kategori komplain --</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="isi"  class="form-control" required=""></textarea>
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
          <button type="submit" class="btn btn-flat btn-primary btn-ajukan">Ajukan</button>
        </div>
      </div>
      <!-- /.modal-content -->

    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  $(function(){
    $(document).on('click', '.btn-unit', function(e){
      e.preventDefault();
      $('#modal-pengajuan-komplain').modal('show');
      var id = $(this).data('id');
      $('#frm-pengajuan-komplain select[name="unit_id"]').val(id);
      $('#frm-pengajuan-komplain textarea[name="isi"]').val('');
      $('#frm-pengajuan-komplain select[name="unit_id"]').trigger('change');
    });

    $(document).on('change', '#frm-pengajuan-komplain select[name="unit_id"]', function(e){
      $('.overlay').show();
      $('#frm-pengajuan-komplain select[name="proses_id"]').empty();
      $('#frm-pengajuan-komplain select[name="proses_id"]').append('<option value="">-- Pilih kategori komplain --</option>');
      
      var data = {
        'unit_id' : $(this).val()
      }
      var url = "<?=site_url('json/get_proses')?>";
      $.get(url, data, function(hasil){
        $.each(hasil, function(idx, val){
          $('#frm-pengajuan-komplain select[name="proses_id"]').append('<option value="'+ val.id +'">'+ val.nama +'</option>');
        });
        $('.overlay').hide();
      });
    });

    $(document).on('submit', '#frm-pengajuan-komplain', function(e){
      e.preventDefault();
      $('.overlay').show();     
      var data = $('#frm-pengajuan-komplain').serialize();
      var url = "<?=site_url('json/pengajuan_komplain')?>";
      $.post(url, data, function(hasil){
        console.log(hasil);
        if(hasil.affected_rows > 0){
          alert('Pengajuan anda telah tersimpan, mohon segera hubungi unit terkait untuk mendapatkan respon yang lebih cepat');
          $('.overlay').hide();
          $('#modal-pengajuan-komplain').modal('hide');   
        }
      });
    });

  });
</script>