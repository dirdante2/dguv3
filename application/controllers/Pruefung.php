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
            // $this->load->view('templates/header');
            // TODO check how show_error works
            show_error('Gerät mit der id "'.$gid.'" existiert nicht.', 404);
            // $this->load->view('templates/footer');
        }
	}

    private function getGid($pruefung_id) {
        $pruefung = $this->Pruefung_model->get($pruefung_id);
        return $pruefung['gid'];
    }

    /*Verlängerungskabel
      Laut Norm darf der RPE (schutzleiter)
      0,3 Ohm für die ersten 5m betragen
      für jede weiteren 7,5m 0,1 Ohm mehr
      maximal jedoch 1 Ohm.*/
    // sze: TODO check by dante
    // sze: TODO add unit tests for this function
    // sze: check(0.3, kabellaengeToRPEmax(1))
    // sze: check(0.3, kabellaengeToRPEmax(5))
    // sze: check(0.4, kabellaengeToRPEmax(12.5))
    // sze: check(0.5, kabellaengeToRPEmax(20))
    // sze: check(1,   kabellaengeToRPEmax(1000000))
    private function kabellaengeToRPEmax($kabellaenge) {
        $first_kl = 5;
        $first = min($kabellaenge, $first_kl);
        $rest  = max(0, $kabellaenge - $first_kl);
        $rest_ohm = 0.1;
        $rest_ratio = 1 / 7.5;

        $rpe_max = min(0.3 + $rest * $rest_ratio * $rest_ohm, 1);
        return $rpe_max;
    }

    function edit($pruefung_id) {
        if(!$this->Pruefung_model->get($pruefung_id)) {
            // $this->load->view('templates/header');
            // TODO check how show_error works
            show_error('Prüfung mit der id "'.$pruefung_id.'" existiert nicht.', 404);
            // $this->load->view('templates/footer');
            return NULL;
        }

		$felder = array('datum','mid','pid','sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion','bestanden','bemerkung');

		$this->form_validation->set_rules('mid', 'Messgerät', 'callback_mid_check');
		$this->form_validation->set_rules('pid', 'Prüfer', 'callback_pid_check');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
            $this->load->view('pruefung/form', array(
                    'pruefer'=> $this->Pruefer_model->get(),
                    'messgeraete'=> $this->Messgeraete_model->get(),
                    'geraet'=>$this->Pruefung_model->get($pruefung_id)
                    ));
			$this->load->view('templates/footer');

		} else {
			$geraet = array();
            $fields_request = array('sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion');
			foreach($felder as $feld) {
			    if($this->input->post($feld) == '') {
			        $geraet[$feld]=null;
			    } else {
				    $geraet[$feld]=$this->input->post($feld);
			    }
			}
			/*Verälngerungskabel
			Laut Norm darf der RPE (schutzleiter)
			0,3 Ohm für die ersten 5m betragen
			für jede weiteren 7,5m 0,1 Ohm mehr
			maximal jedoch 1 Ohm.*/
			
            $geraet['bestanden'] = 1;
            
            //Kriterein
            if($geraet['funktion']==0) {
                $geraet['bestanden'] = 0;
            }
            
            if($geraet['sichtpruefung']==0) {
                $geraet['bestanden'] = 0;
            }
            
            if($geraet['schutzleiter']>0.3) {
                //TODO: Kabellänge
                $geraet['bestanden'] = 0;
            }
            
            if($geraet['isowiderstand']<2.0) {
                $geraet['bestanden'] = 0;
            }
            
            if($geraet['schutzleiterstrom']>0.5) {
                $geraet['bestanden'] = 0;
            }
            
            if($geraet['beruehrstrom']>0.25) {
                $geraet['bestanden'] = 0;
            }
            
            
            
			$this->Pruefung_model->update($geraet,$pruefung_id);
            $pruefung = $this->Pruefung_model->get($pruefung_id);
            redirect('pruefung/index/'.$pruefung['gid']);
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
