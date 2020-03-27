<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Geraete_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($gid=NULL) {
		if($gid===NULL) {
			$this->db->select('geraete.*, orte.name AS ortsname');
			$this->db->from('geraete');
			$this->db->join('orte', 'geraete.oid = orte.oid');
			return $this->db->get()->result_array();
		}
		$this->db->select('geraete.*, orte.name AS ortsname');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->where('gid',$gid);

		$result = $this->db->get()->result_array(); 
		if(is_array($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function getByOid($oid) {
		$this->db->select('geraete.*, orte.name AS ortsname');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->where('orte.oid',$oid);
		return $this->db->get()->result_array();
	}


	function set($data,$gid=NULL) {
		if($gid) {
			$this->db->where('gid',$gid);
			return $this->db->update('geraete',$data);
		}
		return $this->db->insert('geraete',$data);
	}

	function delete($gid) {
		$this->db->where('gid',$gid);
		return $this->db->delete('geraete');
	}


}