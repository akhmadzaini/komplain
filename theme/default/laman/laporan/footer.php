<script src="<?=base_url()?>/theme/default/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>theme/default/plugins/chart.js/Chart.min.js"></script>
<script src="<?=base_url()?>theme/default/plugins/chart.js/Chart.PieceLabel.js"></script>
<script src="https://chartjs-plugin-datalabels.netlify.com/chartjs-plugin-datalabels.js"></script>
<script>

	var genChart = function(idChart, terbuka, proses, tertutup){
		var doughnutData = {
			labels: ['Terbuka', 'Proses', 'Tertutup'],
			datasets: [{
				label: '# Status layanan',
				data: [terbuka, proses, tertutup],
				backgroundColor: ['#cd331c', '#ffc22f', '#44b21a']
			}], 
		};
		var ctx = document.getElementById(idChart).getContext("2d");
		var ch = new Chart(ctx,{
		    type: 'doughnut',
		    data: doughnutData,
			options: {
			  pieceLabel: {
			    render: 'percentage',
			    fontStyle: 'bold',
			    fontColor: '#fff',
			  },
			  legend: {
			  	position: 'right'
			  },
			  animation: false,
			},  
		});
	}

	var genChartRating = function(idChart, r0, r1, r2, r3, r4){
		var doughnutData = {
				labels: ['Rating 0', 'Rating 1', 'Rating 2', 'Rating 3', 'Rating 4'],
				datasets: [{
					label: '# Rating',
					data: [r0, r1, r2, r3, r4],
					backgroundColor: ['#6068d1', '#cd331c', '#2cc1a3', '#f706c3', '#3a8626']
				}], 
			};
		var ctx = document.getElementById(idChart).getContext("2d");
		var ch = new Chart(ctx,{
		    type: 'doughnut',
		    data: doughnutData,
	    	options: {
			  pieceLabel: {
			    render: 'percentage',
			    fontStyle: 'bold',
			    fontColor: '#fff',
			  },
			  legend: {
			  	position: 'right'
			  },
			  animation: false,
			},
		});
	}

	var prosenKepuasan = function(r0, r1, r2, r3, r4){
		var total = (r0 + r1 + r2 + r3 + r4) * 4;
		var rTotal = (r0 * 0) + (r1 * 1) + (r2 * 2) + (r3 * 3) + (r4 * 4);
		var persen = (rTotal / total) * 100;
		return persen.toFixed(2);
	}


	// var genChartDetail = function(){
	// 	var data_ = 
	// }
	
	$(function(){
		
		// cetak laporan
		window.print();
	});


</script>
</body>
</html>
