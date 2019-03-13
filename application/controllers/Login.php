<?php

class Login extends CI_Controller{

	function index(){
		$this->load->view('login');
	}

	function proses(){
		$login = $this->input->post('login');
		$password = $this->input->post('password');
		$jenis = $this->input->post('jenis');
		$this->db->select('nama');
		$this->db->select('email');
		$this->db->where('id', $login);
		$this->db->where('passwd', "AES_ENCRYPT('$password', 'ekomplainM51')", FALSE);
		$nama_tabel = ($jenis == 'doskar') ? 'doskar' : 'mhs';
		$q = $this->db->get($nama_tabel);
		if($q->num_rows() > 0){
			$r = $q->row_array();
			// memuat data login
			$this->session->login = $login;
			$this->session->nama = $r['nama'];
			$this->session->email = $r['email'];
			$this->session->jenis = $jenis;

			// memuat data acl
			$this->db->select('akses');
			$this->db->select('unit_id');
			$this->db->where('doskar_id', $this->session->login );
			$q = $this->db->get('acl');

			if($q->num_rows() > 0){
				$r = $q->row_array();
				$this->session->akses = $r['akses'];
				$this->session->unit_id = $r['unit_id'];
				if($r['akses'] == 1){
					$this->session->unit_saya = "Semua Unit";
				}else{
					$this->db->select('nama');
					$this->db->where ('id', $r['unit_id']);
					$q = $this->db->get('unit');
					$r = $q->row_array();
					$this->session->unit_saya = $r['nama'];
				}
			}else{
				$this->session->akses = FALSE;
				$this->session->unit_id = FALSE;
				$this->session->unit_saya = 'Akses Klien';
			}

			redirect(site_url('dashboard'));
		}else{
			redirect(site_url('login?msg=login_error'));
		}
		// var_dump($q->num_rows());
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(site_url('login'));
	}

}