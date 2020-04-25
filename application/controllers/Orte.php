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
		$this->load->model('Firmen_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index() {
		if($this->session->userdata('logged_in') !== TRUE){
			if($this->agent->is_mobile()){
				$this->load->view('templates/header_mobile');
			} else {
				$this->load->view('templates/header');
			}
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen 8
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');
				$data['orte'] = $this->Orte_model->get(null,$firmen_firmaid);

			} else {
				$data['orte'] = $this->Orte_model->get();
			}


		$data['html2pdf_api_key']= $this->config->item('html2pdf_api_key');

		if($this->agent->is_mobile()){
			$this->load->view('templates/header_mobile');
			$this->load->view('templates/scroll');
			$this->load->view('orte/index_mobile',$data);
		  } else {
			$this->load->view('templates/header');
			$this->load->view('templates/datatable');
			$this->load->view('orte/index',$data);
		  }

			$this->load->view('templates/footer');
			}



	}


	function edit($oid=0) {
		//user level 4 oder höher darf keine orte erstellen oder bearbeiten
		if($this->session->userdata('level')>='4'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');
		//$this->form_validation->set_rules('firmen_firmaid', 'Firma', 'required');

		if($this->form_validation->run() === FALSE) {
			if($this->agent->is_mobile()){
				$this->load->view('templates/header_mobile');
			  } else {
				$this->load->view('templates/header');
			  }

			if($oid==0) {

				if($this->agent->is_mobile()){
					$this->load->view('orte/form_mobile',array(
						'ort'=>array('oid'=>0,'beschreibung'=>'','name'=>''),
						'firmen'=> $this->Firmen_model->get()
					));
				  } else {
					$this->load->view('orte/form',array(
						'ort'=>array('oid'=>0,'beschreibung'=>'','name'=>''),
						'firmen'=> $this->Firmen_model->get()
					));
				  }


			} else {

				if($this->agent->is_mobile()){
					$this->load->view('orte/form_mobile',array(
						'ort'=>$this->Orte_model->get($oid),
						'firmen'=> $this->Firmen_model->get()

					));
				  } else {
					$this->load->view('orte/form',array(
						'ort'=>$this->Orte_model->get($oid),
						'firmen'=> $this->Firmen_model->get()

					));
				  }


			}


			$this->load->view('templates/footer');

		} else {

			$ort = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
				'orte_firmaid' => $this->input->post('orte_firmaid'),
			);
			if ($ort['orte_firmaid']==NULL) {
				$ort['orte_firmaid']=$this->session->userdata('firmaid');


			}

			$this->Orte_model->set($ort,$oid);
			redirect('orte');
		}
	}
	}

	function delete($oid) {
		//nur admin darf orte löschen
		if($this->session->userdata('level')!='1'){
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
		if($this->session->userdata('logged_in') !== TRUE){
			$this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
		}else{
			 //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			 if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');
				$orte=$this->Orte_model->getByName($key,$firmen_firmaid);

			} else {
				$orte=$this->Orte_model->getByName($key);
			}





			$response=array();
			foreach($orte as $ort) {
				$response[$ort['oid']]="{$ort['name']} {$ort['beschreibung']}";
			}

			echo json_encode($response);
		}
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
