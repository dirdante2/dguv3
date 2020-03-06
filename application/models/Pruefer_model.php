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

	function get($pid=NULL) {
		if($pid===NULL) {
			return $this->db->get('pruefer')->result_array();
		}
		return $this->db->get_where('pruefer', array('pid'=>$pid))->result_array()[0];
	}

	function set($data, $pid=NULL) {
		if($pid) {
			$this->db->set(
				array(
					'name' => $data['name'],
					'beschreibung' => $data['beschreibung']
				)
				);
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