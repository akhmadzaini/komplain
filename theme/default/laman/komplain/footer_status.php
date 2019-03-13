<?php $tabel = 'komplain_doskar'?>
<script src="<?=base_url()?>theme/default/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  $(function(){
    // inisiasi select2
    $('.select2').select2();

    // inisiasi date range picker
    $('.tgl-range').daterangepicker({
      startDate: moment().startOf('month'),
      endDate: moment().endOf('month'),
      locale: {
        format: 'DD/MM/YYYY'
      }
    });

    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
    }).datepicker("setDate",'now');  

    // inisiasi datatable
    var tabel = $('#table-status').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })

    // action pada saat submit filter
    $(document).on('submit', '#frm-filter', function(e){
      e.preventDefault();
      $('.overlay').show();
      var data = $(this).serialize();
      var url = '<?=site_url("json/browse_komplain_doskar")?>';
      $.post(url, data, function(hasil){
        var status = [];
        status[0] = '<span class="label label-danger"><i class="fa fa-folder-open" title="Terbuka"></i> Terbuka</span>',
        status[1] = '<span class="label label-warning"><i class="fa fa-hourglass-2" title="Proses"></i> Proses</span>',
        status[2] = '<span class="label label-success"><i class="fa fa-check-circle" title="Tertutup"></i> Tertutup</span>',

        tabel.clear();

        var n = 0;
        $.each(hasil, function(i, v){
          n++;
          var btnGetKomplain = '<button class="btn btn-flat btn-xs btn-primary btn-get-komplain" data-id="'+ v.id +'" data-tabel="<?=$tabel?>" title="Periksa komplain ini" ><i class="fa fa-eye"></i></button>';

          var disabled = (v.status != 1) ? 'disabled' : '';
          var btnTanggapan = '<button class="btn btn-flat btn-xs btn-primary btn-tanggapan" data-id="'+ v.id +'" title="Tanggapi penanganan" '+ disabled +'><i class="fa fa-star-half-o"></i></button>';

          var disabled = (v.status == 0) ? 'disabled' : '';
          var btnCekRespon = '<button class="btn btn-flat btn-xs btn-primary btn-cek-respon" data-id="'+ v.id +'" title="Periksa tindak lanjut unit" '+ disabled +'><i class="fa fa-support"></i></button>';

          var btnTindakan = btnGetKomplain + ' ' + btnTanggapan + ' ' + btnCekRespon;
          tabel.row.add([(n + '.'), v.unit, v.kategori, v.tgl, status[v.status], btnTindakan ]);
          

        });

        tabel.draw();
        $('.overlay').hide();
      });
    });

    $('#frm-filter').trigger('submit');


  });
</script>