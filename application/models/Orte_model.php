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
	function get($oid=NULL) {
		if($oid===NULL) {
			return $this->db->get('orte')->result_array();
		}
		$result = $this->db->get_where('orte', array('oid'=>$oid))->result_array();
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
		$result = $this->db->get('orte')->result_array();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

	function set($data, $oid=NULL) {
		if($oid) {
			$this->db->set(array(
				'name' => $data['name'],
				'beschreibung' => $data['beschreibung']
			));
			$this->db->where('oid',$oid);

			return $this->db->update('orte',$data);
		}
		return $this->db->insert('orte',$data);
	}

	function delete($oid) {
		$this->db->where('oid',$oid);
		return $this->db->delete('orte');
	}

}
