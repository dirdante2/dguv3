<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Geraete_model');
		$this->load->model('Pruefer_model');
		$this->load->model('Messgeraete_model');
		$this->load->model('Orte_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($user_id=NULL) {
		if(!$this->session->userdata('level')){
			$this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		

		if($user_id) {
			$data['users'] = $this->Users_model->get($user_id);
		} else {
			$data['users'] = $this->Users_model->get();
		}

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('users/index',$data);
		$this->load->view('templates/footer');
	}
	}



	function edit($user_id=0) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('name', 'Name', 'required');
		//$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');
		

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			
			if($user_id==0) {
				$this->load->view('users/form',array(
					'pruefer'=> $this->Pruefer_model->get(),
					'messgeraete'=> $this->Messgeraete_model->get(),
					
					'user'=>array('user_id'=>0,'user_name'=>'','user_oid'=>'')
				
				));
			} else {
				$this->load->view('users/form',array(
					'pruefer'=> $this->Pruefer_model->get(),
					'messgeraete'=> $this->Messgeraete_model->get(),
					'user'=>$this->Users_model->get($user_id)
				
				));
			}
			$this->load->view('templates/footer');
			
			



		} else {

			$user = array (
				'name' => $this->input->post('name'),
				
			);

			$this->Users_model->set($user,$user_id);
			redirect('users');
		}
	}
	}

	function delete($user_id) {
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
				'target' => 'users/delete/'.$user_id,
				'canceltarget' => 'Users'
			));
			$this->load->view('templates/footer');
		} else {	
			$this->Users_model->delete($user_id);
			redirect('users');
		}
	}



	}
	
	
}