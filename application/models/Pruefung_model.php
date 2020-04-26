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
		$this->db->select('pruefung.*, geraete.*, messgeraete.*, pruefer.*, messgeraete.name as messgeraetname, pruefer.name as pruefername, geraete.name as geraetename, orte.name as ortsname, geraete.beschreibung as geraetebeschreibung, orte.beschreibung as ortebeschreibung, messgeraete.beschreibung as messgeraetebeschreibung, pruefer.beschreibung as prueferbeschreibung');
		$this->db->from('pruefung');
		$this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
		$this->db->join('messgeraete', 'pruefung.mid = messgeraete.mid', 'LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
		$this->db->join('orte', 'geraete.oid = orte.oid', 'LEFT');
		if($pruefung_id!==NULL) {
			$this->db->where('pruefung.pruefungid',$pruefung_id);
		}
		$this->db->order_by('pruefung.pruefungid', 'DESC');
		$result = $this->db->get()->result_array();
		if(!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}
	//doppelte funktion result ausgabe ist !!ohne index in URL!
	//index.php/pruefung/protokoll/1
	//
	function getnotarray($pruefung_id=NULL) {
		$this->db->select('pruefung.*, geraete.*, firmen.* ,messgeraete.name as messgeraetname, pruefer.name as pruefername, orte.name as ortsname, geraete.name as geraetename, geraete.beschreibung as geraetebeschreibung');
		$this->db->from('pruefung');
		$this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
		$this->db->join('messgeraete', 'pruefung.mid = messgeraete.mid', 'LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
		$this->db->join('orte', 'geraete.oid = orte.oid', 'LEFT');
		$this->db->join('firmen', 'pruefung.pruefung_firmaid = firmen.firmen_firmaid', 'LEFT');



		$this->db->where('pruefung.pruefungid',$pruefung_id);
		$this->db->order_by('pruefung.pruefungid', 'DESC');

		$result = $this->db->get()->result_array();
		if(!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}
	//var1 geräteid var2 firmenid var3 rowlimit var4 offset
	function list($gid=NULL,$firmen_firmaid=NULL,$limit=null, $offset=null) {
		$this->db->select('pruefung.*, firmen.firmen_firmaid,firmen.firma_name,geraete.*,orte.name as ortsname, messgeraete.name as messgeraetname, pruefer.name as pruefername, geraete.name as geraetename, geraete.kabellaenge as geraetekabellaenge');
		$this->db->from('pruefung');
		$this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
		$this->db->join('messgeraete', 'pruefung.mid = messgeraete.mid', 'LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
		$this->db->join('orte', 'pruefung.oid = orte.oid', 'LEFT');
		$this->db->join('firmen', 'pruefung.pruefung_firmaid = firmen.firmen_firmaid', 'LEFT');

		if($firmen_firmaid!==NULL) {
			$this->db->having('pruefung.pruefung_firmaid', $firmen_firmaid);
		}
		if($gid!==NULL) {
			$this->db->where('pruefung.gid',$gid);
		}
		$this->db->order_by('pruefung.pruefungid', 'DESC');
		$this->db->limit($limit,$offset);
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
