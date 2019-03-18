<div class="modal fade" id="modal-custom-komplain" style="display: none;">
  <div class="modal-dialog modal-lg">
    
    <form action="" id="frm-custom-komplain">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Pembuatan Komplain Khusus</h4>
        </div>

        <div class="modal-body">  

          <div class="alert alert-warning">
            <p>Fitur ini merupakan fitur pembantu, ketika klien kesulitan/tidak memungkinkan menerbitkan komplain baru karena sesuatu hal. </p>
            <p>Setelah menerbitkan komplain baru, klien yang bersangkutan tetap diwajibkan untuk memberikan rating dan ulasan terhadap pelayanan yang telah diberikan.</p>
          </div>

          <div class="box box-primary">
            <div class="box-body">

              <div class="form-group">
                <label for="">Pemohon</label>
                <?=combo_doskar()?>
              </div>
              
              <div class="col-md-6">
                
                <div class="form-group">
                  <label for="">Tanggal komplain</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" required="" name="tgl">
                  </div>
                </div>

                <div class="form-group">
                  <label for="">Indikator/Kategori Layanan</label>
                  <?=combo_kategori_layanan($this->session->unit_id)?>
                </div>

                <div class="form-group">
                  <label for="">Deskripsi komplain</label>
                  <textarea name="isi"  class="form-control" required="" rows="3" placeholder="Tulis deskripsi komplain disini"></textarea>
                </div>

              </div>

              <div class="col-md-6">
                
                <div class="form-group">
                  <label for="">Tanggal penanganan</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" required="" name="ex_tgl">
                  </div>
                </div>

                <div class="form-group">
                  <label for="">Petugas yang menangani</label>
                  <?=combo_pic()?>
                </div>

                <div class="form-group">
                  <label for="">Deskripsi penanganan</label>
                  <textarea name="ex_isi"  class="form-control" required="" rows="3" placeholder="Tulis deskripsi penanganan disini"></textarea>
                </div>

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
          <button type="submit" class="btn btn-flat btn-primary ">Ajukan komplain</button>
        </div>
      </div>
      <!-- /.modal-content -->

    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<script>


  $(function(){

    $(document).on('click', '.btn-custom-komplain', function(e){
      $('#modal-custom-komplain').modal('show');
    });

    $(document).on('submit', '#frm-custom-komplain', function(e){
      $('.overlay').show();
      e.preventDefault();
      var data = $(this).serialize();
      var url = '<?=site_url('json/pengajuan_komplain_custom')?>';
      $.post(url, data, function(hasil){
        if(hasil.affected_rows > 0){
          $('#frm-filter').trigger('submit');
          alert('Pengajuan ini telah tersimpan dalam database, selanjutnya silahkan menghubungi klien untuk segera mendapatkan rating dan ulasan');
          $('.overlay').hide();
          $('#modal-custom-komplain').modal('hide');
        }
      });
    });

  });
</script>