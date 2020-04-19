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
		if($this->session->userdata('logged_in') !== TRUE){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{

			if($gid) {
				$data['geraet'] = $this->Geraete_model->get($gid);
			} else {
				$data['geraet'] = NULL;
			}

			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');
				$data['pruefung'] = $this->Pruefung_model->list($gid,$firmen_firmaid);
				
			} else {
				$data['pruefung'] = $this->Pruefung_model->list($gid);
			}
			
		
		$data['pruefungabgelaufen']= $this->config->item('dguv3_pruefungabgelaufen');
		$data['pruefungbaldabgelaufen']= $this->config->item('dguv3_pruefungbaldabgelaufen');
		

		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('pruefung/index',$data);
		$this->load->view('templates/footer');
	}
	}

	function protokoll($pruefung_id=NULL) {
		if($pruefung_id) {
			$data['pruefung'] = $this->Pruefung_model->getnotarray($pruefung_id);

		
		}
		
		

		$data['logourl']= $this->config->item('dguv3_logourl');
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
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		if($this->Geraete_model->get($gid)) {
			 $oid = $this->Geraete_model->get($gid)['oid'];
			$pruefung_id = $this->Pruefung_model->new(array(
			'gid'=>$gid,
			'oid'=>$oid,
			'datum'=>date('Y-m-d')
			));
			redirect('pruefung/edit/'.$pruefung_id);
		} else {
			show_error('Gerät mit der id "'.$gid.'" existiert nicht.', 404);
		}
	}
	}

	private function getGid($pruefung_id) {
		$pruefung = $this->Pruefung_model->get($pruefung_id);
		return $pruefung['gid'];
	}


	function edit($pruefung_id) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
		if(!$this->Pruefung_model->get($pruefung_id)) {
			show_error('Prüfung mit der id "'.$pruefung_id.'" existiert nicht.', 404);
			return NULL;
		}

		$felder = array('datum','oid','mid','pid','sichtpruefung','schutzleiter','isowiderstand','schutzleiterstrom','beruehrstrom','funktion','bestanden','bemerkung');

		$this->form_validation->set_rules('mid', 'Messgerät', 'callback_mid_check');
		$this->form_validation->set_rules('pid', 'Prüfer', 'callback_pid_check');

		$gid = $this->getGid($pruefung_id);
		$RPEmax = $this->Geraete_model->getRPEmax($gid);
		
		$schutzklasse = $this->Geraete_model->get($gid)['schutzklasse'];
		$geraetename = $this->Geraete_model->get($gid)['name'];
		$ortsid = $this->Geraete_model->get($gid)['oid'];
		$ortsname = $this->Geraete_model->get($gid)['ortsname'];
		
		
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
			if($schutzklasse!=4) {
				
				$pruefung['RPEmax'] = $RPEmax;		
			}
			$pruefung['bestanden'] = 1;
			
			//schutzklasse 4=Leiter
			//Kriterein
			if($pruefung['funktion']==0) {
				$pruefung['bestanden'] = 0;
			}
			if($pruefung['sichtpruefung']==0) {
				$pruefung['bestanden'] = 0;
			}			
			if($pruefung['schutzleiter']>$RPEmax & $schutzklasse!=4) {
				// sze: TODO check by dante
				$pruefung['bestanden'] = 0;
				
			}
			if($pruefung['isowiderstand']<2.0 & $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;
				
			}
			if($pruefung['schutzleiterstrom']>=0.5 & $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;
			}
			if($pruefung['beruehrstrom']>0.25 & $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;
			}
			

			$this->Pruefung_model->update($pruefung,$pruefung_id);
			$prdatum = $this->Pruefung_model->get($pruefung_id)['datum'];
			
			//prüfung als pdf speichern
					if($pruefung['bestanden']='1'){
						$bestanden='ok';
					} else {
						$bestanden='fail';
					}
						$timestamp = strtotime($prdatum);
						$year = date("Y", $timestamp);
						$html2pdf_api_key= $this->config->item('html2pdf_api_key');
        		$html2pdf_user_pass= $this->config->item('html2pdf_user_pass');
        		if (!file_exists('pdf/'.$year.'/'.$ortsname)) { mkdir('pdf/'.$year.'/'.$ortsname, 0755, true); }
        		
           // echo "This is Button1 that is selected"; 
           // echo $ortsid;
            //$apikey = '93fa945c-3a01-4fff-a966-3a2f069a1539';
           
						$value = site_url('pruefung/protokoll/'.$pruefung_id); // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
						$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($html2pdf_api_key) . "&value=" .$value . $html2pdf_user_pass);
						file_put_contents('pdf/'.$year.'/'.$ortsname.'/GID'.$gid.'_'.$geraetename.'_PID'.$pruefung_id.'_'.$prdatum.'_'.$bestanden.'.pdf',$result);
			
			
			redirect('pruefung/index/'.$gid);
		}
	}
	}

	function delete($pruefung_id) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
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

}
