<script src="<?=base_url()?>theme/default/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
	$(function(){

		// inisiasi select2
		$('select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

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
	    });

		// action pada saat submit filter
		$(document).on('submit', '#frm-filter', function(e){
			e.preventDefault();
			$('.overlay').show();
			var data = $(this).serialize();
			<?php if($tabel == 'komplain_doskar'):?>
			var url = '<?=site_url("json/browse_komplain_doskar")?>';
			<?php else:?>
			var url = '<?=site_url("json/browse_komplain_mhs")?>';
			<?php endif?>
			$.post(url, data, function(hasil){
				var status = [];
				status[0] = '<span class="label label-danger"><i class="fa fa-folder-open" title="Terbuka"></i> Terbuka</span>',
				status[1] = '<span class="label label-warning"><i class="fa fa-hourglass-2" title="Proses"></i> Proses</span>',
				status[2] = '<span class="label label-success"><i class="fa fa-check-circle" title="Tertutup"></i> Tertutup</span>',

				tabel.clear();

				var n = 0;
				$.each(hasil, function(i, v){
					n++;
					var disabled = (v.status == 2) ? 'disabled' : '';
					var btnSupport = '';
					<?php if($tabel == 'komplain_doskar'):?>
						btnSupport = '<button class="btn btn-flat btn-xs btn-primary btn-respon" data-id="'+ v.id +'" title="Tangani komplain ini" data-disabled="'+ disabled +'"><i class="fa fa-support"></i></button>';
					<?php endif?>
					var btnGetKomplain = '<button class="btn btn-flat btn-xs btn-primary btn-get-komplain" data-id="'+ v.id +'" data-tabel="<?=$tabel?>" title="Periksa komplain ini" ><i class="fa fa-eye"></i></button>';
					var btnRespon = btnSupport + ' ' + btnGetKomplain;
					tabel.row.add([(n + '.'), v.pemohon, v.kategori, v.tgl, status[v.status], btnRespon]);					

				});

				tabel.draw();
				$('.overlay').hide();
				refreshSumm();
			});
		});

		var refreshSumm = function(){		
			// menghitung summary komplain
			// menghitung total komplain
			var data = {tabel : '<?=$tabel?>', unit_id : '<?=$this->session->unit_id?>'};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summTotalKomplain').html(hasil);
			});
			// menghitung komplain terbuka
			var data = {tabel : '<?=$tabel?>', unit_id : '<?=$this->session->unit_id?>', status : 0};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summKomplainTerbuka').html(hasil);
			});
			// menghitung komplain dalam proses
			var data = {tabel : '<?=$tabel?>', unit_id : '<?=$this->session->unit_id?>', status : 1};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summKomplainProses').html(hasil);
			});
			// menghitung komplain tertutup
			var data = {tabel : '<?=$tabel?>', unit_id : '<?=$this->session->unit_id?>', status : 2};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summKomplainTertutup').html(hasil);
			});
		};

		refreshSumm();
		$('#frm-filter').trigger('submit');

	});
</script>