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


//output pruefung/protokoll/$pruefung_id als json format
	function pdfdata($pruefung_id) {
	$pruefung = $this->Pruefung_model->getnotarray($pruefung_id);

	//$data['pruefung'] = $this->Pruefung_model->getnotarray($pruefung_id);
	//$data['naechste_pruefung']= '+'.$this->config->item('dguv3_pruefungabgelaufen');
	$pruefung_datum = $pruefung['datum'];
	$day     = $pruefung_datum;
	$nextDay = strtotime("+1 year", strtotime($day));
	$data['naechste_pruefung']= date("m.Y", $nextDay);



	$y = $pruefung['RPEmax'];
	if($pruefung['schutzleiter']===null || $pruefung['sichtpruefung']== '0') {
		$pruefung['bestanden_schutzleiter']='-';
		$pruefung['schutzleiter']='-';
		$pruefung['RPEmax']='0.3';
		} else {
		if($pruefung['schutzleiter'] >= $y) {
		$pruefung['bestanden_schutzleiter']='nein';
		} else {
		$pruefung['bestanden_schutzleiter']='ja';
		}
	}

	if($pruefung['isowiderstand']===null || $pruefung['sichtpruefung']== '0') {
		$pruefung['bestanden_isowiderstand']='-';
		$pruefung['isowiderstand']='-';
		} else {
			if($pruefung['isowiderstand'] < $y) {
			$pruefung['bestanden_isowiderstand']='nein';
			} else {
			$pruefung['bestanden_isowiderstand']='ja';
			}
	}
	$y = 0.50;
	if($pruefung['schutzleiterstrom']===null || $pruefung['sichtpruefung']== '0') {
		$pruefung['bestanden_schutzleiterstrom']='-';
		$pruefung['schutzleiterstrom']='-';
	} else {
		if($pruefung['schutzleiterstrom'] >= $y) {
			$pruefung['bestanden_schutzleiterstrom']='nein';
		} else {
			$pruefung['bestanden_schutzleiterstrom']='ja';
		}
	}

	$y = 0.25;
	if($pruefung['beruehrstrom']===null || $pruefung['sichtpruefung']== '0') {
		$pruefung['bestanden_beruehrstrom']='-';
		$pruefung['beruehrstrom']='-';
	} else {
		if($pruefung['beruehrstrom'] >= $y) {
			$pruefung['bestanden_beruehrstrom']='nein';
		} else {
			$pruefung['bestanden_beruehrstrom']='ja';
		}
	}

	//$data['ort'] = $this->Orte_model->get($pruefungid);
	//$data['geraete'] = $this->Geraete_model->getByOid($pruefungid);
	//$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');

	$data['dguv3_logourl']= $this->config->config['base_url'].$this->config->item('dguv3_logourl');
	$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$this->config->config['base_url'].'/index.php/pruefung/index/'.$pruefung_id;


	// generate filename
	$firma_id = $pruefung['pruefung_firmaid'];
	$year = date("Y", strtotime($pruefung_datum));
	$oid = $pruefung['oid'];
	$ortsname = $pruefung['ortsname'];
	$filename = 'pdf/'.$firma_id.'/'.$year.'/'.$ortsname.'_'.$oid.'/'.$ortsname.'_'.$pruefung_id.'_pruefung.pdf';
	$data['filename'] = $filename;

	//var die nicht in json nötig sind
	unset($pruefung['mid']);
	unset($pruefung['pid']);
	unset($pruefung['pruefung_firmaid']);
	unset($pruefung['geraete_firmaid']);
	unset($pruefung['oid']);
	unset($pruefung['name']);
	// unset($pruefung['orte_firmaid']);
	$data['pruefung'] = $pruefung;

	return $data;
}


}
