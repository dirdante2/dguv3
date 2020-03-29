<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Pruefung_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($gid=NULL) {
		if($gid===NULL) {
			$this->db->select('pruefung.*, geraete.*');
			$this->db->from('geraete');
			$this->db->join('pruefung', 'pruefung.gid = geraete.gid', 'LEFT');
			return $this->db->get()->result_array();
		}
        $this->db->select('pruefung.*, geraete.*');
        $this->db->from('geraete');
        $this->db->join('pruefung', 'pruefung.gid = geraete.gid', 'LEFT');
		$this->db->where('geraete.gid',$gid);

		$result = $this->db->get()->result_array();
		if(is_array($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function set($data,$gid=NULL) {
		if($gid) {
            $res = $this->db->get_where('pruefung', array('gid'=>$gid))->result_array();
            if ($res) {
                $this->db->where('gid',$gid);
                return $this->db->update('pruefung',$data);
            } else {
                return $this->db->insert('pruefung',$data);
            }
		}
		return $this->db->insert('pruefung',$data);
	}

	function delete($gid) {
		$this->db->where('gid',$gid);
		return $this->db->delete('pruefung');
	}


}
