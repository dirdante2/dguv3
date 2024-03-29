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

	function get($gid=NULL,$oid=null,$firmen_firmaid=null,$limit=null, $offset=null, $notwerkzeug=null) {

		if($gid=='0') {
			return null;
		}

		$this->db->select('geraete.*, firmen.firmen_firmaid,firmen.firma_name,orte.name AS ortsname,orte.beschreibung AS orte_beschreibung, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername, pruefung.pruefungid');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('firmen', 'geraete.geraete_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');

		if($notwerkzeug) {
			$this->db->where('schutzklasse !=', '5');
		}


		if($firmen_firmaid) {
			
			$this->db->where('geraete.geraete_firmaid', $firmen_firmaid);
			
		}
		$this->db->order_by('geraete.gid', 'DESC');

		if($gid) { // einzel gerät
			$this->db->where('geraete.gid',$gid);
		} elseif($oid) { //ortsliste
			$this->db->where('orte.oid',$oid);
		}
		$this->db->limit($limit,$offset);
		$result = $this->db->get()->result_array();


		#print_r($result);

		if(empty($result)) {
			return NULL;
		}
		if($gid) {
				return $result[0];
			} else {
				return $result;
			}
		
			
		
	}
	function getlastpruefung($oid=null,$firmen_firmaid=null) {

		

		$this->db->select('geraete.*, firmen.firmen_firmaid,firmen.firma_name,orte.name AS ortsname,orte.beschreibung AS orte_beschreibung, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername, pruefung.pruefungid');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('firmen', 'geraete.geraete_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');

		
		$this->db->where('schutzklasse !=', '5');

		if($firmen_firmaid) {
			
			$this->db->where('geraete.geraete_firmaid', $firmen_firmaid);
			
		}

		$this->db->order_by('letztesdatum', 'DESC');
		#$this->db->group_by("orte.oid");

		
		if($oid) { //ortsliste
			$this->db->where('orte.oid',$oid);
		}
		
		$result = $this->db->get()->result_array();


		#print_r($result);

		if (empty($result)) {return NULL;} 			
		return $result[0];
		
			
		
	}

	function getByName($name,$firmen_firmaid=NULL) {

		$this->db->select('geraete.*, firmen.firmen_firmaid,firmen.firma_name,orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('firmen', 'geraete.geraete_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');
		if($firmen_firmaid!==NULL) {
			//$this->db->where('orte.orte_firmaid', $firmen_firmaid);
			$this->db->having('orte.orte_firmaid', $firmen_firmaid);
		} 
		
		$this->db->group_by("geraete.typ");

		

		

		$this->db->like('geraete.typ', $name); 
		$this->db->or_like('geraete.name', $name);
		$this->db->or_like('geraete.hersteller', $name);

		$this->db->limit(10);
		$this->db->order_by('geraete.name');

		$result = $this->db->get()->result_array();



		if (empty($result)) {return NULL;} 			
		return $result;
	}

	function fehlerquote($status,$zeitraum) {

		$this->db->select('*');
		$this->db->from('geraete');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');

		$this->db->where('schutzklasse !=', '5');
		$this->db->where('bestanden', $status);
		$this->db->where('datum >=', $zeitraum);

		#$result = $this->db->get()->result_array();
		#return $result;
        return $this->db->count_all_results();
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
		$rpe_max = round($rpe_max, 2);
		return $rpe_max;
	}

	function set($data,$gid=NULL) {
		if($gid) {
			$this->db->where('gid',$gid);
			$this->db->update('geraete',$data);
			$insert_id = $gid;
		} else {
			
			$this->db->insert('geraete',$data);
			$insert_id = $this->db->insert_id();
		}
		
		return $insert_id;
	}




	function delete($gid) {
		$this->db->where('gid',$gid);
		return $this->db->delete('geraete');
	}




// aufruf geräte pdf übersicht liste für ort
function pdfdata($oid) {

	$geraetetyp="5"; // gibt nur geräte mit schutzklasse kleiner als zurück
	$data['ort'] = $this->Orte_model->get($oid,null,$geraetetyp);
	#print_r($data);
#	function get($gid=NULL,$oid=null,$firmen_firmaid=null,$limit=null, $offset=null, $notwerkzeug=null) {

	if($data['ort']===NULL) {return NULL;}
	$geraete = $this->Geraete_model->get(null,$oid,null,null,null,"5");

	//$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
		// -> aktuell $data['dguv3_logourl']= $this->config->config['base_url'].$this->config->item('dguv3_logourl');
		$data['dguv3_logourl']= $this->config->item('dguv3_logourl');
		//unötig
		#$data['dguv3_pdf_titel']= $this->config->item('dguv3_protokoll_header1');

		

	$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$this->config->config['base_url'].'/geraete/index/'.$oid;

/* foreach($geraete as $geraet) {

	if($geraet['bestanden']=='0') {

		$geraete[$geraet['gid']]['bestanden']='nein';
	} else {
		$geraete[$geraet['gid']]['bestanden']='ja';
	}


} */
#print_r($geraete);
$i='0';

foreach((array) $geraete as $geraet) {

	//FIXME beschreibung verursacht absturz in json2pdf server
	$geraete[$i]['beschreibung']='0';

 //gleiches problem json2pdf stürzt ab wenn velängerungskabel im name verkommt
 //geräte name länger als 20 zeichen führt zu absturz
 
//  if($geraete[$i]['name']=='Verlängerungskabel') {
// 	$geraete[$i]['name']='Kabel';
//  }

 
	#if($geraete[$i]['verlaengerungskabel']=='1') {
		
		#$geraete[$i]['name']=$geraete[$i]['name'].' | '.$geraete[$i]['kabellaenge'];

		//$geraete[$i]['kabellaenge']='0';
		//$geraete[$i]['verlaengerungskabel']='0';
		//unset($geraete[$i]['kabellaenge']);
		//unset($geraete[$i]['verlaengerungskabel']);

	#}
	

	#print_r($geraet['bestanden']);

	unset($geraete[$i]['firmen_firmaid']);
	unset($geraete[$i]['firma_name']);
	unset($geraete[$i]['geraete_firmaid']);
	unset($geraete[$i]['oid']);
	unset($geraete[$i]['geraete_produktfoto']);
	unset($geraete[$i]['orte_beschreibung']);
	unset($geraete[$i]['pruefungid']);
	

	if($geraet['anzahl']=='0') {
		$geraete[$i]['letztesdatum']='';
		$geraete[$i]['pruefername']='';
	}

if($geraet['bestanden']=='0' || $geraet['bestanden']===NULL) {
	$geraete[$i]['bestanden']='nein';
} else {
	$geraete[$i]['bestanden']='ja';
	
}
if($geraet['aktiv']=='1') {
	$geraete[$i]['aktiv']='ja';
} else {
	$geraet[$i]['aktiv']='nein';
}
	
$i++;
}





	// generate filename
	$year = date("Y");
	$ortsname = $data['ort']['name'];
	$firma_id = $data['ort']['orte_firmaid'];
	$typ='1'; //übersicht pdf
	$filename = $this->File_model->get_file_pfad($typ,$oid);

	$data['filename'] = $filename;
	$data['geraete'] =$geraete;

	//var die nicht in json nötig sind
	unset($data['ort']['orte_firmaid']);

	return $data;
}






}
