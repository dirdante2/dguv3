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
		$this->db->select('geraete.*, orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefer.pid = pruefung.pid', 'LEFT');

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
		$this->db->select('geraete.*, orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefer.pid = pruefung.pid', 'LEFT');
		$this->db->where('orte.oid',$oid);
		return $this->db->get()->result_array();
	}


	/*Verlängerungskabel
	  Laut Norm darf der RPE (schutzleiter)
	  0,3 Ohm für die ersten 5m betragen
	  für jede weiteren 7,5m 0,1 Ohm mehr
	  maximal jedoch 1 Ohm.*/
	// sze: TODO check by dante
	// sze: TODO add unit tests for this function
	// sze: check(0.3, kabellaengeToRPEmax(1))
	// sze: check(0.3, kabellaengeToRPEmax(5))
	// sze: check(0.4, kabellaengeToRPEmax(12.5))
	// sze: check(0.5, kabellaengeToRPEmax(20))
	// sze: check(1,   kabellaengeToRPEmax(1000000))
	function getRPEmax($gid) {
		$kabellaenge = $this->get($gid)['kabellaenge'];

		$first_kl = 5;
		$first = min($kabellaenge, $first_kl);
		$rest  = max(0, $kabellaenge - $first_kl);
		$rest_ohm = 0.1;
		$rest_ratio = 1 / 7.5;

		$rpe_max = min(0.3 + $rest * $rest_ratio * $rest_ohm, 1);
		return $rpe_max;
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
