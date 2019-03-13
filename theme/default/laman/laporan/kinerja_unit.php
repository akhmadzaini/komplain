<?php $this->load->view('laman/laporan/header') ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h1>Laporan kinerja unit</h1>
			<h2>Per <?=tgl_display(tgl_app($tgl_awal))?> s/d <?=tgl_display(tgl_app($tgl_akhir))?></h2>
		</div>
	</div>

	<div class="row">
		<h2>Ringkasan Keseluruhan</h2>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<td width="50%" class="text-center"><h3>Ringkasan Layanan</h3></td>
					<td width="50%" class="text-center"><h3>Ringkasan Penilaian</h3></td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>Terbuka : <?=$layanan[0]?> Layanan</li>
							<li>Proses : <?=$layanan[1]?> Layanan</li>
							<li>Tertutup : <?=$layanan[2]?> Layanan</li>
							<li>Total Permohonan : <?=$layanan['total']?> Layanan</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>Rating 0 : <?=$kualitas_layanan[0]?> Layanan</li>
							<li>Rating 1 : <?=$kualitas_layanan[1]?> Layanan</li>
							<li>Rating 2 : <?=$kualitas_layanan[2]?> Layanan</li>
							<li>Rating 3 : <?=$kualitas_layanan[3]?> Layanan</li>
							<li>Rating 4 : <?=$kualitas_layanan[4]?> Layanan</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="text-center">
						<h3>Kualitas Layanan : <?=$kualitas_layanan['prosen']?>%</h3>
					</td>
				</tr>
				<tr>
					<td class="text-center"><h3>Grafik Layanan</h3></td>
					<td class="text-center"><h3>Grafik Kualitas Layanan</h3></td>
				</tr>
				<tr>
					<td>
						<canvas id="chart-layanan"></canvas>
					</td>
					<td>
						<canvas id="chart-rating"></canvas>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h3>Grafik kinerja per kategori layanan</h3>
						<canvas id="chart-rating-all"></canvas>
					</td>
				</tr>
			</tbody>			
		</table>
	</div>
	<footer></footer>

	<div class="row">
		<?php foreach($layanan_ as $k => $r):?>
			<h2>Rincian Layanan <?=$r['nama']?></h2>

			<table class="table table-bordered">
				<tbody>
					<tr>
						<td width="50%" class="text-center"><h3>Ringkasan Layanan</h3></td>
						<td width="50%" class="text-center"><h3>Ringkasan Penilaian</h3></td>
					</tr>
					<tr>
						<td>
							<ul>
								<li>Terbuka : <?=$r['layanan'][0]?> Layanan</li>
								<li>Proses : <?=$r['layanan'][1]?> Layanan</li>
								<li>Tertutup : <?=$r['layanan'][2]?> Layanan</li>
								<li>Total Permohonan : <?=$r['layanan']['total']?> Layanan</li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Rating 0 : <?=$r['kualitas'][0]?> Layanan</li>
								<li>Rating 1 : <?=$r['kualitas'][1]?> Layanan</li>
								<li>Rating 2 : <?=$r['kualitas'][2]?> Layanan</li>
								<li>Rating 3 : <?=$r['kualitas'][3]?> Layanan</li>
								<li>Rating 4 : <?=$r['kualitas'][4]?> Layanan</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center">
							<h3>Kualitas Layanan : <?=$r['kualitas']['prosen']?>%</h3>
						</td>
					</tr>
					<tr>
						<td class="text-center"><h3>Grafik Layanan</h3></td>
						<td class="text-center"><h3>Grafik Kualitas Layanan</h3></td>
					</tr>
					<tr>
						<td>
							<canvas id="chart-layanan-<?=$k?>"></canvas>
						</td>
						<td>
							<canvas id="chart-rating-<?=$k?>"></canvas>
						</td>
					</tr>
				</tbody>			
			</table>

			<footer></footer>
		<?php endforeach?>
	</div>
</div>
<?php $this->load->view('laman/laporan/footer') ?>