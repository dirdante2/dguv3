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



/**
	 * Checks if an gid exists
	 * @param gid geräte id
	 * @return TRUE / FALSE
	 
	 funktioniert noch nicht ganz?
	 keine abfrage auf diese funktion vorhanden
	 */
	public function gid_check($gid) {
		if($this->Gerate_model->get($gid)) {
			return TRUE;
		} else {
			 $this->form_validation->set_message('gid_check', 'Unbekanntes Gerät');
			return FALSE;
		}
	}
	function new($gid) {
        $pruefung_id = $this->Pruefung_model->new(array('gid'=>$gid));
        redirect('pruefung/edit/'.$pruefung_id);
	}

    function edit($pruefung_id) {
		$felder = array('datum','mid','pid','sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion','bestanden','bemerkung');
			
					$this->form_validation->set_rules('pid', 'Pid', 'required');
					$this->form_validation->set_rules('mid', 'Mid', 'required');
					//$this->form_validation->set_rules('oid', 'Ort', 'callback_oid_check'); //valid oid?
					
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
