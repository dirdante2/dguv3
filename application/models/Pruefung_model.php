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
            $this->db->where('pruefung.pruefungid',$pruefung_id);
        }
        $result = $this->db->get()->result_array();
        if(is_array($result)) {
            return $result[0];
        } else {
            return NULL;
        }
	}

    function list($gid=NULL) {
        $this->db->select('pruefung.*, geraete.*, messgeraete.name as messgeraetname, pruefer.name as pruefername');
        $this->db->from('pruefung');
        $this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
        $this->db->join('messgeraete', 'pruefung.mid = messgeraete.mid', 'LEFT');
        $this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
        if($gid!==NULL) {
            $this->db->where('pruefung.gid',$gid);
        }
        return $this->db->get()->result_array();
    }

    function new($data) {
        $this->db->insert('pruefung',$data);
        return $this->db->insert_id();
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
