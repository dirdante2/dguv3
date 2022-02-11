<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Log_model');
		$this->load->model('File_model');
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		//$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}


	function index() {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		 
		

			if($this->session->userdata('level')<='4'){


				$header['cronjobs']= $this->File_model->getfiles('cronjob');
				$data['errorlog_files']= $this->Log_model->getlogs('1');
				$data['privatelog_files']= $this->Log_model->getlogs('2');
				$data['cron_files']= $this->Log_model->getlogs('3');

				$this->load->view('templates/header',$header);

				$this->load->view('log/index',$data);
				$this->load->view('templates/footer');
			}
		
	}




}


