<?php
/**
 * Dguv3 - Klasse
 * (C) Christian Klein, 2020
 */


defined('BASEPATH') OR exit('No direct script access allowed');


class File_model extends CI_Model
{

    function __construct()
    {
		$this->load->database();
		$this->load->model('Geraete_model');
		$this->load->model('Orte_model');
		$this->load->model('Pruefung_model');
		$this->load->model('Pdf_model');



    }
	//typ 1 übersicht $oid
	//typ 2 protokoll $pruefungid
	//typ 3 zip
	function get_file_pfad($typ,$id=null) {


		if($typ=='1') {

			$data['ort'] = $this->Orte_model->get($id);
			$year = date("Y");
			$ortsname = $data['ort']['name'];
			$ortsid = $data['ort']['oid'];
			$firma_id = $data['ort']['orte_firmaid'];
			$filename = 'pdf/'.$firma_id.'/'.$year.'/'.$ortsid.'_'.$ortsname.'/'.$ortsname.'_liste.pdf';




		} elseif($typ=='2') {
			$data['pruefung'] = $this->Pruefung_model->get($id);
			$blubb = new DateTime( $data['pruefung']['datum']);
			$datum= date_format($blubb,"Y");
			$ortsname = $data['pruefung']['ortsname'];
			$pruefungid = $data['pruefung']['pruefungid'];
			$geraeteid = $data['pruefung']['gid'];
			$ortsid = $data['pruefung']['oid'];
			$firma_id = $data['pruefung']['pruefung_firmaid'];

			$filename = 'pdf/'.$firma_id.'/'.$datum.'/'.$ortsid.'_'.$ortsname.'/Gid'.$geraeteid.'_'.$pruefungid.'_'.$data['pruefung']['geraetename'].'.pdf';

		} elseif($typ=='3') {
			$filename= 'pdf/'.$this->session->userdata('firmaid').'/'.$id.'.zip';
		}


			return $filename;




	}



	function download_file($typ,$id) {

		if($this->session->userdata('logged_in') === TRUE){
		//automatischer download

		$filename = $this->get_file_pfad($typ,$id);


		 if (file_exists($filename)) {

			$Dateiname = basename($filename);
			$Groesse = filesize($filename);
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=".$Dateiname);
			header("Content-Length: $Groesse");
			readfile($filename);
			redirect('Dguv3');
		} else {
			//return 'error';

		}
	  }
	}






}
