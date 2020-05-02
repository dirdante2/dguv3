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
		$this->load->model('Pdf_model');
		$this->load->model('File_model');
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
foreach($data['orte'] as $ort) {
	$pdf_pfad=$this->File_model->get_file_pfad('1',$ort['oid']);
	$pdffile_data[$ort['oid']]=$pdf_pfad;

}
$data['pdf_data']=$pdffile_data;



		//$data['filename'] = $this->File_model->get_file_pfad();

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

			//generiere PDF übersicht
			//$this->Pdf_model->genpdf_uebersicht($oid);

			file_put_contents('cron/liste/'.$oid,'');

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




  function download_file($typ,$id) {


	$this->File_model->download_file($typ,$id);


}




}
