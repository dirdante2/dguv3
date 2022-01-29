<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/



defined('BASEPATH') OR exit('No direct script access allowed');


class Pruefung_model extends CI_Model {

	function __construct() {
		$this->load->database();
		$this->load->model('File_model');
	}

	function get($pruefung_id=NULL) {
		$this->db->select('pruefung.*, geraete.*,firmen.* , messgeraete.*, pruefer.*, messgeraete.name as messgeraetname, pruefer.name as pruefername, geraete.name as geraetename, orte.name as ortsname, geraete.beschreibung as geraetebeschreibung, orte.beschreibung as ortebeschreibung, messgeraete.beschreibung as messgeraetebeschreibung, pruefer.beschreibung as prueferbeschreibung');
		$this->db->from('pruefung');
		$this->db->join('geraete', 'pruefung.gid = geraete.gid', 'LEFT');
		$this->db->join('messgeraete', 'pruefung.mid = messgeraete.mid', 'LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
		$this->db->join('orte', 'geraete.oid = orte.oid', 'LEFT');
		$this->db->join('firmen', 'pruefung.pruefung_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->order_by('pruefung.pruefungid', 'DESC');



		

		if($pruefung_id) {
			$this->db->where('pruefung.pruefungid',$pruefung_id);
		}
		$result = $this->db->get()->result_array();
		

		if(!empty($result)) {
			if($pruefung_id) {
				return $result[0];
			} else {
				return $result;
			}
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

	//gibt nur geräte mit prüfung zurück
	// gibt nur eine prüfung pro gerät zurück
	function get_geraete_pruefung() {

$year=date('Y');
		$this->db->select('geraete.*, letztepruefung.*');
		$this->db->from('(select gid,pid,mid,bestanden,pruefungid , max(datum) as letztesdatum from pruefung group by gid) as letztepruefung');
		$this->db->join('geraete', 'letztepruefung.gid = geraete.gid', 'LEFT');
		$this->db->where('letztesdatum >', $year);

		$this->db->order_by('geraete.gid', 'DESC');
		$result = $this->db->get()->result_array();
		if(!empty($result)) {
			return $result;
		} else {
			return NULL;
		}

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

		
	$pruefung = $this->Pruefung_model->get($pruefung_id);
	if($pruefung===NULL) {

		return null;
	}

	#print_r($pruefung);
	//FIXME wird bei sql abfrage falsch zugeordnet "prueferbeschreibung" wird zu "beschreibung"

	$pruefung['beschreibung']=$pruefung['geraetebeschreibung'];
	
	//$data['naechste_pruefung']= '+'.$this->config->item('dguv3_pruefungabgelaufen');
	$pruefung_datum = $pruefung['datum'];
	$day     = $pruefung_datum;
	$nextDay = strtotime("+1 year", strtotime($day));
	$pruefung['naechste_pruefung']= date("m.Y", $nextDay);



	$pruefung['bestanden']='ja';
	$y = $pruefung['RPEmax'];
	if($pruefung['schutzleiter']===null || $pruefung['sichtpruefung']== '0') {
		$pruefung['bestanden_schutzleiter']='-';
		$pruefung['schutzleiter']='-';
		$pruefung['RPEmax']='0.3';
		} else {
		if($pruefung['schutzleiter'] >= $y) {
		$pruefung['bestanden_schutzleiter']='nein';
		$pruefung['bestanden']='nein';
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
			$pruefung['bestanden']='nein';
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
			$pruefung['bestanden']='nein';
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
			$pruefung['bestanden']='nein';
		} else {
			$pruefung['bestanden_beruehrstrom']='ja';
		}
	}

	if($pruefung['aktiv']=='1') {
		$pruefung['aktiv']='ja';
	} else {
		$pruefung['aktiv']='nein';
	}

	if($pruefung['funktion']=='1') {
		$pruefung['funktion']='ja';
	} else {
		$pruefung['funktion']='nein';
		$pruefung['bestanden']='nein';
	}

	if($pruefung['sichtpruefung']=='1') {
		$pruefung['sichtpruefung']='ja';
	} else {
		$pruefung['sichtpruefung']='nein';
		$pruefung['bestanden']='nein';
	}

	if($pruefung['verlaengerungskabel']=='1') {
		$pruefung['verlaengerungskabel']='ja ('.$pruefung['kabellaenge'].'m)';
	} else {
		$pruefung['verlaengerungskabel']='nein';
	}

	//$data['ort'] = $this->Orte_model->get($pruefungid);
	//$data['geraete'] = $this->Geraete_model->getByOid($pruefungid);
	//$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');

	

	if($pruefung['schutzklasse']<='3') {
		//elektro geräte
		$data['dguv3_header']= $this->config->item('dguv3_protokoll_header1');
	} elseif ($pruefung['schutzklasse']=='4') {
		//leitern
		$data['dguv3_header']= $this->config->item('dguv3_protokoll_header2');
	} else {
		$data['dguv3_header']= 'Diese Prüfung ist ungültig weil es keine überschrift gibt?!';
	}
	
	


	$data['dguv3_logourl']= $this->config->item('dguv3_logourl');
	$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.$this->config->config['base_url'].'/pruefung/index/'.$pruefung['gid'];


	// generate filename

		$typ='2'; //protokoll pdf
		$filename = $this->File_model->get_file_pfad($typ,$pruefung_id);

	$data['filename'] = $filename;

	//var die nicht in json nötig sind
	unset($pruefung['mid']);
	unset($pruefung['pid']);
	unset($pruefung['pruefung_firmaid']);
	unset($pruefung['geraete_firmaid']);
	unset($pruefung['firmen_firmaid']);
	unset($pruefung['oid']);
	unset($pruefung['name']);
	// unset($pruefung['orte_firmaid']);
	$data['pruefung'] = $pruefung;

	

	return $data;
}


}
