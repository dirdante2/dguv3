<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Geraete_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($gid=NULL) {
		$this->db->select('geraete.*, orte.name AS ortsname, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('pruefung','pruefung.gid = geraete.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefer.pid = pruefung.pid');

		if($gid===NULL) {
			return $this->db->get()->result_array();
		}
		$this->db->where('geraete.gid',$gid);

		$result = $this->db->get()->result_array();
		if(!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function getByOid($oid) {
		$this->db->select('geraete.*, orte.name AS ortsname, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('pruefung','pruefung.gid = geraete.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefer.pid = pruefung.pid');
		$this->db->where('orte.oid',$oid);
		return $this->db->get()->result_array();
	}

	function set($data,$gid=NULL) {
		if($gid) {
			$this->db->where('gid',$gid);
			return $this->db->update('geraete',$data);
		}
		return $this->db->insert('geraete',$data);
	}

	function delete($gid) {
		$this->db->where('gid',$gid);
		return $this->db->delete('geraete');
	}

}
