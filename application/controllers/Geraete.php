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
		site_denied($this->session->userdata('logged_in'));
		
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		  

			$pageid =  $this->uri->segment(4);
			$data['ort'] = $this->Orte_model->get($oid);

			if(!$pageid) { $pageid =0;}		
			if($data['ort']===NULL) {$oid = NULL;}

			if(!$oid) {
				$data['ort'] = NULL; 
				$haeder_ortsname=NULL;
				$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete');
			
			} else {
				$haeder_ortsname=$data['ort']['name'];
				$data["page_total_rows"] = $this->Dguv3_model->getcountdata('geraete','oid',$oid);
			}

		

			$data["page_show_rows"] = $this->config->item('dguv3_show_page_rows_'.$data['useragent']);
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

			
			$this->load->view('templates/header',$header);
			$this->load->view('templates/'.$data['useragent']);

			$this->load->view('geraete/index_'.$data['useragent'],$data);
			$this->load->view('templates/footer');
		
	}


	function uebersicht($oid) {

		$data['ort'] = $this->Orte_model->get($oid);

		if($data['ort']===NULL) {exit;}

		$data['geraete'] = $this->Geraete_model->get(null,$oid,null,null,null,"5");

		$this->load->view('templates/print/header_desktop');
		$this->load->view('templates/desktop');
		$this->load->view('geraete/uebersicht',$data);
		$this->load->view('templates/print/footer');
    
	}

	function werkzeug($oid) {

		$data['ort'] = $this->Orte_model->get($oid);

		if($data['ort']===NULL) {exit;}

		$data['geraete'] = $this->Geraete_model->get(null,$oid);

		$this->load->view('templates/print/header_desktop');
		$this->load->view('templates/desktop');
		$this->load->view('geraete/werkzeug',$data);
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


	function edit($gid=0,$oid=NULL) {
		site_denied($this->session->userdata('logged_in'));

		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		  
		
		  $firmen_firmaid=$this->session->userdata('firmaid');
		  $data['lagerorte']=$this->Orte_model->getByName('Lager',$firmen_firmaid);

		  $data['geraet'] = $this->Geraete_model->get($gid);
		  $data['product_typ_pic'] = get_product_typ_pic_url($data['geraet']);
		  #print_r($data['product_typ_pic']);
		  $data['firmen'] = $this->Firmen_model->get();

		if($this->agent->is_mobile()){$useragent = 'mobile';} else {$useragent = 'desktop';}
		#$useragent = 'desktop';
		$felder = array('oid','geraete_firmaid','lagerorte','hersteller','name','typ','seriennummer','nennstrom','nennspannung','leistung','hinzugefuegt','beschreibung','aktiv','schutzklasse','verlaengerungskabel','kabellaenge');

		$this->form_validation->set_rules('typ', 'Typ', 'required');
		#$this->form_validation->set_rules('oid', 'Orts-ID', 'required');
		#$this->form_validation->set_rules('oid', 'Ort', 'callback_oid_check'); //valid oid?
		$header['cronjobs']= $this->File_model->getfiles('cronjob');

	

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);

			//Neues Gerät
			if($gid==0) {
				foreach($felder as $feld) {
					$data['geraet'][$feld]="";
				}

				if($oid) {
					$ort = $this->Orte_model->get($oid);

					$data['geraet']['oid']=$ort['oid'];
					$data['geraet']['ortsname']=$ort['name'];
					$data['geraet']['orte_beschreibung']=$ort['beschreibung'];	

				} else {
					$data['geraet']['oid']='';
					$data['geraet']['ortsname']='';
					$data['geraet']['orte_beschreibung']='';	
				}


				$data['geraet']['gid']=0;

						
				

				$data['geraet']['geraete_firmaid']=$this->session->userdata('firmaid');
				$data['geraet']['aktiv']=TRUE;
				$data['geraet']['nennspannung']='230';
				$data['geraet']['schutzklasse']='2';
				$data['geraet']['hinzugefuegt']=date('Y-m-d');

				#$this->load->view('geraete/form_'.$useragent,array(
				$this->load->view('geraete/form',$data);
				
				



			}
			//Vorhandeses Gerät
			else {

				
				#$this->load->view('geraete/form_'.$useragent,array(
				$this->load->view('geraete/form',$data);



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

		    #print_r($geraet);


			if ($geraet['lagerorte']!='NULL') {
				#echo "lagerort wird als oid verwendet";
				$geraet['oid']=$geraet['lagerorte'];
				unset($geraet['lagerorte']);
				
			} else {

				
				unset($geraet['lagerorte']);

			}



			#print_r($geraet);

			if($gid!=0) {
			$arrayold = $this->Geraete_model->get($gid);
			$logstatus='edit';

			} else {
				$logstatus='new';
				$arrayold= array();
			}

			//get the correct gid if new geraet
			$gid= $this->Geraete_model->set($geraet,$gid);

			
			
			$arraynew = $this->Geraete_model->get($gid);
			

			

			//$this->Pdf_model->genpdf_uebersicht($gortsid);
			file_put_contents('cron/liste/'.$geraet['oid'],$geraet['geraete_firmaid']);


			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				if(empty($arrayold)) {
					$context='Gerät neu gid '.$gid.' ; '.$log_diff;
				} else {
					$context='Gerät bearbeitet gid '.$gid.' ; '.$log_diff;
				}

				#print_r($context);
				$this->Log_model->privatlog($context);
			} 

			if($geraet['oid']===NULL) {
				redirect('geraete');
				}
			//Vorhandeses Gerät
			else {
			redirect('geraete/index/'.$geraet['oid']);

			}

		}
	}



	function delete($gid) {
		site_denied($this->session->userdata('logged_in'));

		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }

		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');
		$header['cronjobs']= $this->File_model->getfiles('cronjob');
		$geraet = $this->Geraete_model->get($gid);
// //TODO userabfrage



		if($this->form_validation->run() === FALSE) {

			$data['geraet']= $geraet;
			
			$data['target']= 'geraete/delete/'.$gid;
			$data['canceltarget']= 'geraete';

			$this->load->view('templates/header',$header);
			$this->load->view('geraete/delete_info',$data);
			$this->load->view('templates/confirm',$data);
			$this->load->view('templates/footer');
		} else {

			$arrayold = $this->Geraete_model->get($gid);
			$arraynew= array();
			$logstatus='delete';

			$this->Geraete_model->delete($gid);


			
			
			
			file_put_contents('cron/liste/'.$geraet['oid'],$geraet['geraete_firmaid']);

			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				
				$context='Gerät gelöscht gid '.$gid.' ; '.$log_diff;
				

				#print_r($context);
				$this->Log_model->privatlog($context);
			} 

			redirect('geraete/index/'.$geraet['oid']);
		}
	}





	function pagination($oid,$pageid) {



		#path with end /,oid,pageid
		site_pagination('geraete/index/',$oid,$pageid);
			
		}




		#gibt übersichtsliste für ort mit geräten aus
		function jsonout($oid) {
			$data = $this->Geraete_model->pdfdata($oid);
			

			// $this->output
       		// 	 ->set_content_type('application/json', 'utf-8')
			// 		->set_output(json_encode(array($data)));

			echo json_encode($data);
		}

		function json($key="") {
			site_denied($this->session->userdata('logged_in'));

			

				$search = array("%C3%A4", "%C3%B6", "%C3%BC", "%C3%9F", "%60");
		
				$replace = array("ä", "ö", "ü", "ß", "");
				
				$key= str_replace($search, $replace, $key);


				
				


				 //userlevel 2 oder höher kann nur orte mit eigener firma sehen
				 if($this->session->userdata('level')>='2'){
					$firmen_firmaid=$this->session->userdata('firmaid');
					$geraete=$this->Geraete_model->getByName($key,$firmen_firmaid);
	
				} else {
					$geraete=$this->Geraete_model->getByName($key);
				}

	
				if (empty($geraete)) {return NULL;} 	

				
	
				$kabelinfo="";
				
				$response=array();
				//FIXME umlaute werden nicht erkannt und zurücgegeben ->fehler
				foreach($geraete as $geraet) {
					
					if($geraet['verlaengerungskabel']=='1'){
						$kabelinfo= " {$geraet['kabellaenge']}m ";
					}
					$geraet['dummyname']="{$geraet['name']} ({$geraet['hersteller']}) ({$geraet['typ']})$kabelinfo";
					
					$response[$geraet['gid']]=$geraet;			

				}
				
				#print_r($response);

				echo json_encode($response);
			
		}




		function jsongid($gid) {
			site_denied($this->session->userdata('logged_in'));

		

			$geraete=$this->Geraete_model->get($gid);
			

		
			#print_r($geraete);
			
			echo json_encode($geraete);
			
		}




}
