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
		$this->load->model('Firmen_model');
		$this->load->model('Orte_model');
		$this->load->model('Login_model');
		$this->load->model('File_model');
		$this->load->model('Log_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		//$this->load->library('Session_update');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($user_id=NULL) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }

		
		

			if($this->session->userdata('level')!='1'){
				$user_id=$this->session->userdata('userid');

			}

		if($user_id) {
			$data['users'] = $this->Users_model->list($user_id);
		} else {
			$data['users'] = $this->Users_model->list();
		}
		//$this->output->cache(10);
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

		$this->load->view('templates/header',$header);
		$this->load->view('templates/datatable');
		$this->load->view('users/index',$data);
		$this->load->view('templates/footer');
	
	}

	function new($user_id=NULL) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		if($this->session->userdata('level')!='1'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');

          }else{

		if($this->Users_model->get($user_id)) {
			 //
			 $users_firmaid = $this->Users_model->get($user_id)['users_firmaid'];

			$user_id = $this->Users_model->new(array(
			'users_firmaid'=>$users_firmaid
			//'oid'=>$oid,
			//'datum'=>date('Y-m-d')
			));
			$arrayold = array();
			$arraynew = $this->Users_model->get($user_id);
			$logstatus='edit';

			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				$context='User neu id '.$user_id.' ; '.$log_diff;
				#print_r($context);
				$this->Log_model->privatlog($context);
			} 



			redirect('users/edit/'.$user_id);
		} else {
			show_error('user mit der id "'.$user_id.'" existiert nicht.', 404);
		}
	}
	}

	function edit($user_id) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		
			$header['cronjobs']= $this->File_model->getfiles('cronjob');

			if($this->session->userdata('level')!='1'){
				$user_id=$this->session->userdata('userid');

			}
			$felder = array('user_oid','user_name','user_email','user_mid','user_pid','users_firmaid','user_level','user_password','user_showlink1','user_delete','user_edit','user_new','user_edituser');
			$this->form_validation->set_rules('user_name', 'Name', 'required');
			$this->form_validation->set_rules('user_email', 'Email', 'required');
			//$this->form_validation->set_rules('user_level', 'Level', 'required');
			//$this->form_validation->set_rules('users_firmaid', 'Firma', 'required');
		//$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');


		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);

			
				$this->load->view('users/form',array(
					'pruefer'=> $this->Pruefer_model->get(),
					'messgeraete'=> $this->Messgeraete_model->get(),
					'firmen'=> $this->Firmen_model->get(),
					'user'=>$this->Users_model->get($user_id)

				));
			
			$this->load->view('templates/footer');





		} else {
			$userpassword= $this->Users_model->get($user_id)['user_password'];
			$userlevel= $this->Users_model->get($user_id)['user_level'];
			$userfirmaid= $this->Users_model->get($user_id)['users_firmaid'];
			$user = array();

			foreach($felder as $feld) {
				$user[$feld]=$this->input->post($feld);
			}
			if($user['user_password']) {
				$salt= $this->config->item('passwordsalt');
				#echo $salt.$user['user_password'];

				$user['user_password']= md5($salt.$user['user_password']);
			} else {
				$user['user_password']=$userpassword;
			}

			if(!$user['users_firmaid']) {

				$user['users_firmaid']=$userfirmaid;
			}
			if(!$user['user_level']) {

				$user['user_level']=$userlevel;
			}

			$arrayold = $this->Users_model->get($user_id);

			$this->Users_model->update($user,$user_id);
			$this->Login_model->update();
			
			$arraynew = $this->Users_model->get($user_id);
			$logstatus='edit';

			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				
					$context='User bearbeitet id '.$user_id.' ; '.$log_diff;
				

				#print_r($context);
				$this->Log_model->privatlog($context);
			} 


				
				redirect('users');
		}
		

	}

	function delete($user_id) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		if($this->session->userdata('level')!='1'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$header['cronjobs']= $this->File_model->getfiles('cronjob');

		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Messgerät wirklich löschen?',
				'target' => 'users/delete/'.$user_id,
				'canceltarget' => 'Users'
			));
			$this->load->view('templates/footer');
		} else {

			$arrayold = $this->Users_model->get($user_id);
			$arraynew= array();
			$logstatus='delete';

			$this->Users_model->delete($user_id);




			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				
				$context='User gelöscht id '.$user_id.' ; '.$log_diff;
				

				#print_r($context);
				$this->Log_model->privatlog($context);
			} 


			redirect('users');
		}
	}


}

		  }
