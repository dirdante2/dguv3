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
        $this->db->select('pruefung.*, geraete.*');
        $this->db->from('pruefung');
        $this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
        if($gid!==NULL) {
            $this->db->where('geraete.gid',$gid);
        }
        return $this->db->get()->result_array();
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
