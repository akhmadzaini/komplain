<?php

class Akun extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=denied'));
			exit(0);
		}
	}

	function index(){
		echo "Untuk modifikasi detil akun dan password dapat dilakukan melalui aplikasi kepegawaian. Akun pada aplikasi e-komplain telah terintegrasi dengan akun kepegawaian.";
	}
}