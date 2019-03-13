<?php

function tgl_mysql($tgl){
	$tgl_tmp = explode('/', $tgl);
	return $tgl_tmp[2] . '-' . $tgl_tmp[1] . '-' . $tgl_tmp[0];
}

function tgl_app($tgl){
	$tgl_tmp = explode('-', $tgl);
	return $tgl_tmp[0] . '/' . $tgl_tmp[1] . '/' . $tgl_tmp[2];
}

// merubah tgl app menjadi display
function tgl_display($tgl){
	$tgl_tmp = explode('/', $tgl);
	$bln = array(
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'Nopember',
		'12' => 'Desember'
	);
	return $tgl_tmp[2] . ' ' . $bln[$tgl_tmp[1]] . ' ' . $tgl_tmp[0];
}

function status($id){
	$v = array( '0' => 'Terbuka',
				'1' => 'Proses',
				'2' => 'Tertutup');
	return $v[$id];
}

function akses($id){
	if($id != FALSE){	
		$acl[0] = 'Klien';
		$acl[1] = 'Pengawas';
		$acl[2] = 'Kepala Unit';
		return $acl[$id];
	}else{
		return 'Klien';
	}
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}