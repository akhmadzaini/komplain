<?php

class Test_theme extends CI_Controller{
	function __construct(){
		parent::__construct();
		// $this->custom_js='test_theme.js';
	}
	function limaratus(){
		$this->load->view('500');
	}
	function daftar_unit(){
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Examples</a></li>
		<li class="active">500 error</li>
		';
		$this->load->view('laman/daftar_unit', $data);
	}	
	function status_komplain(){
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Examples</a></li>
		<li class="active">500 error</li>
		';
		$this->load->view('laman/status_komplain', $data);
	}
}
