<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Dguv3_model');
		$this->load->model('Pdf_model');
		$this->load->model('File_model');
		$this->load->model('Orte_model');
		$this->load->model('Pruefung_model');
	}
	//modus 1 bulk Orte neu erstellen
	//modus 2 bulk protokolle neu erstellen
	//modus 3 cronjob alle anstehenden aufgaben abarbeiten
	//modus 1+2 nur für debug zwecke und nur für admin
	function create_pdf($modus) {
		if($modus=='1'){
			if($this->session->userdata('level')=='1'){

				$orte = $this->Orte_model->get();
				

				foreach($orte as $ort) {
					// nur fürs aktuelle jahr
					$filename= $this->Pdf_model->genpdf_uebersicht($ort['oid']);
					echo $filename;
					echo '<br>';
					echo $ort['oid'].'<br>';

				}
			}
		}elseif($modus=='2'){
			if($this->session->userdata('level')=='1'){

				//gibt nur eine prüfung pro gerät zurück && die im aktuellen jahr gemacht wurde
				$protokolle = $this->Pruefung_model->get_geraete_pruefung();

				foreach($protokolle as $protokoll) {
					$filename= $this->Pdf_model->genpdf_protokoll($protokoll['pruefungid']);
					echo $filename;
					echo '<br>';
					echo $protokoll['pruefungid'].' '.$protokoll['gid'].'<br>';
				}
			}
		}elseif($modus=='3'){

			$cron_liste_pfad = 'cron/liste/';
			$cron_protokoll_pfad = 'cron/protokoll/';

			$cron_liste = array_diff(scandir($cron_liste_pfad, 1), array('.', '..'));
			$cron_protokoll = array_diff(scandir($cron_protokoll_pfad, 1), array('.', '..'));
			$errordata=array();
			
			//listen übersicht als pdf anfordern
			foreach($cron_liste as $ortsid) {

				$firmaid = file_get_contents($cron_liste_pfad.$ortsid, true);
				$filename= $this->Pdf_model->genpdf_uebersicht($ortsid);
				if($filename===null){
echo 'error kein server';
return null;
				}
				echo $filename;
				echo '<br>';
				echo $firmaid;
				echo '<br>';

				if (!unlink($cron_liste_pfad.$ortsid)) {
					$error='Fehler '.$filename;
					array_push($errordata, $error);
				}
			}

			// protokoll als pdf anfordern
			foreach($cron_protokoll as $pruefung_id) {

				$firmaid = file_get_contents($cron_protokoll_pfad.$pruefung_id, true);

				$filename= $this->Pdf_model->genpdf_protokoll($pruefung_id);
				echo '<br>';

				echo $filename;
				echo '<br>';
				echo $firmaid;


				if (!unlink($cron_protokoll_pfad.$pruefung_id)) {
					$error='Fehler '.$filename;

					array_push($errordata, $error);
				}
			}
				//aktuelles jahr wird als zip neu erstellt wenn änderungen sind
				$year=date('Y');
				if(!empty($cron_liste) || !empty($cron_protokoll)){
				$this->File_model->createfiles($year,$firmaid);
				}

				echo '<br>';
			if(empty($errordata)){
				echo 'OK';
				echo '<br>Übersicht ';
				print_r($cron_liste);
				echo '<br>Protokoll ';
					print_r($cron_protokoll);
			} else {
				print_r($errordata);
			}


		}
	}


}
