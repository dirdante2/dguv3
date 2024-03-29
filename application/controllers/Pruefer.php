<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruefer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Pruefer_model');
		$this->load->model('Firmen_model');
		$this->load->model('Pdf_model');
		$this->load->model('Log_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
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
		  

		
			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');

				$data['pruefer'] = $this->Pruefer_model->get(null,$firmen_firmaid);

			} else {
				$data['pruefer'] = $this->Pruefer_model->get();
			}
			$header['title']= 'Prüfer';

			$header['cronjobs']= $this->File_model->getfiles('cronjob');


		$this->load->view('templates/header',$header);
		$this->load->view('templates/desktop');
		$this->load->view('pruefer/index',$data);
		$this->load->view('templates/footer');
		
	}

	function edit($pid=0) {

		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }

		//nur rolle 1 und 2 darf prüfer hinzufügen
		if($this->session->userdata('level')>='3'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{

			$header['cronjobs']= $this->File_model->getfiles('cronjob');

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

			if($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header',$header);

				if($pid==0) {
					$this->load->view('pruefer/form',array(
						'pruefer'=>array('pid'=>0,'beschreibung'=>'','name'=>''),
						'firmen'=> $this->Firmen_model->get()

					));
				} else {
					$this->load->view('pruefer/form',array(
						'pruefer'=>$this->Pruefer_model->get($pid),
						'firmen'=> $this->Firmen_model->get()

					));
				}
				$this->load->view('templates/footer');

			} else {

				$pruefer = array (
					'name' => $this->input->post('name'),
					'beschreibung' => $this->input->post('beschreibung'),
					'pruefer_firmaid' => $this->input->post('pruefer_firmaid'),
				);
				if ($pruefer['pruefer_firmaid']==NULL) {
					$pruefer['pruefer_firmaid']=$this->session->userdata('firmaid');


				}
				//generiere PDF übersicht
				//$this->Pdf_model->genpdf($oid);
				$this->Pruefer_model->set($pruefer,$pid);

				$pruefer = $this->Pruefer_model->get($pid);
				$context='Prüfer bearbeitet name '.$pruefer['name'].' pid '.$pruefer['pid'];
				$this->Log_model->privatlog($context);

				redirect('pruefer');

			}
		}
	}

	function delete($pid) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		  
		if(!$this->session->userdata('level')!='1'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$header['cronjobs']= $this->File_model->getfiles('cronjob');

		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Prüfer wirklich löschen?',
				'target' => 'pruefer/delete/'.$pid,
				'canceltarget' => 'pruefer'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Pruefer_model->delete($pid);

			$pruefer = $this->Pruefer_model->get($pid);
			$context='Prüfer gelöscht name '.$pruefer['name'].' pid '.$pruefer['pid'];
			$this->Log_model->privatlog($context);

			redirect('pruefer');
		}
	}
	}

	function json($key="") {
		$prueferliste=$this->Pruefer_model->getByName($key);
		$response=array();
		foreach($prueferliste as $pruefer) {
			$response[$pruefer['pid']]="{$pruefer['name']} {$pruefer['beschreibung']}";
		}

		echo json_encode($response);
	}

}
