<script src="<?=base_url()?>theme/default/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>theme/default/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<div class="modal fade" id="modal-pengaturan-unit" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
        <!--<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        </div>-->

        <div class="modal-body">  

          <div class="box">
            
            <div class="box-body">

              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Pengaturan</a></li>
                  <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Layanan</a></li>
                </ul>

                <div class="tab-content">

                  <div class="tab-pane active" id="tab_1">
                    <form action="" id="frm-pengaturan-unit">
                    
                      <div class="form-group">
                        <label>Nama Unit</label>
                        <?=combo_unit()?>
                      </div>

                      <div class="form-group">
                        <label>Kepala Unit</label>
                        <?=combo_doskar()?>
                      </div>

                      <div class="form-group">
                        <label>No. Ekstensi</label>
                        <input type="text" class="form-control" name="ext" value="">
                      </div>


                      <button type="submit" class="btn btn-flat btn-primary btn-ajukan">Simpan</button>
                    </form>
                  </div>

                  <div class="tab-pane" id="tab_2">
                    <button class="btn btn-primary btn-flat" id="layanan-baru"><i class="fa fa-plus"></i> Baru</button>
                    <table class="table tabel-layanan">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Layanan</th>
                          <th>Tindakan</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                      
                    </table>
                  </div>
      
                </div>

              </div>
            
            </div>
            <!--/.box-body-->
            
            <div class="overlay" style="display: none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- /.overlay -->
          </div>
          <!--/.box-->

        </div>
        <!--/.modal-body-->


        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Selesai</button>
        </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-layanan-baru" style="display: none;">
  <div class="modal-dialog">
    
    <div class="modal-content">
      <form action="" id="frm-layanan-baru">
        
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="unit_id" value="">
            <label for="">Layanan</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama layanan">

          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-flat btn-primary" >Simpan</button>
        </div>

      </form>

    </div>
    <!--/.modal-content-->
  </div>
  <!--/.modal-dialog-->
</div>

<script>
  $(function(){

    // Inisialisasi awal
    $('.select2').select2();
    var tabelLayanan = $('.tabel-layanan').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });

    var refreshTabel = function(id){
      var url = '<?=site_url('json/get_proses')?>';
      var data = {'unit_id' : id};
      tabelLayanan.clear();
      $.get(url, data, function(hasil){
        var n = 0;
        $.each(hasil, function(idx, val){
          var tombolHapus = '<button class="btn btn-xs btn-flat btn-default btn-hapus-layanan" data-id="'+ 
          val.id +'"><i class="fa fa-trash"></i></button>';
          tabelLayanan.row.add([++n, val.nama, tombolHapus]);
        });
        tabelLayanan.draw();
      });
    }

    // Saat klik tambah modal baru
    $(document).on('click','#layanan-baru', function(){
      $('#modal-layanan-baru').modal('show');
    });
  

    // Saat tombol unit diklik
    $(document).on('click', '.btn-unit', function(e){
      e.preventDefault();
      var id = $(this).data('id');
      $('#modal-pengaturan-unit').modal('show');
      $('#frm-pengaturan-unit select[name="unit_id"]').val(id).trigger('change');
    });

    // Saat ada pergantian pilihan unit
    $(document).on('change', '#frm-pengaturan-unit select[name="unit_id"]', function(){
      $('.overlay').show();
      var id = $(this).val();
      var url = '<?=site_url("json/get_detail_unit")?>';
      $.post(url, {id : id}, function(hasil){
        $('#frm-pengaturan-unit select[name="doskar"]').val(hasil.doskar_id).trigger('change');
        $('#frm-pengaturan-unit input[name="ext"]').val(hasil.ext);
        refreshTabel(id);
        $('.overlay').hide();
      });
      $('input[name="unit_id"]').val(id);
    });

    // ketika submit pengaturan unit
    $(document).on('submit', '#frm-pengaturan-unit', function(e){
      e.preventDefault();
      $('.overlay').show();
      var data = $(this).serialize();
      var url = '<?=site_url("json/set_detail_unit")?>';
      // console.log(data);
      $.post(url, data, function(hasil){
        if(hasil == 'sukses'){
          $('.overlay').hide();
          alert('Data telah tersimpan');
          // $('#modal-pengaturan-unit').modal('hide');
        }
      });
    });

    // ketika submit pelayanan baru
    $(document).on('submit', '#frm-layanan-baru', function(e){
      e.preventDefault();
      $('#modal-layanan-baru').modal('hide');
      $('.overlay').show();
      var data = $(this).serialize();
      var url = '<?=site_url("json/add_proses")?>';
      $.post(url, data, function(e){
        // console.log(e);
        if(e == 'ok'){
          refreshTabel($('input[name="unit_id"]').val());
          $('.overlay').hide();
          $('#frm-layanan-baru input[name="nama"]').val('');
        }
      });
    });

    // Ketika menghapus layanan
    $(document).on('click', '.btn-hapus-layanan', function(e){
      if(confirm("Layanan akan dihapus ?")){      
        var data = {id : $(this).data('id')};
        var url = '<?=site_url("json/del_proses")?>';
        $('.overlay').show();
        $.get(url, data, function(hasil){
          console.log(hasil);
          if(hasil == 'ok'){
            refreshTabel($('input[name="unit_id"]').val());
          }else{
            alert('Layanan tdk dapat dihapus karena telah berisi komplain');
          }
          $('.overlay').hide();
        });
      }
    });

  });
</script>