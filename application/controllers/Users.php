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
			$data['users'] = $this->Users_model->list($user_id);
		} else {
			$data['users'] = $this->Users_model->list();
		}

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('users/index',$data);
		$this->load->view('templates/footer');
	}
	}

	function new($user_id) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		if($this->Users_model->get($user_id)) {
			 //

			$user_id = $this->Users_model->new(array(
			'user_firmaid'=>'1'
			//'oid'=>$oid,
			//'datum'=>date('Y-m-d')
			));
			redirect('users/edit/'.$user_id);
		} else {
			show_error('user mit der id "'.$user_id.'" existiert nicht.', 404);
		}
	}
	}

	function edit($user_id=0) {
		if(!$this->session->userdata('level')){

			

          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$felder = array('user_oid','user_name','user_email','user_mid','user_pid','user_firmaid','user_level','user_password');
		$this->form_validation->set_rules('user_name', 'Name', 'required');
		//$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');
		

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			
			if($user_id==0) {
				$this->load->view('users/form',array(
					'pruefer'=> $this->Pruefer_model->get(),
					'messgeraete'=> $this->Messgeraete_model->get(),
					
					'user'=>array('user_id'=>0,'user_name'=>'','user_oid'=>'','ortsname'=>'')
				
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

			$user = array();

			foreach($felder as $feld) {
				$user[$feld]=$this->input->post($feld);
			}
			
			$this->Users_model->update($user,$user_id);
				// get ortsid von neu angelegtem gerät damit redirect zu richtiger seite führt?!!
			//$gortsid = $this->Geraete_model->get($gid);
			
			//if($gid==0) {
				redirect('users');
			//	}
			//Vorhandeses Gerät
			//else {
			//redirect('geraete/index/'.$gortsid['oid']);
			//}
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