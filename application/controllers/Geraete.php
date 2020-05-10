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




		if($this->session->userdata('logged_in') !== TRUE){
			if($this->agent->is_mobile()){
				$this->load->view('templates/header_mobile');
			} else {
				$this->load->view('templates/header');
			}
			$this->load->view('static/denied');
			$this->load->view('templates/footer');

          }else{

			$pageid =  $this->uri->segment(4);
			if(!$pageid) { $pageid =0;}
			if($oid) {
			$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete','oid',$oid);
			} else{
			$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete');
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

				if($oid) {
					$data['ort'] = $this->Orte_model->get($oid);
					$data['geraete'] = $this->Geraete_model->get(null,$oid,$firmen_firmaid);
					$data['pdf_data'] = $this->File_model->get_file_pfad('1',$oid);
					$header['title']= 'Geräte '.$data['ort']['name'];
				} else {
					$data['ort'] = NULL;
					$data['geraete'] = $this->Geraete_model->get(null,null,$firmen_firmaid,$data["page_show_rows"],$data['page_offset']); //$gid=NULL,$oid=null,$firmen_firmaid=NULL,$limit=null, $offset=null
					$header['title']= 'Geräte';
				}

			} else {
				//admin ansicht

				if($oid) {
					$data['ort'] = $this->Orte_model->get($oid);
					$data['geraete'] = $this->Geraete_model->get(null,$oid);
					$header['title']= 'Geräte '.$data['ort']['name'];

					$data['pdf_data'] = $this->File_model->get_file_pfad('1',$oid);
				} else {
					$data['ort'] = NULL;
					$data['geraete'] = $this->Geraete_model->get(null,null,null,$data["page_show_rows"],$data['page_offset']); //$gid=NULL,$oid=null,$firmen_firmaid=NULL,$limit=null, $offset=null
					$header['title']= 'Geräte';
				}
			}


		$data['pruefungabgelaufen']= $this->config->item('dguv3_pruefungabgelaufen');
		$data['pruefungbaldabgelaufen']= $this->config->item('dguv3_pruefungbaldabgelaufen');
		/*$this->output->cache(5);*/

		$header['cronjobs']= $this->File_model->getfiles('cronjob');


		if($this->agent->is_mobile()){
		$this->load->view('templates/header_mobile',$header);
		$this->load->view('templates/scroll');
		$this->load->view('geraete/index_mobile',$data);
      } else {
		$this->load->view('templates/header',$header);
		$this->load->view('templates/datatable');
		$this->load->view('geraete/index',$data);
      }

		$this->load->view('templates/footer');
		}
	}


	function uebersicht($oid=NULL) {

		if($oid) {
			$data['ort'] = $this->Orte_model->get($oid);
			$data['geraete'] = $this->Geraete_model->get(null,$oid);
		} else {
			$data['ort'] = NULL;
			$data['geraete'] = $this->Geraete_model->get();
		}
//FIXME
		$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
		$data['adresse']= $this->config->item('dguv3_adresse');


		/*$this->output->cache(5);*/

		//ob_start();

		$this->load->view('templates/print/header');
		$this->load->view('templates/datatable');
		$this->load->view('geraete/uebersicht',$data);
		$this->load->view('templates/print/footer');
//$content = ob_get_contents();
    //ob_clean();

    //$content=serialize($content);

		//$this->Html2pdf_model->html2pdfget($content);
		//$this->Geraete_model->downloadUrlToFile('https://dguv3.qabc.eu/index.php/geraete/geraete/'.$oid);


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
		$felder = array('oid','geraete_firmaid','hersteller','name','typ','seriennummer','nennstrom','nennspannung','leistung','hinzugefuegt','beschreibung','aktiv','schutzklasse','verlaengerungskabel','kabellaenge');

		$this->form_validation->set_rules('typ', 'Typ', 'required');
		$this->form_validation->set_rules('oid', 'Orts-ID', 'required');
		$this->form_validation->set_rules('oid', 'Ort', 'callback_oid_check'); //valid oid?
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

		if($this->form_validation->run() === FALSE) {
			if($this->agent->is_mobile()){
				$this->load->view('templates/header_mobile',$header);
			  } else {
				$this->load->view('templates/header',$header);
			  }

			//Neues Gerät
			if($gid==0) {
				foreach($felder as $feld) {
					$liste[$feld]="";
				}
				$liste['gid']=0;
				$liste['ortsname']='';
				$liste['geraete_firmaid']=$this->session->userdata('firmaid');
				$liste['aktiv']=TRUE;
				$liste['nennspannung']='230';
				$liste['schutzklasse']='2';
				$liste['hinzugefuegt']=date('Y-m-d');

				if($this->agent->is_mobile()){
					$this->load->view('geraete/form_mobile',array(
						'geraet'=>$liste,
						'firmen'=> $this->Firmen_model->get()
					));
				  } else {
					$this->load->view('geraete/form',array(
						'geraet'=>$liste,
						'firmen'=> $this->Firmen_model->get()
					));
				  }



			}
			//Vorhandeses Gerät
			else {

				if($this->agent->is_mobile()){
					$this->load->view('geraete/form_mobile',array(
						'geraet'=>$this->Geraete_model->get($gid),
						'firmen'=> $this->Firmen_model->get()
					));
				  } else {
					$this->load->view('geraete/form',array(
						'geraet'=>$this->Geraete_model->get($gid),
						'firmen'=> $this->Firmen_model->get()
					));
				  }



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
				// get ortsid von neu angelegtem gerät damit redirect zu richtiger seite führt?!!
			$ortsid = $this->Geraete_model->get($gid)['oid'];

			//$this->Pdf_model->genpdf_uebersicht($gortsid);
			file_put_contents('cron/liste/'.$ortsid,$geraet['geraete_firmaid']);

			$context='Gerät bearbeitet name '.$geraet['name'].' gid '.$gid.' oid '.$geraet['oid'];
			$this->Log_model->privatlog($context);


			if($gid==0) {
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

			redirect('geraete');
		}
	}
	function pagination($oid,$pageid) {



			redirect('geraete/index/'.$oid.'/'.$pageid);
		}

		function json($oid="") {
			$data = $this->Geraete_model->pdfdata($oid);

			$this->output
       			 ->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(array($data)));

			//echo json_encode($data);
		}



}
