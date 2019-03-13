<?php

class Komplain extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=please_login'));
		}
	}

	function pengajuan(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-book"></i> Komplain Saya</a></li>
		<li class="active">Pengajuan</li>
		';
		$data['judul'] = 'Daftar Unit UNIKAMA';
		$data['add_views'] = array('komponen/modal_pengajuan_komplain');
		$this->load->view('laman/daftar_unit', $data);
	}

	function status(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-book"></i> Status Komplain Saya</a></li>
		<li class="active">Pengajuan</li>
		';
		$data['judul'] = 'Status permohonan komplain saya';
		$data['add_views'] = array('komponen/modal_tanggapan',
									'komponen/modal_cek_respon',
									'komponen/modal_get_komplain',
									'laman/komplain/footer_status');
		$this->load->view('laman/komplain/status', $data);
	}

}
