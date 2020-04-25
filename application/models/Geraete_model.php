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
	public function get_count() {
		$this->db->select('*');
		$this->db->from('geraete');
        return $this->db->count_all_results();
	}

	function get($gid=NULL,$firmen_firmaid=NULL,$limit=null, $offset=null) {
		$this->db->select('geraete.*, firmen.firmen_firmaid,firmen.firma_name,orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('firmen', 'geraete.geraete_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');




		if($firmen_firmaid!==NULL) {
			$this->db->having('geraete.geraete_firmaid', $firmen_firmaid);
		}


		$this->db->order_by('geraete.gid', 'DESC');


		if($gid===NULL) {
			$this->db->limit($limit,$offset);
			return $this->db->get()->result_array();
		}

		$this->db->where('geraete.gid',$gid);
		//$this->db->limit($limit,$offset);

		$result = $this->db->get()->result_array();
		if(!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function getByOid($oid,$firmen_firmaid=NULL) {
		$this->db->select('geraete.*, firmen.firmen_firmaid,firmen.firma_name,orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('firmen', 'geraete.geraete_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');

		if($firmen_firmaid!==NULL) {
			$this->db->having('geraete.geraete_firmaid', $firmen_firmaid);
		}
		$this->db->where('orte.oid',$oid);
		return $this->db->get()->result_array();
	}


	/*Verlängerungskabel
	  Laut Norm darf der RPE (schutzleiter)
	  0,3 Ohm für die ersten 5m betragen
	  für jede weiteren 7,5m 0,1 Ohm mehr
	  maximal jedoch 1 Ohm.*/

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
