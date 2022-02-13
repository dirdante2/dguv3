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
		$this->load->model('Dguv3_model');
		$this->load->model('Messgeraete_model');
		$this->load->model('Pdf_model');
		$this->load->model('Orte_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($gid=NULL) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		  
		


			$pageid =  $this->uri->segment(4);
			if(!$pageid) { $pageid =0;}



			$data['geraet'] = $this->Geraete_model->get($gid);
			# bei oid ohne eintrag setze auf null
			#print_r($data['geraet']);
			#var_dump(count($data['geraet']));

			if($data['geraet']===NULL) {$gid = NULL;}
			

			if($gid) {
				#$data['geraet'] = $this->Geraete_model->get($gid);
				$data["page_total_rows"] = $this->Dguv3_model->getcountdata('pruefung','gid',$gid); // count prüfungen wenn auf gerät begrenzt
				$header['title']= 'Prüfung '.$data['geraet']['name'];
			} else {
				$data['geraet'] = NULL;
				$data["page_total_rows"] = $this->Dguv3_model->getcountdata('pruefung'); //count alle prüfungen
				$header['title']= 'Prüfung';

			}

			if($this->agent->is_mobile()){
				$data["page_show_rows"] = $this->config->item('dguv3_show_page_rows_mobile');
			} else {
				$data["page_show_rows"] = $this->config->item('dguv3_show_page_rows_desktop');

			}
			$data['page_pages']=ceil($data["page_total_rows"] / $data["page_show_rows"]);
			$data['page_pageid']=$pageid;
			$data['page_offset']=$data["page_show_rows"] * $pageid ;


			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');

				if($gid) {
					$data['pruefung'] = $this->Pruefung_model->list($gid,$firmen_firmaid,$data["page_show_rows"],$data['page_offset']); //prüfungen mit einer gid

				} else {
					$data['pruefung'] = $this->Pruefung_model->list(null,$firmen_firmaid,$data["page_show_rows"],$data['page_offset']); //alle prüfungen

				}


			} else {
				if($gid) {
					//admin
					$data['pruefung'] = $this->Pruefung_model->list($gid,null,$data["page_show_rows"],$data['page_offset']); //prüfungen mit einer gid

				} else {
					$data['pruefung'] = $this->Pruefung_model->list(null,null,$data["page_show_rows"],$data['page_offset']); //alle prüfungen

				}
			}
			$pdffile_data=array();
			foreach($data['pruefung'] as $pruefung) {
				$pdf_pfad=$this->File_model->get_file_pfad('2',$pruefung['pruefungid']);
				$pdffile_data[$pruefung['pruefungid']]=$pdf_pfad;

			}
			$data['pdf_data']=$pdffile_data;

		$data['pruefungabgelaufen']= $this->config->item('dguv3_pruefungabgelaufen');
		$data['pruefungbaldabgelaufen']= $this->config->item('dguv3_pruefungbaldabgelaufen');
		//$this->output->enable_profiler(TRUE);
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

		if($this->agent->is_mobile()){
			$this->load->view('templates/header_mobile',$header);
			$this->load->view('templates/scroll');
			$this->load->view('pruefung/index_mobile',$data);
		  } else {
			$this->load->view('templates/header',$header);
			$this->load->view('templates/datatable');
			$this->load->view('pruefung/index',$data);
		  }

			$this->load->view('templates/footer');
			

	}
//TODO abfrage ob user eingeloggt ist
	function protokoll($pruefung_id=NULL) {
		if($pruefung_id) {
			$data['pruefung'] = $this->Pruefung_model->get($pruefung_id);


		}

		#print_r($data['pruefung']['schutzklasse']);
		$data['dguv3_logourl']= $this->config->item('dguv3_logourl');

		if($data['pruefung']['schutzklasse']<='3') {
			//elektro geräte
			$data['dguv3_header']= $this->config->item('dguv3_protokoll_header1');
		} elseif ($data['pruefung']['schutzklasse']=='4') {
			//leitern
			$data['dguv3_header']= $this->config->item('dguv3_protokoll_header2');
		} else {
			$data['dguv3_header']= 'Diese Prüfung ist ungültig weil es keine überschrift gibt?!';
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
		site_denied($this->session->userdata('logged_in'));

		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }

		

			$header['cronjobs']= $this->File_model->getfiles('cronjob');

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
		$firma_id = $this->Geraete_model->get($gid)['geraete_firmaid'];


		$header['title']= 'Prüfung '.$geraetename;

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);
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
			if($pruefung['schutzleiter']>$RPEmax && $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;

			}
			if($pruefung['isowiderstand']<2.0 && $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;

			}
			if($pruefung['schutzleiterstrom']>=0.5 && $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;
			}
			if($pruefung['beruehrstrom']>0.25 && $schutzklasse!=4) {
				$pruefung['bestanden'] = 0;
			}

			//setze firma id auf die gleiche des gerätes
			$pruefung['pruefung_firmaid'] =$firma_id;


			$this->Pruefung_model->update($pruefung,$pruefung_id);

			//generiere PDF übersicht
			//$this->Pdf_model->genpdf_uebersicht($ortsid);
			file_put_contents('cron/liste/'.$ortsid,$pruefung['pruefung_firmaid']);

			//$this->Pdf_model->genpdf_protokoll($pruefung_id);
			file_put_contents('cron/protokoll/'.$pruefung_id,$pruefung['pruefung_firmaid']);

			$pruefung = $this->Pruefung_model->get($pruefung_id);

			$context='Prüfung bearbeitet name '.$pruefung['geraetename'].' pruefungid '.$pruefung['pruefungid'].' ort '.$pruefung['ortsname'];
			$this->Log_model->privatlog($context);

			redirect('pruefung/index/'.$gid);
		}
	
	}

	function delete($pruefung_id) {
		if(!$this->session->userdata('level')){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$header['cronjobs']= $this->File_model->getfiles('cronjob');

		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Prüfung wirklich löschen?',
				'target' => 'pruefung/delete/'.$pruefung_id,
				'canceltarget' => 'pruefung'
			));
			$this->load->view('templates/footer');
		} else {
			$pruefung = $this->Pruefung_model->get($pruefung_id);
			$filename = $this->File_model->get_file_pfad('2', $pruefung_id);

			$this->Pruefung_model->delete($pruefung_id);

			$cron_protokoll_pfad = 'cron/protokoll/';

			if (file_exists($cron_protokoll_pfad.$pruefung_id)) {
				unlink($cron_protokoll_pfad.$pruefung_id);
				}

			
			if (file_exists($filename)) {
				unlink($filename);
				}

			
			$context='Prüfung gelöscht name '.$pruefung['geraetename'].' pruefungid '.$pruefung['pruefungid'].' ort '.$pruefung['ortsname'];
			$this->Log_model->privatlog($context);


			redirect('pruefung');
		}
		}



	}

	function pagination($gid,$pageid) {


		#path with end /,oid,pageid
		site_pagination('geraete/index/',$gid,$pageid);
		
	}

	function json($pruefung_id="") {
		$data = $this->Pruefung_model->pdfdata($pruefung_id);
		echo json_encode($data);
	}

}
