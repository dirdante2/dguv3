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
		if($this->agent->is_mobile()){$useragent = 'mobile';} else {$useragent = 'desktop';}

		if($this->session->userdata('logged_in') !== TRUE){

			
			$this->load->view('templates/header_'.$useragent);
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{

			
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
		$this->load->view('templates/header_'.$useragent,$header);

		if($this->agent->is_mobile()){
			$this->load->view('templates/scroll');			
		  } else {			
			$this->load->view('templates/datatable');			
		  }
		  $this->load->view('orte/index_'.$useragent,$data);

			$this->load->view('templates/footer');
			}



	}


	function edit($oid=0) {
		if($this->agent->is_mobile()){$useragent = 'mobile';} else {$useragent = 'desktop';}
		//user level 4 oder höher darf keine orte erstellen oder bearbeiten
		
		if($this->session->userdata('level')>='4' || $this->session->userdata('logged_in') !== TRUE){
			$this->load->view('templates/header_'.$useragent);
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
          }else{
			$header['cronjobs']= $this->File_model->getfiles('cronjob');
			
			

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');
		//$this->form_validation->set_rules('firmen_firmaid', 'Firma', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header_'.$useragent,$header);

			if($oid==0) {

				
					$this->load->view('orte/form_'.$useragent,array(
						'ort'=>array('oid'=>0,'beschreibung'=>'','name'=>''),
						'firmen'=> $this->Firmen_model->get()
					));
				  
				 

			} else {

				
					$this->load->view('orte/form_'.$useragent,array(
						'ort'=>$this->Orte_model->get($oid),
						'firmen'=> $this->Firmen_model->get()

					));
				  

				  //generiere PDF übersicht
			//$this->Pdf_model->genpdf_uebersicht($oid);
			$ort = $this->Orte_model->get($oid);
			

			file_put_contents('cron/liste/'.$oid,$ort['orte_firmaid']);
			// $typ='1';
			// $filename = $this->File_model->get_file_pfad($typ,$oid);


			//FIXME fehler weil ordner nicht verfügbar ist w
			// $toast_content['filename']=$filename;
			// $toast_content['ortsname']=$ort['name'];
			// file_put_contents('toast/'.$this->session->userdata('userid').'/'.$oid.'.txt', json_encode($toast_content));

			

			
			


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

			if($oid!=0) { $filenameold = $this->File_model->get_file_pfad('1', $oid);}
			
			$this->Orte_model->set($ort,$oid);
			

			if($oid==0) {				
			
			  $context='Ort neu erstellt '.$ort['name'].' besschreibung '.$ort['beschreibung'].' oid ';
			  $this->Log_model->privatlog($context);

			} else {
				
				$filenamenew = $this->File_model->get_file_pfad('1', $oid);

				$context='Ort bearbeitet name '.$ort['name'].' besschreibung '.$ort['beschreibung'].' oid '.$oid;
				$this->Log_model->privatlog($context);

				echo $filenamenew;
				echo '<br>';
				echo $filenameold;

				if (!file_exists($filenamenew) && file_exists($filenameold)) {
					echo '<br>namensänderung<br>';
					
					$dateinameold = basename($filenameold);
					$dirnameold = dirname($filenameold);
	
					$dateinamenew = basename($filenamenew);
					$dirnamenew = dirname($filenamenew);
	
	
					rename ($dirnameold, $dirnamenew);
					rename ($dirnamenew.'/'.$dateinameold, $filenamenew);
	
					}

			}



			

			redirect('orte');
		}
	}
	}

	function delete($oid) {
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
			$this->load->view('templates/header',$header);
			$this->load->view('templates/confirm',array(
				'beschreibung' => 'Ort wirklich löschen?',
				'target' => 'orte/delete/'.$oid,
				'canceltarget' => 'orte'
			));
			$this->load->view('templates/footer');
		} else {

			$filename = $this->File_model->get_file_pfad('1', $oid);

			if (file_exists($filename)) {
				$dirname = dirname($filename);

				array_map('unlink', glob("$dirname/*.*"));

				rmdir($dirname);
				
				}

			$this->Orte_model->delete($oid);
			

			$context='Ort gelöscht name '.$ort['name'].' oid '.$ort['oid'];
			$this->Log_model->privatlog($context);

			redirect('orte');
		}
	}
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
	}




  function download_file($typ,$id) {


	$this->File_model->download_file($typ,$id);


}




}
