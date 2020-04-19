<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Messgeraete extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Messgeraete_model');
		$this->load->model('Firmen_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index() {
		if($this->session->userdata('logged_in') !== TRUE){
			$this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');

				$data['messgeraete'] = $this->Messgeraete_model->get(null,$firmen_firmaid);
			} else {
				$data['messgeraete'] = $this->Messgeraete_model->get();
			}


		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('messgeraete/index',$data);
		$this->load->view('templates/footer');
	}
	}

	function edit($mid=0) {
		if($this->session->userdata('logged_in') !== TRUE){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			if($mid==0) {
				$this->load->view('messgeraete/form',array(
					'messgeraet'=>array('mid'=>0,'beschreibung'=>'','name'=>''),
					'firmen'=> $this->Firmen_model->get()
				
				));
			}
			
			else {
				$this->load->view('messgeraete/form',array(
					'messgeraet'=>$this->Messgeraete_model->get($mid),
					'firmen'=> $this->Firmen_model->get()
				
				));
			}
			$this->load->view('templates/footer');

		} else {

			$messgeraet = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
				'messgeraete_firmaid' => $this->input->post('messgeraete_firmaid'),
			);
			if ($messgeraet['messgeraete_firmaid']==NULL) {
				$messgeraet['messgeraete_firmaid']=$this->session->userdata('firmaid');
				

			}
			

			$this->Messgeraete_model->set($messgeraet,$mid);
			redirect('messgeraete');
		}
	}
	}

	function delete($mid) {
		if(!$this->session->userdata('level')=='1'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Messgerät wirklich löschen?',
				'target' => 'messgeraete/delete/'.$mid,
				'canceltarget' => 'messgeraete'
			));
			$this->load->view('templates/footer');
		} else {	
			$this->Messgeraete_model->delete($mid);
			redirect('messgeraete');
		}
	}



	}
	
	function json($key="") {
	    $geraete=$this->Messgeraete_model->getByName($key);
	    $response=array();
	    foreach($geraete as $geraet) {
	        $response[$geraet['gid']]="{$gereat['name']} {$gereat['beschreibung']}";
	        
	    }
	    
	    echo json_encode($response);
	}
}