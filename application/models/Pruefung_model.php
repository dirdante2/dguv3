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

	function get($pruefung_id=NULL) {
        $this->db->select('pruefung.*, geraete.*, messgeraete.name as messgeraetname, pruefer.name as pruefername');
        $this->db->from('pruefung');
        $this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
        $this->db->join('messgeraete', 'pruefung.mid = messgeraete.mid', 'LEFT');
        $this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
        if($pruefung_id!==NULL) {
            $this->db->where('pruefung.pruefung_id',$pruefung_id);
        }
        return $this->db->get()->result_array();
	}

    function new($data) {
		return $this->db->insert('pruefung',$data);
    }

	function update($data,$pruefung_id) {
        $this->db->where('pruefungid',$pruefung_id);
        return $this->db->update('pruefung',$data);
	}

	function delete($pruefung_id) {
		$this->db->where('pruefungid',$pruefung_id);
		return $this->db->delete('pruefung');
	}


}
