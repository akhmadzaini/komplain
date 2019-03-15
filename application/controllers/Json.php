<?php

class Json extends CI_controller{
	function __construct(){
		parent::__construct();
		if(empty($this->session->login)){
			header("HTTP/1.1 403 Forbidden" );
			exit('Anda tidak memiliki cukup izin.');
		}
	}

	function get_proses(){
		$unit_id = $this->input->get('unit_id');
		$this->db->select('id');
		$this->db->select('nama');
		$this->db->where('unit_id', $unit_id);
		$this->db->order_by('id');
		$q = $this->db->get('proses');
		$data = $q->result_array();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function add_proses(){
		$post = $this->input->post();
		$this->db->set('id', 'UUID()', FALSE);
		$this->db->set('unit_id', $post['unit_id']);
		$this->db->set('nama', $post['nama']);
		$this->db->insert('proses');
		header('Content-Type: text/plain');
		echo ('ok');	
	}

	function del_proses(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$this->db->db_debug = FALSE;
		$this->db->delete('proses');
		header('Content-Type: text/plain');
		$this->db->db_debug = TRUE;
		$err = $this->db->error()['code'];
		if($err == 1451){
			echo ('gagal');
		}else{
			echo ('ok');	
		}
	}

	function add_pengawas(){
		$doskar_id = $this->input->post('doskar');
		$this->db->where('doskar_id', $doskar_id);
		$this->db->delete('acl');
		$this->db->set('doskar_id', $doskar_id);
		$this->db->set('akses', 1);
		$this->db->insert('acl');
		header('Content-Type: text/plain');
		echo 'ok';
	}

	function get_pengawas(){
		$sql = "SELECT a.doskar_id, b.nama
					FROM acl a 
					LEFT JOIN doskar b ON a.doskar_id = b.id
					WHERE akses = 1
					ORDER BY b.nama";
		$q = $this->db->query($sql);
		$data = $q->result_array();
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	function del_pengawas(){
		$doskar_id = $this->input->get('id');
		$this->db->where('doskar_id', $doskar_id);
		$this->db->delete('acl');
		header('Content-Type: text/plain');
		echo 'ok';
	}

	function pengajuan_komplain(){		
		$jenis = $this->input->post('jenis');
		$this->db->set('id', 'UUID()', FALSE);
		if($jenis == 'doskar'){
			$this->db->set('doskar_id', $this->session->login);
		}else{
			$this->db->set('nim', $this->session->login);
		}
		$this->db->set('proses_id', $this->input->post('proses_id'));
		$this->db->set('isi', $this->input->post('isi'));
		$this->db->set('tgl', 'NOW()', FALSE);

		$nama_tabel = ($jenis == 'doskar') ? 'komplain_doskar' : 'komplain_mhs';
		// echo $this->db->get_compiled_insert($nama_tabel);
		$this->db->insert($nama_tabel);
		$data = array('affected_rows' => $this->db->affected_rows());
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function pengajuan_komplain_custom(){		
		$data = $this->input->post();
		$this->db->set('id', 'UUID()', FALSE);
		$this->db->set('doskar_id', $data['doskar']);
		$this->db->set('tgl', tgl_mysql($data['tgl']));
		$this->db->set('proses_id', $data['proses_id']);
		$this->db->set('isi', $data['isi']);
		$this->db->set('ex_tgl', tgl_mysql($data['ex_tgl']));
		$this->db->set('ex_pic_nama', $data['pic']);
		$this->db->set('ex_isi', $data['ex_isi']);
		$this->db->set('status', 1);

		$this->db->insert('komplain_doskar');
		$data = array('affected_rows' => $this->db->affected_rows());
		header('Content-Type: application/json');
		echo json_encode($data);
	}	

	function browse_komplain_doskar(){
		$data = $this->input->post();

		if(!empty($data['tgl'])){			
			$tgl_pecah = explode(' - ', $data['tgl']);
			$tgl_awal = tgl_mysql($tgl_pecah[0]);
			$tgl_akhir = tgl_mysql($tgl_pecah[1]);
			$where[] = "(a.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')";
		}

		if(!empty($data['pemohon'])){
			$where[] = "a.doskar_id = '$data[pemohon]'";
		}
		if((@$data['status']) != ''){
			$where[] = "a.status = $data[status]";
		}
		if(!empty($data['unit_id'])){
			$where[] = "b.unit_id = '$data[unit_id]'";
		}

		$where = implode(" AND ", $where);
		$sql = "SELECT a.id, c.nama AS pemohon, e.nama AS unit,
				b.nama AS kategori, DATE_FORMAT(a.tgl, '%d/%m/%Y') AS tgl , a.`status`
				FROM komplain_doskar a
				LEFT JOIN proses b ON a.proses_id = b.id
				LEFT JOIN doskar c ON a.doskar_id = c.id
				LEFT JOIN unit e ON b.unit_id = e.id
				WHERE $where ORDER BY a.tgl DESC";
		$q = $this->db->query($sql);
		$data = $q->result_array();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function browse_komplain_mhs(){
		$data = $this->input->post();
		
		if(!empty($data)){

			if(!empty($data['tgl'])){			
				$tgl_pecah = explode(' - ', $data['tgl']);
				$tgl_awal = tgl_mysql($tgl_pecah[0]);
				$tgl_akhir = tgl_mysql($tgl_pecah[1]);
				$where[] = "(a.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')";
			}

			if(!empty($data['unit_id'])){
				$where[] = "b.unit_id = '$data[unit_id]'";
			}

			$where = implode(" AND ", $where);
			$sql = "SELECT a.id, c.nama AS pemohon, e.nama AS unit,
					b.nama AS kategori, DATE_FORMAT(a.tgl, '%d/%m/%Y') AS tgl , a.`status`
					FROM komplain_mhs a
					LEFT JOIN proses b ON a.proses_id = b.id
					LEFT JOIN mhs c ON a.nim = c.id
					LEFT JOIN unit e ON b.unit_id = e.id
					WHERE $where ORDER BY a.tgl DESC";
			$q = $this->db->query($sql);
			$data = $q->result_array();
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}

	function tangani_komplain(){
		$data = $this->input->post();
		$this->db->set('status', 1);
		$this->db->set('ex_tgl', tgl_mysql($data['tgl']));
		$this->db->set('ex_pic_nama', $data['pic']);
		$this->db->set('ex_isi', $data['isi']);
		$this->db->where('id', $data['id']);
		$this->db->update('komplain_doskar');
		$data = array('affected_rows' => $this->db->affected_rows());
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function tanggapi_komplain(){
		$data = $this->input->post();
		$this->db->set('tgp_isi', $data['isi_tanggapan']);
		$this->db->set('tgp_rating', $data['rating']);
		$this->db->set('tgp_tgl', 'NOW()', FALSE);
		$this->db->set('status', 2);
		$this->db->where('id', $data['id_komplain']);
		$this->db->update('komplain_doskar');
		$data = array('affected_rows' => $this->db->affected_rows());
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function get_tangani_komplain(){
		$data = $this->input->post();
		$this->db->select('DATE_FORMAT(ex_tgl, \'%d/%m/%Y\') AS ex_tgl', FALSE);
		$this->db->select('ex_pic_nama');
		$this->db->select('ex_isi');
		$this->db->select('status');
		$this->db->where('id', $data['id']);
		$q = $this->db->get('komplain_doskar');
		$data = $q->row_array();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function get_komplain(){
		$id = $this->input->post('id');
		$tabel = $this->input->post('tabel');
		if($tabel == 'komplain_doskar'){		
			$sql = "
				SELECT b.nama AS pemohon,
				c.nama AS kategori,
				d.nama AS unit,
				a.isi,
				DATE_FORMAT(a.tgl, '%d/%m/%Y') AS tgl
				FROM komplain_doskar a
				LEFT JOIN doskar b ON a.doskar_id= b.id
				LEFT JOIN proses c ON a.proses_id=c.id
				LEFT JOIN unit d ON c.unit_id=d.id 
				WHERE a.id = '$id' 
			";
		}else{
			$sql = "
				SELECT b.nama AS pemohon,
				c.nama AS kategori,
				d.nama AS unit,
				a.isi,
				DATE_FORMAT(a.tgl, '%d/%m/%Y') AS tgl
				FROM komplain_mhs a
				LEFT JOIN mhs b ON a.nim= b.id
				LEFT JOIN proses c ON a.proses_id=c.id
				LEFT JOIN unit d ON c.unit_id=d.id 
				WHERE a.id = '$id' 
			";
		}
		$q = $this->db->query($sql);
		$data = $q->row_array();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function get_komplain_count(){
		$data = $this->input->post();
		if(!empty($data)){		
			$where = array();
			if(!empty($data['tgl'])){			
				$tgl_pecah = explode(' - ', $data['tgl']);
				$tgl_awal = tgl_mysql($tgl_pecah[0]);
				$tgl_akhir = tgl_mysql($tgl_pecah[1]);
				$where[] = "(a.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')";
			}

			if(!empty($data['pemohon'])){
				$where[] = "a.doskar_id = '$data[pemohon]'";
			}
			if(@($data['status']) != ''){
				$where[] = "a.status = $data[status]";
			}
			if(!empty($data['proses'])){
				$where[] = "a.proses_id = '$data[proses]'";
			}
			if(!empty($data['unit_id'])){
				$where[] = "b.unit_id = '$data[unit_id]'";
			}
			if(@($data['rating']) != ''){
				$where[] = "a.tgp_rating = $data[rating]";
			}
			$where = implode(" AND ", $where);
			if(!empty($where)){
				$where = "WHERE $where";	
			}
			if($data['tabel'] == 'komplain_doskar'){
				$sql = "SELECT count(*) AS jml
						FROM komplain_doskar a
						LEFT JOIN proses b ON a.proses_id = b.id
						LEFT JOIN doskar c ON a.doskar_id = c.id
						LEFT JOIN unit e ON b.unit_id = e.id
						$where ORDER BY a.tgl DESC";
			}else{
				$sql = "SELECT count(*) AS jml
						FROM komplain_mhs a
						LEFT JOIN proses b ON a.proses_id = b.id
						LEFT JOIN mhs c ON a.nim = c.id
						LEFT JOIN unit e ON b.unit_id = e.id
						$where ORDER BY a.tgl DESC";
			}
			// die($sql);
			$q = $this->db->query($sql);
			$data = $q->row_array();
			echo $data['jml'];
		}
	}

	function get_kategori_layanan(){
		$post = $this->input->post();
		$this->db->select('id');
		$this->db->select('nama');
		$this->db->where('unit_id', $post['unit_id']);
		$q = $this->db->get('proses');
		$data = $q->result_array();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function get_detail_unit(){
		$post = $this->input->post();
		$sql = "SELECT  a.ext, b.doskar_id
				FROM unit a
				LEFT JOIN acl b ON a.id = b.unit_id AND b.akses = 2
				WHERE a.id = '$post[id]'";
		$q = $this->db->query($sql);
		$data = $q->row_array();
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	function set_detail_unit(){
		$post = $this->input->post();
		$sql = "DELETE FROM acl WHERE unit_id = '$post[unit_id]'";
		$this->db->simple_query($sql);
		if(!empty($post['doskar'])){
			$sql = "DELETE FROM acl WHERE doskar_id = '$post[doskar]'";	
			$this->db->simple_query($sql);
			$sql = "INSERT INTO acl (doskar_id, akses, unit_id) VALUES 
					('$post[doskar]', 2, '$post[unit_id]')";
			$this->db->simple_query($sql);
		}
		if(!empty($post['ext'])){
			$sql = "UPDATE unit SET ext = '$post[ext]' 
			WHERE id = '$post[unit_id]'";
			$this->db->simple_query($sql);
		}
		header('Content-Type: text/plain');
		echo 'sukses';
	}

}