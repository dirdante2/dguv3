<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');

class Pruefung extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Pruefung_model');
		$this->load->model('Geraete_model');
		$this->load->model('Pruefer_model');
		$this->load->model('Messgeraete_model');
		$this->load->model('Orte_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($gid=NULL) {
		if($gid) {
			$data['geraet'] = $this->Geraete_model->get($gid);
		} else {
			$data['geraet'] = NULL;
		}
		$data['pruefung'] = $this->Pruefung_model->list($gid);

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('pruefung/index',$data);
		$this->load->view('templates/footer');
	}

	function protokoll($pruefung_id=NULL) {
		if($pruefung_id) {
			$data['pruefung'] = $this->Pruefung_model->getnotarray($pruefung_id);
		}

		$this->load->view('templates/print/header');
		$this->load->view('templates/datatable');
		$this->load->view('pruefung/protokoll',$data);
		$this->load->view('templates/print/footer');
	}

	public function mid_check($mid) {
		if($this->Messgeraete_model->get($mid)) {
			return TRUE;
		} else {
			 $this->form_validation->set_message('mid_check', 'Unbekanntes Messgerät');
			return FALSE;
		}
	}
	public function pid_check($pid) {
		if($this->Pruefer_model->get($pid)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('pid_check', 'Unbekannter Prüfer');
			return FALSE;
		}
	}

	function new($gid) {
		if($this->Geraete_model->get($gid)) {
			$pruefung_id = $this->Pruefung_model->new(array('gid'=>$gid));
			redirect('pruefung/edit/'.$pruefung_id);
		} else {
			show_error('Gerät mit der id "'.$gid.'" existiert nicht.', 404);
		}
	}

	private function getGid($pruefung_id) {
		$pruefung = $this->Pruefung_model->get($pruefung_id);
		return $pruefung['gid'];
	}


	function edit($pruefung_id) {
		if(!$this->Pruefung_model->get($pruefung_id)) {
			show_error('Prüfung mit der id "'.$pruefung_id.'" existiert nicht.', 404);
			return NULL;
		}

		$felder = array('datum','mid','pid','sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion','bestanden','bemerkung');

		$this->form_validation->set_rules('mid', 'Messgerät', 'callback_mid_check');
		$this->form_validation->set_rules('pid', 'Prüfer', 'callback_pid_check');

		$gid = $this->getGid($pruefung_id);
		$RPEmax = $this->Geraete_model->getRPEmax($gid);

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('pruefung/form', array(
					'pruefer'=> $this->Pruefer_model->get(),
					'messgeraete'=> $this->Messgeraete_model->get(),
					'geraet'=>$this->Pruefung_model->get($pruefung_id),
					'RPEmax'=>$RPEmax
					));
			$this->load->view('templates/footer');

		} else {
			$pruefung = array();
			$fields_request = array('sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion');
			foreach($felder as $feld) {
				if($this->input->post($feld) == '') {
					$pruefung[$feld]=null;
				} else {
					$pruefung[$feld]=$this->input->post($feld);
				}
			}

			$pruefung['RPEmax'] = $RPEmax;
			$pruefung['bestanden'] = 1;

			//Kriterein
			if($pruefung['funktion']==0) {
				$pruefung['bestanden'] = 0;
			}

			if($pruefung['sichtpruefung']==0) {
				$pruefung['bestanden'] = 0;
			}

			if($pruefung['schutzleiter']>=$RPEmax) {
				// sze: TODO check by dante
				$pruefung['bestanden'] = 0;
			}

			if($pruefung['isowiderstand']<=2.0) {
				$pruefung['bestanden'] = 0;
			}

			if($pruefung['schutzleiterstrom']>=0.5) {
				$pruefung['bestanden'] = 0;
			}

			if($pruefung['beruehrstrom']>=0.25) {
				$pruefung['bestanden'] = 0;
			}

			$this->Pruefung_model->update($pruefung,$pruefung_id);
			redirect('pruefung/index/'.$gid);
		}
	}

	function delete($pruefung_id) {
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Prüfung wirklich löschen?',
				'target' => 'pruefung/delete/'.$pruefung_id,
				'canceltarget' => 'pruefung'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Pruefung_model->delete($pruefung_id);
			redirect('pruefung');
		}



	}

}
