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

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($oid=null) {

		$pageid =  $this->uri->segment(4);
		if(!$pageid) { $pageid =0;}


		if($this->session->userdata('logged_in') !== TRUE){
			if($this->agent->is_mobile()){
				$this->load->view('templates/header_mobile');
			} else {
				$this->load->view('templates/header');
			}
			$this->load->view('static/denied');
			$this->load->view('templates/footer');

          }else{


			$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete');
			$data["page_show_rows"] = '20';
			$data['page_pages']=ceil($data["page_total_rows"] / $data["page_show_rows"]);
			$data['page_pageid']=$pageid;
			$data['page_offset']=$data["page_show_rows"] * $pageid ;

			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');



				if($oid) {
					$data['ort'] = $this->Orte_model->get($oid);
					$data['geraete'] = $this->Geraete_model->getByOid($oid,$firmen_firmaid);
				} else {
					$data['ort'] = NULL;
					$data['geraete'] = $this->Geraete_model->get(null,$firmen_firmaid);
				}

			} else {
				//admin ansicht

				if($oid) {
					$data['ort'] = $this->Orte_model->get($oid);
					$data['geraete'] = $this->Geraete_model->getByOid($oid);
				} else {
					$data['ort'] = NULL;
					$data['geraete'] = $this->Geraete_model->get(null,null,$data["page_show_rows"],$data['page_offset']);
					//$data['geraete'] = $this->Geraete_model->get();
				}
			}
//$config["per_page"], $page
			//$pagination['target']= 0;
			//$data['pagination']=$pagination['target'];

		$data['html2pdf_api_key']= $this->config->item('html2pdf_api_key');
		$data['html2pdf_user_pass']= $this->config->item('html2pdf_user_pass');
		$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_col');
		$data['pruefungabgelaufen']= $this->config->item('dguv3_pruefungabgelaufen');
		$data['pruefungbaldabgelaufen']= $this->config->item('dguv3_pruefungbaldabgelaufen');
		/*$this->output->cache(5);*/



		if($this->agent->is_mobile()){
		$this->load->view('templates/header_mobile');
		$this->load->view('templates/scroll');
		$this->load->view('geraete/index_mobile',$data);
      } else {
		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('geraete/index',$data);
      }

		$this->load->view('templates/footer');
		}
	}


	function uebersicht($oid=NULL) {

		if($oid) {
			$data['ort'] = $this->Orte_model->get($oid);
			$data['geraete'] = $this->Geraete_model->getByOid($oid);
		} else {
			$data['ort'] = NULL;
			$data['geraete'] = $this->Geraete_model->get();
		}

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

	function html2pdf_liste($oid) {

		 		$html2pdf_api_key= $this->config->item('html2pdf_api_key');
				$html2pdf_user_pass= $this->config->item('html2pdf_user_pass');

		 		$ortsname = $this->Orte_model->get($oid)['name'];
		 		$year=date("Y");




        if (!file_exists('pdf/'.$year.'/'.$ortsname)) { mkdir('pdf/'.$year.'/'.$ortsname, 0755, true); }

           //echo "PDF Übersicht wurde erstellt";


					$value = site_url('geraete/uebersicht/'.$oid); // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
					$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($html2pdf_api_key) . "&value=" .$value . $html2pdf_user_pass);
					file_put_contents('pdf/'.$year.'/'.$ortsname.'/liste_'.$ortsname.'.pdf',$result);

					redirect('geraete/index/'.$oid);


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

		if($this->form_validation->run() === FALSE) {
			if($this->agent->is_mobile()){
				$this->load->view('templates/header_mobile');
			  } else {
				$this->load->view('templates/header');
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
			$gortsid = $this->Geraete_model->get($gid);

			if($gid==0) {
				redirect('geraete');
				}
			//Vorhandeses Gerät
			else {
			redirect('geraete/index/'.$gortsid['oid']);

			}

		}
	}



	function delete($gid) {
		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Geraet wirklich löschen?',
				'target' => 'geraete/delete/'.$gid,
				'canceltarget' => 'geraete'
			));
			$this->load->view('templates/footer');
		} else {
			$this->Geraete_model->delete($gid);
			redirect('geraete');
		}
	}
	function pagination($oid,$pageid) {

		if($pageid=='pre') {
			$pageid=$pageid -1;
		} elseif($pageid=='nex') {
			$pageid=$pageid +1;
		}


			redirect('geraete/index/'.$oid.'/'.$pageid);
		}




}
