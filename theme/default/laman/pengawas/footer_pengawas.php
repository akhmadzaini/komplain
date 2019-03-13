<script src="<?=base_url()?>theme/default/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url()?>theme/default/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>theme/default/plugins/chart.js/Chart.min.js"></script>
<script src="<?=base_url()?>theme/default/plugins/chart.js/Chart.PieceLabel.js"></script>
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

	    // Memastikan unit terisi
	    $('#frm-filter select[name="unit_id"]').prop('required',true);

	    $(document).on('submit', '#frm-filter', function(e){
	    	e.preventDefault();
	    	$('.overlay').show();
	    	var data = $(this).serialize();
	    	var url = '<?=site_url("json/get_kategori_layanan")?>';
	    	$.post(url, data, function(hasil){
	    		$('.overlay').hide();
	    		refreshSumm();
    			$('#areaGrafik').empty();
	    		$.each(hasil, function(k, v){
	    			addAreaGrafik(v.id, v.nama);
	    		});
	    	});
	    });

	    $(document).on('click', '.btn-cetak', function(){
	    	var tgl = $('#frm-filter input[name="tgl"]').val();
	    	var unit_id = $('#frm-filter select[name="unit_id"]').val();
	    	var tabel = '<?=$tabel?>';
	    	if((tgl == '') || (unit_id == '')){
	    		alert('Lengkapi data penyaringan dengan mengisi rentang waktu dan unit');
	    	}else{
	    		window.open('<?php echo site_url("laporan/kinerja_unit") ?>?tgl=' + tgl + 
	    			'&unit_id=' + unit_id + '&tabel=' + tabel);
	    	}
	    });

	    var addAreaGrafik = function(id, nama){
	    	$('#areaGrafik').append('\
	    		<div class="col-md-6">\
			      	<div class="box box-primary ">\
			      		<div class="box-header with-border">\
			      			<h3 class="box-title">'+ nama +'</h3>\
			              <div class="box-tools pull-right">\
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>\
			                </button>\
			              </div>\
			      		</div>\
			      		<div class="box-body" id="box-'+ id +'">\
			      			Sedang menghitung setatistik ...\
			      		</div>\
			          \
			          <div class="overlay overlay-'+ id +'" style="display: none;">\
			            <i class="fa fa-refresh fa-spin"></i>\
			          </div>\
			        </div>\
			    </div>\
	    		');
	    	$('.overlay-' + id).show();
	    	var unit_id = $('#frm-filter select[name="unit_id"]').val();
	    	var tgl = $('#frm-filter input[name="tgl"]').val();
	    	getDataGrafik(unit_id, id, tgl);
	    }

	    var getDataGrafik = function(unit_id, proses, tgl){
	    	var komplainTotal = getKomplainCount(unit_id, proses, tgl, '');
	    	var komplainTerbuka = getKomplainCount(unit_id, proses, tgl, '0');
	    	var komplainProses = getKomplainCount(unit_id, proses, tgl, '1');
	    	var komplainTertutup = getKomplainCount(unit_id, proses, tgl, '2');
	    	var rating0 = getKomplainCount(unit_id, proses, tgl, '2', 0);
	    	var rating1 = getKomplainCount(unit_id, proses, tgl, '2', 1);
	    	var rating2 = getKomplainCount(unit_id, proses, tgl, '2', 2);
	    	var rating3 = getKomplainCount(unit_id, proses, tgl, '2', 3);
	    	var rating4 = getKomplainCount(unit_id, proses, tgl, '2', 4);
	    	var html = '<div class="col-md-6" id="canvas-holder"><canvas id="graph-komplain-'+ proses +'" width="400" height="400"/></div>\
	    	<div class="col-md-6" id="canvas-holder"><canvas id="graph-rating-'+ proses +'" width="400" height="400"/></div>\
	    	<p>&nbsp;</p>\
	    	<div class="col-md-12">'+ boxKepuasan(komplainTertutup, rating0, rating1, rating2, rating3, rating4) +'</div>\
	    	';
	    	$('#box-' + proses).html(html);
	    	$('.overlay-' + proses).hide();
	    	genChartKomplain(proses, komplainTerbuka, komplainProses, komplainTertutup);
	    	genChartRating(proses, rating0, rating1, rating2, rating3, rating4);
	    }

	    var getKomplainCount = function(unit_id, proses, tgl, status, rating = ''){
	    	var data = {
	    		unit_id : unit_id,
	    		proses : proses,
	    		tgl : tgl,
	    		status : status,
	    		tabel: '<?=$tabel?>',
	    		rating: rating
	    	}
	    	var rtr = '';
	    	$.ajax({
     			type: 'POST',
     			url: '<?=site_url("json/get_komplain_count")?>',
     			data: data,
     			async: false,
     			success: function(hasil){
     				rtr = hasil;
     			}
     		});
	    	return rtr;
	    }

		var refreshSumm = function(){		
			// menghitung summary komplain
			// menghitung total komplain
			var unit_id = $('#frm-filter select[name="unit_id"]').val();
	    	var tgl = $('#frm-filter input[name="tgl"]').val();
			var data = {tabel : '<?=$tabel?>', unit_id : unit_id, tgl : tgl};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summTotalKomplain').html(hasil);
			});
			// menghitung komplain terbuka
			var data = {tabel : '<?=$tabel?>', unit_id : unit_id, tgl : tgl, status : 0};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summKomplainTerbuka').html(hasil);
			});
			// menghitung komplain dalam proses
			var data = {tabel : '<?=$tabel?>', unit_id : unit_id, tgl : tgl, status : 1};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summKomplainProses').html(hasil);
			});
			// menghitung komplain tertutup
			var data = {tabel : '<?=$tabel?>', unit_id : unit_id, tgl : tgl, status : 2};
			var url = '<?=site_url('json/get_komplain_count')?>';
			$.post(url, data, function(hasil){
				$('#summKomplainTertutup').html(hasil);
			});
		};

		var prosenKepuasan = function(t, r0, r1, r2, r3, r4){
			var total = t * 4;
			var rTotal = (r0 * 0) + (r1 * 1) + (r2 * 2) + (r3 * 3) + (r4 * 4);
			var persen = (rTotal / total) * 100;
			return persen.toFixed(2);
		}

		var prosen = function(t, r){
			var persen = (r / t) * 100;
			return persen.toFixed(2);
		}

		var boxKepuasan = function(t, r0, r1, r2, r3, r4){
			var _prosen = prosenKepuasan(t, r0, r1, r2, r3, r4);
			return '<div class="info-box bg-aqua">\
			<span class="info-box-icon bg-aqua"><i class="fa fa-thumbs-o-up"></i></span>\
			<div class="info-box-content">\
              <span class="info-box-text">Tingkat Kepuasan</span>\
              <span class="info-box-number">'+ _prosen +' %</span>\
            </div>';
		}

		var optionDoughnut = {
		  pieceLabel: {
		    render: 'percentage',
		    // render: 'value',
		    // fontSize: 14,
		    fontStyle: 'bold',
		    fontColor: '#fff',
		  }
		};
				

		var genChartKomplain = function(idProses, terbuka, proses, tertutup){
			var doughnutData = {
				labels: ['Terbuka', 'Proses', 'Tertutup'],
				datasets: [{
					label: '# Status layanan',
					data: [terbuka, proses, tertutup],
					backgroundColor: ['#cd331c', '#ffc22f', '#44b21a']
				}], 
			};
			var ctx = document.getElementById('graph-komplain-' + idProses).getContext("2d");
			var ch = new Chart(ctx,{
			    type: 'doughnut',
			    data: doughnutData,
				options: optionDoughnut,  
			});
		}

		var genChartRating = function(idProses, r0, r1, r2, r3, r4){
			var doughnutData = {
					labels: ['Rating 0', 'Rating 1', 'Rating 2', 'Rating 3', 'Rating 4'],
					datasets: [{
						label: '# Rating',
						data: [r0, r1, r2, r3, r4],
						backgroundColor: ['#6068d1', '#cd331c', '#2cc1a3', '#f706c3', '#3a8626']
					}], 
				};
			var ctx = document.getElementById('graph-rating-' + idProses).getContext("2d");
			var ch = new Chart(ctx,{
			    type: 'doughnut',
			    data: doughnutData,
		    	options: optionDoughnut,
			});
		}		


	});
</script>