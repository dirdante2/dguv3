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

	function get($firmen_firmaid=NULL) {
		if($firmen_firmaid===NULL) {
			return $this->db->get('firmen')->result_array();
		}
		$result = $this->db->get_where('firmen', array('firmen_firmaid'=>$firmen_firmaid))->result_array();
		if (!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function list($firmen_firmaid=NULL) {
		$this->db->select('firmen.*');
        $this->db->from('firmen');
       
        if($firmen_firmaid!==NULL) {
            $this->db->having('firmen.firmen_firmaid',$firmen_firmaid);
        }

        return $this->db->get()->result_array();
    }
	

	function set($data, $firmen_firmaid=NULL) {
		if($firmen_firmaid) {
			$this->db->set(array(
				'firma_name' => $data['firma_name'],
				'firma_ort' => $data['firma_ort'],
				'firma_strasse' => $data['firma_strasse'],
				'firma_plz' => $data['firma_plz'],
				'firma_beschreibung' => $data['firma_beschreibung']
			));
			$this->db->where('firmen_firmaid',$firmen_firmaid);
			return $this->db->update('firmen',$data);
		}
		return $this->db->insert('firmen',$data);
	}

	function delete($firmen_firmaid) {
		$this->db->where('firmen_firmaid',$firmen_firmaid);
		return $this->db->delete('firmen');
	}

}
