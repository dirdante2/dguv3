<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Pruefer_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($pid=NULL,$firmen_firmaid=NULL) {
		$this->db->select('pruefer.*,firmen.firma_name');
		$this->db->from('pruefer');
		
		$this->db->join('firmen', 'pruefer.pruefer_firmaid = firmen.firmen_firmaid', 'LEFT');
		
		if($firmen_firmaid!==NULL) {
			$this->db->having('pruefer.pruefer_firmaid', $firmen_firmaid);
		} 
		if($pid===NULL) {
			return $this->db->get()->result_array();
		} else {
			$this->db->where('pruefer.pid', $pid);
		}

		$result = $this->db->get()->result_array();
		if (!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}

	}

	function getByName($name) {
		$this->db->like('name', $name);
		$this->db->limit(10);
		$this->db->order_by('name');
		$result = $this->db->get('pruefer')->result_array();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

	function set($data, $pid=NULL) {
		if($pid) {
			$this->db->set(array(
				'name' => $data['name'],
				'beschreibung' => $data['beschreibung']
			));
			$this->db->where('pid',$pid);

			return $this->db->update('pruefer',$data);
		}
		return $this->db->insert('pruefer',$data);
	}

	function delete($pid) {
		$this->db->where('pid',$pid);
		return $this->db->delete('pruefer');
	}

}
