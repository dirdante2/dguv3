<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

		
class Pruefung_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Geraete_model');
		$this->load->model('Orte_model');
		$this->load->model('Pruefung_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	



	
		//output geraete/uebersicht/$oid als json format
		function json($pruefung_id="") {
			
			$pruefung = $this->Pruefung_model->getnotarray($pruefung_id);

			$data['pruefung'] = $this->Pruefung_model->getnotarray($pruefung_id);
			//$data['naechste_pruefung']= '+'.$this->config->item('dguv3_pruefungabgelaufen');
			$pruefung_datum = $this->Pruefung_model->getnotarray($pruefung_id)['datum'];
			$day     = $pruefung_datum;
			$nextDay = strtotime("+1 year", strtotime($day));
			$data['naechste_pruefung']= date("m.Y", $nextDay);


			
			$y = $pruefung['RPEmax'];
			if($pruefung['schutzleiter']===null || $pruefung['sichtpruefung']== '0') { 
				$pruefung['bestanden_schutzleiter']='-';
			 } else {
			 	if($pruefung['schutzleiter'] >= $y) {
				$pruefung['bestanden_schutzleiter']='nein';
			 	} else { 
				$pruefung['bestanden_schutzleiter']='ja'; 
			 	}
			}

			if($pruefung['isowiderstand']===null || $pruefung['sichtpruefung']== '0') { 
				$pruefung['bestanden_isowiderstand']='-'; 
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
			} else {
				if($pruefung['beruehrstrom'] >= $y) {
					$pruefung['bestanden_beruehrstrom']='nein'; 
				} else { 
					$pruefung['bestanden_beruehrstrom']='ja';  
				}
			}
			$data['pruefung'] = $pruefung;
			//$data['ort'] = $this->Orte_model->get($pruefungid);
			//$data['geraete'] = $this->Geraete_model->getByOid($pruefungid);
			//$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
			
			$data['dguv3_logourl']= $this->config->config['base_url'].$this->config->item('dguv3_logourl');
			$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$this->config->config['base_url'].'/index.php/pruefung/index/'.$pruefung_id;
			

			//$data['adresse']= $this->config->item('dguv3_adresse');
			
			
			echo json_encode($data);
		}







	
	


	
	
}
