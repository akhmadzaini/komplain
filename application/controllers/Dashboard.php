<?php

class Dashboard extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=denied'));
			exit(0);
		}
	}

	function index(){
		if($this->session->akses == 1){
			redirect(site_url('pengawas'));
		}elseif($this->session->akses == 2){
			redirect(site_url('respon'));
		}else{
			redirect(site_url('komplain/pengajuan'));
		}
	}
}