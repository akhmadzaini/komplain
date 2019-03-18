<?php

function combo_unit(){
	$CI =& get_instance();
	$CI->db->select('id');
	$CI->db->select('nama');
	$CI->db->order_by('nama');
	$q = $CI->db->get('unit');
	$rtr = '<select name="unit_id" class="form-control select2" style="width: 100%;">';
	$rtr .= '<option value="">-- Pilih salah satu unit --</option>';
	foreach ($q->result_array() as $r){
		$rtr .= '<option value="'. $r['id'] .'">'. $r['nama'] .'</option>';
	}
	$rtr .= '</select>';
	return $rtr;
}

function tombol_unit_all(){
	$CI =& get_instance();
	$CI->db->select('id');
	$CI->db->select('nama');
	$CI->db->select('icon');
	$CI->db->select('ext');
	$CI->db->order_by('nama');
	$q = $CI->db->get('unit');
	$rtr = '<div id="glyphicons">
          <ul class="bs-glyphicons">';
    foreach ($q->result_array() as $r) {
    	$rtr .= '<a href="#" class="btn-unit" data-id="'. $r['id'] .'">
			<li>
                <span class="'. $r['icon'] .'"></span>
                <span class="glyphicon-class">'. $r['nama'] . ', ext : ' . $r['ext'] .'</span>
			</li>
    	</a>';
    }
    $rtr .= '</ul></div>';
    return $rtr;
}

function combo_status(){
	return '<select name="status" class="form-control select2" style="width: 100%;" >
		<option value="">-- Semuanya --</option>
		<option value="0">Terbuka</option>
		<option value="1">Proses</option>
		<option value="2">Tertutup</option>
	</select>';
}

function combo_doskar($option=''){
	// jika multi
	if(strpos($option, 'multi') === FALSE){
		$multi = 'name="doskar"';
	}else{
		$multi = 'name="doskar[]" multiple="multiple"';
	}

	$CI =& get_instance();
	$CI->db->select('id');
	$CI->db->select('nama');
	$CI->db->order_by('nama');
	$q = $CI->db->get('doskar');
	$rtr = '<select class="form-control select2" style="width: 100%;" '. $multi .' required>
			<option value="">-- Pilih salah satu pengguna --</option>';
	foreach($q->result_array() as $r){
		$rtr .= "<option value=\"$r[id]\">$r[nama] ($r[id])</option>";
	}
	$rtr .= '</select>';
	return $rtr;
}

function combo_kategori_layanan($id_unit){
	$CI =& get_instance();
	$CI->db->select('id');
	$CI->db->select('nama');
	$CI->db->where('unit_id', $id_unit);
	$CI->db->order_by('nama');
	$q = $CI->db->get('proses');
	$rtr = '<select name="proses_id" class="form-control select2" style="width: 100%;" required>
			<option value="">-- Pilih indikator/kategori layanan --</option>';
	foreach($q->result_array() as $r){
		$rtr .= "<option value=\"$r[id]\">$r[nama]</option>";
	}
	$rtr .= '</select>';
	return $rtr;
}

function combo_pic(){
	$CI =& get_instance();
	// $CI->db->select('id');
	$CI->db->select('nama');
	$CI->db->order_by('nama');
	$q = $CI->db->get('pic');
	$rtr = '<select name="pic" class="form-control select2" style="width: 100%;" required>
			<option value="">-- Petugas yang dikirim --</option>';
	foreach($q->result_array() as $r){
		$rtr .= "<option value=\"$r[nama]\">$r[nama]</option>";
	}
	$rtr .= '</select>';
	return $rtr;
}