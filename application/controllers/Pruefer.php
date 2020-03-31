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
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index() {

		$data['pruefer'] = $this->Pruefer_model->get();

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('pruefer/index',$data);
		$this->load->view('templates/footer');
	}

	function edit($pid=0) {

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			if($pid==0) {
				$this->load->view('pruefer/form',array('pruefer'=>array('pid'=>0,'beschreibung'=>'','name'=>'')));
			}
			
			else {
				$this->load->view('pruefer/form',array('pruefer'=>$this->Pruefer_model->get($pid)));
			}
			$this->load->view('templates/footer');

		} else {

			$pruefer = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
			);

			$this->Pruefer_model->set($pruefer,$pid);
			redirect('pruefer');
		}
	}

	function delete($pid) {
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Prüfer wirklich löschen?',
				'target' => 'pruefer/delete/'.$pid,
				'canceltarget' => 'pruefer'
			));
			$this->load->view('templates/footer');
		} else {	
			$this->Pruefer_model->delete($pid);
			redirect('pruefer');
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