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
		$this->load->model('Pdf_model');



    }

	function download_file($file,$typ,$pfad=null) {

		if($this->session->userdata('logged_in') === TRUE){
		//automatischer download

		if($pfad==null) {
			$Datei = 'pdf/'.$this->session->userdata('firmaid').'/'.$file.'.zip';

		} else {

			$Datei = 'pdf/'.$pfad.'/'.$file.'.'.$typ;

		}

		 if (file_exists($Datei)) {

			$Dateiname = basename($Datei);
			$Groesse = filesize($Datei);
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=".$Dateiname);
			header("Content-Length: $Groesse");
			readfile($Datei);
			redirect('Dguv3');
		} else {
			//return 'error';

		}
	  }
	}






}
