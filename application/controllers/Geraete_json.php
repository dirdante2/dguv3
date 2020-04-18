<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

		
class Geraete_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Geraete_model');
		$this->load->model('Orte_model');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	



	
		//output geraete/uebersicht/$oid als json format
		function json($oid="") {
			
			$data['ort'] = $this->Orte_model->get($oid);
			$data['geraete'] = $this->Geraete_model->getByOid($oid);
			$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
			

			$data['dguv3_logourl']= $this->config->config['base_url'].$this->config->item('dguv3_logourl');
			$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$this->config->config['base_url'].'/index.php/geraete/index/'.$oid;
			

			//var die nicht in json nötig sind
			unset($data['ort']['orte_firmaid']);
			unset($data['ort']['firmen_firmaid']);
			
			echo json_encode($data);
		}







	
	


	
	
}
