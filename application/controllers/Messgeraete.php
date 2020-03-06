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
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index() {

		$data['messgeraete'] = $this->Messgeraete_model->get();

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('messgeraete/index',$data);
		$this->load->view('templates/footer');
	}

	function edit($mid=0) {

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			if($mid==0) {
				$this->load->view('messgeraete/form',array('messgeraet'=>array('mid'=>0,'beschreibung'=>'','name'=>'')));
			}
			
			else {
				$this->load->view('messgeraete/form',array('messgeraet'=>$this->Messgeraete_model->get($mid)));
			}
			$this->load->view('templates/footer');

		} else {

			$messgeraet = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
			);

			$this->Messgeraete_model->set($messgeraet,$mid);
			redirect('messgeraete');
		}
	}

	function delete($mid) {
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