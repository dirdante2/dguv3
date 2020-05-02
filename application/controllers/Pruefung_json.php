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
		$this->load->model('Pdf_model');
		$this->load->model('Pruefung_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

//TODO delete funktion ist in pruefung_model
	//output pruefung/protokoll/$pruefung_id als json format
	private function data($pruefung_id) {
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

	function genpdf($pruefung_id="") {
		$data = $this->data($pruefung_id);
		$filename = $data['filename'];
		unset($data['filename']);

		$this->Pdf_model->generate_pdf('protokoll', $data, $filename);
		echo $filename;
	}

	function json($pruefung_id="") {
		$data = $this->data($pruefung_id);
		echo json_encode($data);
	}



}
