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

	function get($gid=NULL,$oid=null,$firmen_firmaid=null,$limit=null, $offset=null) {
		$this->db->select('geraete.*, firmen.firmen_firmaid,firmen.firma_name,orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
		$this->db->from('geraete');
		$this->db->join('orte', 'geraete.oid = orte.oid');
		$this->db->join('firmen', 'geraete.geraete_firmaid = firmen.firmen_firmaid', 'LEFT');
		$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
		$this->db->join('pruefer', 'pruefung.pid = pruefer.pid', 'LEFT');

		


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

		if(!empty($result)) {
			if($gid) {
				return $result[0];
			} else {
				return $result;
			}
		} else {
			return NULL;
		}
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
			return $this->db->update('geraete',$data);
		}
		return $this->db->insert('geraete',$data);
	}

	function delete($gid) {
		$this->db->where('gid',$gid);
		return $this->db->delete('geraete');
	}

// aufruf geräte pdf
function pdfdata($oid) {
	$data['ort'] = $this->Orte_model->get($oid);
	$geraete = $this->Geraete_model->get(null,$oid);
	//$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
		// -> aktuell $data['dguv3_logourl']= $this->config->config['base_url'].$this->config->item('dguv3_logourl');
		$data['dguv3_logourl']='https://dguv3.d-systems.us/application/bilder/logo.jpg';

	$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$this->config->config['base_url'].'/index.php/geraete/index/'.$oid;

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

	

	unset($geraete[$i]['firmen_firmaid']);
	unset($geraete[$i]['firma_name']);
	unset($geraete[$i]['geraete_firmaid']);
	unset($geraete[$i]['oid']);

	if($geraet['anzahl']=='0') {
		$geraete[$i]['letztesdatum']='';
		$geraete[$i]['pruefername']='';
	}

if(!$geraet['bestanden']=='1') {
	$geraete[$i]['bestanden']='nein';
} else {
	$geraet[$i]['bestanden']='ja';
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
