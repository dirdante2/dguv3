<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Firmen_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($firma_id=NULL) {
		if($firma_id===NULL) {
			return $this->db->get('firmen')->result_array();
		}
		$result = $this->db->get_where('firmen', array('firma_id'=>$firma_id))->result_array();
		if (!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	

	function set($data, $firma_id=NULL) {
		if($firma_id) {
			$this->db->set(array(
				'firma_name' => $data['firma_name'],
				'firma_beschreibung' => $data['firma_beschreibung']
			));
			$this->db->where('firma_id',$firma_id);
			return $this->db->update('firmen',$data);
		}
		return $this->db->insert('firmen',$data);
	}

	function delete($firma_id) {
		$this->db->where('firma_id',$firma_id);
		return $this->db->delete('firmen');
	}

}
