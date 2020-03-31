<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Messgeraete_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($mid=NULL) {
		if($mid===NULL) {
			return $this->db->get('messgeraete')->result_array();
		}
		return $this->db->get_where('messgeraete', array('mid'=>$mid))->result_array()[0];
	}

	function getByName($name) {
		$this->db->like('name', $name);
		$this->db->limit(10);
		$this->db->order_by('name');
		$result = $this->db->get('messgeraete')->result_array();
		if (is_array($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

	function set($data, $mid=NULL) {
		if($mid) {
			$this->db->set(array(
				'name' => $data['name'],
				'beschreibung' => $data['beschreibung']
			));
			$this->db->where('mid',$mid);
			return $this->db->update('messgeraete',$data);
		}
		return $this->db->insert('messgeraete',$data);
	}

	function delete($mid) {
		$this->db->where('mid',$mid);
		return $this->db->delete('messgeraete');
	}

}
