<?php

class Pengawas extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=please_login'));
		}

		// memastikan bahwa pengguna adalah pengawas
		if($this->session->akses != 1){
			redirect(site_url('login?msg=please_login'));
		}
	}

	function index(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-area-chart"></i> Laporan</a></li>
		<li><a href="#">Komplain Dosen</a></li>
		<li class="active">Beranda</li>
		';
		$data['judul'] = 'Laporan Komplain Unit';
		$data['add_views'] = array('laman/pengawas/footer_pengawas');
		$data['tabel'] = 'komplain_doskar';
		$this->load->view('laman/pengawas/index', $data);
	}	

	function mhs(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-area-chart"></i> Laporan</a></li>
		<li><a href="#">Komplain Mahasiswa</a></li>
		<li class="active">Beranda</li>
		';
		$data['judul'] = 'Laporan Komplain Mahasiswa';
		$data['add_views'] = array('laman/pengawas/footer_pengawas');
		$data['tabel'] = 'komplain_mhs';
		$this->load->view('laman/pengawas/index', $data);
	}

	function rekap(){
		$this->load->helper('db_form');
		$data['breadcrumb'] = '
		<li><a href="#"><i class="fa fa-area-chart"></i> Laporan</a></li>
		<li><a href="#">Rekapitulasi Pelayanan Unit</a></li>
		<li class="active">Beranda</li>
		';
		$data['judul'] = 'Rekapitulasi Pelayanan Unit';
		$data['add_views'] = array('laman/pengawas/footer_rekap');
		$data['tabel'] = 'komplain_doskar';
		$this->load->view('laman/pengawas/rekap', $data);
	}
} 