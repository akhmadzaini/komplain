<?php

class Pengaturan extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=please_login'));
		}
		if($this->session->akses != 1){
			die('Anda tidak memiliki cukup ijin membuka halaman ini!');
		}
	}

	function unit(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-gears"></i> Pengaturan</a></li>
		<li class="active">Unit</li>
		';
		$data['judul'] = 'Pengaturan Konfigurasi Unit';
		$data['add_views'] = array('komponen/modal_pengaturan_unit');
		$this->load->view('laman/daftar_unit', $data);
	} 

	function pengawas(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-gears"></i> Pengaturan</a></li>
		<li class="active">Pengawas</li>
		';
		$data['judul'] = 'Pengaturan Akun Pengawas';
		// $data['add_views'] = array('komponen/modal_tambah_pengawas');
		$this->load->view('laman/daftar_pengawas', $data);
	}
}