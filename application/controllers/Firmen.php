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
		$this->load->model('Pdf_model');
		$this->load->model('Orte_model');
		$this->load->model('File_model');
		$this->load->model('Log_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($firmen_firmaid=NULL) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		  
		
		
			//echo $this->session->userdata('level');
			//echo $this->session->userdata('firmaid');

			if($this->session->userdata('level')!=1){
				$firmen_firmaid=$this->session->userdata('firmaid');

			}

		if($firmen_firmaid) {
			$data['firmen'] = $this->Firmen_model->list($firmen_firmaid);
		} else {
			$data['firmen'] = $this->Firmen_model->list();
		}
		//$this->output->cache(10);
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

		$this->load->view('templates/header',$header);
		$this->load->view('templates/datatable');
		$this->load->view('firmen/index',$data);
		$this->load->view('templates/footer');
	
	}

	function edit($firmen_firmaid=0) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		//admin prüfer verwalter dürfen bearbeiten
		if($this->session->userdata('level')>='4'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			  //alle außer admin dürfen nur eigene firma bearbeiten
			if($this->session->userdata('level')!='1'){
				$firmen_firmaid=$this->session->userdata('firmaid');

			}
		$this->form_validation->set_rules('firma_name', 'Name', 'required');
		$this->form_validation->set_rules('firma_beschreibung', 'Beschreibung', 'required');
		$this->form_validation->set_rules('firma_ort', 'Ort', 'required');
		$this->form_validation->set_rules('firma_plz', 'PLZ', 'required');
		$this->form_validation->set_rules('firma_strasse', 'Strasse', 'required');
		$header['cronjobs']= $this->File_model->getfiles('cronjob');


		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);

			if($firmen_firmaid==0) {
				$this->load->view('firmen/form',array('firma'=>array(
					'firmen_firmaid'=>0,
					'firma_name'=>'',
					'firma_ort'=>'',
					'firma_strasse'=>'',
					'firma_plz'=>'',
					'firma_beschreibung'=>''
				)));
			}

			else {
				$this->load->view('firmen/form',array('firma'=>$this->Firmen_model->get($firmen_firmaid)));
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
			//generiere PDF übersicht
			//$this->Pdf_model->genpdf($oid);

			$this->Firmen_model->set($firma,$firmen_firmaid);


			$firma = $this->Firmen_model->get($firmen_firmaid);

			$context='Firma bearbeitet name '.$firma['firma_name'].' firmaid '.$firma['firmen_firmaid'];
			$this->Log_model->privatlog($context);


			redirect('firmen');
		}

	}
	}

	function delete($firmen_firmaid) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		//nur admin darf löschen
		if($this->session->userdata('level')!=1){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Messgerät wirklich löschen?',
				'target' => 'firmen/delete/'.$firmen_firmaid,
				'canceltarget' => 'firmen'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Firmen_model->delete($firmen_firmaid);

			$firma = $this->Firmen_model->get($firmen_firmaid);

			$context='Firma bearbeitet name '.$firma['firma_name'].' firmaid '.$firma['firmen_firmaid'];
			$this->Log_model->privatlog($context);

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
