<?php

class Respon extends  CI_Controller{
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=please_login'));
		}

		// memastikan bahwa pengguna adalah kepala unit
		if($this->session->akses != 2){
			redirect(site_url('login?msg=please_login'));
		}
	}

	function index(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-flash"></i> Komplain Masuk di Unit Saya</a></li>
		<li class="active">Beranda</li>
		';
		$data['add_html'] = '<input type="hidden" name="unit_id" value="'. $this->session->unit_id .'">';
		$data['judul'] = 'Daftar komplain yang masuk di Unit saya';
		$data['add_views'] = array('komponen/modal_respon',
								   'komponen/modal_get_komplain',
									'komponen/modal_custom_komplain',
									'laman/respon/footer_respon');
		$data['tabel'] = 'komplain_doskar';
		$this->load->view('laman/respon/index', $data);
	}
	function mhs(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-graduation-cap"></i> Komplain Mhs</a></li>
		<li class="active">Beranda</li>
		';
		$data['add_html'] = '<input type="hidden" name="unit_id" value="'. $this->session->unit_id .'">';
		$data['judul'] = 'Daftar komplain komplain mahasiswa';
		$data['add_views'] = array('komponen/modal_get_komplain',
									'laman/respon/footer_respon');
		$data['tabel'] = 'komplain_mhs';
		$this->load->view('laman/respon/index', $data);
	}
}