<div class="modal fade" id="modal-get-komplain" style="display: none;">
  <div class="modal-dialog">
    
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Periksa Permohonan Komplain</h4>
      </div>
      
      <form id="frm-get-komplain">
        <div class="modal-body">  

          <div class="box box-primary">
            <div class="box-body">

              <div class="form-group">
                <label>Deskripsi Komplain :</label>
                <textarea name="isi" rows="5" class="form-control" disabled=""></textarea>
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
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Selesai</button>
      </div>
    </div>
    <!-- /.modal-content -->

  </div>
  <!-- /.modal-dialog -->
</div>

<script>


  $(function(){

    $(document).on('click', '.btn-get-komplain', function(e){
      var id = $(this).data('id');
      var tabel = $(this).data('tabel');
      $('#modal-get-komplain').modal('show');
      $('.overlay').show();
      var data = {'id' : id, 'tabel' : tabel};
      var url = '<?=site_url('json/get_komplain')?>';
      $.post(url, data, function(hasil){
        $('#frm-get-komplain input[name="pemohon"]').val(hasil.pemohon);
        $('#frm-get-komplain input[name="tgl"]').val(hasil.tgl);
        $('#frm-get-komplain input[name="proses"]').val(hasil.kategori);
        $('#frm-get-komplain textarea[name="isi"]').val(hasil.isi);
        $('.overlay').hide();
      });
    });

  });
</script>