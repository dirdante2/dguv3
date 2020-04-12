
<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

		
class createpdf extends CI_Controller {


function pdf($oid=NULL)
{
    $this->load->helper('pdf_helper');
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
		
		
		
    $this->load->view('pdfreport', $data);
}

}