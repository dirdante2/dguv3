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
		$this->load->model('Html2pdf_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	function index($oid=NULL) {
		if($oid) {
			$data['ort'] = $this->Orte_model->get($oid);
			$data['geraete'] = $this->Geraete_model->getByOid($oid);
		} else {
			$data['ort'] = NULL;
			$data['geraete'] = $this->Geraete_model->get();
		}
		
		$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_col');
		$data['pruefungabgelaufen']= $this->config->item('dguv3_pruefungabgelaufen');
		$data['pruefungbaldabgelaufen']= $this->config->item('dguv3_pruefungbaldabgelaufen');
		/*$this->output->cache(5);*/
		$this->load->view('templates/header');
		$this->load->view('templates/datatable');
		$this->load->view('geraete/index',$data);
		$this->load->view('templates/footer');
	}


	function geraete($oid=NULL) {
		
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
		$this->load->view('geraete/geraete',$data);
		$this->load->view('templates/print/footer');
//$content = ob_get_contents();
    //ob_clean();
    
    //$content=serialize($content);
    
		//$this->Html2pdf_model->html2pdfget($content);
		//$this->Geraete_model->downloadUrlToFile('https://dguv3.qabc.eu/index.php/geraete/geraete/'.$oid);
		
		
		}
	
	
	
function downloadUrlToFile()
{   
   $apikey = '93fa945c-3a01-4fff-a966-3a2f069a1539';
$value = '25'; // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" .$value);
file_put_contents('mypdf25.pdf',$result);
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
		$felder = array('oid','hersteller','name','typ','seriennummer','nennstrom','nennspannung','leistung','hinzugefuegt','beschreibung','aktiv','schutzklasse','verlaengerungskabel','kabellaenge');

		$this->form_validation->set_rules('typ', 'Typ', 'required');
		$this->form_validation->set_rules('oid', 'Orts-ID', 'required');
		$this->form_validation->set_rules('oid', 'Ort', 'callback_oid_check'); //valid oid?

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');

			//Neues Gerät
			if($gid==0) {
				foreach($felder as $feld) {
					$liste[$feld]="";
				}
				$liste['gid']=0;
				$liste['ortsname']='';
				$liste['aktiv']=TRUE;
				$liste['nennspannung']='230';
				$liste['schutzklasse']='2';
				$liste['hinzugefuegt']=date('Y-m-d');
				$this->load->view('geraete/form',array('geraet'=>$liste));
			}
			//Vorhandeses Gerät
			else {
				$this->load->view('geraete/form',array('geraet'=>$this->Geraete_model->get($gid)));
			}
			$this->load->view('templates/footer');

		} else {
			$geraet = array();

			foreach($felder as $feld) {
				$geraet[$feld]=$this->input->post($feld);
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
	
}
