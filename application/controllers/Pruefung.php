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
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($gid=NULL) {
        if($gid) {
            $data['geraet'] = $this->Geraete_model->getByOid($gid);
        }
        $data['pruefung'] = $this->Pruefung_model->get($gid);

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('pruefung/index',$data);
		$this->load->view('templates/footer');
	}


	function pruefung($oid=NULL) {
		if($oid) {
			$data['ort'] = $this->Orte_model->get($oid);
			$data['pruefung'] = $this->Pruefung_model->getByOid($oid);
		} else {
			$data['ort'] = NULL;
			$data['pruefung'] = $this->Pruefung_model->get();
		}

		$this->load->view('templates/print/header');
		$this->load->view('templates/datatable');
		$this->load->view('pruefung/pruefung',$data);
		$this->load->view('templates/print/footer');
	}



	/**
	 * Checks if an oid exists
	 * @param oid OID
	 * @return TRUE / FALSE
	 */
	public function oid_check($oid) {
		if($this->Orte_model->get($oid)) {
			return TRUE;
		} else {
			 $this->form_validation->set_message('oid_check', 'Unbekannter Ort');
			return FALSE;
		}
	}


	function edit($gid=0) {
		$felder = array('gid','datum','mid','pid','sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion','bestanden','bemerkung');

	
		$this->form_validation->set_rules('gid', 'Greraete-ID', 'required');
		$this->form_validation->set_rules('gid', 'Geraet', 'callback_oid_check'); //valid gid?

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			//Neues Gerät
			if($gid==0) {
				/* foreach($felder as $feld) {
					$liste[$feld]="";
				}
				$liste['gid']=0;
				$liste['ortsname']='';
				$liste['aktiv']=TRUE;
				$liste['schutzklasse']='2';
				$liste['hinzugefuegt']=date('Y-m-d');
				$this->load->view('pruefung/form',array('geraet'=>$liste)); */
			}
			//Vorhandeses Gerät
			else {
				$this->load->view('pruefung/form',array('geraet'=>$this->Pruefung_model->get($gid)));
			}
			$this->load->view('templates/footer');

		} else {
			$geraet = array();
                        $fields_request = array('sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion');
			foreach($felder as $feld) {
				$geraet[$feld]=$this->input->post($feld);
			}
                        $geraet['bestanden'] = 1;
                        foreach ($fields_request as $key) {
                            if ($geraet[$key] == 0) {
                                $geraet['bestanden'] = 0;
                            }
                        }
			$this->Pruefung_model->set($geraet,$gid);
			redirect('pruefung');
		}
	}

	function delete($gid) {
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Geraet wirklich löschen?',
				'target' => 'pruefung/delete/'.$gid,
				'canceltarget' => 'pruefung'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Pruefung_model->delete($gid);
			redirect('pruefung');
		}



	}
	
}
