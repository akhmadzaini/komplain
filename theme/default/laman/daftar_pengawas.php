
<?php $this->load->view('umum/header')?>
<?php $this->load->view('umum/nav')?>
<?php $this->load->view('umum/sidebar')?>

<div class="content-wrapper" style="min-height: 1126px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?=$judul?>
    </h1>
  
    <!--berubah-->
    <ol class="breadcrumb">
      <?=$breadcrumb?>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Akun Pengawas</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <button class="btn btn-flat btn-primary btn-tambah-pengawas" data-toggle="modal" data-target="#modal-tambah-pengawas"><i class="fa fa-plus"></i> Baru</button>
        <table class="table table-hover table-pengawas">
          <thead>
            <tr>
              <th>#</th>
              <th>Pengguna</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <!-- /.box-body -->

      <div class="overlay" style="display: none;">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
      <!-- /.overlay -->
    </div>
    <!-- /.box -->
    
    <?php if(!empty($komponen)) {$this->load->view('komponen/'.$komponen);}?>

  </section>
  <!-- /.content -->
</div>

<div class="modal fade" id="modal-tambah-pengawas" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
        <form action="" id="frm-tambah-pengawas">
          <div class="modal-body">
            <div class="form-group">
              <label>Pilih pengguna sebagai pengawas</label>
              <?=combo_doskar()?>
            </div>
          </div>
          <!--/.modal-body-->
          <div class="modal-footer">
            <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-flat btn-primary">Tambahkan</button>
          </div>
          <!--/.modal-footer-->
        </form>
      </div>
    </div>
</div>

<?php $this->load->view('umum/footer')?>
<script src="<?=base_url()?>theme/default/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>theme/default/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
  $(function(){
    // Inisialisasi awal
        var tabelPengawas = $('.table-pengawas').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
    $('.select2').select2();

    // saat diklik tombol simpan 
    $(document).on('submit', '#frm-tambah-pengawas', function(e){
      e.preventDefault();
      var data = $(this).serialize();
      var url = '<?=site_url("json/add_pengawas")?>';
      $.post(url, data, function(hasil){
        if(hasil == 'ok'){
          refreshTabel();
          $('#modal-tambah-pengawas').modal('hide');
        }
      });
    });

    // me refresh data di tabel
    var refreshTabel = function(){
      tabelPengawas.clear();
      tabelPengawas.draw();
      $.get('<?=site_url("json/get_pengawas")?>', {}, function(hasil){
        var no = 0;
        $.each(hasil, function(k, v){
          no++;
          var data = 'data-id = "'+ v.doskar_id +'"';
          var tindakan = '<button class="btn btn-xs btn-flat btn-default btn-hapus-pengawas" '+  data
          +'><i class="fa fa-trash"></i></button>';
          tabelPengawas.row.add([(no + '.'), v.nama, tindakan]);
        });
        tabelPengawas.draw();
      });
    }

    refreshTabel();

    $(document).on('click', '.btn-hapus-pengawas', function(){
      var id = $(this).data('id');
      var url = '<?=site_url('json/del_pengawas')?>';
      if(confirm('Data akan dihapus')){
        $.get(url, {id: id}, function(hasil){
          if(hasil == 'ok'){
            refreshTabel();
            alert('terhapus');
          }
        });        
      }
    });
    
  });
</script>