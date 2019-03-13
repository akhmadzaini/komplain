<?php

class Laporan extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			redirect(site_url('login?msg=please_login'));
		}

		// memastikan bahwa pengguna adalah pengawas
		if($this->session->akses != 1){
			die('Anda tidak memiliki cukup ijin membuka halaman ini!');
		}
	}

	function kinerja_unit(){
		$data = $this->input->get();
		$tgl_pecah = explode(' - ', $data['tgl']);
		$tgl_awal = tgl_mysql($tgl_pecah[0]);
		$tgl_akhir = tgl_mysql($tgl_pecah[1]);

		// menghitung statistik layanan
		$layanan = array(
			'total' => 0,
			0 => 0,
			1 => 0,
			2 => 0
		);

		$sql = "SELECT
		a.status, count(*) AS jml
		FROM $data[tabel] a
		LEFT JOIN proses b ON a.proses_id = b.id
		WHERE b.unit_id = '$data[unit_id]'
		AND (a.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')
		GROUP BY a.status";

		$q = $this->db->query($sql);
		foreach($q->result_array() as $r){
			$layanan[$r['status']] = $r['jml'];
			$layanan['total'] += $r['jml'];
		}

		// menghitung statistik kualitas layanan
		$kualitas_layanan = array(
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0
		);

		$sql = "SELECT
		a.tgp_rating, count(*) AS jml
		FROM $data[tabel] a
		LEFT JOIN proses b ON a.proses_id = b.id
		WHERE b.unit_id = '$data[unit_id]'
		AND (a.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')
		AND a.`status` = 2
		GROUP BY a.tgp_rating";

		$q = $this->db->query($sql);
		foreach($q->result_array() as $r){
			$kualitas_layanan[$r['tgp_rating']] = $r['jml'];
		}

		// menghitung prosen kualitas
		$kualitas_layanan['prosen'] = $this->_prosen_kualitas($kualitas_layanan);

		// menghitung statistik layanan per kategori
		$layanan_ = array();
		$sql = "SELECT 
		a.id, a.nama, b.status, count(b.status) AS jml
		FROM proses a
		LEFT JOIN $data[tabel] b ON a.id = b.proses_id
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')
		WHERE a.unit_id = '$data[unit_id]'
		GROUP BY  a.id, b.status";

		$q = $this->db->query($sql);
		foreach($q->result_array() as $r){
			$layanan_[$r['id']]['nama'] = $r['nama'];
			if(empty($layanan_[$r['id']]['layanan'])){
				$layanan_[$r['id']]['layanan'] = array(
					'total' => 0,
					0 => 0,
					1 => 0,
					2 => 0
				);
				$layanan_[$r['id']]['kualitas'] = array(
					0 => 0,
					1 => 0,
					2 => 0,
					3 => 0,
					4 => 0
				);
			}
			if(!empty($r['status'])){
				$layanan_[$r['id']]['layanan'][$r['status']] = $r['jml'];
				$layanan_[$r['id']]['layanan']['total'] += $r['jml'];
			}
		}

		// menghitung statistik kualitas layanan per kategori
		$sql = "SELECT 
		a.id, a.nama, b.tgp_rating, count(b.status) AS jml
		FROM proses a
		LEFT JOIN $data[tabel] b ON a.id = b.proses_id
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')
		WHERE a.unit_id = '$data[unit_id]'
		AND b.status = 2
		GROUP BY  a.id, b.tgp_rating";

		$q = $this->db->query($sql);
		foreach($q->result_array() as $r){
			$layanan_[$r['id']]['kualitas'][$r['tgp_rating']] = $r['jml'];
		}

		// menghitung prosen kualitas layanan per kategori
		foreach ($layanan_ as $k => $v) {
			$layanan_[$k]['kualitas']['prosen'] = $this->_prosen_kualitas($v['kualitas']); 
		}


		$data['layanan'] = $layanan;
		$data['kualitas_layanan'] = $kualitas_layanan;
		$data['layanan_'] = $layanan_;
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;


		$this->load->view('laman/laporan/kinerja_unit', $data);
	}

	function rekap(){
		$data = $this->input->get();
		$tgl_pecah = explode(' - ', $data['tgl']);
		$tgl_awal = tgl_mysql($tgl_pecah[0]);
		$tgl_akhir = tgl_mysql($tgl_pecah[1]);

		$sql = "SELECT a.id, a.nama,
		(SELECT COUNT(*) FROM $data[tabel] b 
		LEFT JOIN proses c ON b.proses_id = c.id
		WHERE c.unit_id = a.id AND b.`status` = 2 
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')) AS tertutup,
		(SELECT COUNT(*) FROM $data[tabel] b 
		LEFT JOIN proses c ON b.proses_id = c.id
		WHERE c.unit_id = a.id AND b.`status` = 2 AND b.tgp_rating = 0
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ) AS r0,
		(SELECT COUNT(*) FROM $data[tabel] b 
		LEFT JOIN proses c ON b.proses_id = c.id
		WHERE c.unit_id = a.id AND b.`status` = 2 AND b.tgp_rating = 1
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ) AS r1,
		(SELECT COUNT(*) FROM $data[tabel] b 
		LEFT JOIN proses c ON b.proses_id = c.id
		WHERE c.unit_id = a.id AND b.`status` = 2 AND b.tgp_rating = 2
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ) AS r2,
		(SELECT COUNT(*) FROM $data[tabel] b 
		LEFT JOIN proses c ON b.proses_id = c.id
		WHERE c.unit_id = a.id AND b.`status` = 2 AND b.tgp_rating = 3
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ) AS r3,
		(SELECT COUNT(*) FROM $data[tabel] b 
		LEFT JOIN proses c ON b.proses_id = c.id
		WHERE c.unit_id = a.id AND b.`status` = 2 AND b.tgp_rating = 4
		AND (b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ) AS r4
		FROM unit a
		";
		$q = $this->db->query($sql);
		$hasil = $q->result_array() ;
		foreach ($hasil as $k => $v) {
			$hasil[$k]['kualitas'] = $this->_prosen_kualitas(array($v['r0'], $v['r1'], $v['r2'], $v['r3'], $v['r4']));
		}

		$data['hasil'] = $hasil;
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$this->load->view('laman/laporan/rekap', $data);

	}

	private function _prosen_kualitas($arr){
		$t = array_sum($arr) * 4;
		$rTotal = ($arr[0] * 0) + 
				  ($arr[1] * 1) +
				  ($arr[2] * 2) +
				  ($arr[3] * 3) +
				  ($arr[4] * 4);
		if($t > 0){
			return round(($rTotal / $t) * 100);
		}else{
			return 0;
		}
	}

}