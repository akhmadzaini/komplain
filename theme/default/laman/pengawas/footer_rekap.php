<script src="<?=base_url()?>theme/default/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<style>

.chartjs-legend li {
  list-style: none;
  cursor:pointer;
  margin: 10px 4px;
}
.chartjs-legend li span {
  position:relative;
  padding: 5px 5px;
  color:white;
  z-index:2;
  margin-right: 10px;
}
	
</style>
<script>
	$(function(){

		// inisiasi date range picker
		$('.tgl-range').daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    }
		});

	    //Date picker
	    $('.datepicker').datepicker({
	      autoclose: true,
	      format: 'dd/mm/yyyy',
	    }).datepicker("setDate",'now');

	    // Memastikan unit terisi
	    $('#frm-filter select[name="unit_id"]').prop('required',true);

	    $(document).on('click', '.btn-cetak', function(){
	    	var tgl = $('#frm-filter input[name="tgl"]').val();
	    	var unit_id = $('#frm-filter select[name="unit_id"]').val();
	    	var tabel = '<?=$tabel?>';
	    	if((tgl == '') || (unit_id == '')){
	    		alert('Lengkapi data penyaringan dengan mengisi rentang waktu dan unit');
	    	}else{
	    		window.open('<?php echo site_url("laporan/rekap") ?>?tgl=' + tgl + '&tabel=' + tabel);
	    	}
	    });

	});
</script>