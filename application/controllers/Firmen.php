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

	function edit($mid=0) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		//$this->form_validation->set_rules('name', 'Name', 'required');
		//$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			if($mid==0) {
				$this->load->view('firmen/form',array('messgeraet'=>array('mid'=>0,'beschreibung'=>'','name'=>'')));
			}
			
			else {
				$this->load->view('firmen/form',array('messgeraet'=>$this->Firmen_model->get($mid)));
			}
			$this->load->view('templates/footer');

		} else {

			$messgeraet = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
			);

			$this->Firmen_model->set($messgeraet,$mid);
			redirect('firmen');
		}
	}
	}

	function delete($mid) {
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
				'target' => 'firmen/delete/'.$mid,
				'canceltarget' => 'firmen'
			));
			$this->load->view('templates/footer');
		} else {	
			$this->Firmen_model->delete($mid);
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