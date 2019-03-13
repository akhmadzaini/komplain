<?php $this->load->view('laman/laporan/header') ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h1>Rekapitulasi Kinerja Unit</h1>
			<h2>Per <?=tgl_display(tgl_app($tgl_awal))?> s/d <?=tgl_display(tgl_app($tgl_akhir))?></h2>
		</div>
	</div>

	<div class="row">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Unit</th>
					<th>Tertutup</th>
					<th>R0</th>
					<th>R1</th>
					<th>R2</th>
					<th>R3</th>
					<th>R4</th>
					<th>Kualitas Layanan</th>
				</tr>
			</thead>
			<tbody>
				<?php array_sort_by_column($hasil, 'kualitas', SORT_DESC); ?>
				<?php foreach($hasil as $r): ?>
				<tr>
					<td><?=$r['nama']?></td>
					<td><?=$r['tertutup']?></td>
					<td><?=$r['r0']?></td>
					<td><?=$r['r1']?></td>
					<td><?=$r['r2']?></td>
					<td><?=$r['r3']?></td>
					<td><?=$r['r4']?></td>
					<td><?=$r['kualitas']?> %</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

</div>
<?php $this->load->view('laman/laporan/footer') ?>