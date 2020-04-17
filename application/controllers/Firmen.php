<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Firmen extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Firmen_model');
		$this->load->model('Geraete_model');
		$this->load->model('Pruefer_model');
		$this->load->model('Messgeraete_model');
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
		$data['firmen'] = $this->Firmen_model->get();

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('firmen/index',$data);
		$this->load->view('templates/footer');
	}
	}

	function edit($firma_id=0) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('firma_name', 'Name', 'required');
		//$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			if($firma_id==0) {
				$this->load->view('firmen/form',array('firma'=>array(
					'firma_id'=>0,
					'firma_beschreibung'=>'',
					'firma_name'=>'',
					'firma_ort'=>'',
					'firma_strasse'=>'',
					'firma_plz'=>''
				)));
			}
			
			else {
				$this->load->view('firmen/form',array('firma'=>$this->Firmen_model->get($firma_id)));
			}
			$this->load->view('templates/footer');

		} else {

			$firma = array (
				'firma_name' => $this->input->post('firma_name'),
				'firma_ort' => $this->input->post('firma_ort'),
				'firma_strasse' => $this->input->post('firma_strasse'),
				'firma_plz' => $this->input->post('firma_plz'),
				'firma_beschreibung' => $this->input->post('firma_beschreibung'),
			);

			$this->Firmen_model->set($firma,$firma_id);
			redirect('firmen');
		}
	}
	}

	function delete($firma_id) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Messgerät wirklich löschen?',
				'target' => 'firmen/delete/'.$firma_id,
				'canceltarget' => 'firmen'
			));
			$this->load->view('templates/footer');
		} else {	
			$this->Firmen_model->delete($firma_id);
			redirect('firmen');
		}
	}



	}
	
	function json($key="") {
	    $geraete=$this->Firmen_model->getByName($key);
	    $response=array();
	    foreach($geraete as $geraet) {
	        $response[$geraet['gid']]="{$gereat['name']} {$gereat['beschreibung']}";
	        
	    }
	    
	    echo json_encode($response);
	}
}