<?php

function acl_get(){
	$CI =& get_instance();
	$CI->db->select('akses');
	$CI->db->select('unit_id');
	$CI->db->where('doskar_id', $CI->session->login );
	$q = $CI->db->get('acl');
	return $q->row_array();
}