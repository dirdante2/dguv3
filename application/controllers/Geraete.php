<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');


class Geraete extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Geraete_model');
		$this->load->model('Orte_model');
		$this->load->model('Firmen_model');
		$this->load->model('Dguv3_model');
		$this->load->model('Pdf_model');
		$this->load->model('File_model');
		$this->load->model('Log_model');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($oid=null) {
		
		if($this->agent->is_mobile()){$useragent = 'mobile';} else {$useragent = 'desktop';}

		if($this->session->userdata('logged_in') !== TRUE){
			$this->load->view('templates/header_'.$useragent);
			$this->load->view('static/denied');
			$this->load->view('templates/footer');

          }else{

			$pageid =  $this->uri->segment(4);
			$data['ort'] = $this->Orte_model->get($oid);

			if(!$pageid) { $pageid =0;}		
			if($data['ort']===NULL) {$oid = NULL;}

			if(!$oid) {
				$data['ort'] = NULL; $haeder_ortsname=NULL;
				$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete');
			
			} else {
				$haeder_ortsname=$data['ort']['name'];
				$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete','oid',$oid);
			}

		

			$data["page_show_rows"] = $this->config->item('dguv3_show_page_rows_'.$useragent);
			$data['page_pages']=ceil($data["page_total_rows"] / $data["page_show_rows"]);
			$data['page_pageid']=$pageid;
			$data['page_offset']=$data["page_show_rows"] * $pageid ;

			
			
			
			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			if($this->session->userdata('level')>='2'){$firmen_firmaid=$this->session->userdata('firmaid');} else {$firmen_firmaid= NULL;}

			$data['geraete'] = $this->Geraete_model->get(null,$oid,$firmen_firmaid,$data["page_show_rows"],$data['page_offset']); //$gid=NULL,$oid=null,$firmen_firmaid=NULL,$limit=null, $offset=null
			$data['pdf_data'] = $this->File_model->get_file_pfad('1',$oid);
			$header['title']= 'Geräte '.$haeder_ortsname;
				

			


			$data['pruefungabgelaufen']= $this->config->item('dguv3_pruefungabgelaufen');
			$data['pruefungbaldabgelaufen']= $this->config->item('dguv3_pruefungbaldabgelaufen');
			/*$this->output->cache(5);*/

			$header['cronjobs']= $this->File_model->getfiles('cronjob');
			$this->load->view('templates/header_'.$useragent,$header);
			$this->load->view('templates/'.$useragent);
			$this->load->view('geraete/index_'.$useragent,$data);
			$this->load->view('templates/footer');
		}
	}


	function uebersicht($oid=NULL) {

		$data['ort'] = $this->Orte_model->get($oid);
		#print_r($data['ort']);
		# bei oid ohne eintrag setze auf null
		if($data['ort']===NULL) { 
			$oid = NULL;
			
		
		}

		if($oid) {
			#$data['ort'] = $this->Orte_model->get($oid);
			$data['geraete'] = $this->Geraete_model->get(null,$oid);
		} else {
			$data['ort'] = NULL;
			$data['geraete'] = $this->Geraete_model->get();
		}
//FIXME
		
		$data['adresse']= $this->config->item('dguv3_adresse');


		/*$this->output->cache(5);*/

		//ob_start();

		$this->load->view('templates/print/header_desktop');
		$this->load->view('templates/desktop');
		$this->load->view('geraete/uebersicht',$data);
		$this->load->view('templates/print/footer');
//$content = ob_get_contents();
    //ob_clean();

    
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


	function edit($gid=0,$oid=NULL) {

		$data['ort'] = $this->Orte_model->get($oid);
		if($this->agent->is_mobile()){$useragent = 'mobile';} else {$useragent = 'desktop';}
		#$useragent = 'desktop';
		$felder = array('oid','geraete_firmaid','hersteller','name','typ','seriennummer','nennstrom','nennspannung','leistung','hinzugefuegt','beschreibung','aktiv','schutzklasse','verlaengerungskabel','kabellaenge');

		$this->form_validation->set_rules('typ', 'Typ', 'required');
		$this->form_validation->set_rules('oid', 'Orts-ID', 'required');
		$this->form_validation->set_rules('oid', 'Ort', 'callback_oid_check'); //valid oid?
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header_'.$useragent,$header);

			//Neues Gerät
			if($gid==0) {
				foreach($felder as $feld) {
					$liste[$feld]="";
				}
				$liste['gid']=0;
					if($oid) {
					$liste['ortsname']=$data['ort']['name'].' ('.$data['ort']['beschreibung'].')';
					$liste['oid']=$oid;
					} else {$liste['ortsname']='';}

				$liste['geraete_firmaid']=$this->session->userdata('firmaid');
				$liste['aktiv']=TRUE;
				$liste['nennspannung']='230';
				$liste['schutzklasse']='2';
				$liste['hinzugefuegt']=date('Y-m-d');


				$this->load->view('geraete/form_'.$useragent,array(
					'geraet'=>$liste,
					'firmen'=> $this->Firmen_model->get()
				));
				
				



			}
			//Vorhandeses Gerät
			else {

				

				  $this->load->view('geraete/form_'.$useragent,array(
					'geraet'=>$this->Geraete_model->get($gid),
					'firmen'=> $this->Firmen_model->get()
				));



			}
			$this->load->view('templates/footer');

		} else {
			$geraet = array();

			foreach($felder as $feld) {
				$geraet[$feld]=$this->input->post($feld);
			}
			if ($geraet['geraete_firmaid']==NULL) {
				$geraet['geraete_firmaid']=$this->session->userdata('firmaid');


			}



			$this->Geraete_model->set($geraet,$gid);
			#print_r($geraet['oid']);

				// get ortsid von neu angelegtem gerät damit redirect zu richtiger seite führt?!!
			$ortsid = $geraet['oid'];

			//$this->Pdf_model->genpdf_uebersicht($gortsid);
			file_put_contents('cron/liste/'.$ortsid,$geraet['geraete_firmaid']);

			$context='Gerät bearbeitet name '.$geraet['name'].' gid '.$gid.' oid '.$geraet['oid'];
			$this->Log_model->privatlog($context);


			if($ortsid===NULL) {
				redirect('geraete');
				}
			//Vorhandeses Gerät
			else {
			redirect('geraete/index/'.$ortsid);

			}

		}
	}



	function delete($gid) {
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');
		$header['cronjobs']= $this->File_model->getfiles('cronjob');
		$geraet = $this->Geraete_model->get($gid);
//TODO userabfrage
		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Geraet wirklich löschen?',

				'target' => 'geraete/delete/'.$gid,
				'canceltarget' => 'geraete'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Geraete_model->delete($gid);


			$context='Gerät gelöscht name '.$geraet['name'].' gid '.$gid.' oid '.$geraet['oid'];
			$this->Log_model->privatlog($context);


			redirect('geraete/index/'.$geraet['oid']);
		}
	}
	function pagination($oid,$pageid) {



			redirect('geraete/index/'.$oid.'/'.$pageid);
		}

		function jsonout($oid="") {
			$data = $this->Geraete_model->pdfdata($oid);
			

			// $this->output
       		// 	 ->set_content_type('application/json', 'utf-8')
			// 		->set_output(json_encode(array($data)));

			echo json_encode($data);
		}

		function json($key="") {

			if($this->session->userdata('logged_in') !== TRUE){
				$this->load->view('templates/header',$header);
				$this->load->view('static/denied');
				$this->load->view('templates/footer');
			}else{
				
				
				

				 //userlevel 2 oder höher kann nur orte mit eigener firma sehen
				 if($this->session->userdata('level')>='2'){
					$firmen_firmaid=$this->session->userdata('firmaid');
					$geraete=$this->Geraete_model->getByName($key,$firmen_firmaid);
	
				} else {
					$geraete=$this->Geraete_model->getByName($key);
				}
	
				#print_r($geraete);
	
				
				$response=array();
				//FIXME umlaute werden nicht erkannt und zurückgeben ->fehler
				foreach($geraete as $geraet) {
					
					$geraet['dummyname']="{$geraet['name']} ({$geraet['hersteller']})({$geraet['typ']})";
					#$response[$geraet['name']]="1 {$geraet['name']} ({$geraet['hersteller']} {$geraet['typ']})";
					$response[$geraet['gid']]=$geraet;

					#$response[$geraet['typ']]=array();

					#$response[$geraet['name']]['']=

				}
				#
				#print_r($response);

				echo json_encode($response);
			}
		}
		function jsongid($gid) {

			if($this->session->userdata('logged_in') !== TRUE){
				$this->load->view('templates/header',$header);
				$this->load->view('static/denied');
				$this->load->view('templates/footer');
			}else{

			$geraete=$this->Geraete_model->get($gid);
			

		
			#print_r($geraete);
			
			echo json_encode($geraete);
			}
		}




}
