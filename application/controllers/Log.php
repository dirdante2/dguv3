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
        } else{

			if($this->session->userdata('level')=='1'){


				$header['cronjobs']= $this->File_model->getfiles('cronjob');
				$data['errorlog_files']= $this->Log_model->getlogs('1');
				$data['privatelog_files']= $this->Log_model->getlogs('2');

				$this->load->view('templates/header',$header);

				$this->load->view('log/index',$data);
				$this->load->view('templates/footer');
			}
		}
	}




}


