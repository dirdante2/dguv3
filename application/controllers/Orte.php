<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Orte extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Orte_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index() {
		if(!$this->session->userdata('level')){
			$this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$data['orte'] = $this->Orte_model->get();
		$data['html2pdf_api_key']= $this->config->item('html2pdf_api_key');
		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('orte/index',$data);
		$this->load->view('templates/footer');
	}
	}

	function edit($oid=0) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			if($oid==0) {
				$this->load->view('orte/form',array('ort'=>array('oid'=>0,'beschreibung'=>'','name'=>'')));
			} else {
				$this->load->view('orte/form',array('ort'=>$this->Orte_model->get($oid)));
			}
			$this->load->view('templates/footer');

		} else {
			$ort = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
			);

			$this->Orte_model->set($ort,$oid);
			redirect('orte');
		}
	}
	}

	function delete($oid) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Ort wirklich löschen?',
				'target' => 'orte/delete/'.$oid,
				'canceltarget' => 'orte'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Orte_model->delete($oid);
			redirect('orte');
		}
	}
	}

	function json($key="") {
		$orte=$this->Orte_model->getByName($key);
		$response=array();
		foreach($orte as $ort) {
			$response[$ort['oid']]="{$ort['name']} {$ort['beschreibung']}";
		}

		echo json_encode($response);
	}


	function html2pdf_listen() {
		
		 		$orte = $this->Orte_model->get();
		 		
		 		$html2pdf_api_key= $this->config->item('html2pdf_api_key');
				$html2pdf_user_pass= $this->config->item('html2pdf_user_pass');
	 			foreach($orte as $ort) {
	 				
	 				$ortsname = $this->Orte_model->get($ort['oid'])['name'];
	 				
	 				$year=date("Y");
      
     
      
      
	        if (!file_exists('pdf/'.$year.'/'.$ortsname)) { mkdir('pdf/'.$year.'/'.$ortsname, 0755, true); }
	        		
	           //echo "PDF Übersicht wurde erstellt"; 
	            
	            
						$value = site_url('geraete/uebersicht/'.$ort['oid']); // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
						$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($html2pdf_api_key) . "&value=" .$value . $html2pdf_user_pass);
						file_put_contents('pdf/'.$year.'/'.$ortsname.'/liste_'.$ortsname.'.pdf',$result);
				}
				redirect('orte');
				
					
  }





}
