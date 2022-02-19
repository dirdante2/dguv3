<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Orte_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	/**
	 * returns an Ort or an list of Orte
	 * @param oid requested id or NULL if all Orte are requested
	 * @return list of Orte, single Ort or NULL
	 */
	function get($oid=NULL,$firmen_firmaid=NULL) {
		$this->db->select('orte.*, firmen.*,COUNT(gid) AS geraeteanzahl');
		$this->db->from('orte');
		$this->db->join('geraete', 'orte.oid = geraete.oid','LEFT');
		$this->db->join('firmen', 'orte.orte_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->group_by('orte.oid');
		if($firmen_firmaid!==NULL) {
			$this->db->having('orte.orte_firmaid', $firmen_firmaid);
		} 

		if($oid===NULL) {
			return $this->db->get()->result_array();
		} else {
			$this->db->where('orte.oid', $oid);
		}

		$result = $this->db->get()->result_array();
		if (!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function getByName($name,$firmen_firmaid=NULL) {

		$this->db->select('orte.*, firmen.firmen_firmaid,firmen.firma_name');
		$this->db->from('orte');
		$this->db->join('firmen', 'orte.orte_firmaid = firmen.firmen_firmaid', 'LEFT');
		if($firmen_firmaid!==NULL) {
			//$this->db->where('orte.orte_firmaid', $firmen_firmaid);
			$this->db->having('orte.orte_firmaid', $firmen_firmaid);
		} 

		$this->db->like('orte.name', $name); 
		$this->db->or_like('orte.beschreibung', $name);

		$this->db->limit(10);
		$this->db->order_by('orte.name');
		$result = $this->db->get()->result_array();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

	function set($data, $oid=NULL) {
		 if($oid) {
		
			$this->db->where('oid',$oid);
			$this->db->update('orte',$data);
			$insert_id = $oid;
		} else {
			$this->db->insert('orte',$data);
			$insert_id = $this->db->insert_id();
		}
		
		
		return $insert_id;
	}

	function delete($oid) {
		$this->db->where('oid',$oid);
		return $this->db->delete('orte');
	}

}
