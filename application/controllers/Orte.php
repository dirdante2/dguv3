<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Orte extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Orte_model');
		$this->load->model('Firmen_model');
		$this->load->model('Pdf_model');
		$this->load->model('File_model');
		$this->load->model('Log_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index() {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		if($this->agent->is_mobile()){$useragent = 'mobile';} else {$useragent = 'desktop';}

		

		

			
			  //userlevel 2 oder höher kann nur orte mit eigener firma sehen 8
			if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');
				$data['orte'] = $this->Orte_model->get(null,$firmen_firmaid);

			} else {
				$data['orte'] = $this->Orte_model->get();

			}
			if(count($data['orte'])!=0) {
foreach($data['orte'] as $ort) {
	$pdf_pfad=$this->File_model->get_file_pfad('1',$ort['oid']);
	$pdffile_data[$ort['oid']]=$pdf_pfad;

}

$data['pdf_data']=$pdffile_data;
			}
$header['cronjobs']= $this->File_model->getfiles('cronjob');
$header['title']= 'Orte';


		//$data['filename'] = $this->File_model->get_file_pfad();
		$this->load->view('templates/header',$header);

		if($this->agent->is_mobile()){
			$this->load->view('templates/scroll');			
		  } else {			
			$this->load->view('templates/datatable');			
		  }
		  $this->load->view('orte/index_'.$useragent,$data);

			$this->load->view('templates/footer');
			



	}


	function edit($oid=0) {
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }
		//user level 4 oder höher darf keine orte erstellen oder bearbeiten
		
		if($this->session->userdata('level')>='4' || $this->session->userdata('logged_in') !== TRUE){
			$this->load->view('templates/header',$header);
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$header['cronjobs']= $this->File_model->getfiles('cronjob');
			
			

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');
		//$this->form_validation->set_rules('firmen_firmaid', 'Firma', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$header);

			if($oid==0) {

				
					$this->load->view('orte/form_'.$header['useragent'],array(
						'ort'=>array('oid'=>0,'beschreibung'=>'','name'=>''),
						'firmen'=> $this->Firmen_model->get()
					));
				  
				 

			} else {

				
					$this->load->view('orte/form_'.$header['useragent'],array(
						'ort'=>$this->Orte_model->get($oid),
						'firmen'=> $this->Firmen_model->get()

					));
				  

				  //generiere PDF übersicht
			
			$ort = $this->Orte_model->get($oid);
			file_put_contents('cron/liste/'.$oid,$ort['orte_firmaid']);
			

			}


			$this->load->view('templates/footer');

		} else {

			$ort = array (
				'name' => $this->input->post('name'),
				'beschreibung' => $this->input->post('beschreibung'),
				'orte_firmaid' => $this->input->post('orte_firmaid'),
			);

			if ($ort['orte_firmaid']==NULL) {
				$ort['orte_firmaid']=$this->session->userdata('firmaid');


			}

		

			if($oid==0) {				
			
				$arrayold = array();
				$logstatus='new';
			} else {
				$logstatus='edit';
				$arrayold = $this->Orte_model->get($oid);

				$filenameold = $this->File_model->get_file_pfad('1', $oid);
			}
			

			$oid= $this->Orte_model->set($ort,$oid);
			

			
				
				$arraynew = $this->Orte_model->get($oid);
				
				#print_r($arraynew);
				$filenamenew = $this->File_model->get_file_pfad('1', $oid);

				
				

				#echo $filenamenew;
				#echo '<br>';
				#echo $filenameold;

				if (!file_exists($filenamenew) && file_exists($filenameold)) {
					echo '<br>namensänderung<br>';
					
					$dateinameold = basename($filenameold);
					$dirnameold = dirname($filenameold);
	
					$dateinamenew = basename($filenamenew);
					$dirnamenew = dirname($filenamenew);
	
	
					rename ($dirnameold, $dirnamenew);
					rename ($dirnamenew.'/'.$dateinameold, $filenamenew);
	
					}

			

			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				if(empty($arrayold)) {
					$context='Ort neu oid '.$oid.' ; '.$log_diff;
				} else {
					$context='Ort bearbeitet oid '.$oid.' ; '.$log_diff;
				}

				#print_r($context);
				$this->Log_model->privatlog($context);
			} 



			

			redirect('orte');
		}
	}
	}

	function delete($oid) {
		site_denied($this->session->userdata('logged_in'));
		if($this->agent->is_mobile()){
			$data['useragent'] = 'mobile';
			$header['useragent'] = 'mobile';
		  } else {
			$data['useragent'] = 'desktop';
			$header['useragent'] = 'desktop';
		  }

		//nur admin darf orte löschen
		if($this->session->userdata('level')!='1'){
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$header['cronjobs']= $this->File_model->getfiles('cronjob');
			$ort = $this->Orte_model->get($oid);

		$this->form_validation->set_rules('confirm', 'Bestätigung', 'required');

		if($this->form_validation->run() === FALSE) {

			$data['ort']= $this->Orte_model->get($oid);
			$data['target']= 'orte/delete/'.$oid;
			$data['canceltarget']= 'orte';



			$this->load->view('templates/header',$header);
			$this->load->view('orte/delete_info',$data);
			$this->load->view('templates/confirm',$data);
			$this->load->view('templates/footer');
		} else {

			$filename = $this->File_model->get_file_pfad('1', $oid);

			if (file_exists($filename)) {
				$dirname = dirname($filename);

				array_map('unlink', glob("$dirname/*.*"));

				rmdir($dirname);
				
				}
			$arrayold = $this->Orte_model->get($oid);
			$arraynew= array();
			$logstatus='delete';

			$this->Orte_model->delete($oid);
			

			// log data
			$log_diff=log_change($arrayold, $arraynew, $logstatus);
			if(!empty($log_diff)) {
				if(empty($arrayold)) {
					$context='Ort neu oid '.$oid.' ; '.$log_diff;
				} else {
					$context='Ort bearbeitet oid '.$oid.' ; '.$log_diff;
				}

				#print_r($context);
				$this->Log_model->privatlog($context);
			} 

			redirect('orte');
		}
	}
	}

	function json($key="") {
		site_denied($this->session->userdata('logged_in'));
		
			$search = array("%C3%A4", "%C3%B6", "%C3%BC", "%C3%9F", "%60");		
			$replace = array("ä", "ö", "ü", "ß", "");			
			$key= str_replace($search, $replace, $key);


			 //userlevel 2 oder höher kann nur orte mit eigener firma sehen
			 if($this->session->userdata('level')>='2'){
				$firmen_firmaid=$this->session->userdata('firmaid');
				$orte=$this->Orte_model->getByName($key,$firmen_firmaid);

			} else {
				$orte=$this->Orte_model->getByName($key);
			}
			




			$response=array();
			foreach($orte as $ort) {
				$response[$ort['oid']]="{$ort['name']} ({$ort['beschreibung']})";
			}

			echo json_encode($response);
		
	}




  function download_file($typ,$id) {


	$this->File_model->download_file($typ,$id);


}




}
