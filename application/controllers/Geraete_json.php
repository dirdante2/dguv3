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

			$orte['ort'] = $this->Orte_model->get($oid);
			$data['geraete'] = $this->Geraete_model->getByOid($oid);
			$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
			$data['adresse']= $this->config->item('dguv3_adresse');
			

			echo json_encode($data);
		}











	
	


	
	
}
